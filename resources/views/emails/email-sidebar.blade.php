<div class="email-sidebar-wrap">
    <a href="{{ URL::to('/email/compose') }}" class="btn btn-primary btn-block" style="margin: 5px 0 15px 6%; width: 95%;"><i class="fa fa-plus fa-lg"></i> Compose</a>

    <div class="email-sidebar">
        <ul class="nav flex-column">
            <li><a href="{{ URL::to('/email/inbox') }}"><i class="fa fa-inbox"></i>Inbox <span class="badge badge-primary float-right"><?php echo DB::table('emails')->where('email_type', '=', 'inbox')->count(); ?></span></a></li>
            <li><a href="{{ URL::to('/email/starred') }}"><i class="far fa-star"></i>Starred <span class="badge badge-primary float-right"><?php echo DB::table('emails')->where('email_attribute', '=', 'starred')->count(); ?></span></a></li>
            <li><a href="{{ URL::to('/email/sent') }}"><i class="far fa-location-arrow text-default"></i>Sent <span class="badge badge-primary float-right"><?php echo DB::table('emails')->where('email_type', '=', 'sent')->count(); ?></span></a></li>
            <li><a href="{{ URL::to('/email/drafts') }}"><i class="far fa-file text-default"></i>Drafts <span class="badge badge-primary float-right"><?php echo DB::table('emails')->where('email_type', '=', 'drafts')->count(); ?></span></a></li>
            <li><a href="{{ URL::to('/email/spam') }}"><i class="far fa-filter text-default"></i>Spam <span class="badge badge-primary float-right"><?php echo DB::table('emails')->where('email_type', '=', 'spam')->count(); ?></span></a></li>
            <li><a href="{{ URL::to('/email/trash') }}"><i class="far fa-trash-alt text-default"></i>Trash <span class="badge badge-primary float-right"><?php echo DB::table('emails')->where('email_type', '=', 'trash')->count(); ?></span></a></li>
        </ul>
    </div>
</div>


