var protocol = window.location.protocol;
var hostname = window.location.hostname;
var domain_name = window.location.href.split('/')[3];
var project_name = protocol + "//" + hostname + "/" + domain_name;


/*****************waves paramateres :: http://fian.my.id/Waves/#start***************/
Waves.init();
Waves.attach('.btn', ['']);
Waves.attach('.btn-effect', ['']);
//Waves.attach('.btn', ['waves-button', 'waves-float']);


$("body").append('<div class="ajax-loader" style="background: url( '+ tits_project.url +'/images/processing.gif ) center 65% no-repeat lightgoldenrodyellow; height: 80px; width: 100px; position: fixed; border-radius: 4px; left: 50%; top: 50%; margin: -40px 0px 0px -50px; z-index: 2000; display: none;"></div>');
$(".ajax-loader").css({ background: 'lightgoldenrodyellow url('+ tits_project.url +'/images/processing.gif) no-repeat center 65%', height: '80px', width: '100px', position: 'fixed', borderRadius: '4px', left: '50%', top: '50%', margin: '-40px 0 0 -50px', zIndex: '2000', display: 'none' });


$(document).ready(function() {
    var title = $('title').text();
    document.title = $('h2:first').text() ? $('h2:first').text() +" :: "+ title : "Dashboard :: " + title;
});

$(document).on('click', 'a.sidebar-toggle', function(){
    setTimeout(function () {
        $.fn.dataTable.tables( {visible: true, api: true} ).columns.adjust();
    }, 1000);
});


function ajaxLoad(filename, content) {
    content = typeof content !== 'undefined' ? content : 'contentWrapper';
    $.ajax({
        type: "GET",
        url: filename,
        contentType: false,
        success: function (data) {
            $("#" + content).html(data);
        },
        error: function (xhr, status, error) { alert(xhr.responseText); },
        beforeSend: function( xhr ) { $(".ajax-loader").show('slow'); },
        complete: function( jqXHR, textStatus ) { $(".ajax-loader").hide('fast'); },
    });
}




//routie('*', function () {
//    var url = window.location.href;
//    var p = url.indexOf('#');
//
//    if (p > -1) {
//        var controllerAction = url.substr(url.indexOf('#') + 1);
//        var pos = controllerAction.indexOf('*');
//        var menu = controllerAction;
//
//        if (pos > -1)
//            menu = controllerAction.substr(0, pos);
//
//        activeMenu("nav_" + menu.replace('/', '_'));
//        $('body,html').animate({ scrollTop: 0 }, 800);
//        ajaxLoad(controllerAction.replace('*', '/'));
//    } else {
//        activeMenu("nav_home");
//        //ajaxLoad('dashboard');
//    }
//});


function activeMenu(nav) {
    $('.nav li.active').removeClass('active');
    $(".nav ." + nav).addClass('active');
}


$(document).ready(function() {

    // the following portion will wrap the menu depending on screen/window size
    var original_menu_level_1_list = $('.topbar-menu .container-fluid > ul > li');
    var additional_width = 5;
    var $prismMenu = $('.topbar-menu .container-fluid > ul');

    function wrapMenu(){
        var totalWidth = 10; // initial value for left and right brand
        var extra_lis = [];
        var important_menu_names_list = ['Reports', 'Help'];
        var important_menu_list = [];

        original_menu_level_1_list.width(function(i,w){
            if ($(this).html() != '') {
                for (var each in important_menu_names_list) {
                    if ($(this).text().search(important_menu_names_list[each]) != -1) {
                        important_menu_list.push($(this));
                        $(this).hide();
                        return;
                    }
                }
                totalWidth += w + additional_width;
                if (totalWidth >= $(window).width()) {
                    extra_lis.push($(this));
                    $(this).hide();
                }else{
                    $(this).show();
                }
            }
        });
        $prismMenu.find('li.extra').remove();
        if (extra_lis.length != 0) {
            $prismMenu.append('<li class="extra">... <ul></ul></li>');
            for (var i = 0; i < extra_lis.length; i++) {
                if (extra_lis[i].html() != '') {
                    var $subMenu = $('.topbar-menu .container-fluid > ul > li:last > ul');
                    $subMenu.append('<li>' + extra_lis[i].html() + '</li>');
                    //$subMenu.append('<li class="separator"></li>');
                }
            }
        }
        if (important_menu_list.length != 0) {
            for (var m = 0; m < important_menu_list.length; m++) {
                $prismMenu.append('<li class="extra">' + important_menu_list[m].html() + '</li>');
            }
        }
        //$prismMenu.jdMenu({disableLinks: false});
    };
    wrapMenu();

    $(window).on('resize', function () { wrapMenu(); });
    $(window).trigger('hashchange');
});


$('form input').on('keypress', function(e){
    var code = e.keyCode || e.which;
    if (code == 13){
        $(this).trigger("keypress", [9]);
        //$(this).next().focus();
    }
});

//measure load time
window.onload = function () {
    var show_response_time = parseInt("1");
    document.show_response_time = show_response_time;
    if (show_response_time) {
        setTimeout(function () {
            var timing = performance.timing;
            var response = (timing.loadEventEnd - timing.requestStart); // in millisecond
            var response_insecond = (response / 1000).toFixed(2);
            document.getElementById('response_time').text = 'Response: ' + response_insecond + 's';
        }, 0);
    }
};

// $.ajaxSetup({
    //complete: function( jqXHR, textStatus ) { $("#memory_usage").html("Memory Usage: "+); },
// });


//For Auto redirect login page, if no cache or cookie
$.ajaxSetup({
    statusCode: {
        401: function(){
            alert( "Not authenticated" );
            location.href = tits_project.url + "/login";
        }
    }
});




//window.onbeforeunload = function() {
//    return "Did you save your stuff?"
//}


$(document).ready(function (){
    $("a[href='#']").click('click', function(e){
        e.preventDefault();
    });

    $('.select2').select2({
        theme: "bootstrap4",
        width: '76%',
        placeholder: $(this).attr('placeholder'),
    });
});


$(document).ready(function (){
    //if ($(this).attr("href") === window.location.pathname) { $(this).addClass("selected") }
    //$("form.multiselect[method=post]", b).find("button, input[type=submit]").each(function() {}

    var CURRENT_URL = window.location.href.split('?')[0];
    //var SIDEBAR_MENU = $('.sidebar-menu');
    //var a = $SIDEBAR_MENU.outerHeight();
    //var menu_position = $SIDEBAR_MENU.find('a[href="' + CURRENT_URL + '"]').parent('li').outerHeight();
    //alert( CURRENT_URL );
    $('body.header-menu').find('.topbar-menu').find('a[href="' + CURRENT_URL + '"]').parent('li').addClass('active');
    $('body.header-menu').find('.topbar-menu').find('a[href="' + CURRENT_URL + '"]').parent('li').parents('li').addClass('active');

    var menu_position = $('.sidebar-menu').find('a[href="' + CURRENT_URL + '"]').parent('li').offset().top;
    $("nav.sidebar").animate({ scrollTop: menu_position - ($(document).height()/2)+100 }, 1000);
});

$(document).ready(function (){
    //all type of nav menu
    $('ul.nav').find('a[href="' + window.location.href.split('?')[0] + '"]').parent('li').addClass('active');
});


$(document).ready(function (){
    var MarTop = 100;
    var MarBottom = 100;

    var windowHeight = $( window ).outerHeight();
    var modalHeight = windowHeight - (MarTop + MarBottom);

    $(".modal").css({overflow: 'hidden'});
    $(".modal .modal-body").addClass('custom-scroll').css({ overflowx: 'hidden', overflowY: 'scroll', maxHeight: modalHeight + "px"});
});



