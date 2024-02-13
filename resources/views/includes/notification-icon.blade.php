
{{--<li class="dropdown messages-menu">--}}
{{--    <nav class="navbar navbar-expand-sm">--}}
        <?php //$conversation_id = DB::table('chat_contacts')->where('user_id', Auth::id())->first(); echo $conversation_id->conversation_id; //->where('conversation_id', $conversation_id)

        //$joined_ids = array();
        //$contact_ids = DB::table('chat_contacts')->where('user_id', array(Auth::id()))->pluck('receipent_id');
        //foreach ($contact_ids as $id) { $joined_ids[] = $id; }

        //$conversation_ids = array();
        //$conversation_id = DB::table('chat_contacts')->where('user_id', array(Auth::id()))->pluck('conversation_id');
        //foreach ($conversation_id as $id) { $conversation_ids[] = $id; }

        //$user_data = DB::table('users')->whereNotIn('id', $joined_ids)->select('id', 'name', 'photo', 'mobile')->get();
        ?>
        <?php //$message_query = DB::table('chat_messages')->where('reading_status', 'unread')->whereNotIn('sender_id', array(Auth::id()))->whereIn('conversation_id', array($conversation_ids)); //echo '<pre>'; print_r($conversation_id); exit(); ?>

{{--        <a href="#" data-toggle="dropdown" class="position-relative">--}}
{{--            <i class="far fa-envelope fa-2x text-black"></i>--}}
{{--            <span class="notify"></span>--}}
{{--            <span class="heartbeat"></span>--}}
{{--            { $message_query->count() > 0 ? '<span class="badge badge-danger">'.$message_query->count().'</span>' : "" }}--}}
{{--        </a>--}}
{{--        <ul class="dropdown-menu animated bounceInDown">--}}
{{--            <li class="header">You have { $message_query->count() }} messages</li>--}}
{{--            <li>--}}
{{--                <a href="{ url('inbox') ."/". "rabiul" }}" class="message-item">--}}
{{--                    <div class="message-image">--}}
{{--                        <img src="{{ asset('images/logo-square.png') }}" class="rounded-circle">--}}
{{--                        <i class="profile-status online pull-right"></i>--}}
{{--                    </div>--}}
{{--                    <div class="message-contnet">--}}
{{--                        <h5 class="message-title">Pavan kumar</h5>--}}
{{--                        <span class="mail-desc">Just see the my admin!</span> <span class="time fa fa-clock-o">5 mins</span>--}}
{{--                    </div>--}}
{{--                    <button class="read-unread-message" data-toggle="tooltip" data-placement="left" title="Mark as Read" id="1"><i class="fa fa-envelope fa-lg"></i></button>--}}
{{--                </a>--}}
{{--                <a href="{ url('inbox') ."/". "rabiul" }}" class="message-item">--}}
{{--                    <div class="message-image">--}}
{{--                        <img src="{{ asset('images/logo-square.png') }}" class="rounded-circle">--}}
{{--                        <i class="profile-status online pull-right"></i>--}}
{{--                    </div>--}}
{{--                    <div class="message-contnet">--}}
{{--                        <h5 class="message-title">Pavan kumar</h5>--}}
{{--                        <span class="mail-desc">Just see the my admin!</span> <span class="time fa fa-clock-o">5 mins</span>--}}
{{--                    </div>--}}
{{--                    <button class="read-unread-message" data-toggle="tooltip" data-placement="left" title="Mark as Read" id="1"><i class="fa fa-envelope fa-lg"></i></button>--}}
{{--                </a>--}}
{{--            </li>--}}
{{--            <li class="footer"><a href="{ url('message') }}">See All Messages <i class="fa fa-angle-right"></i></a></li>--}}
{{--        </ul>--}}
{{--    </nav>--}}
{{--</li>--}}



<li class="dropdown notifications-menu messages-menu">
    @php $notification_count = DB::table('notifications')->where('reading_status', 'unread')->count() @endphp
    <nav class="navbar navbar-expand-sm">
        <a href="#" data-toggle="dropdown">
            <i class="fa fa-bell fa-2x text-black"></i>
            <span class="badge badge-danger badgeCount1">{{ $notification_count }}</span>
        </a>
        <ul class="dropdown-menu animated bounceInDown">
            <li class="header">You have <span class="badgeCount2">{{ $notification_count }}</span> notifications</li>
            <ul class="custom-scroll" style="max-height: 305px; padding: 0;">
                @foreach(DB::table('notifications')->orderBy('created_at', 'DESC')->where('reading_status', 'unread')->get() as $notification)
                    <li id={{$notification->notification_id}} style="position: relative; {{$notification->reading_status == "unread" ? "background-color: #eef8ff" : "background-color: #fff"}};">
                    <a href="{{ $notification->notification_url }}" class="message-item">
                        <div class="message-image">
                            {{--<img src="{{ asset('images/logo-square.png') }}" class="rounded-circle">--}}
                            <i class="{{ $notification->notification_icon }} text-aqua fa-2x"></i>
                        </div>
                        <div class="message-contnet">
                            <span class="mail-desc"><strong>{{ $notification->notification_title }}</strong> {{ $notification->notification_body }}</span> <span class="time fa fa-clock-o">{{ human_date($notification->created_at) }}</span>
                        </div>
                    </a>
                    <button class="read-unread-notification0 unreadNotificationBtn" style="position: absolute; right: 15px; top: 15px; z-index: 999; background: none; border: none;" id={{$notification->notification_id}} data-toggle="tooltip" data-placement="left" title="Mark as Read" id="1"><i class="fa fa-envelope fa-lg"></i></button>
                    </li>
                    @endforeach
                    </li>
            </ul>
            <li class="footer"><a href="{{ url('/notification/notification-list') }}" target="_blank">View All Notifications <i class="fa fa-angle-right"></i></a></li>
        </ul>
    </nav>
</li><!-- message-notification -->



<script type="text/javascript">
    $(document).ready(function(){
        $(document).on("click", "button.unreadNotificationBtn", function(event){
            event.preventDefault();

            var menuId = $(".notifications-menu");
            var notification_id = $(this).attr('id');
            var badgeCount = menuId.find(".badgeCount1").text();

            $.ajax({
                type: "POST",
                url: "{{ url('/notification/change-notification-status') }}",
                data: {notification_id: notification_id, reading_status: 'read'},
                headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
                dataType: 'json',
                success: function (response) {
                    toastr.success( response.success );
                    menuId.find(".badgeCount1").text(badgeCount-1);
                    menuId.find(".badgeCount2").text(badgeCount-1);
                    menuId.find("li#"+notification_id).delay(1000).slideUp('slow');
                    menuId.find("li#"+notification_id).remove();
                },
                statusCode:{ 404: function(){ alert( "page not found" ); } },
                error: function (xhr, textStatus, errorThrown) { alert(errorThrown); },
                beforeSend: function( xhr ) { $(".ajax-loader").show('slow'); },
                complete: function( jqXHR, textStatus ) { $(".ajax-loader").hide('fast'); },
            });
        });
    }); //End of Document ready
</script>
