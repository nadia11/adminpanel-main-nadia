(function($) {
    var defaults = {
        reNumbers: /(-|-\$)?(\d+(,\d{3})*(\.\d{1,})?|\.\d{1,})/g,
        cleanseNumber: function(v) {
            return v.replace(/[^0-9.\-]/g, "")
        },
        useFieldPlugin: (!!$.fn.getValue),
        onParseError: null,
        onParseClear: null
    };
    $.Calculation = {
        version: "0.4.05",
        setDefaults: function(options) {
            $.extend(defaults, options)
        }
    };
    $.fn.parseNumber = function(options) {
        var aValues = [];
        options = $.extend(options, defaults);
        this.each(function() {
            var $el = $(this),
                sMethod = ($el.is(":input") ? (defaults.useFieldPlugin ? "getValue" : "val") : "text"),
                v = $el[sMethod]().match(defaults.reNumbers, "");
            if (v == null) {
                v = 0;
                if (jQuery.isFunction(options.onParseError)) {
                    options.onParseError.apply($el, [sMethod])
                }
                $.data($el[0], "calcParseError", true)
            } else {
                v = options.cleanseNumber.apply(this, [v[0]]);
                if ($.data($el[0], "calcParseError") && jQuery.isFunction(options.onParseClear)) {
                    options.onParseClear.apply($el, [sMethod]);
                    $.data($el[0], "calcParseError", false)
                }
            }
            aValues.push(parseFloat(v, 10))
        });
        return aValues
    };
    $.fn.calc = function(expr, vars, cbFormat, cbDone) {
        var $this = this,
            exprValue = "",
            precision = 0,
            $el, parsedVars = {},
            tmp, sMethod, _, bIsError = false;
        for (var k in vars) {
            expr = expr.replace((new RegExp("(" + k + ")", "g")), "_.$1");
            if (!!vars[k] && !!vars[k].jquery) {
                parsedVars[k] = vars[k].parseNumber()
            } else {
                parsedVars[k] = vars[k]
            }
        }
        this.each(function(i, el) {
            var p, len;
            $el = $(this);
            sMethod = ($el.is(":input") ? (defaults.useFieldPlugin ? "setValue" : "val") : "text");
            _ = {};
            for (var k in parsedVars) {
                if (typeof parsedVars[k] == "number") {
                    _[k] = parsedVars[k]
                } else {
                    if (typeof parsedVars[k] == "string") {
                        _[k] = parseFloat(parsedVars[k], 10)
                    } else {
                        if (!!parsedVars[k] && (parsedVars[k] instanceof Array)) {
                            tmp = (parsedVars[k].length == $this.length) ? i : 0;
                            _[k] = parsedVars[k][tmp]
                        }
                    }
                }
                if (isNaN(_[k])) {
                    _[k] = 0
                }
                p = _[k].toString().match(/\.\d+$/gi);
                len = (p) ? p[0].length - 1 : 0;
                if (len > precision) {
                    precision = len
                }
            }
            try {
                exprValue = eval(expr);
                if (precision) {
                    exprValue = Number(exprValue.toFixed(Math.max(precision, 4)))
                }
                if (!!cbFormat) {
                    exprValue = cbFormat(exprValue)
                }
            } catch (e) {
                exprValue = e;
                bIsError = true
            }
            $el[sMethod](exprValue.toString())
        });
        if (!!cbDone) {
            cbDone(this)
        }
        return this
    };
    $.each(["sum", "mul", "sub", "div", "avg", "min", "max"], function(i, method) {
        $.fn[method] = function(bind, selector) {
            if (arguments.length == 0) {
                return math[method](this.parseNumber())
            }
            var bSelOpt = selector && (selector.constructor == Object) && !(selector instanceof jQuery);
            var opt = bind && bind.constructor == Object ? bind : {
                bind: bind || "keyup",
                selector: (!bSelOpt) ? selector : null,
                oncalc: null
            };
            if (bSelOpt) {
                opt = jQuery.extend(opt, selector)
            }
            if (!!opt.selector) {
                opt.selector = $(opt.selector)
            }
            var self = this,
                sMethod, doCalc = function() {
                    var value = math[method](self.parseNumber(opt));
                    if (!!opt.selector) {
                        sMethod = (opt.selector.is(":input") ? (defaults.useFieldPlugin ? "setValue" : "val") : "text");
                        opt.selector[sMethod](value.toString())
                    }
                    if (jQuery.isFunction(opt.oncalc)) {
                        opt.oncalc.apply(self, [value, opt])
                    }
                };
            doCalc();
            return self.live(opt.bind, doCalc)
        }
    });
    var math = {
        sum: function(a) {
            var total = 0,
                precision = 0;
            $.each(a, function(i, v) {
                var p = v.toString().match(/\.\d+$/gi),
                    len = (p) ? p[0].length - 1 : 0;
                if (len > precision) {
                    precision = len
                }
                total += v
            });
            if (precision) {
                total = Number(total.toFixed(precision))
            }
            return total
        },
        mul: function(a) {
            var total = 1,
                precision = 0;
            total = a[2] * a[3];
            if (precision) {
                total = Number(total.toFixed(precision))
            }
            return total
        },
        div: function(a) {
            var precision = 0;
            if (a[3] != 0) {
                total = a[4] / a[3]
            } else {
                total = 0
            }
            if (precision) {
                total = Number(total.toFixed(precision))
            }
            return total
        },
        sub: function(a) {
            var sub_total, discount, total = 0,
                precision = 0;
            if (typeof a[0] == "number") {
                sub_total = a[0]
            } else {
                sub_total = Math.parseFloat(a[0])
            }
            if (typeof a[1] == "number") {
                discount = a[1]
            } else {
                discount = Math.parseFloat(a[1])
            }
            total = sub_total - discount;
            if (precision) {
                total = Number(total.toFixed(precision))
            }
            return total
        },
        avg: function(a) {
            return math.sum(a) / a.length
        },
        min: function(a) {
            return Math.min.apply(Math, a)
        },
        max: function(a) {
            return Math.max.apply(Math, a)
        }
    }
})(jQuery);