$(document).ready(function (){
    //Refresh button
    $('button#refresh').click(function(){
        //$(".overlay").show('slow');
//        $(this).parents('.box').reload();
        location.reload();
    });

    //Expand search filed on focus
    /*$('#navbar-search-input, #editor').focus(function(){
        $(this).animate({ width: '+=50' }, 'slow');
    }).blur(function(){
        $(this).animate({ width: '-=50' }, 'slow');
    });
    */


    //Date input masked
    //$(document).on('click', 'input[type="datetime"]');
    $('input[type="datetime"]').datepicker({
        showButtonPanel: true,
        showOtherMonths: true,
        selectOtherMonths: true,
        changeMonth: true,
        changeYear: true,
        gotoCurrent : true,
        hideIfNoPrevNext: true,
        closeText: "Done",
        currentText: "Today",
        prevText:"Prev",
        nextText:"Next",
        //showMonthAfterYear: true,
        //showWeek: true, weekHeader: "Wk",
        firstDay: 6,  //6: "Saturday", 0: "Sunday",
        //monthNames: ["January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December"],
        //monthNamesShort: ["Jan", "Feb", "Mar", "Apr", "May", "Jun", "Jul", "Aug", "Sep", "Oct", "Nov", "Dec"],
        //dayNames: ["Sunday", "Monday", "Tuesday", "Wednesday", "Thursday", "Friday", "Saturday"],
        //dayNamesShort: ["Sun", "Mon", "Tue", "Wed", "Thu", "Fri", "Sat"],
        dayNamesMin: ["Sun", "Mon", "Tue", "Wed", "Thu", "Fri", "Sat"],

        isRTL: false,

        //minDate: new Date(2007, 1 - 1, 1),
        //maxDate: '+20Y+0M',
        yearRange: '1950:c+10' ,
        //stepMonths: 3,
        //yearSuffix:"-CE",
        //minDate: '-20', maxDate: '+0D',  //+1Y+6M, "+1m +1w", "+1M +10D", '-4Y', minDate: new Date(2010, 0, 1), maxDate: new Date(2010, 5, 31),
        //numberOfMonths:[2,2],
        //defaultDate: +7,
        showOptions: { direction: "up" },
        dateFormat: "dd/mm/yy",
        showAnim: "slideDown", duration: "fast", //fold, slideDown, fadeIn
        buttonImageOnly: true, showOn: "button", buttonImage: "" + tits_project.url + "/images/calendar.png", buttonText: "Date selector",
        //onSelect: function (dateStr) { $("#archive_date").text( dateStr ); },
        //onChangeMonthYear: function (year, month, inst) { $(this).val(month + "/" + year); },
        beforeShow: function(inputElem, inst) { var zi = Number($(inputElem).closest('.modal').css('z-index')); $(inputElem).css('z-index',zi+1); },
        beforeShowDay: function(date) {
            //National Holidays
            var Event = function(text, className) { this.text = text; this.className = className; };

            var events = {};
            events[new Date("02/21/"+date.getFullYear())] = new Event("Shahid Day & International Mother Language Day", "national_holiday");
            events[new Date("03/17/"+date.getFullYear())] = new Event("Father of Nation of Bangladesh", "national_holiday");
            events[new Date("03/26/"+date.getFullYear())] = new Event("Independence & National Day", "national_holiday");
            events[new Date("04/14/"+date.getFullYear())] = new Event("Pahela Boishakh", "national_holiday");
            events[new Date("04/29/"+date.getFullYear())] = new Event("Birth of Buddha", "national_holiday");
            events[new Date("05/01/"+date.getFullYear())] = new Event("International Labour Day & May Day", "national_holiday");
            events[new Date("05/10/"+date.getFullYear())] = new Event("Buddha Purnima", "national_holiday");
            events[new Date("05/02/"+date.getFullYear())] = new Event("Public Sector and Banks. Celebrated on the 15th Sha'aban", "national_holiday");
            //events[new Date("06/13/"+date.getFullYear())] = new Event("Celebrated on the 27th day of Ramadan", "national_holiday");
            events[new Date("08/14/"+date.getFullYear())] = new Event("Shuba Janmashtami", "national_holiday");
            events[new Date("08/15/"+date.getFullYear())] = new Event("National Mourning Day", "national_holiday");
            events[new Date("09/30/"+date.getFullYear())] = new Event("Durga Puja (Bijoya Dashami)", "national_holiday");
            events[new Date("12/25/"+date.getFullYear())] = new Event("Christmas Day", "national_holiday");
            events[new Date("12/31/"+date.getFullYear())] = new Event("Not a public holiday. Banks closed", "national_holiday");

            var event = events[date];
            if (event) { return [true, event.className, event.text]; }

            //var dates = [new Date(date.getFullYear(), 2, 21), new Date(date.getFullYear(), 9, 20),  new Date(date.getFullYear(), 11, 21), new Date(date.getFullYear(), 11, 16)];
           //for (var i = 0; i < dates.length; i++) { if (dates[i].getTime() == date.getTime()) { return [true, 'national_holiday']; } }

            //var weekend = date.getDay() == 4 || date.getDay() == 5;
            //return [!weekend, weekend ? 'weekly-holiday' : ''];
            var weekend = date.getDay() == 5;
            return [true, weekend ? 'weekly-holiday' : ''];
        },
        onSelect: function (){ this.focus(); },
        onClose: function (){ this.focus(); }
    });
    $.datepicker._gotoToday = function(id) { $(id).datepicker('setDate', new Date()).datepicker('hide').focus(); }; //.blur(); if button selector not active


//    $.datepicker.regional['bn'] = {
        //closeText: "Done",
        //prevText: "Prev",
        //nextText: "Next",
        //currentText: "Today",
        //monthNames: ["January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December"],
        //monthNamesShort: ["Jan", "Feb", "Mar", "Apr", "May", "Jun", "Jul", "Aug", "Sep", "Oct", "Nov", "Dec"],
        //dayNames: ["Sunday", "Monday", "Tuesday", "Wednesday", "Thursday", "Friday", "Saturday"],
        //dayNamesShort: ["Sun", "Mon", "Tue", "Wed", "Thu", "Fri", "Sat"],
        //dayNamesMin: ["Su", "Mo", "Tu", "We", "Th", "Fr", "Sa"],
        //weekHeader: "Wk",

//        closeText: 'ওকে',
//        prevText: 'পূর্বের তারিখ',
//        nextText: 'পরের তারিখ',
//        currentText: 'আজকের তারিখ',
//        monthNames: ["জানুয়ারি", "ফেব্রুয়ারি", "মার্চ", "এপ্রিল", "মে", "জুন", "জুলাই", "আগস্ট", "সেপ্টেম্বর", "অক্টোবর", "নভেম্বর", "ডিসেম্বর" ],
//        monthNamesShort: ["জানুয়ারি", "ফেব্রুয়ারি", "মার্চ", "এপ্রিল", "মে", "জুন", "জুলাই", "আগস্ট", "সেপ্টেম্বর", "অক্টোবর", "নভেম্বর", "ডিসেম্বর" ],
//        dayNames: ['শনিবার','রবিবার','সোমবার','মঙ্গলবার','বুধবার','বৃহস্পতিবার','শুক্রবার'],
//        dayNamesShort: ['শনি','রবি','সোম','মঙ্গল','বুধ','বৃহ','শুক্র'],
//        dayNamesMin: ['শনি','রবি','সোম','মঙ্গল','বুধ','বৃহ','শুক্র'],
//        weekHeader: 'সপ্তাহ',
//        dateFormat: "yy/mm/dd",
//	  firstDay: 0,  //0 = Saturday, 1 = Sunday
//        isRTL: false,
//	  showMonthAfterYear: false,
//	  yearSuffix: ""
//    };
//    $.datepicker.setDefaults($.datepicker.regional['bn']);
});



//general Settings
$(function () {
    $('[data-toggle="tooltip"]').tooltip();
    //$(".alert").delay(4000).fadeOut(1500);
});

