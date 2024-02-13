<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, minimum-scale=1, maximum-scale=1">
        <title>401 Error | Unauthorized Access</title>
        
        <link rel="Shortcut Icon" type="image/x-icon" href="{{ asset('/images/favicon.png') }}" />
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.1.1/css/bootstrap.min.css">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
        <link type="text/css" rel="stylesheet" href="{{ asset('/css/404.css') }}" />
    </head>
    <body>
        <div id="wrapper" class="wrapper-shadow" style="background-color:#e5e9ec;">

            <canvas id="world"></canvas>
            <div class="real-boxs">
                
                <div class="row align-lg-center">
                    <div class="col-md-12">
                        <div class="error-template">
                            <h1> ERROR <strong>401</strong> – :) </h1>
                            <h2>Sorry, you are unauthorized to access this page.</h2>
                            <div class="error-actions">
                                <a href="{{ url('dashboard') }}" class="btn btn-theme btn-lg"><i class="fa fa-chevron-left"></i> Back to Home</a>
                                <a href="#" class="btn btn-theme-inverse btn-lg"><span class="fa fa-envelope-o"></span> Contact Support </a>
                            </div>
                            <div class="error-details"> Copyright &copy; {{ date('Y') }} {{ config('app.name', 'Laravel') }}</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
        <script type="text/javascript" src="assets/js/styleswitch.js"></script>

        <script type="text/javascript">
            (function () {
                var COLORS, Confetti, NUM_CONFETTI, PI_2, canvas, confetti, context, drawCircle, i, range, resizeWindow, xpos;
                NUM_CONFETTI = 100;
                COLORS = [[85, 71, 106], [174, 61, 99], [219, 56, 83], [244, 92, 68], [248, 182, 70], [26, 188, 155], [212, 223, 90]];
                PI_2 = 2 * Math.PI;
                canvas = document.getElementById("world");
                context = canvas.getContext("2d");
                window.w = 0;
                window.h = 0;
                resizeWindow = function () {
                    window.w = canvas.width = window.innerWidth;
                    return window.h = canvas.height = window.innerHeight;
                };
                window.addEventListener('resize', resizeWindow, false);
                window.onload = function () {
                    return setTimeout(resizeWindow, 0);
                };
                range = function (a, b) {
                    return (b - a) * Math.random() + a;
                };
                drawCircle = function (x, y, r, style) {
                    context.beginPath();
                    context.arc(x, y, r, 0, PI_2, false);
                    context.fillStyle = style;
                    return context.fill();
                };
                xpos = 0.5;
                document.onmousemove = function (e) {
                    return xpos = e.pageX / w;
                };
                window.requestAnimationFrame = (function () {
                    return window.requestAnimationFrame || window.webkitRequestAnimationFrame || window.mozRequestAnimationFrame || window.oRequestAnimationFrame || window.msRequestAnimationFrame || function (callback) {
                        return window.setTimeout(callback, 1000 / 60);
                    };
                })();
                Confetti = (function () {
                    function Confetti() {
                        this.style = COLORS[~~range(0, 5)];
                        this.rgb = "rgba(" + this.style[0] + "," + this.style[1] + "," + this.style[2];
                        this.r = ~~range(2, 6);
                        this.r2 = 2 * this.r;
                        this.replace();
                    }
                    Confetti.prototype.replace = function () {
                        this.opacity = 0;
                        this.dop = 0.03 * range(1, 4);
                        this.x = range(-this.r2, w - this.r2);
                        this.y = range(-20, h - this.r2);
                        this.xmax = w - this.r;
                        this.ymax = h - this.r;
                        this.vx = range(0, 2) + 8 * xpos - 5;
                        return this.vy = 0.7 * this.r + range(-1, 1);
                    };

                    Confetti.prototype.draw = function () {
                        var _ref;
                        this.x += this.vx;
                        this.y += this.vy;
                        this.opacity += this.dop;
                        if (this.opacity > 1) {
                            this.opacity = 1;
                            this.dop *= -1;
                        }
                        if (this.opacity < 0 || this.y > this.ymax) {
                            this.replace();
                        }
                        if (!((0 < (_ref = this.x) && _ref < this.xmax))) {
                            this.x = (this.x + this.xmax) % this.xmax;
                        }
                        return drawCircle(~~this.x, ~~this.y, this.r, "" + this.rgb + "," + this.opacity + ")");
                    };
                    return Confetti;
                })();

                confetti = (function () {
                    var _i, _results;
                    _results = [];
                    for (i = _i = 1; 1 <= NUM_CONFETTI ? _i <= NUM_CONFETTI : _i >= NUM_CONFETTI; i = 1 <= NUM_CONFETTI ? ++_i : --_i) {
                        _results.push(new Confetti);
                    }
                    return _results;
                })();

                window.step = function () {
                    var c, _i, _len, _results;
                    requestAnimationFrame(step);
                    context.clearRect(0, 0, w, h);
                    _results = [];
                    for (_i = 0, _len = confetti.length; _i < _len; _i++) {
                        c = confetti[_i];
                        _results.push(c.draw());
                    }
                    return _results;
                };
                step();
            }).call(this);
        </script>
    </body>
</html>