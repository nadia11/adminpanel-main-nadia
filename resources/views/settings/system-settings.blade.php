@extends('dashboard')
@section('main_content')

<section class="content-wrapper">
    <div class="member-mgmt-list">
        <ul class="nav nav-tabs">
            <li class="nav-item"><a class="nav-link active" data-toggle="tab" href="#general_settings" onclick="pushstate('#general_settings')"><i class="fa fa-list"></i> General Settings</a></li>
            <li class="nav-item"><a class="nav-link" data-toggle="tab" href="#system_info" onclick="pushstate('#system_info')"><i class="fa fa-info-circle"></i> System Info</a></li>
            <li class="nav-item"><a class="nav-link" data-toggle="tab" href="#email_sms_notification" onclick="pushstate('#email_sms_notification')"><i class="fa fa-envelope"></i> Email & SMS Notification</a></li>
            <li class="nav-item"><a class="nav-link" data-toggle="tab" href="#backup_and_restore" onclick="pushstate('#backup_and_restore')"><i class="fas fa-undo"></i> Backup & Restore</a></li>
            <li class="nav-item"><a class="nav-link" data-toggle="tab" href="#optimize_performance" onclick="pushstate('#optimize_performance')"><i class="fas fa-tachometer-alt"></i> Optimize & Performance</a></li>
        </ul>
        <div class="tab-content">
            <i class="fa fa-spin fa-spinner" style="display: none;"></i>

            <div class="tab-pane fade show animated fadeInLeft active" id="general_settings">
                @include('settings.tab-general-settings')
            </div>
            <div class="tab-pane fade animated fadeInLeft" id="system_info">
                @include('settings.tab-system-info')
            </div>
            <div class="tab-pane fade animated fadeInLeft" id="email_sms_notification">
                @include('settings.tab-email-sms-notification')
            </div>
            <div class="tab-pane fade animated fadeInLeft" id="backup_and_restore">
                @include('settings.tab-backup-and-restore')
            </div>
            <div class="tab-pane fade animated fadeInLeft" id="optimize_performance">
                @include('settings.tab-optimize-performance')
            </div>
        </div>
    </div>
</section>

@endsection





@section('custom_js')
<script type="text/javascript">

//$(document).ready(function() {
////    $('a[data-toggle="tab"]').on( 'shown.bs.tab', function (e) {
////        $.fn.dataTable.tables( {visible: true, api: true} ).columns.adjust();
////         var target = $(e.target).attr("href"); // activated tab
////         alert (target);
////    } );
//    $("table.multi_datatable").DataTable({
//        responsive: true
//    });
//});



function pushstate( id ) {
    var url = id.replace('#', '#tab=');
    //var currentState = history.state;

    return window.history.pushState(null, null, url);
};

$(window).on('hashchange', function () {
    var tab = window.location.hash != "" ? window.location.hash.split("#tab=")[1] : ""
    $("ul.nav").find("a[href='#" +tab + "']").trigger('click');
});

$(document).ready(function(){
    $(document).on('click', '.nav-link', function () {
        var id = $(this).attr('href');

        $.ajax({
            url: "{{ url()->current() }}" + id.replace('#', '/').replace('_', '-').replace('_', '-').replace('_', '-'),
            type: "get",
            success: function(data){ $('.tab-content .tab-pane' + id).html( data ); },
            error: function (jqXHR, textStatus, errorThrown){ alert("error"); },
            statusCode:{ 404: function(){ alert( "page not found" ); } },
            beforeSend: function( xhr ) { $(".tab-content i.fa-spin").show(); },
            complete: function( jqXHR, textStatus ) { $(".tab-content i.fa-spin").hide(); },
        });
    });
}); //End of Document ready
</script>
@endsection