$(document).ready(function() {
    var emptyTableIcon = '<div class="datatable__empty-data datatable__empty-border"><div class="datatable__empty-default"><div class="datatable__empty-icon"><div class="datatable__icon--inner"><span class="inner-rect"></span> <span class="inner-horizontal-line inner-line1"></span> <span class="inner-horizontal-line inner-line2"></span> <span class="inner-horizontal-line inner-line3"></span> <span class="inner-circle"></span></div></div> <span class="datatable__empty-text">No Data</span></div></div>';

    //var contentHeight = $(".content").css('height', ($( window ).outerHeight() - 195));
    //var tableHeight = $( window ).outerHeight() - $(".content").height();
    //var tableHeight = ( $( window ).outerHeight() - 380 );
    var topbarMenu = $(".topbar-menu").outerHeight(true);
    var header = $("header").outerHeight(true);
    var footer = $("footer").outerHeight(true);

    var t = $('#general_datatable').DataTable({
        fixedHeader: true,
        //fixedHeader: { header: true },
        //responsive: true,
        //select: true,
        //keys: true,
        searchHighlight: true,
        //scrollY: ($( window ).outerHeight() - (topbarMenu + header + footer) - 180),
        scrollCollapse: true,
        scroller: { loadingIndicator: true },
        //stateSave: true,
        deferRender: true,
        paging: true,
        autoWidth: false,
        pagingType: "full_numbers", //full_numbers ('First', 'Previous', 'Next' and 'Last' buttons, plus page numbers), first_last_numbers ('First' and 'Last' buttons, plus page numbers), numbers (Page number buttons only), simple(Previous' and 'Next' buttons only), simple_numbers('Previous' and 'Next' buttons, plus page numbers), full (First', 'Previous', 'Next' and 'Last' buttons)
        order: [], //order: [2, 'asc'],
        displayLength: 25,
        lengthMenu: [[10, 25, 50, 100, 200, 500, -1], [10, 25, 50, 100, 200, 500, "All"]],
        columnDefs: [
            { className: 'control', orderable: false, "searchable": false, targets: [0] }, //-1 for all, 1, 2,  'td:last'
            //{visible: false, targets: [5]}
        ],

        //rowGroup: { dataSrc: 2 },
        //dataSrc: 'office',
        language: {
            decimal: ".", thousands: ",",
            emptyTable:     emptyTableIcon,
            //emptyTable:     "No data available in table",
            info:           "Showing _START_ to _END_ of _TOTAL_ entries",
            infoEmpty:      "Showing 0 to 0 of 0 entries",
            infoFiltered:   "(filtered from _MAX_ total entries)",
            infoPostFix:    "",
            lengthMenu:     "Show _MENU_ entries",
            loadingRecords: "Loading...",
            processing:     "Processing, Please Wait...",
            search:         "Search:",
            zeroRecords:    "No matching records found",
            paginate: { first: "First", last: "Last", next: "<i class='fa fa-chevron-right'></i>", previous: "<i class='fa fa-chevron-left'></i>" },
            //paginate: { first: "First", last: "Last", next: "Next", previous: "Previous" },
            aria: { sortAscending:  ": activate to sort column ascending", sortDescending: ": activate to sort column descending" }
        },
        //"language": { "url": "dataTables.Bangla.json" }
        //dom: 'B<"clear">l<"custom_column_button">frtip',

        dom: 'lBfrtip', //Bfrtip
        buttons: [
            { extend: "copy", text: '<i class="fa fa-copy"> Copy</i>', className: "btn-sm btn-dark" },
            //{ extend: "csv", text: '<i class="fa fa-file-excel"> CSV</i>', className: "btn-sm btn-success" },
            { extend: "excel", text: '<i class="fa fa-file-excel"> Excel</i>', className: "btn-sm btn-info", title: $('h2:first').text(),
                customize: function (xlsx) {
                    var source = xlsx.xl['workbook.xml'].getElementsByTagName('sheet')[0];
                    source.setAttribute('name','New Name');

                    var sheet = xlsx.xl.worksheets['sheet1.xml'];
                    $('row c', sheet).attr('s', '25');
                    //$('row c[r^="C"]', sheet).attr( 's', '2' );
                    //$('row c[r*="10"]', sheet).attr( 's', '25' );
                }
            },
            {
                extend: 'pdfHtml5',
                text: '<i class="fa fa-file-pdf"> PDF</i>',
                title: $('h2:first').text(),
                className: "btn-sm btn-danger",
                orientation: 'landscape', /*portrait*/
                pageSize: 'A4', /*A3 , A5 , A6 , legal , letter*/
                // download: 'open', /*open in new window*/
                exportOptions: { columns: ':not(.no-print)' },
            },
            {
                extend: "print",
                text: '<i class="fa fa-print"> Print</i>',
                title: $('h2:first').text(),
                className: "btn-sm btn-warning",
                footer: true,

                //messageTop: 'This print was produced using the Print button for DataTables',
                exportOptions: {
                    columns: ':not(.no-print)',
                    modifier: {
                        page: 'current',
                        columns: [2, 3, 4, 5, 6, 7, 8, 9, ':visible'],
                        orientation: 'landscape', /*portrait*/
                    }
                },
                customize: function (win) {
                    $(win.document.body).css('font-size', '10pt').prepend('<img src="http://datatables.net/media/images/logo-fade.png" style="position:absolute; top:0; left:0;" />');
                    //$(win.document.body).find( 'table' ).addClass( 'compact' ).css( 'font-size', 'inherit' );
                    $(win.document.body).find('table').addClass('display').css('font-size', '9px');
                    $(win.document.body).find('table thead th').css({"background-color": "#666", "color": "#fff"});
                    $(win.document.body).find('tr:nth-child(odd) td').each(function (index) {
                        $(this).css('background-color', '#D0D0D0');
                    });
                    $(win.document.body).find('h1').css('text-align', 'center');
                }
            },
            /*
            {
                extend: 'colvisGroup',
                className: "btn-sm btn-outline-success",
                text: '<i class="fa fa-tags"> PO</i>',
                show: [ 1, 2 ],
                hide: [ 3, 4, 5 ]
            },
            {
                extend: 'colvisGroup',
                className: "btn-sm btn-outline-danger",
                text: '<i class="fa fa-fire"> Pending Bill</i>',
                show: [ 3, 4, 5 ],
                hide: [ 1, 2 ]
            },
            {
                extend: 'colvisGroup',
                className: "btn-sm btn-outline-info",
                text: '<i class="fa fa-leaf"> Submitted Bill</i>',
                show: [ 3, 4, 5 ],
                hide: [ 1, 2 ]
            },
            {
                extend: 'colvisGroup',
                className: "btn-sm btn-danger",
                text: '<i class="fa fa-th-list"> Show all</i>',
                show: ':hidden'
            },
            {
                extend: 'colvis',
                "activate": "mouseover",
                text: "Columns Visibility",
                collectionLayout: 'fixed two-column',
                columns: '1,2,3,4,5,6,7,8,9,10,11', //:not(:first-child)
                className: "btn-sm btn-primary",
                columnText: function (dt, idx, title) {
                    return (idx + 1) + ': ' + title;
                }
            },
            {
                text: '<i class="fa fa-plus"> Add New Job</i>',
                className: "btn-sm btn-info",
                action: function ( e, dt, node, config ) {
                    window.location.assign("new-job");
                }
            },
            */
        ],
        //search colum data on clicking cell for management page
        /*
        "initComplete": function () {
            var api = this.api();
            api.$('td:eq(1),td:eq(2),td:eq(3),td:eq(4),td:eq(5),td:eq(6),td:eq(7),td:eq(8)').dblclick( function () {
                api.search( this.innerHTML ).draw();
            });
        },
        */

        "initComplete": function () {
            //if(getParam()){ this.api().search( getParam() ).draw(); }
            if(getParamValue('division_name')){ this.api().column( getParamColumn(3) ).search( getParamValue('division_name') ).draw(); }
            if(getParamValue('division_id')){ this.api().column( getParamColumn(3) ).search( getParamValue('division_id') ).draw(); }
            if(getParamValue('user_name')){ this.api().column( getParamColumn(2) ).search( getParamValue('user_name') ).draw(); }
            if(getParamValue('driver_mobile')){ this.api().column( getParamColumn(3) ).search( getParamValue('driver_mobile') ).draw(); }
            if(getParamValue('driver_cocuments')){ this.api().column( getParamColumn(3) ).search( getParamValue('driver_cocuments') ).draw(); }
            if(getParamValue('rider_mobile')){ this.api().column( getParamColumn(11) ).search( getParamValue('rider_mobile') ).draw(); }
            if(getParamValue('vehicle_type')){ this.api().column( getParamColumn(1) ).search( getParamValue('vehicle_type') ).draw(); }
            if(getParamValue('agent_status')){ this.api().column( getParamColumn(10) ).search( getParamValue('agent_status') ).draw(); }
            if(getParamValue('referral_code')){ this.api().column( getParamColumn(2) ).search( getParamValue('referral_code') ).draw(); }
            if(getParamValue('trip_driver_id')){ this.api().column( getParamColumn(2) ).search( getParamValue('trip_driver_id') ).draw(); }
            if(getParamValue('trip_driver_mobile')){ this.api().column( getParamColumn(2) ).search( getParamValue('trip_driver_mobile') ).draw(); }
            if(getParamValue('trip_status')){ this.api().column( getParamColumn(9) ).search( getParamValue('trip_status') ).draw(); }
            if(getParamValue('trip_rider_mobile')){ this.api().column( getParamColumn(11) ).search( getParamValue('trip_rider_mobile') ).draw(); }
            if(getParamValue('todays_trip_filter')){ this.api().column( getParamColumn(12) ).search( getParamValue('todays_trip_filter') ).draw(); }
            if(getParamValue('this_month_trip_filter')){ this.api().column( getParamColumn(13) ).search( getParamValue('this_month_trip_filter') ).draw(); }
            if(getParamValue('trip_search_rider_mobile')){ this.api().column( getParamColumn(8) ).search( getParamValue('todays_trip_search_filter') ).draw(); }
            if(getParamValue('todays_trip_search_filter')){ this.api().column( getParamColumn(9) ).search( getParamValue('todays_trip_search_filter') ).draw(); }
            if(getParamValue('this_month_trip_search_filter')){ this.api().column( getParamColumn(10) ).search( getParamValue('this_month_trip_search_filter') ).draw(); }
            if(getParamValue('trip_number')){ this.api().column( getParamColumn(1) ).search( getParamValue('trip_number') ).draw(); }
            if(getParamValue('vehicle_reg_number')){ this.api().column( getParamColumn(6) ).search( getParamValue('vehicle_reg_number') ).draw(); }
        }
    });

    //var column = t.column(':contains(Action)');
    //t.orderable([8, false]).draw();

    //index counter (Serial No.)
    t.on( 'order.dt search.dt', function () {
        t.column(0, {search:'applied', order:'applied'}).nodes().each( function (cell, i) {
            cell.innerHTML = i+1;
            t.cell(cell).invalidate('dom');//show number to print/ pdf page
        } );
    }).draw();

}); //End of Document ready


function getParamValue(param_name){
    // return (location.search.split(name + '=')[1] || '').split('&')[0];
    // return window.location.href.slice(window.location.href.indexOf('?') + 1).split('division_name=')[1];
    var params = new window.URLSearchParams(window.location.search);
    var param_value = '';
    if(params.has(param_name)){ param_value = params.get(param_name); };
    return param_value;
}

function getParamColumn(column_number){
    //var params = new window.URLSearchParams(window.location.search);
    //var column_number = '';
    // if(params.has('division_name')){ column_number = 1; };
    // if(params.has('po_number')){ column_number = 1; };
    return column_number;
}


function search_column(filter_value, table_name){
    var table = $('table#'+table_name).DataTable();

    if(table.search( filter_value ).draw().page.info().recordsDisplay == 1){ $('table#'+table_name).find('tbody tr:first').css('height', '100px'); };
    //alert(table.page.info().recordsTotal);
    //alert(table.columns().header().length);
    //alert(table.rows().count());
    //table.page( 'next' ).draw( 'page' );
    return table.column( column_number ).search( filter_value===""? "" : '^' + filter_value +'$', true, false).draw();
    //return table.search( filter_value ).draw();
}

function filter_column(filter_value, table_name, column_number){
    //for get id (this.id, this.value)
    //var e = document.getElementById(filter_id);
    //alert(e.options[e.selectedIndex].value);
    var table = $('table#'+table_name).DataTable();

    if(table.column( column_number ).search( filter_value ).draw().page.info().recordsDisplay == 1){
        $('table#'+table_name).find('tbody tr:first').css('height', '100px');
    };
    return table.column( column_number ).search( filter_value ).draw();
}

function filter_column_exact_value(filter_value, table_name, column_number){
    //for get id (this.id, this.value)
    //var e = document.getElementById(filter_id);
    //alert(e.options[e.selectedIndex].value);

    var table = $('table#'+table_name).DataTable();
    if(table.column( column_number ).search( filter_value ).draw().page.info().recordsDisplay == 1){ $('table#'+table_name).find('tbody tr:first').css('height', '100px'); };
    return table.column( column_number ).search( filter_value===""? "" : '^' + filter_value +'$', true, false).draw();
    //return table.column( column_number ).search( '\\b' + filter_value +'\\b', true, false).draw();
    //return table.column( column_number ).search( filter_value ).draw();
}

// $('.dataTables_filter input').unbind().bind('keyup', function() {
//     var searchTerm = this.value.toLowerCase(),
//         regex = '\\b' + searchTerm + '\\b';
//     table.rows().search(regex, true, false).draw();
// })



$(document).ready(function() {
    /**********************************************************/
    /**********   Blank Status table on dashboard   **********/
    var b = $('#submitted_billing_status').DataTable( {
        "paging": true,
        "lengthChange": false,
        "searching": false,
        "ordering": true,
        "info": true,
        "pageLength": 5,
        "autoWidth": false,

        // Datatables Grand Total row
        "footerCallback": function ( row, data, start, end, display ) {
            var api = this.api(), data;

            // Remove the formatting to get integer data for summation
            var intVal = function ( i ) { return typeof i === 'string' ? i.replace(/[\$,]/g, '')*1 : typeof i === 'number' ? i : 0; };

            // Total over all pages
            total = api.column( 3 ).data().reduce( function (a, b) { return intVal(a) + intVal(b); }, 0 );

            // Total over this page
            pageTotal = api.column( 3, { page: 'current'} ).data().reduce( function (a, b) { return intVal(a) + intVal(b); }, 0 );

            // Update footer
            $( api.column( 3 ).footer() ).html(
                //'$'+pageTotal +' ( $'+ total +' total)'
                ''+pageTotal +' / ( '+ total +' )'
            );
        }
    });
    //index counter (Serial No.)
    b.on( 'order.dt search.dt', function () {
        b.column(0, {search:'applied', order:'applied'}).nodes().each( function (cell, i) {
            cell.innerHTML = i+1;
            b.cell(cell).invalidate('dom');
        } );
    }).draw();
}); //End of Document ready