@section('custom_css')
    <style type="text/css">
        body{ background: url('<?php echo image_url('email-body.jpg'); ?>') no-repeat left top; background-size: cover; }
        .wrapper, .content-wrapper{ background-color: transparent !important; }

        body.sidebar-menu .email-sidebar-wrap{ display: none; }
        body.sidebar-menu .col-10{ flex-basis: 98%; max-width: 98%; margin-left: 15px; }
        .mail-option {
            display: inline-block;
            margin-bottom: 5px;
            width: 100%;
            padding: 15px 20px 0 5px;
        }
        .mail-option a{ color: #444; }
        .mail-option .select-checkbox-wrap{
            background: #fff;
            border-radius: 3px;
            margin-right: 5px;
        }
        .mail-option .btn-group { margin-right: 5px; }
        .mail-option .btn-group a.btn {
            background: none repeat scroll 0 0 #fcfcfc;
            border: 1px solid #e7e7e7;
            border-radius: 3px !important;
            display: inline-block;
            padding: 5px 10px;
        }
        .inbox-pagination a.np-btn {
            background: none repeat scroll 0 0 #fcfcfc;
            border: 1px solid #e7e7e7;
            border-radius: 3px !important;
            display: inline-block;
            padding: 5px 15px;
            color: #444;
        }
        .mail-option .chk-all input[type="checkbox"] { margin-top: 0; }
        .mail-option .btn-group a.all { border: medium none; padding: 0; }
        .inbox-pagination a.np-btn { margin-left: 5px; }
        .inbox-pagination li span { display: inline-block; margin-right: 5px; margin-top: 7px; }
        ul.inbox-pagination { float: right; color: #fff; }
        ul.inbox-pagination li { float: left; }
    </style>
@endsection


@section('custom_js')
    <script type="text/javascript">
        $("body").on("click", "button#draftButton", function(event){
            event.preventDefault();

            var form = $(this).parents('form').serialize();
            if(!form) return;

            $.ajaxSetup({
                headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') }
            });

            $.ajax({
                type: "POST",
                url: "{{ url('/email/drafts-save') }}",
                data: form,
                dataType: 'json',
                success: function (response) {
                    toastr.info( response.message, "Info", {"closeButton": true,"newestOnTop": true,"progressBar": true,"preventDuplicates": true});
                    //setTimeout(function(){ window.location.reload(); },1000);
                    window.location.assign("{{ url('/email/inbox') }}");
                },
                statusCode:{ 404: function(){ alert( "page not found" ); } },
                beforeSend: function( xhr ) { $(".ajax-loader").show(); },
                complete: function( jqXHR, textStatus ) { $(".ajax-loader").hide(); },
            });
        });


        $("tr.view-email td:not(.view-btn)").on('click', function(){
            var id = $(this).parents('tr').attr('id');

            $.ajax({
                type: "get",
                url: "{{ url('/email/request_url/view') }}/"+ id,
                dataType: 'json',
                success: function (response) {
                    window.location.assign( response.view_url );
                },
            });
        });

        $("div.email-action-btn > btn").on('click', function(event){
            event.preventDefault();
        });


        $(document).on("click", "button.softDelete", function(event){
            event.preventDefault();
            var email_id = $(this).attr('id');
            var parentTr = $(this).closest('tr');

            if( !confirm("Are you sure want to delete this email.")){ return; }

            $.ajaxSetup({
                headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') }
            });

            $.ajax({
                type: "POST",
                url: "{{ url('/email/soft-delete') }}",
                data: { 'email_id': email_id, '_method': 'DELETE' },
                dataType: 'json',
                success: function (response) {
                    toastr.info( response.message, "Info", {"closeButton": true,"newestOnTop": true,"progressBar": true,"preventDuplicates": true});
                    parentTr.slideUp(300, function() { parentTr.closest("tr").remove(); });
                },
                statusCode:{ 404: function(){ alert( "page not found" ); } },
                beforeSend: function( xhr ) { $(".ajax-loader").show(); },
                complete: function( jqXHR, textStatus ) { $(".ajax-loader").hide(); },
            });
        });


        $(document).on("click", "button.empty-trash", function(event){
            event.preventDefault();
            var table = $("table#email-trash-table");
            var row_count = table.find('tbody').find('tr').length;
            // var a = table.find('tr:eq(0)').attr('id');

            if( !confirm("This action will affect all "+row_count+" messages in Trash. Are you sure you want to continue?")){ return; }

            $.ajaxSetup({
                headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') }
            });

            $.ajax({
                type: "POST",
                url: "{{ url('/email/empty-trash') }}",
                dataType: 'json',
                success: function (response) {
                    toastr.info( response.message, "Info", {"closeButton": true,"newestOnTop": true,"progressBar": true,"preventDuplicates": true});
                    for($i=0; $i<=row_count; $i++){
                        table.find('tr:eq('+$i+')').animate({ backgroundColor: "#ffe7e4" }, $i*200).animate({ opacity: "hide" }, $i*200);
                    }
                },
                statusCode:{ 404: function(){ alert( "page not found" ); } },
                beforeSend: function( xhr ) { $(".ajax-loader").show(); },
                complete: function( jqXHR, textStatus ) { $(".ajax-loader").hide(); },
            });
        });


        $(document).on("click", "button.change-email-status-btn", function(){

            var $this = $(this);
            var id = $(this).attr('id');
            var email_status = $(this).data('status');
            var parentTr = $(this).closest('tr');
            var parent = $(this).parent('div');

            $.ajaxSetup({
                headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') }
            });

            $.ajax({
                type: "POST",
                url: "{{ url('/email/change-email-status') }}/"+ id +"/"+ email_status,
                dataType: 'json',
                success: function (response) {
                    parentTr.removeClass('read unread').addClass(response.email_status);

                    if(response.email_status == "read"){
                        $this.remove();
                        parent.append('<button type="button" id="'+response.email_id+'" class="btn btn-sm change-email-status-btn" data-status="unread" data-toggle="tooltip" data-placement="bottom" title="Mark as unread"><i class="fa fa-envelope fa-lg" aria-hidden="true"></i></button>');
                    }else{
                        $this.remove();
                        parent.append('<button type="button" id="'+response.email_id+'" class="btn btn-sm change-email-status-btn" data-status="read" data-toggle="tooltip" data-placement="bottom" title="Mark as read"><i class="fa fa-envelope-open fa-lg" aria-hidden="true"></i></button>');
                    }
                    toastr.info( response.message, "Info", {"closeButton": true,"newestOnTop": true,"progressBar": true,"preventDuplicates": true});
                },
                statusCode:{ 404: function(){ alert( "page not found" ); } },
                beforeSend: function( xhr ) { $(".ajax-loader").show(); },
                complete: function( jqXHR, textStatus ) { $(".ajax-loader").hide(); },
            });
        });

        $(document).on("click", "button.set-email-star-btn", function(){

            var $this = $(this);
            var id = $(this).attr('id');
            var attribute = $(this).data('attribute');
            var parent = $(this).parent('div');

            $.ajaxSetup({
                headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') }
            });

            $.ajax({
                type: "POST",
                url: "{{ url('/email/set-email-star') }}/"+ id +"/"+ attribute,
                dataType: 'json',
                success: function (response) {
                    if(response.attribute == "Starred"){
                        $this.remove();
                        parent.append('<button type="button" id="'+response.email_id+'" class="btn btn-sm set-email-star-btn" data-attribute="Not starred" title="Not starred"><i class="far fa-star" aria-hidden="true"></i></button>');
                    }else{
                        $this.remove();
                        parent.append('<button type="button" id="'+response.email_id+'" class="btn btn-sm set-email-star-btn" data-attribute="Starred" title="Starred"><i class="fas fa-star text-yellow" aria-hidden="true"></i></button>');
                    }
                    toastr.info( response.message, "Info", {"closeButton": true,"newestOnTop": true,"progressBar": true,"preventDuplicates": true});
                },
                statusCode:{ 404: function(){ alert( "page not found" ); } },
                beforeSend: function( xhr ) { $(".ajax-loader").show(); },
                complete: function( jqXHR, textStatus ) { $(".ajax-loader").hide(); },
            });
        });
    </script>
@endsection