(function(a) {
    a.fn.setDecimalPrecision = function() {
        a(this).blur(function() {
            var c = a(this).val();
            var b = /^\d+$/;
            var d = /^(\d+(\.\d *)?)$/;
            if (b.test(c) || d.test(c)) {
                a(this).val(c !== undefined ? (c * 1).toFixed(2) : "")
            }
        })
    }
})(jQuery);

(function(a) {
    a.fn.equalHeight = function(b) {
        return a(this).each(function() {
            maxheight = 0;
            a(this).find(">" + b).each(function() {
                maxheight = Math.max(maxheight, a(this).height())
            });
            a(this).find(">" + b).each(function() {
                a(this).height(maxheight + "px")
            })
        })
    }, a.fn.viewNotification = function() {
        a(this).bind("click", function() {
            var b = myLayout.state;
            var c = !b.east.isClosed;
            if (c) {
                myLayout.close("east");
                myLayout.resizeContent("center");
                a("#right_main_content").empty()
            } else {
                myLayout.open("east");
                myLayout.sizePane("east", 255);
                a("#right_main_content").load("/notification/?layout=ajax");
                myLayout.resizeContent("center")
            }
        })
    };
    a.fn.sideMenu = function(b) {
        b = a.extend({}, {
            key: "",
            loadFirst: true,
            bindOnly: false
        }, b || {});
        var c = a(this);
        a("#" + c.attr("id") + ">li>a").bind("click", function() {
            var d = {};
            d[b.key] = a(this).attr("id");
            a.bbq.pushState(d, 2);
            a(this).parent().siblings().each(function() {
                a(this).find("a").removeClass("ui-state-highlight")
            });
            return false
        });
        if (b.bindOnly) {
            return c
        }
        if (!window.location.hash && b.loadFirst) {
            a("#" + c.attr("id") + ">li>a").first().click()
        }
        a("#" + c.attr("id")).bookmarkChange({
            id: b.key,
            callback: function(e, f) {
                var d = a("#" + f).data("content_url");
                if (!d) {
                    d = "/" + f + "/setting/?layout=ajax_toolbar"
                }
                if (f !== null) {
                    c.children().find("#" + f).addClass("ui-state-highlight");
                    a("#main_content").load(d)
                }
            }
        });
        return c
    };
    a.fn.leftMenu = function() {
        var b = {
            preserveState: ".sform"
        };
        options = a.extend({}, b, arguments[0] || {});
        a(this).each(function() {
            var c = a(this).find("a");
            c.each(function() {
                if (a(this).attr("href") === window.location.pathname) {
                    a(this).addClass("selected")
                }
                a(this).click(function() {
                    var d = a(options.preserveState).zSerialize();
                    a(this).attr("href", a(this).attr("href") + (d ? "?" : "") + d)
                })
            })
        });
        return a(this)
    }
})(jQuery);