$(document).ready(function() {
    /**********************************************************/
    /**********   Rented Status table on dashboard   **********/
    var r = $('#pending_billing_status').DataTable( {
        "paging": true,
        "lengthChange": false,
        "searching": false,
        "ordering": true,
        "info": true,
        "pageLength": 5,
        "autoWidth": false,


        // Datatables Grand Total row
        "footerCallback": function ( row, data, start, end, display ) {
            var api = this.api(), data;

            // Remove the formatting to get integer data for summation
            var intVal = function ( i ) { return typeof i === 'string' ? i.replace(/[\$,]/g, '')*1 : typeof i === 'number' ? i : 0; };

            // Total over all pages
            total = api.column( 3 ).data().reduce( function (a, b) { return intVal(a) + intVal(b); }, 0 );

            // Total over this page
            pageTotal = api.column( 3, { page: 'current'} ).data().reduce( function (a, b) { return intVal(a) + intVal(b); }, 0 );

            // Update footer
            $( api.column( 3 ).footer() ).html(
                //'$'+pageTotal +' ( $'+ total +' total)'
                ''+pageTotal +' / ( '+ total +' )'
            );
        }
    });
    //index counter (Serial No.)
    r.on( 'order.dt search.dt', function () {
        r.column(0, {search:'applied', order:'applied'}).nodes().each( function (cell, i) {
            cell.innerHTML = i+1;
            r.cell(cell).invalidate('dom');
        } );
    }).draw();
}); //End of Document ready


$(document).ready(function() {
    /**********************************************************/
    /**********   Rented Status table on dashboard   **********/
    var r = $('#po_receiving_status00').DataTable( {
        "paging": true,
        "lengthChange": false,
        "searching": false,
        "ordering": true,
        "info": true,
        "pageLength": 5,
        "autoWidth": false,

        // Datatables Grand Total row
        "footerCallback": function ( row, data, start, end, display ) {
            var api = this.api(), data;

            // Remove the formatting to get integer data for summation
            var intVal = function ( i ) { return typeof i === 'string' ? i.replace(/[\$,]/g, '')*1 : typeof i === 'number' ? i : 0; };

            // Total over all pages
            total = api.column( 3 ).data().reduce( function (a, b) { return intVal(a) + intVal(b); }, 0 );

            // Total over this page
            pageTotal = api.column( 3, { page: 'current'} ).data().reduce( function (a, b) { return intVal(a) + intVal(b); }, 0 );

            // Update footer
            $( api.column( 3 ).footer() ).html(
                //'$'+pageTotal +' ( $'+ total +' total)'
                ''+pageTotal +' / ( '+ total +' )'
            );
        }
    });

    //index counter (Serial No.)
    r.on( 'order.dt search.dt', function () {
        r.column(0, {search:'applied', order:'applied'}).nodes().each( function (cell, i) {
            cell.innerHTML = i+1;
            r.cell(cell).invalidate('dom');
        } );
    }).draw();
}); //End of Document ready



$(document).ready(function() {
    /**********   Rented Status table on dashboard   **********/
    var r = $('#divisionwise_billboard_summery').DataTable( {
        "paging": false,
        "lengthChange": false,
        "searching": false,
        "ordering": false,
        "info": false,
        "pageLength": 10,
        "autoWidth": false,

        // Datatables Grand Total row
        /*
        "footerCallback": function ( tfoot, data, start, end, display ) {
            var api = this.api(), data;
            var intVal = function ( i ) { return typeof i === 'string' ? i.replace(/[\$,]/g, '')*1 : typeof i === 'number' ? i : 0; };

            // Total over all pages
            billboard_total = api.column( 2 ).data().reduce( function (a, b) { return intVal(a) + intVal(b); }, 0 );
            unipole_total = Number(api.column( 3 ).data().reduce( function (a, b) { return intVal(a) + intVal(b); }, 0 ));
            neon_sign_total = api.column( 4 ).data().reduce( function (a, b) { return intVal(a) + intVal(b); }, 0 );
            led_sign_total = api.column( 5 ).data().reduce( function (a, b) { return intVal(a) + intVal(b); }, 0 );
            rented_total = api.column( 6 ).data().reduce( function (a, b) { return intVal(a) + intVal(b); }, 0 );
            blank_total = api.column( 7 ).data().reduce( function (a, b) { return intVal(a) + intVal(b); }, 0 );
            pageTotal = api.column( 8, { page: 'current'} ).data().reduce( function (a, b) { return intVal(a) + intVal(b); }, 0 );

            $( api.column( 1 ).footer() ).html('Total');
            $( api.column( 2 ).footer() ).html(billboard_total + " Nos");
            $( api.column( 3 ).footer() ).html(unipole_total + " Nos");
            $( api.column( 4 ).footer() ).html(neon_sign_total + " Nos");
            $( api.column( 5 ).footer() ).html(led_sign_total + " Nos");
            $( api.column( 6 ).footer() ).html(rented_total + " Nos");
            $( api.column( 7 ).footer() ).html(blank_total + " Nos");
            $( api.column( 8 ).footer() ).html(pageTotal + " Nos");
        },
         */
        //"headerCallback": function( thead, data, start, end, display ) {
        //    $(thead).find('th').eq(0).html( 'Displaying '+(end-start)+' records' );
        //},
        // "drawCallback": function( settings ) {
        //     var api = this.api();
        //
        //     // Output the data for the visible rows to the browser's console
        //     console.log( api.rows( {page:'current'} ).data() );
        // }
    });

    //index counter (Serial No.)
    r.on( 'order.dt search.dt', function () {
        r.column(0, {search:'applied', order:'applied'}).nodes().each( function (cell, i) {
            cell.innerHTML = i+1;
            r.cell(cell).invalidate('dom');
        });
    }).draw();
});



$(document).ready(function() {
    /**********   Rented Status table on dashboard   **********/
    var r = $('#running_job_status00').DataTable( {
        "paging": true,
        "lengthChange": false,
        "searching": false,
        "ordering": true,
        "info": true,
        "pageLength": 5,
        "autoWidth": false,

        // Datatables Grand Total row
        "footerCallback": function ( tfoot, data, start, end, display ) {
            var api = this.api(), data;
            var intVal = function ( i ) { return typeof i === 'string' ? i.replace(/[\$,]/g, '')*1 : typeof i === 'number' ? i : 0; };

            // Total over all pages
            total = api.column( 3 ).data().reduce( function (a, b) { return intVal(a) + intVal(b); }, 0 );

            // Total over this page
            pageTotal = api.column( 3, { page: 'current'} ).data().reduce( function (a, b) { return intVal(a) + intVal(b); }, 0 );

            // Update footer
            $( api.column( 3 ).footer() ).html(
                //'$'+pageTotal +' ( $'+ total +' total)'
                ''+pageTotal +' / ( '+ total +' )'
            );
        }
    });
    //index counter (Serial No.)
    r.on( 'order.dt search.dt', function () {
        r.column(0, {search:'applied', order:'applied'}).nodes().each( function (cell, i) {
            cell.innerHTML = i+1;
            r.cell(cell).invalidate('dom');
        } );
    }).draw();
});





(function ($) {
    //    $('.dataTables_filter label').css({ position: 'relative', });
//    $('.dataTables_filter input').css({ right: '5%', top: '25%', margin: 'auto', fontSize: '18px', cursor: 'pointer', color: '#0073aa', zIndex: '999', position: 'absolute', });

    $('.dataTables_filter input').addClass('searchinput');
    $('.dataTables_filter input').attr('placeholder', 'Search Data');
    $('.dataTables_filter input').after('<i class="searchclear fa fa-times" aria-hidden="true"></i>');

    $(".searchinput").keyup(function () {
        $(".searchclear").show();
    });

    $(".searchclear").toggle(Boolean($(".searchinput").val()));
    $(".searchclear").click(function () {
        $(this).prev().val('').focus();
        $(this).hide();
        var table = $('table.datatables').DataTable();

        //clear datatable
        table.search('').columns().search('').draw();
    });
})(jQuery);




$(document).ready(function () {
    // Select all checkboxs
    $('#select-all').on('click', function () {
        var rows = table.rows({'search': 'applied'}).nodes();

        $('input[type="checkbox"]', rows).prop('checked', this.checked);
        $('table tbody tr').toggleClass('selected');
    });

    $('table tbody tr td input:checkbox').on('click', function(){
        //var count = $('input[type=checkbox]:indeterminate').length;
        var checkedCount = $('input:checked').length;
        var totalCheckbox = $('input[type=checkbox]').length;

        if ( checkedCount > 0 && checkedCount < totalCheckbox ) {
            $('#select-all').prop("indeterminate", true);
        }else{
            $('#select-all').prop("indeterminate", false);
        }
        $(this).closest('tr').toggleClass('selected');
    });


    $("div.delete_selected_button").html('<input id="delete_selected" type="submit" value="Delete Selected" name="delete_selected" class="btn btn-outline-danger delete_selected btn-sm" /><span style="margin-left: 10px;"></span>').css({ "position": "absolute", "left": "30%", "top": 0, "display": "none" });

    var table = $('table#general_datatable').DataTable();
    table.on('change', 'input[type="checkbox"]', function () {
        var row_count = table.rows('.selected').data().length;

        if ($(this).is(":checked") && row_count > 1) {
            $(".delete_selected_button").fadeIn('slow')
            $(".delete_selected_button span").text(row_count + ' records selected');
        } else {
            $(".delete_selected_button").fadeOut('slow');
        }
    });


    $('input#delete_selected').on('click', function (e) {
        e.preventDefault();

        var selected_checkbok = $('table').find('tr.selected').find('input[type="checkbox"]:checked');
        var url = selected_checkbok.data('href');

        var chkArray = [];
        selected_checkbok.each(function() { chkArray.push($(this).val()); });
        //var selected_ids = chkArray.join(',');
        var selected_ids = chkArray;
        //var row_count = table.rows('.selected').count();
        //window.alert(selected_ids);

        if (!confirm('Are you sure to delete ' + selected_ids.length + ' records from database permanently?')){ return; }

        $.ajaxSetup({
            headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') }
        });

        $.ajax({
            type: "POST",
            url: url,
            data: {ids: selected_ids, _method: 'DELETE' },
            dataType: 'json',
            success: function (data) {
                $.each(data.ids, function(key, value){
                    $("table").find('tr#' + value).animate({ backgroundColor: "#e74c3c", color: "#fff" }, "slow").animate({ opacity: "hide" }, "slow");
                });
                toastr.success( data.success );
            },
            statusCode:{ 404: function(){ alert( "page not found" ); } },
            error: function (xhr, textStatus, errorThrown) { alert(errorThrown); },
            beforeSend: function( xhr ) { $(".ajax-loader").show('slow'); },
            complete: function( jqXHR, textStatus ) { $(".ajax-loader").hide('fast'); },
        });
    });
});


$(document).ready(function(){
   // var table = $('table#general_datatable').DataTable();

   // $('#division_filter, #district_filter, #business_type_filter').each(function () {
   //     $(this).on('change', function () {
   //         table.search(this.value).draw();
   //     });
   // });
   // $("select#division_filter").appendTo('div.custom_column_button').delay(1000).fadeIn(1500);
   // $("select#district_filter").appendTo('div.custom_column_button').delay(1000).fadeIn(1500);
   // $("select#business_type_filter").appendTo('div.custom_column_button').delay(1000).fadeIn(1500);
   // $('.dataTables_wrapper').wrap('<form id="delete_selected_member_form" name="delete_selected_member_form" method="post"></form>');

    // $('#division_filter').on('change', function(){ table.column( 1 ).search( this.value ).draw(); });
    // $('#district_filter').on('change', function(){ table.column( 2 ).search( this.value ).draw(); });
    // $('#size_filter').on('change', function(){ table.column( 4 ).search( this.value ).draw(); });
    // $('#status_filter').on('change', function(){ table.column( 5 ).search( this.value ).draw(); });
    // $('#type_filter').on('change', function(){ table.column( 7 ).search( this.value ).draw(); });
    // $('#position_filter').on('change', function(){ table.search(this.value).draw(); });
});

function search_column(filter_value, table_name){
    var table = $('table#'+table_name).DataTable();
    return table.search( filter_value ).draw();
}

function filter_column(filter_value, table_name, column_number){
    //for get id (this.id, this.value)
    //var e = document.getElementById(filter_id);
    //alert(e.options[e.selectedIndex].value);

    var table = $('table#'+table_name).DataTable();
    return table.column( column_number ).search( filter_value ).draw();
}

function filter_column_serverside(filter_value, table_name){
    var table = $('table#'+table_name).DataTable();
    return table.column().search( filter_value ).draw();
}

$(document).ready(function(){
    $("body").on('click', 'button.ajaxDelete', function(event) {
        event.preventDefault();

        var modal = $('#deleteModal');
        var url = $(this).data('href');
        var id = $(this).attr('id');
        var title = $(this).data('title');
        var parentTr = $(this).closest('tr');

        modal.find('.modal-body').find('strong').text( title );

        modal.modal({ keyboard: true }).on('click', '#delete', function () {

            $.ajaxSetup({
                headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') }
            });

            $.ajax({
                url: url,
                method: "POST",
                data: { _method: 'DELETE', id: id },
                dataType: "json",
                cache:false,
                async: true,
                success: function( response ) {
                    toastr.info( response.message, "Delete Success", {"closeButton": true,"newestOnTop": true,"progressBar": true,"preventDuplicates": true});

                    modal.modal('hide');
                    parentTr.animate({ backgroundColor: "#e74c3c", color: "#fff" }, "slow").animate({ opacity: "hide" }, "slow");
                    //parentTr.slideUp(300, function() { parentTr.closest("tr").remove(); });
                    //setInterval(function() { window.location.reload(); }, 5900);
                    //setTimeout(function(){ window.location.reload(); },1000);
                },
                error: function( errorThrown, xhr, data ) {
                    //$('.alert.alert-danger').fadeIn('slow').delay(3000).hide('slide', {direction: 'down'}, 1000);
                    //console.log(xhr.responseText);
                    if( data.status === 422 ) { toastr.error('Cannot delete the category'); }
                },
                statusCode:{ 404: function(){ alert( "page not found" ); } },
                beforeSend: function( xhr ) { $(".ajax-loader").show('slow'); },
                complete: function( jqXHR, textStatus ) {
                    //$(".ajax-loader").hide('fast').detach();
                    //$('form :input').val('');
                    $(".ajax-loader").hide('fast');
                },
            });
        });
        return false;
    });
}); //End of Document ready




// Step by step form for edit registers
//$(document).ready(function () {
//
//    $("#po_qty, #rate, #used_po_qty").each(function(){
//
//        $(this).on('keyup blur change', function(){
//
//            $("#po_amount").val(parseInt( $("#po_qty").val() * $("#rate").val() ));
//
//
//            if($("#active_vat").is(':checked')){
//                $("#po_vat").val(parseInt($("#po_amount").val()*15/100));
//                $("#po_total_amount").val(parseInt($("#po_amount").val())+parseInt($("#po_vat").val()));
//            }else{
//                $("#po_total_amount").val(parseInt($("#po_amount").val()));
//            }
//
//            if($("#used_po_qty").val() == 0 || null){$("#used_po_qty").val('0')}
//            $("#pending_po_qty").val(parseInt($("#po_qty").val()) - parseInt($("#used_po_qty").val()));
//        });
//    });
//
//
//
//    $("#active_vat").click(function(){
//        var vat = $("#po_vat");
//
//        if( $(this).is(':checked')){
//            $(vat).val($("#po_amount").val()*15/100);
//            $("#po_total_amount").val(parseInt($("#po_amount").val())+parseInt($("#po_vat").val()));
//            $(vat).attr("disabled", "disabled");
//            $(vat).prop("disabled", false);
//        }else{
//            $(vat).attr('disabled', true);
//            $(vat).val("");
//            $("#po_total_amount").val(parseInt($("#po_amount").val()));
//        }
//
//    });
//
//
//    $("#amountWithVat").click(function(e){
//        e.preventDefault();
//        $('#gen_net_value').modal();
//    });
//
//    // Billing Amount with VAT Modal
//    $("#po_amount_with_vat_modal").keyup(function(){
//        var billingAWV = $("#po_amount_with_vat_modal").val();
//        $("#po_vat_modal").val(parseInt(billingAWV) - parseInt(billingAWV/115*100));
//        $("#net_po_amount").val(parseInt(billingAWV) - parseInt($("#po_vat_modal").val()));
//    });
//
//
//    $("#active_bill").on('click', function(){
//        var billing_amount = $("#billing_amount");
//        var billing_amount_with_vat = $("#billing_amount_with_vat");
//        if( $(this).is(":checked") ){
//            $(billing_amount).val( $("#rate").val() * $("#used_po_qty").val() );
//            $(billing_amount_with_vat).val( $(billing_amount).val() );
//            $(billing_amount).attr("disabled", "disabled");
//            $(billing_amount).prop('disabled', false);
//        }else{
//            $(billing_amount).attr({"class":"disabled form-control"});
//            $(billing_amount).val("");
//            $(billing_amount).attr('disabled', true);
//
//            $(billing_amount_with_vat).attr({"class":"disabled form-control"});
//            $(billing_amount_with_vat).val("");
//            $(billing_amount_with_vat).attr('disabled', true);
//        };
//    });
//
//
//
//
//    $("#active_bill_vat").click(function(){
//        var billing_vat = $("#billing_vat");
//
//        if( $(this).is(':checked') ){
//            $(billing_vat).val($("#billing_amount_with_vat").val()*15/100);
//            $("#billing_amount_with_vat").val( parseInt( $("#billing_amount").val()) + parseInt( $(billing_vat).val()) );
//            $(billing_vat).attr("disabled", "disabled");
//            $(billing_vat).prop('disabled', false);
//        }else{
//            $(billing_vat).attr({"class":"disabled form-control"});
//            $(billing_vat).val("");
//            $(billing_vat).attr('disabled', true);
//            $("#billing_amount_with_vat").val( $("#billing_amount").val());
//        }
//    });
//
//    $("#active_installment").click(function(){
//            var installment = $("#first_installment, #second_installment, #third_installment, #fourth_installment");
//        if( $(this).is(':checked') ){
//            $(installment).val($("#billing_amount_with_vat").val()/4);
//            $(installment).attr("disabled", "disabled");
//            $(installment).prop('disabled', false);
//        }else{
//            $(installment).attr({"class":"disabled form-control"});
//            $(installment).val("");
//            $(installment).attr('disabled', true);
//        }
//    });
//}); //End of Document ready