(function(d) {
    var a = null;
    var b = {};
    var c = false;
    d(window).bind("hashchange", function(f) {
        c = true;
        var g = f.getState();
        if (g != null) {
            for (i in g) {
                if (a == null || a[i] != g[i]) {
                    if (b[i] != undefined) {
                        b[i](i, g[i])
                    }
                }
            }
            a = g
        }
        c = false
    });
    d.fn.bookmarkChange = function(e) {
        return d(this).each(function() {
            var f = e.id || this.id;
            b[f] = e.callback;
            params = null;
            if (a != null && a[f] != undefined) {
                params = a[f]
            }
            c = true;
            e.callback(f, params);
            c = false
        })
    };
    d.fn.divineTabs = function() {
        d(this).find('a[href=""]:parent').remove();
        d.tools.tabs.conf.loading = '<div class="loading"> Loading </div>';
        d.tools.tabs.conf.fadeOutSpeed = 10;
        d.tools.tabs.conf.tabs = "li > a";
        d.tools.tabs.addEffect("fadeajax", function(k, g) {
            var h = this.getTabs().eq(k).attr("href");
            var j = this.getConf();
            if (h[0] != "#") {
                var m = this.getPanes().eq(0).fadeTo(j.fadeOutSpeed, 0);
                var f = m.height();
                m.html(j.loading).css({
                    height: f
                }).load(h, function() {
                    d(this).stop(true, true).css({
                        height: "auto"
                    }).fadeTo(j.fadeInSpeed, 1);
                    g.call()
                })
            } else {
                var j = this.getConf();
                var l = this.getPanes();
                l.hide();
                l.eq(k).fadeIn(j.fadeInSpeed, g)
            }
        });
        var e = d(this);
        if (d(".tab_panes", e).length == 0) {
            e.append('<div class="tab_panes"><div></div></div>')
        }
        e.addClass("css-tabs");
        d("#" + e.attr("id") + " > ul").tabs(".tab_panes > div", {
            effect: "fadeajax",
            onBeforeClick: function(g, f) {
                if (c) {
                    this.getCurrentTab().parent().removeClass("active");
                    this.getTabs().eq(f).parent().addClass("active")
                } else {
                    var k = this.getCurrentTab();
                    var h = this.getTabs().eq(f);
                    if (k.length != 0) {
                        g.preventDefault();
                        var j = {};
                        j[h.closest("div").attr("id")] = h.attr("id");
                        d.bbq.pushState(j)
                    } else {
                        if (this.getConf().autoload == true) {
                            this.getTabs().eq(f).parent().addClass("active")
                        } else {
                            g.preventDefault()
                        }
                    }
                }
            }
        }).show();
        d("#" + e.attr("id")).bookmarkChange({
            callback: function(g, h) {
                var f = true;
                if (h === null) {
                    d("#" + g + ">ul>li>a").eq(0).click()
                } else {
                    d("#" + g + ">ul>li>a").each(function() {
                        if (this.id == h) {
                            f = false
                        }
                    });
                    if (f) {
                        d("#" + g + ">ul>li>a").eq(0).click()
                    } else {
                        d("#" + g + ">ul>li #" + h).click()
                    }
                }
            }
        });
        return this
    }
})(jQuery);


function is_verified(c, a) {
    var b = "/email/api/check_email_address_verified/?email=" + c;
    $.ajax({
        type: "GET",
        url: b,
        success: function(d) {
            d = JSON.parse(d);
            if (d.is_verified == "True") {
                $("." + a).removeClass("_pending");
                $("." + a).addClass("_yes");
                $("." + a).attr("title", "Verified")
            } else {
                if (d.is_verified == "False") {
                    $("." + a).removeClass("_yes");
                    $("." + a).addClass("_pending");
                    $("." + a).bind("click").smartpopup({
                        url: "/email/verify/?layout=popup&email=" + c + "&uri={{ PATH }}"
                    });
                    $("." + a).attr("title", "Not Verified, click to verify.")
                } else {
                    $("." + a).removeClass("_pending");
                    $("." + a).removeClass("_yes")
                }
            }
        }
    })
}(function(a) {
    a.fn.tickcrossmark = function(b) {
        $parentfield = a(this).parents(".input");
        if ($parentfield.hasClass("tcmark")) {
            $parentfield.removeClass("tcmark");
            $parentfield.children("a").remove()
        }
        if (b.tick) {
            $parentfield.addClass("tcmark").prepend('<a class="tickmark"></a>')
        }
        if (b.cross) {
            $parentfield.addClass("tcmark").prepend('<a class="crossmark"></a>')
        }
    }
})(jQuery);

String.prototype.lpad = function(a, b) {
    var c = this;
    while (c.length < b) {
        c = a + c
    }
    return c
};

$.ui.cookie = {
    read: function(a) {
        var h = document.cookie,
            d = h ? h.split(";") : [],
            f = "",
            e;
        for (var b = 0, g = d.length; b < g; b++) {
            e = $.trim(d[b]).split("=");
            if (e[0] == a) {
                f = decodeURIComponent(e[1]);
                break
            }
        }
        return $.decodeJSON(f)
    },
    write: function(e, h, d) {
        var g = "",
            c = "",
            a = false,
            b = h,
            f = $.extend({}, d || {});
        if (!f.expires) {} else {
            if (f.expires.toUTCString) {
                c = f.expires
            } else {
                if (typeof f.expires == "number") {
                    c = new Date();
                    if (f.expires > 0) {
                        c.setDate(c.getDate() + f.expires)
                    } else {
                        c.setYear(1970);
                        a = true
                    }
                }
            }
        }
        if (c) {
            g += ";expires=" + c.toUTCString()
        }
        if (f.path) {
            g += ";path=" + f.path
        }
        if (f.domain) {
            g += ";domain=" + f.domain
        }
        if (f.secure) {
            g += ";secure"
        }
        if (typeof b != "string") {
            b = $.encodeJSON(b)
        }
        document.cookie = e + "=" + (a ? "" : encodeURIComponent(b)) + g;
        return h
    },
    update: function(c, b, a) {
        var d = $.ui.cookie.read(c);
        if (typeof d != "string" && typeof b != "string") {
            d = $.extend({}, d || {}, b || {})
        }
        return $.ui.cookie.write(c, d, a)
    },
    clear: function(a) {
        $.ui.cookie.write(a, "", {
            expires: -1
        })
    }
};;