// Step by step form for edit registers
// $(document).ready(function () {
//     var navListItems = $('div.setup-panel div a'),
//     allWells = $('.setup-content'),
//     allNextBtn = $('.nextBtn');
//
//   allWells.hide();
//
//   navListItems.click(function (e) {
//         e.preventDefault();
//         var $target = $($(this).attr('href')),
//           $item = $(this);
//
//         if (!$item.hasClass('disabled')) {
//           navListItems.removeClass('btn-primary').addClass('btn-default');
//           $item.addClass('btn-primary');
//           allWells.hide();
//           $target.show();
//           $target.find('input:eq(0)').focus();
//         }
//   });
//
//     allNextBtn.click(function(){
//         var curStep = $(this).closest(".setup-content"),
//         curStepBtn = curStep.attr("id"),
//         nextStepWizard = $('div.setup-panel div a[href="#' + curStepBtn + '"]').parent().next().children("a"),
//         curInputs = curStep.find("input[type='text'],input[type='url'],textarea[textarea]"),
//         isValid = true;
//
//         $(".form-group").removeClass("has-error");
//         for(var i=0; i<curInputs.length; i++){
//           if (!curInputs[i].validity.valid){
//             isValid = false;
//             $(curInputs[i]).closest(".form-group").addClass("has-error");
//           }
//         }
//
//         if (isValid)
//         nextStepWizard.removeAttr('disabled').trigger('click');
//     });
//
//   $('div.setup-panel div a.btn-primary').trigger('click');
//
// }); //End of Document ready



$(document).ready(function(){
    // Progressbar
    $(".progress .progress-bar")[0] && $(".progress .progress-bar").progressbar();

    $(".basic_summernote").summernote({
        tabsize: 2,
        fontSize: 20,
        height: 100,
        toolbar:[
           ['style', ['bold', 'italic', 'underline', 'color', 'height', 'clear']],
           ['para', ['ul', 'ol', 'paragraph', 'hr']],
        ],
    });

    // wysiwygi text editor toolbar
    $(".summernote").summernote({
        placeholder: 'Product Description Here...',
        tabsize: 2,
        fontSize: 20,
        height: 200,
        //fontNames: ['Arial', 'Arial Black', 'Comic Sans MS', 'Courier New']
        toolbar:[
           ['fontname', ['fontname', 'fontsize', 'height']],
           ['style', ['bold', 'italic', 'underline', 'color', 'clear']],
           ['para', ['ul', 'ol', 'paragraph']],
           //['strikethrough', ['strikethrough', 'superscript', 'subscript']],
           ['picture', ['picture', 'video', 'link']],
           ['table', ['table', 'hr']],
           ['fullscreen', ['fullscreen', 'undo', 'redo']], //'codeview', 'help',
        ],
    });
    $(".note-editor").find(".note-btn-group button").css({padding: '0.25rem 0.4rem'});

    $('.note-editor').append( '<span class="charCount" style="font-weight: bold; font-size: 14px; margin-left: 15px;"></span>' );
    $('#editor').on('summernote.keydown', function(we, e) {
        var len = $(this).val().length + 1;
        $('.charCount').text("Charecter Count: " + len);
    });


    // iCheck
    if ($("input.flat")[0]) {
        $('input.flat').iCheck({
            checkboxClass: 'icheckbox_flat-green',
            radioClass: 'iradio_flat-green'
        });
    }

    // Smart Form wizard for add new register
//    $('#wizard').smartWizard();
//
//    $('#wizard_edit').smartWizard({
//        transitionEffect: 'slide'
//    });

    // $('.buttonPrevious').addClass('btn btn-info');
    // $('.buttonNext').addClass('btn btn-primary');
    // $('.buttonFinish').addClass('btn btn-success');
    // $('.buttonBack').addClass('btn btn-warning');




    // Progress bar Change based on value
    var progressBar = $(".progress .progress-bar");
    var dayRemaining = $(".progress .progress-bar").text();

    if(dayRemaining<=5) progressBar.addClass("progress-bar-green");
    else if(dayRemaining<=10) progressBar.addClass("progress-bar-success");
    else if(dayRemaining<=15) progressBar.addClass("progress-bar-aqua");
    else if(dayRemaining<=20) progressBar.addClass("progress-bar-info");
    else if(dayRemaining<=25) progressBar.addClass("progress-bar-primary");
    else if(dayRemaining<=30) progressBar.addClass("progress-bar-warning");
    else if(dayRemaining<=35) progressBar.addClass("progress-bar-danger");

//    // Progress bar Change based on value
//    var progressBarColor;
//    var someValueToCheck = 5;
//
//    if(someValueToCheck >= 10) progressBarColor = "#A52A2A";
//    else if(someValueToCheck >=5) progressBarColor = "#00FFFF";
//    else progressBarColor = "#00008B";

//    $("#progressbar").css('background-color', progressBarColor);
}); //End of Document ready


$(document).ready(function(){
    // $('input[type="tel"]').parents('div.form-group').append( '<span class="characterCountwrap" style="float: right; margin-bottom: 10px;">Must be <var style="font-style: normal; font-weight: bold;">13</var> digits. <em class="currently_entered">Currently Entered: <var style="font-style: normal; font-weight: bold;">0</var> digits.</em></span>' );

    $('input[type="tel"]').on('focus', function (e) {
        $(this).on('keyup', function(){
            var max = 13;
            var len = $(this).val().length;
            var ch = max - len;

            if (len >= max) {
                $('.characterCount').text('Limit exceeded');
                $('.characterCount').removeClass('btn-dark').addClass('btn-danger');
                $('.characterCountwrap em var').text(len).css('color', 'red');
            }
            else {
                $('.characterCount').text(ch + ' char left');
                $('.characterCountwrap em var').text(len);
                $('.characterCount').removeClass('btn-danger').addClass('btn-dark');
            }
        });
    });
}); //End of Document ready









$(document).ready(function(){
/*
$('#deleteModal').on('shown.bs.modal', function () {
    var modal = $(this);

    $(document).on('keydown', function( event ){
        event.preventDefault();

        var key = event.which || event.keyCode;
        if( key == '27' ){
            modal.modal('hide');
        }
        else if(key == '13'){
            modal.find('button[type=submit]').trigger('click');
        }
    });
});
*/
  }); //End of Document ready




$(document).ready(function(){
//    $("#fullscreen").on('click', function(){
//        $('#fullscreen').fullscreen(true);
//        return false;
//    });

    var requestFullscreen = function (ele) {
      if (ele.requestFullscreen) {
              ele.requestFullscreen();
      } else if (ele.webkitRequestFullscreen) {
              ele.webkitRequestFullscreen();
      } else if (ele.mozRequestFullScreen) {
              ele.mozRequestFullScreen();
      } else if (ele.msRequestFullscreen) {
              ele.msRequestFullscreen();
      } else {
              console.log('Fullscreen API is not supported.');
      }
  };

    var exitFullscreen = function () {
        if (document.exitFullscreen) {
                document.exitFullscreen();
        } else if (document.webkitExitFullscreen) {
                document.webkitExitFullscreen();
        } else if (document.mozCancelFullScreen) {
                document.mozCancelFullScreen();
        } else if (document.msExitFullscreen) {
                document.msExitFullscreen();
        } else {
                console.log('Fullscreen API is not supported.');
        }
    };


    $("#fullscreen").on('click', function(e){
        e.preventDefault();
        //requestFullscreen(document.documentElement);
        requestFullscreen(document.documentElement);
        $(this).hide();
        $("#exitFullscreen").show();
    });
    $("#exitFullscreen").on('click', function(e){
        e.preventDefault();
        exitFullscreen();
        $(this).hide();
        $("#fullscreen").show();
    });

    $("#fullscreenVideo").on('click', function(e){
        e.preventDefault();
        requestFullscreen('#video');
    });
    $("#fullscreenImage").on('click', function(e){
        e.preventDefault();
        requestFullscreen('#image');
    });
}); //End of Document ready





$(document).ready(function(){
    //Password Generator Modal
    $('#gen_password').click(function(){
        $('#gen_password_modal').modal();
    });

    $("#gen_new_pwd").click(function(){

        var alpha_lower = $("#alpha_lower").is(':checked') ? $("#alpha_lower").val() : '';
        var alpha_upper = $("#alpha_upper").is(':checked') ? $("#alpha_upper").val() : '';
        var numeric = $("#numeric").is(':checked') ? $("#numeric").val() : '';
        var special = $("#special").is(':checked') ? $("#special").val() : '';
        var charset = alpha_lower + alpha_upper + numeric + special;

        var password = '';
        var password_length = parseInt($('#pwd_length').val());

        for(var i = 0; i < password_length; i++){
            var random_position = Math.floor(Math.random() * charset.length);
            password += charset[random_position];
        }
        if(password.length == password_length){
            password = password.replace(/</g, "&lt;").replace(/>/g, "&gt;");
            $('#gen_pwd_container').val(password);
        }else{
            console.log(password.length , password_length);
        }
    });

    $('#password_copied').click(function(e){
        if( $(this).is(':checked') ){
            $('#use_password').attr({class: "btn btn-success", disabled: "disabled"});
            $('#use_password').prop('disabled',false);
        }else{
            $('#use_password').attr("class", "disabled btn btn-success");
            $('#use_password').attr('disabled',true);
        }
    });

    $('#use_password').click(function(){
        $('#password, #confirm_password').val( $('#gen_pwd_container').val() );
        $('#password').focus().blur();
    });

    $("#select_n_copy").click(function(){
        $("#gen_pwd_container").focus();
        $("#gen_pwd_container").select();
        document.execCommand('copy');

        $( ".coppied_msg" ).text( "Password Copied to clipboard" ).show().fadeOut( 2000 )
    });


    $("#gen_password_byadmin, .gen_password_member").on('click', function(){
        var modal = $(this).parents('.modal');

        var charset = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789!@#$%^&*()-_ []{}<>~`+=,.;:/?|';
        var password = '';

        for(var i = 0; i < 18; i++){
            var random_position = Math.floor(Math.random() * charset.length);
            password += charset[random_position];
        }
        password = password.replace(/</g, "&lt;").replace(/>/g, "&gt;");

        modal.find('#password, #confirm_password').val( password );
        modal.find('#password').focus().blur();
    });



    //show hide password on registration/change password page form
    $("#show_profile_password").on("click", function(e) {
        e.preventDefault();

        $(this).closest("button").toggleClass("btn-warning");
        $(this).closest("button").find("i").toggleClass("fa-eye-slash");

        var btnText = $(this).closest("button").find("span").text();
        if( btnText == "Show Password" ){
            $(this).closest("button").find("span").text("Hide Password");
            $("input:password").attr("type", "text");
        }else{
            $(this).closest("button").find("span").text("Show Password");
            $("input#old_password").attr("type", "password");
            $("input#password").attr("type", "password");
            $("input#confirm_password").attr("type", "password");
        }
    });

    $("#confirm_password").focus(function(){
        $(this).parents('.form-group').append('<span class="matchPassword"></span>');
        $(this).keyup(function(){
            if($('#password').val() != $("#confirm_password").val() ){
                $(".matchPassword").removeClass('text-success').addClass("text-danger");
                $(".matchPassword").text("Passwords Don't Match!");
            }else{
                $(".matchPassword").removeClass('text-danger').addClass("text-success");
                $(".matchPassword").text("Passwords Matched");
            }
        });
    });
    $("#confirm_password").blur(function(){
        $(".matchPassword").remove();
    });



    $(".modal").on("click", 'button.show_password', function(e) {
        e.preventDefault();

        var modal_id = $(this).parents('.modal').attr('id');

        $(this).toggleClass("btn-danger active");
        $(this).find("i").toggleClass("fa-eye-slash");

        if( $(this).hasClass("active") ){
            $("#"+modal_id).find("input:password").attr("type", "text");
        }else{
            $("#"+modal_id).find("input#password").attr("type", "password");
            $("#"+modal_id).find("input#confirm_password").attr("type", "password");
        }
    });


/******** passwors confirmation validation ****************/
//    var password = document.getElementById("password"),
//        confirm_password = document.getElementById("confirm_password");
//
//    function validatePassword(){
//      if(password.value != confirm_password.value) {
//        confirm_password.setCustomValidity("Passwords Don't Match");
//      } else {
//        confirm_password.setCustomValidity('');
//      }
//    }
//
//    if(password) password.onchange = validatePassword;
//    if(confirm_password) confirm_password.onkeyup = validatePassword;


}); //End of Document ready







$(document).ready(function(){
    $("form#searchform").submit(function(){

        var search_text = $.trim($('[name=s]', this).val());

        /*
        if( search_text == 'কী খুঁজতে চান?' || !search_text){
            alert('অনুগ্রহ পূর্বক খোজ করার জন্য কিছু একটা লিখুন');
            return false;
        }
        */
        if( search_text == 'What are you looking for...' || !search_text){
            alert('Please type something to search');
            return false;
        }
        return true;
    });
});




//function currencyFormatter(e, b, d) {
//    function c(i) {
//        if ($.trim(i)) {
//            var g = $.trim(i.replace(/,/g, "")) * 1;
//            if (!isNaN(g) && isFinite(g)) {
//                if (g) {
//                    var f = Number(g).toFixed(2);
//                    var h = "";
//                    if (b.colModel.formatoptions !== undefined && b.colModel.formatoptions.colorize === true) {
//                        h = 'style="color: ' + (g < 0 ? "red" : "green") + '"'
//                    }
//                    return "<span " + h + ">" + (g < 0 ? "(" + i.substr(1) + ")" : i) + "</span>"
//                }
//                return "0.00"
//            }
//        }
//        return ""
//    }
//    b.colModel.align = "right";
//    var a = $(e);
//    return a.length == 1 ? $("<div>").append(a.html(c(a.text()))).html() : c(e)
//}

//(function(a) {
//    a.fn.setDecimalPrecision = function() {
//        a(this).blur(function() {
//            var c = a(this).val();
//            var b = /^\d+$/;
//            var d = /^(\d+(\.\d *)?)$/;
//            if (b.test(c) || d.test(c)) {
//                a(this).val(c !== undefined ? (c * 1).toFixed(2) : "")
//            }
//        })
//    }
//})(jQuery);


$(document).ready(function() {
    $(".takaFormat").each(function() {
        var num = $(this).text();
        $(this).text(takaFormat(num));
    });

    $("td[data-index='currency']").each(function() {
        var num = $(this).text();
        $(this).text(takaFormat(num));
    });
});


function takaFormat(number){
    //var x=1234567890.57;
    var x= parseFloat(number).toFixed(2);
    if(isNaN(x)) return;

    x=x.toString();
    var afterPoint = '';

    if(x.indexOf('.') > 0) afterPoint = x.substring(x.indexOf('.'), x.length);

    x = ( Math.floor(x)).toString();
    var lastThree = x.substring(x.length-3);
    var otherNumbers = x.substring(0,x.length-3);

    if(otherNumbers != '') lastThree = ',' + lastThree;
    var res = otherNumbers.replace(/\B(?=(\d{2})+(?!\d))/g, ",") + lastThree + afterPoint;

    return res;
}

//function formatNumber(num) {
//    var n1, n2;
//    num = num + '' || '';
//    // works for integer and floating as well
//    n1 = num.split('.');
//    n2 = n1[1] || null;
//    n1 = n1[0].replace(/(\d)(?=(\d\d)+\d$)/g, "$1,");
//    num = n2 ? n1 + '.' + n2 : n1;
//    return num;
//}

//function formatNumber(num) {
//  return num.toString().replace(/(\d)(?=(\d{3})+(?!\d))/g, '$1,')
//}

//function numberFormat(number) {
//    var parts = number.toString().split(".");
//    parts[0] = parts[0].replace(/\B(?=(\d{3})+(?!\d))/g, ",");
//    return parts.join(".");
//}


var KeyCode = {
    UP: 38,
    DOWN: 40,
    DEL: 46,
    TAB: 9,
    RETURN: 13,
    ESC: 27,
    COMMA: 188,
    PAGEUP: 33,
    PAGEDOWN: 34,
    BACKSPACE: 8
};



//BEGIN COUNTER FOR SUMMARY BOX
// counterNum($(".count-number"));
//
// function counterNum(obj) {
//     var start = obj.data('start');
//     var end = obj.data('end');
//     var step = obj.data('step');
//     var duration = obj.data('duration');
//
//     $(obj).html(start);
//     setInterval(function(){
//         var val = Number($(obj).html());
//         if (val < end) {
//             $(obj).html(val+step);
//         } else {
//             clearInterval();
//         }
//     },duration);
// }

//counterNum($(".visit h4 span:first-child"), 310, 376, 1, 500);
//function counterNum(obj, start, end, step, duration) {
//    $(obj).html(start);
//    setInterval(function(){
//        var val = Number($(obj).html());
//        if (val < end) {
//            $(obj).html(val+step);
//        } else {
//            clearInterval();
//        }
//    },duration);
//}
//END COUNTER FOR SUMMARY BOX










/*********************************************/
/*
jQuery ( document ).ready ( function () {
    // right click restriction start
    function fp_mouse_right_click_restriction() {
        jQuery ( document ).mousedown ( function ( e ) {
            if ( e.which === 3 ) {
                document.addEventListener ( 'contextmenu' , event => event.preventDefault () ) ;
            }
        } );
    }
    fp_mouse_right_click_restriction () ;
});


function contentprotector() {
    return false; //initialize the function return false
}
function contentprotectors() {
    return false; //initialize the function return false
}
document.oncontextmenu = contentprotector ; //calling the false function in contextmenu
document.onmouseup = contentprotector; //calling the false function in mouseup event
var isCtrl = false;
var isAlt = false;
var isShift = false;
var isPrint = false;

window.onkeypress = function ( e ) {
    var isCmd = false ;
    //make the condition when ctrl key is pressed no action has performed.
    if ( e.which === 17 ){ isCtrl = false; }
    if ( e.which === 44 ) {}
    var keyCode = e.keyCode || e.which ;
    if ( keyCode === 123 || keyCode === 112 || e.key === 'F12' ) {}

    //make the condition when ctrl key is pressed no action has performed.
    if ( ( e.which === 93 ) || ( e.which === 91 ) || ( e.which === 224 ) ){ isCmd = false; }
};

document.onkeydown = function ( e ) {
    var isCtrl = false ;
    //if onkeydown event is triggered then ctrl with possible copying keys are disabled.
    if ( e.which === 17 ) { isCtrl = true; }
    if ( ( e.which === 85 ) && ( e.ctrlKey ) ) { return false; }
    if ( ( e.which === 80 ) && ( e.ctrlKey ) ) { return false; }
    if ( ( e.which === 65 ) && e.ctrlKey ) { return false; }
    if ( ( e.which === 88 ) && e.ctrlKey ) { return false; }
    if ( ( e.which === 67 ) && ( e.ctrlKey ) ) { return false; }
    if ( ( e.which === 86 ) && ( e.ctrlKey ) ) { }
    if ( ( e.which === 83 ) && ( e.ctrlKey ) ) { return false; }
    if ( e.which === 44 ) {}

    var keyCode = e.keyCode || e.which ;
    if ( keyCode === 123 || keyCode === 112 || e.key === 'F12' ) {}
    if ( e.which === 16 ) { isShift = true; }

    //for ctlr+shift+i key combination in Windows
    if ( e.ctrlKey && isShift === true && e.which === 73 ) { return false; }

    var isCmd = false ;
    if ( ( e.which === 93 ) || ( e.which === 91 ) || ( e.which === 224 ) ){ isCmd = true; }

    //if onkeydown event is triggered then ctrl with possible copying keys are disabled.
    if ( ( e.which === 85 ) && ( isCmd === true ) ) { return false; }
    if ( ( e.which === 80 ) && ( isCmd === true ) ) { return false; }
    if ( ( e.which === 65 ) && ( isCmd === true ) ) { return false; }
    if ( ( e.which === 88 ) && ( isCmd === true ) ) { return false; }
    if ( ( e.which === 67 ) && ( isCmd === true ) ) { return false; }
    if ( ( e.which === 86 ) && ( isCmd === true ) ) {}
    if ( ( e.which === 83 ) && ( isCmd === true ) ) { return false; }
    if ( e.which === 18 ) { isAlt = true; }

    //for cmd+alt+i key combination in mac
    if ( isCmd === true && isAlt === true && e.which === 73 ) { return false; }

    // Mac OS Print screen function
    //for cmd+shift+3 key combination in mac
    if ( isCmd === true && isShift === true && e.which === 51 ) { return false; }
    //for cmd+shift+4 key combination in mac
    if ( isCmd === true && isShift === true && e.which === 52 ) { return false; }
    //for Cmd+Ctrl+Shift+3 key combination in mac
    if ( isCmd === true && isCtrl === true && isShift === true && e.which === 51 ) { return false; }
    //for Cmd+Shift+4+hit Space bar combination in mac
    if ( isCmd === true && isShift === true && e.which === 52 && e.which === 32 ) { return false; }
};

isCtrl = false ;
isCmd = false ;
document.ondragstart = contentprotector ; //Dragging for Image is also Disabled(By Making Condition as false)
// right click restriction end
*/



$(document).keydown(function(event) {
    if(event.which == 113) { //F2
        //$(this).trigger("keypress", [9]);
        $("input#bmdc_culumn_search").trigger("focus");
        return false;
    }
});



//show file name on label bootstrap4
$('input[type="file"]').change(function(e){
    var fileName = e.target.files[0].name;
    $(this).siblings('.custom-file-label').html( fileName );
});





$(document).ready(function(){
    $("a[data-fancybox=gallery]").fancybox({
        loop: false,
        arrows: true,
        keyboard: true,
        margin: [44, 0],
        gutter: 50, // Horizontal space between slides
        protect: true, // Disable right-click and use simple image protection for images
        infobar: true,
        toolbar: true,
        smallBtn: 'auto',
        idleTime : 3,
        wheel : 'auto',
        animationEffect: "zoom-in-out", //"zoom-in-out", "fade", "zoom", false
        transitionEffect: "circular", //"fade', "slide', "circular', "tube', "zoom-in-out', "rotate'
        transitionDuration: 366,
        slideClass: '', // Custom CSS class for slide element
        baseClass : '',
        modal : false,
        clickOutside : 'close',
        //clickSlide : 'close',
        zoomOpacity : 'auto',
        spinnerTpl : '<div class="fancybox-loading"></div>',
        errorTpl : '<div class="fancybox-error"><p>{{ERROR}}<p></div>',
        image: {
            preload: "auto",
        },
//        mobile : {
//            idleTime : false,
//            margin   : 0,
//
//            clickContent : function( current, event ) {
//                return current.type === 'image' ? 'toggleControls' : false;
//            },
//            clickSlide : function( current, event ) {
//                return current.type === 'image' ? 'toggleControls' : 'close';
//            },
//            dblclickContent : function( current, event ) {
//                return current.type === 'image' ? 'zoom' : false;
//            },
//            dblclickSlide : function( current, event ) {
//                return current.type === 'image' ? 'zoom' : false;
//            }
//        },
        buttons: [ 'slideShow', 'fullScreen', 'thumbs', 'share', 'download', 'zoom', 'close' ],
        thumbs : {
            autoStart   : false,                  // Display thumbnails on opening
            hideOnClose : true,                   // Hide thumbnail grid when closing animation starts
            parentEl    : '.fancybox-container',  // Container is injected into this element
            axis        : 'y'                     // Vertical (y) or horizontal (x) scrolling
        },
        slideShow : { autoStart: false, speed: 4000 },
        iframe: { preload: false },
        youtube: { controls: 0, showinfo: 0 },
        vimeo: { color: 'f00' },
        touch : {
            vertical : true,  // Allow to drag content vertically
            momentum : true   // Continue movement after releasing mouse/touch when panning
        },
        // Internationalization
        lang: 'en',
        i18n: {
            'en': {
                CLOSE: 'Close',
                NEXT: 'Next',
                PREV: 'Previous',
                ERROR: 'The requested content cannot be loaded. <br/> Please try again later.',
                PLAY_START: 'Start slideshow',
                PLAY_STOP: 'Pause slideshow',
                FULL_SCREEN: 'Full screen',
                THUMBS: 'Thumbnails'
            },
            'de': {
                CLOSE: 'Schliessen',
                NEXT: 'Weiter',
                PREV: 'Zurück',
                ERROR: 'Die angeforderten Daten konnten nicht geladen werden. <br/> Bitte versuchen Sie es später nochmal.',
                PLAY_START: 'Diaschau starten',
                PLAY_STOP: 'Diaschau beenden',
                FULL_SCREEN: 'Vollbild',
                THUMBS: 'Vorschaubilder'
            }
        }
    });
});




$("#agreement_date, #land_renewal_date").blur(function(){

    //var dateFormat = $("#agreement_date").datepicker("getDate");
    //var startDate = $.datepicker.formatDate('mm/dd/yy', new Date(dateFormat)); // convert 2016/07/30 To 30/07/2016

    //var dateFormat2 = $("#land_renewal_date").datepicker("getDate");
    //var endDate = $.datepicker.formatDate('mm/dd/yy', new Date(dateFormat2)); // convert 2016/07/30 To 30/07/2016

    //var user_date = Date.parse(startDate);
    //var today_date = Date.parse(endDate);
    //var today_date = new Date();
    //var diff_date =  user_date - today_date;

    var start = $("#agreement_date").val();
    var end = $("#land_renewal_date").val();
    $("#agreement_period").val(calculateDaysFromTwoDates(start, end));
});


$("#agreement_date").datepicker({
    maxDate: $("#land_renewal_date").datepicker('getDate'), /* 0 == new Date()*/
    showButtonPanel: true,
    changeMonth: true,
    changeYear: true,
    showOtherMonths: true,
    gotoCurrent : true,
    dateFormat: "dd/mm/yy",
    onSelect: function (dateStr) {
        var min = $(this).datepicker('getDate'); // Get selected date
        $('#land_renewal_date').datepicker('option', {minDate: min, maxDate: min+'+5Y+0M'}); // Set other max, default to +18 months
        var start = $("#agreement_date").val();
        var end = $("#land_renewal_date").val();
        $("#agreement_period").val(calculateDaysFromTwoDates(start, end));
    }
});


$("#land_renewal_date").datepicker({
    minDate: $("#agreement_date").datepicker('getDate'), /* 0 == new Date()*/
    //maxDate: '+5Y+0M',
    showButtonPanel: true,
    changeMonth: true,
    changeYear: true,
    showOtherMonths: true,
    gotoCurrent : true,
    dateFormat: "dd/mm/yy",
    onSelect: function (dateStr) {
        var max = $('#land_renewal_date').datepicker('getDate'); // Get selected date
        $('#agreement_date').datepicker('option', 'maxDate', max); // Set other max, default to +18 months
        var start = $("#agreement_date").val();
        var end = $("#land_renewal_date").val();
        $("#agreement_period").val(calculateDaysFromTwoDates(start, end));
    }
});

function calculateDaysFromTwoDates(start_date, end_date){
    // var start = $("#agreement_date").datepicker("getDate");
    // var end = $("#land_renewal_date").datepicker("getDate");
    //var days = (end - start) / (1000 * 60 * 60 * 24);
    var start = $.datepicker.parseDate("d/mm/yy", start_date);
    var end = $.datepicker.parseDate("d/mm/yy", end_date);

    //For add 1 day plus
    end.setDate(end.getDate() + 1); /*(now.getDate()+1)+now.getMonth()+now.getFullYear()*/

    var day_in_seconds = 1000 * 60 * 60 * 24; //(miliseconds * second * minute * day) == 86400000 ms
    var month_in_seconds = day_in_seconds *  30.4375;  //2629800000 ms
    var week_in_seconds = day_in_seconds *  7;  //604800016.56 ms
    var year_in_seconds = day_in_seconds * 365.25; //31557600000 ms
    var diff_date =  new Date(end - start);


    var num_years = diff_date / year_in_seconds;
    var num_months = (diff_date % year_in_seconds)/month_in_seconds;
    var num_days = ((diff_date % year_in_seconds) % month_in_seconds)/day_in_seconds;

    //Math.floor(diffDate); / Math.ceil(diffDate); / Math.round(diffDate);
    var dateDiff = (Math.floor(num_years) ? Math.floor(num_years) + (num_days >1 ? " Years " : " Year ") : "") + (Math.floor(num_months) ? Math.floor(num_months) + (num_days >1 ? " Months " : " Month ") : "") + (Math.floor(num_days) ? Math.floor(num_days) + (num_days >1 ? " Days " : " Day ") : "");

    return dateDiff;
}


/*
//Date range as a button
$('#daterange-btn').daterangepicker({
//        ranges: {
//           'Today': [moment(), moment()],
//           'Yesterday': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
//           'Last 7 Days': [moment().subtract(6, 'days'), moment()],
//           'Last 30 Days': [moment().subtract(29, 'days'), moment()],
//           'This Month': [moment().startOf('month'), moment().endOf('month')],
//           'Last Month': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')]
//        }
}, cb);
function cb(start, end) {
    //$('#daterange-btn span').html('<span name="custom_date_begin" class="custom_date_begin">' + start.format('YYYY-MM-DD')  + '</span>' + ' - ' + '<span name="custom_date_end" class="custom_date_end">' + end.format('YYYY-MM-DD') + '</span>' );
    $('#custom_date_begin').val(start.format('YYYY-MM-DD') );
    $('#custom_date_end').val(end.format('YYYY-MM-DD') );
}
cb(moment().subtract(29, 'days'), moment());
*/







// <h1>Your Ip Address : <span class="ip"></span></h1>
// $(document).ready(function() {
//     $.getJSON("https://api.ipify.org/?format=json", function(e) {
//         $('.ip').text(e.ip);
//     });
// });




$(document).on("change", ".content-wrapper select", function(){
    var $this = $(this);

    if( $(this).val() ){
        $this.addClass('filtered');
    }else{
        $this.removeClass('filtered');
    }
}).change();




/********Restriction for Date patern********/
$('input[type="datetime"]').attr('pattern', '(0[1-9]|1[0-9]|2[0-9]|3[01])/(0[1-9]|1[012])/[0-9]{4}');




$(document).on('keypress', function(e){
    var code = e.keyCode || e.which;
    if (code === 113){
        alert(1);
        //$(this).trigger("keypress", [9]);
        //$(this).next().focus();
    }
});



function capitalizeFirstLetter(string) {
    return string.charAt(0).toUpperCase() + string.slice(1);
}
