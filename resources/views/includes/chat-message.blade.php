@extends('dashboard')
@section('main_content')

<section class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-3">
                <div class="card contact-list">
                    <div class="card-header">
                        <div class="search-bar">
                            <button type="button" class="btn add-contact-btn" data-toggle="modal" data-target="#newChatContactModal"><i class="fa fa-user-plus fa-lg"></i> </button>
                            <select name="filter-contact" id="filter-contact" class="custom-select">
                                <option value="contact">All Conversation</option>
                                <option value="read">Read</option>
                                <option value="unread">Unread</option>
                                <option value="starred">Starred</option>
                                <option value="archive">Archive</option>
                                <option value="spam">Spam</option>
                                <option value="block">Block</option>
                            </select>
                            <button type="button" class="btn btn-outline-info search-contact-btn"><i class="fa fa-search"></i></button>
                        </div>

                        <form method="get" class="search-contact-form" action="#" role="search" style="display: none;">
                            <div class="input-group">
                                <input type="search" id="s" name="s" class="form-control" autocomplete="off" placeholder="Search for a username" />
                                 <div class="input-group-append">
                                    <button type="reset" class="btn btn-danger close-search-contact-form"><i class="fa fa-times"></i></button>
                                </div>
                            </div>
                        </form>
                    </div>

                    <div class="card-body">
                        <div class="empty-state nothing-tosee" style="display: none;">
                            <i class="fal fa-comments fa-4x"></i>
                            <strong class="font-accent">No Conversations</strong>
                            <small>There are no conversations <br>under <span class="text-capitalize">"Archived"</span></small>
                            <button class="btn btn-link view-all-conversation text-success">View All Conversations</button>
                        </div>

                        @if(count($contact_lists) < 0)
                            <div class="empty-state no-selection">
                                <i class="fal fa-comments fa-4x"></i>
                                <strong class="font-accent" style="font-size: 20px;">No Contact Founds.</strong>
                                <small>Add a contact from the list.</small>
                            </div>
                        @endif

                        @foreach( $contact_lists as $contact )
                            <?php $message_query = DB::table('chat_messages')->where('conversation_id', $contact->conversation_id)->latest(); ?>
                            <a href="{{ url('message') ."/". $contact->name }}" id="{{ $contact->chat_contact_id }}" class="contact {{ $username == $contact->name ? "active-contact" : "" }} {{ $message_query->value('reading_status') }} {{ $contact->block_status }} {{ $contact->star_status }} {{ $contact->archive_status }} {{ $contact->spam_status }} {{ $last_messages == $contact->conversation_id ? "First" : "" }}">
                                <div class="message-image">
                                    <img class="contacts-list-img"  src="<?php echo !empty($contact->photo) ? public_url( "user-photo/". $contact->photo ) : image_url('defaultAvatar.jpg'); ?>" />
                                    @if(Cache::has('user-is-online-'.$contact->id)) <i class="profile-status online pull-right"></i> @else <i class="profile-status offline pull-right"></i> @endif
                                </div>
                                <div class="contact-name">
                                    <strong>{{ $contact->name }}</strong>
                                    <p><?php echo $message_query->value('sender_id') ==  Auth::id() ? "Me: " : ""; ?> {{ $message_query->value('message_body') }}</p>
                                </div>
                                <time class="contacts-list-date">{{ human_date($message_query->max('created_at')) }}</time>

                                <nav class="navbar navbar-expand-sm">
                                    <?php echo $message_query->whereNotIn('sender_id', array(Auth::id()))->where('reading_status', 'unread')->count() > 0 ? '<span class="unread-count">'.$message_query->whereNotIn('sender_id', array(Auth::id()))->where('reading_status', 'unread')->count().'</span>' : ""; ?>
                                    <span class="{{ $contact->star_status == 'Starred' ? 'fas fa-star text-yellow' : '' }}"></span>
                                    <i class="far fa-ellipsis-v fa-lg text-black" data-toggle="dropdown"></i>

                                    <ul class="dropdown-menu contact-action">
                                        <li><button id="{{ $contact->chat_contact_id }}" class="btn btn-sm action-star" data-status="{{ $contact->star_status == 'Starred' ? 'Starred' : 'NotStarred' }}"><i class="{{ $contact->star_status == 'Starred' ? 'fas fa-star text-yellow' : 'far fa-star' }}"></i> Starred</button></li>
                                        <li><button id="{{ $contact->chat_contact_id }}" class="btn btn-sm change-reading-status-btn" data-status="{{ $message_query->value('reading_status') == 'read' ? 'unread' : 'read' }}"><i class="fal fa-envelope{{ $message_query->value('reading_status') =="unread" ? "-open" : "" }} fa-lg"></i> Mark as {{ $message_query->value('reading_status') == 'read' ? 'unread' : 'read' }}</button></li>
                                        <li><button id="{{ $contact->chat_contact_id }}" class="btn btn-sm block-chat-contact-btn"><i class="far fa-user-slash fa-lg"></i> Block Contact</button></li>
                                        <li><button id="{{ $contact->chat_contact_id }}" class="btn btn-sm delete-chat-contact-btn"><i class="fa fa-times fa-lg"></i> Delete</button></li>
                                    </ul>
                                </nav>
                            </a>
                        @endforeach
                    </div>
                </div>
            </div>
            <div class="@if($username) col-6 @else col-9 @endif">
                <div id="conversation" class="card">
                    @if(!$username)
                    <div class="empty-state no-selection">
                        <i class="fad fa-comments-alt fa-5x"></i>
                        <strong class="font-accent">Select a Conversation</strong>
                        <small>Try selecting a conversation or searching for someone specific.</small>
                    </div>
                    @else
                    <div class="conversation-room">
                        <div class="card-header">
                            <h3 class="card-title d-flex">
                                <div class="message-image">
                                    <img class="contacts-list-img"  src="<?php echo !empty($user_photo) ? public_url( "user-photo/". $user_photo ) : image_url('defaultAvatar.jpg'); ?>" />
                                    @if(Cache::has('user-is-online-'.$user_id)) <i class="profile-status online pull-right"></i> @else <i class="profile-status offline pull-right"></i> @endif
                                </div>
                                <span class="contact-name" style="margin-top: 15px;">{{ $username }}</span>
                            </h3>
                            <div class="card-tools">
                                <button class="btn action-star" id="{{ $chat_contact_id }}" data-status="{{ $star_status == 'Starred' ? 'Starred' : 'NotStarred' }}"><i class="{{ $star_status == 'Starred' ? 'fas fa-star fa-lg text-yellow' : 'far fa-star fa-lg' }}"></i></button>
                                <button class="btn change-reading-status-btn" id="{{ $chat_contact_id }}" data-status="{{ $message_query->value('reading_status') == 'read' ? 'unread' : 'read' }}" data-toggle="tooltip" data-placement="bottom" title="Mark as {{ $message_query->value('reading_status') == 'read' ? "unread" : 'read' }}"><i class="fal fa-envelope{{ $message_query->value('reading_status') =="read" ? "" : "-open" }} fa-lg"></i></button>
                                <button class="btn block-chat-contact-btn" id="{{ $chat_contact_id }}" data-toggle="tooltip" data-placement="bottom" title="Block This Contact"><i class="far fa-user-slash fa-lg"></i></button>
                                <button class="btn action-archive" id="{{ $chat_contact_id }}"><i class="fal fa-inbox-in fa-lg"></i></button>
                                <button class="btn delete-chat-contact-btn" id="{{ $chat_contact_id }}" data-toggle="tooltip" data-placement="bottom" title="Delete Conversation"><i class="fal fa-trash-alt fa-lg"></i></button>
                            </div>
                        </div>
                       <div class="card-body">
                            @foreach( $message_lists as $message )
                                @if($message->sender_id !== Auth::id())
                                <div class="d-flex justify-content-start mb-5">
                                    <div class="img_cont_msg">
                                        <img class="rounded-circle user_img_msg"  src="<?php echo !empty($message->photo) ? public_url( "user-photo/". $message->photo ) : image_url('defaultAvatar.jpg'); ?>" />
                                    </div>
                                    <div class="msg_cotainer">
                                        {{ $message->message_body }}
                                        <time class="msg_time"><?php $date1 = Carbon\CarbonImmutable::parse($message->created_at); echo $date1->calendar(); ?></time>
                                    </div>
                                </div>
                                @else
                                <div class="d-flex justify-content-end mb-5">
                                    <div class="msg_cotainer_send">
                                        {{ $message->message_body }}
                                        <time class="msg_time_send"><?php $date1 = Carbon\CarbonImmutable::parse($message->created_at); echo $date1->calendar(); ?></time>
                                    </div>
                                    <div class="img_cont_msg">
                                        <img class="rounded-circle user_img_msg"  src="<?php echo !empty($message->photo) ? public_url( "user-photo/". $message->photo ) : image_url('defaultAvatar.jpg'); ?>" />
                                    </div>
                                </div>
                                @endif
                            @endforeach
                        </div>
                        <div class="card-footer">
                            <form  id="chatMessageForm" action="{{ route('send-message') }}" method="post">
                                @csrf
                                <div class="input-group">
                                    <div class="input-group-append">
                                        <button type="button" class="btn"><i class="far fa-clipboard-list-check fa-lg"></i></button>
                                        <button type="button" class="btn"><i class="fa fa-paperclip fa-lg"></i></button>
                                        <input type="file" style="display: none;">
                                    </div>
                                    <input type="text" name="message_body" placeholder="Type Message..." class="form-control" autocomplete="off">
                                    <input type="hidden" name="conversation_id" value="{{ $conversation_id }}">
                                    <div class="input-group-append">
                                        <button type="submit" class="btn btn-success">Send</button>
                                    </div>
                                </div>
                            </form>
                        </div><!-- /.card-footer-->
                    </div>
                    @endif
                </div><!-- #conversation -->
            </div><!-- ./col-6 -->

            @if($username)
            <div class="col-3">
                <div class="card contact-about">
                    <div class="card-header">
                        <h3 class="card-title">About</h3>
                    </div>
                    <div class="card-body">
                            <div class="message-image">
                                <img class="contacts-list-img"  src="<?php echo !empty($user_photo) ? public_url( "user-photo/". $user_photo ) : image_url('defaultAvatar.jpg'); ?>" />
                            </div>
                                @if(Cache::has('user-is-online-'.$user_id)) Active now on Chatroom @else Ofline @endif
                            <a href="{{ url('') ."/". $username }}" class="contact-name" style="margin-top: 5px;">{{ $username }}</a>
                            <p class="contact-name" style="margin-top: 5px;">{{ $role_name }}</p>
                    </div>
                </div>
            </div><!-- col-3 -->
            @endif
        </div>
    </div><!-- ./container -->

    <div class="modal fade" id="newChatContactModal">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">

                <!-- Modal Header -->
                <div class="modal-header">
                    <h4 class="modal-title">New Chat Contact List</h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>

                <!-- Modal body -->
                <div class="modal-body">
                    <table class="table table-custom">
                        <tbody>
                        <?php
                        $joined_ids = array(Auth::id());
                        $contact_ids = DB::table('chat_contacts')->where('user_id', array(Auth::id()))->pluck('receipent_id');
                        foreach ($contact_ids as $id) { $joined_ids[] = $id; }

                        $user_data = DB::table('users')->whereNotIn('id', $joined_ids)->select('id', 'name', 'photo', 'mobile')->get();
                        ?>
                        @foreach( $user_data as $user )
                            @if($user->id)
                            <tr id="{{ $user->id }}">
                                <td><img src="<?php echo !empty($user->photo) ? public_url( "user-photo/". $user->photo ) : image_url('defaultAvatar.jpg'); ?>" style="border-radius: 50%; width: 40px; height: 40px; border: 1px solid #eee; box-shadow: 0 0 3px rgba(0,0,0,.3); padding: 1px; margin: 0;" /></td>
                                <td class="text-left">{{ $user->name }}</td>
                                <td w-25><button type="button" class="btn btn-primary add_to_chat_contact" id="{{ $user->id }}"><i class="fa fa-plus" aria-hidden="true"></i> Add to Contact</button></td>
                            </tr>
                            @else
                                <tr><td colspan="3">No Contact Found.</td></tr>
                            @endif
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div><!-- ./newChatContactModal -->
</section>

@endsection



@section('custom_css')
    <style type="text/css">
        {{--body{ background: url('<?php //echo image_url('email-body.jpg'); ?>') no-repeat left top; background-size: cover; }--}}
        .wrapper, .content-wrapper{ background-color: transparent !important; }

        body, html {
            height: 100%;
            margin: 0;
            background: #7F7FD5;
            background: -webkit-linear-gradient(to right, #91EAE4, #86A8E7, #7F7FD5);
            background: linear-gradient(to right, #91EAE4, #86A8E7, #7F7FD5);
        }
        .contact-list{
            margin-top: 7px;
            height: 100%;
        }
        .contact-list .card-header{
            padding: 20px;
        }
        .contact-list .search-bar{
            display: flex;
            flex-flow: row nowrap;
            justify-content: space-between;
        }
        .contact-list .search-bar select{
            width: 70%;
        }
        .contact-list .card-body{
            padding: 0;
            height: 100%;
        }
        .contact-list .card-body ul{
            padding: 0;
        }
        .contact-list a.contact {
            display: flex;
            flex-flow: row nowrap;
            justify-content: space-between;
            width: 100%;
            border-bottom: 1px solid #e3e3e3;
            padding: 10px 0 10px 15px;
        }
        .contact-list a.contact.active-contact {
            background-color: #e5f8e6;
        }
        #conversation .message-image,
        .contact-about .message-image,
        .contact-list a.contact .message-image{
            position: relative;
            margin-right: 10px;
            max-height: 50px;
        }
        #conversation .message-image img,
        .contact-about .message-image img,
        .contact-list a.contact .message-image img{
            box-shadow: 0 0 3px rgba(0,0,0,.3);
            height: 50px;
            width: 50px;
            padding: 2px;
            float: none;
            border-radius: 50%;
        }
        #conversation .message-image .profile-status,
        .contact-about .message-image .profile-status,
        .contact-list a.contact .message-image .profile-status{
            border-radius: 50%;
            display: inline-block;
            height: 12px;
            left: 35px;
            position: absolute;
            bottom: 0px;
            width: 12px;
            border: 2px solid #fff;
        }
        #conversation .message-image .profile-status.online,
        .contact-about .message-image .profile-status.online,
        .contact-list a.contact .message-image .profile-status.online{
            background: #2cd07e;
        }
        #conversation .message-image .profile-status.offline,
        .contact-about .message-image .profile-status.offline,
        .contact-list a.contact .message-image .profile-status.offline{
            background: #ffc107;
        }
        #conversation .message-image .profile-status.busy,
        .contact-about .message-image .profile-status.busy,
        .contact-list a.contact .message-image .profile-status.busy{
            background: #ff5050;
        }
        #conversation .contact-name,
        .contact-about .message-image .contact-name,
        .contact-list a.contact .contact-name{
            margin: 0;
            color: #444;
            margin-top: 3%;
            width: 0;
            -webkit-box-flex: 2;
            -webkit-flex: 2 2 auto;
            -ms-flex: 2 2 auto;
            flex: 2 2 auto;
            padding-right: 10px;
        }
        .contact-list .contact p {
            color: #555;
            font-size: 13px;
            font-weight: 700;
            height: 15px;
        }
        .contact-list .contact.read p {
            font-weight: 400;
        }
        .contact-list a.contact .contacts-list-date{
            margin: 0;
            margin-top: 6%;
            color: #999;
            font-size: 10px;
            font-weight: 500;
            display: inline-block;
            white-space: pre;
        }
        .contact-list nav ul.contact-action{
            right: 35%;
            left: auto;
            position: absolute;
            top: 65%;
        }
        .contact-list nav ul.contact-action li{
            border-bottom: 1px solid #ddd;
            padding: 3px 0;
        }
        .contact-list nav ul.contact-action li:hover{
            background: #eee;
        }
        .contact-list nav span.unread-count {
            background-color: #1dbf73;
            display: inline-block;
            color: #fff;
            font-size: 10px;
            font-weight: 500;
            padding: 2px 8px;
            border-radius: 8px;
            text-align: center;
            margin-right: 5px;
        }

        #conversation{
            height: 100%;
            padding: 0 10px;
            margin: 8px 0;
            position: relative;
        }
        .empty-state {
            width: 100%;
            height: 100%;
            display: -webkit-box;
            display: -webkit-flex;
            display: -ms-flexbox;
            display: flex;
            -webkit-box-orient: vertical;
            -webkit-box-direction: normal;
            -webkit-flex-direction: column;
            -ms-flex-direction: column;
            flex-direction: column;
            -webkit-box-pack: center;
            -webkit-justify-content: center;
            -ms-flex-pack: center;
            justify-content: center;
            text-align: center;
        }
        .empty-state.no-selection {
            -webkit-box-align: center;
            -webkit-align-items: center;
            -ms-flex-align: center;
            align-items: center;
        }
        .empty-state strong {
            color: #555;
            font-size: 30px;
            line-height: 100%;
            margin-bottom: 5px;
        }
        .empty-state small {
             color: #999;
             white-space: pre-line;
             font-size: 16px;
             line-height: 140%;
             font-weight: 400;
             max-width: 300px;
             margin: 10px auto;
             padding: 0 20px;
        }
        #conversation .card-header > .card-tools {
            position: absolute;
            right: 1rem;
            top: 1.5rem;
        }
        #conversation .card-header > .card-tools button{ color: #333; }
        #conversation .card-body{
            height: calc(100% - 0px);
            padding: 10px 0;
            margin-bottom: 30px;
        }
        .img_cont_msg{
            height: 40px;
            width: 40px;
        }
        .user_img_msg {
            height: 40px;
            width: 40px;
            border: 1.5px solid #f5f6fa;
        }
        .msg_cotainer{
            background: #ebebeb none repeat scroll 0 0;
            border-radius: 3px;
            color: #646464;
            font-size: 14px;
            margin: 0;
            padding: 5px 10px 5px 12px;
            position: relative;
            width: 50%;
        }
        .msg_cotainer_send{
            background: #05728f none repeat scroll 0 0;
            border-radius: 3px;
            font-size: 14px;
            margin: 0;
            color: #fff;
            padding: 5px 10px 5px 12px;
            position: relative;
            width: 50%;
        }
        .msg_time{
            position: absolute;
            left: 0;
            bottom: -15px;
            font-size: 10px;
            color: #646464;
        }
        .msg_time_send{
            position: absolute;
            right:0;
            bottom: -15px;
            font-size: 10px;
            color: #646464;
        }
        #conversation .card-footer{
            padding: 0;
            position: absolute;
            width: 96%;
            bottom: 10px;
            left: 50%;
            transform: translate(-50%, 0);
        }


        .contact-about{
            margin-top: 7px;
            height: 100%;
        }
        .contact-about .card-body{
            display: flex;
            flex-flow: column nowrap;
            align-items: center;
            justify-content: center;
            text-align: center;
        }



        .contact-list .card-body{ overflow-x: hidden; max-height: 375px; }
        .contact-list .card-body::-webkit-scrollbar { width: .5em; }
        .contact-list .card-body::-webkit-scrollbar-thumb { background-color: #274448; border-radius: 10px; }


        .conversation-room .card-body{ overflow-x: hidden; max-height: 345px; }
        .conversation-room .card-body::-webkit-scrollbar { width: .5em; }
        .conversation-room .card-body::-webkit-scrollbar-thumb { background-color: #274448; border-radius: 10px; }

    </style>
@endsection




@section('custom_js')

    <script src="https://js.pusher.com/5.0/pusher.min.js"></script>
    <script>
        // Enable pusher logging - don't include this in production
        Pusher.logToConsole = true;

        var pusher = new Pusher('9855c55ed4e7fe357123', {
            cluster: 'ap2',
            forceTLS: true
        });

        var channel = pusher.subscribe('chat-push-notification-channel');
        //console.log(channel);
        // channel.bind('pusher:subscription_succeeded', function(members) {
        //     alert(JSON.stringify(members));
        //     pusher.subscribe(Date.now() + Math.random().toString(36).replace(/\W+/g, ''));
        //     // update_member_count(members.count);
        //     // members.each(function(member) {
        //     //     add_member(member.id, member.info);
        //     // });
        // });
        // channel.bind('update', function (data) {
        //     document.getElementById('visitorCount').textContent = data.newCount;
        // });

        channel.bind('chat-push-notification-event', function(data) {
            alert(JSON.stringify(data));
        });
    </script>

    <script type="text/javascript">
        $(document).ready(function() {
            if(typeof $('.conversation-room').find('.card-body')[0] !== 'undefined'){
                $('.conversation-room').find('.card-body').animate({
                    scrollTop: $('.conversation-room').find('.card-body')[0].scrollHeight
                }, 1000);
            };
        });

        $(document).on('click', '.search-contact-btn', function(event) {
            event.preventDefault();
            $(".contact-list").find('.search-bar').hide();
            var $form = $("form.search-contact-form").show();
            $form.find('input').focus();
        });

        $(document).on('click', '.close-search-contact-form', function(event) {
            event.preventDefault();

            $(".contact-list").find('.search-bar').show();
            $("form.search-contact-form").hide();

            $(".contact-list .contact-name").each(function(){
                $(this).parent().show();
            });
            $("form.search-contact-form").trigger('reset');
        });

        $(document).on("change", "select#filter-contact", function (){
            var filter = $(this).find('option:selected').val().toLowerCase();
            var count = $(".contact-list a.contact."+filter).length;

            if( count) {
                $(".contact-list a.contact").filter(function () {
                    if ($(this).hasClass(filter)) {
                        $(this).show();
                    } else {
                        $(this).hide();
                    }
                    $(".contact-list").find('.nothing-tosee').hide();
                });
            }else{
                $(".contact-list a.contact").hide();
                $(".contact-list").find('.nothing-tosee').show();
                $(".contact-list").find('.nothing-tosee').find('span').html('"'+filter+'"');
            }
        });

        $(document).on('click', 'button.view-all-conversation', function(event) {
            event.preventDefault();
            $(".contact-list a.contact").show();
            $(".contact-list").find('.nothing-tosee').hide();
            $("select#filter-contact").prop('selectedIndex',0); /*.val('contact')*/
        });

        //search Contact
        $("form.search-contact-form #s").on('keyup', function(){
            var filter = $(this).val().toLowerCase();

            $(".contact-list .contact-name").filter(function(){
                //$(this).parent().toggle($(this).text().toLowerCase().indexOf(filter) > -1)

                if ($(this).text().search(new RegExp(filter, "i")) < 0) {
                    $(this).parent().hide();
                }else {
                    $(this).parent().show();
                }
            });
        });

        //
        // $("form#chatMessageForm").submit(function (event) {
        //     event.preventDefault();
        //     $("button[type=submit]").attr('disabled', 'disabled').html("<i class='fa fa-spinner fa-spin'></i> sending...");
        //
        //     var form = $(this);
        //     //var message_body = form.find('input[name=message_body]').val();
        //     var data = form.serialize();
        //     var url = form.attr("action");
        //
        //     $.ajaxSetup({
        //         headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') }
        //     });
        //
        //     $.ajax({
        //         type: "POST",
        //         url: url,
        //         data: data,
        //         dataType: 'json',
        //         success: function (response) {
        //             var message_item = '<div id="'+response[0].user_id+'" class="d-flex justify-content-end mb-5 animated slideInUp" style="display:none;">'
        //                 + '<div class="msg_cotainer_send">'+response[0].message_body+'<time class="msg_time_send">'+response[1].message_time+'</time></div>'
        //                 + '<div class="img_cont_msg"><img class="rounded-circle user_img_msg"  src="'+response[1].photo_url+'" /></div>'
        //                 + '</div>';
        //             $(message_item).appendTo( $("#conversation").find(".conversation-room .card-body") ).fadeIn(1000);
        //
        //             $('.conversation-room').find('.card-body').animate({scrollTop: $('.conversation-room').find('.card-body')[0].scrollHeight}, 1000);
        //
        //             toastr.info( response.message, "Info", {"closeButton": true,"newestOnTop": true,"progressBar": true,"preventDuplicates": true});
        //             $("button[type=submit]").removeAttr('disabled').html("Send");
        //             form.trigger('reset');
        //         },
        //         statusCode:{ 404: function(){ alert( "page not found" ); } },
        //         error: function (xhr, textStatus, errorThrown) { alert(errorThrown); },
        //         beforeSend: function( xhr ) { $(".ajax-loader").show('slow'); },
        //         complete: function( jqXHR, textStatus ) { $(".ajax-loader").hide('fast'); },
        //     });
        //     return false;
        // });


        $(document).on("click", "button.add_to_chat_contact", function(){
            var id = $(this).attr('id');

            $.ajaxSetup({
                headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') }
            });

            $.ajax({
                type: "POST",
                url: "{{ url('message/add-chat-contact') }}/"+ id,
                dataType: 'json',
                success: function (response) {
                    setTimeout(function(){ window.location.reload(); }, 500);
                    //$('#newChatContactModal').modal('hide');
                    toastr.info( response.message, "Info", {"closeButton": true,"newestOnTop": true,"progressBar": true,"preventDuplicates": true});
                },
                statusCode:{ 404: function(){ alert( "page not found" ); } },
                beforeSend: function( xhr ) { $(".ajax-loader").show(); },
                complete: function( jqXHR, textStatus ) { $(".ajax-loader").hide(); },
            });
        });


        $(document).on("click", "button.delete-chat-contact-btn", function(event){
            event.preventDefault();
            var chat_contact_id = $(this).attr('id');
            var parent = $(this).parents('a.contact');

            if( !confirm("Are you sure want to delete this contact?.")){ return; }

            $.ajaxSetup({
                headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') }
            });

            $.ajax({
                type: "POST",
                url: "{{ url('message/delete-chat-contact') }}",
                data: { 'chat_contact_id': chat_contact_id, '_method': 'DELETE' },
                dataType: 'json',
                success: function (response) {
                    toastr.info( response.message, "Info", {"closeButton": true,"newestOnTop": true,"progressBar": true,"preventDuplicates": true});
                    parent.slideUp(300, function() { parent.parents('a.contact').remove(); });
                    window.location.assign( "{{ url('message') }}" );
                },
                statusCode:{ 404: function(){ alert( "page not found" ); } },
                beforeSend: function( xhr ) { $(".ajax-loader").show(); },
                complete: function( jqXHR, textStatus ) { $(".ajax-loader").hide(); },
            });
        });


        $(document).on("click", "button.change-reading-status-btn", function(event){
            event.preventDefault();
            var chat_contact_id = $(this).attr('id');
            var status = $(this).data('status');

            $.ajaxSetup({
                headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') }
            });

            $.ajax({
                type: "POST",
                url: "{{ url('message/change-reading-status') }}/"+chat_contact_id+"/"+status,
                dataType: 'json',
                success: function (response) {
                    window.location.assign( "{{ url('message') }}" );
                    toastr.info( response.message, "Info", {"closeButton": true,"newestOnTop": true,"progressBar": true,"preventDuplicates": true});
                },
                statusCode:{ 404: function(){ alert( "page not found" ); } },
                beforeSend: function( xhr ) { $(".ajax-loader").show(); },
                complete: function( jqXHR, textStatus ) { $(".ajax-loader").hide(); },
            });
        });


        $(document).on("click", "button.block-chat-contact-btn", function(event){
            event.preventDefault();
            var chat_contact_id = $(this).attr('id');

            if( !confirm("Are you sure want to block this contact?")){ return; }

            $.ajaxSetup({
                headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') }
            });

            $.ajax({
                type: "POST",
                url: "{{ url('message/block-chat-contact') }}/"+chat_contact_id,
                dataType: 'json',
                success: function (response) {
                    toastr.info( response.message, "Info", {"closeButton": true,"newestOnTop": true,"progressBar": true,"preventDuplicates": true});
                    window.location.assign( "{{ url('message') }}" );
                },
                statusCode:{ 404: function(){ alert( "page not found" ); } },
                beforeSend: function( xhr ) { $(".ajax-loader").show(); },
                complete: function( jqXHR, textStatus ) { $(".ajax-loader").hide(); },
            });
        });


        $(document).on("click", "button.action-star", function(event){
            event.preventDefault();

            var $this = $(this);
            var id = $(this).attr('id');
            var status = $(this).data('status');
            var parent = $(this).parent('div');

            $.ajaxSetup({
                headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') }
            });

            $.ajax({
                type: "POST",
                url: "{{ url('message/change-star-status') }}/"+ id +"/"+ status,
                dataType: 'json',
                success: function (response) {
                    if(response.star_status == "Starred"){
                        $this.remove();
                        parent.prepend('<button id="'+response.chat_contact_id+'" class="btn action-star" data-status="NotStarred" title="NotStarred"><i class="far fa-star"></i></button>');
                        $("ul.contact-action").find('li').first().remove();
                        $("ul.contact-action").prepend('<li><button id="'+response.chat_contact_id+'" class="btn action-star" data-status="NotStarred" title="Not starred"><i class="far fa-star"></i></button></li>');
                    }else{
                        $this.remove();
                        parent.prepend('<button id="'+response.chat_contact_id+'" class="btn action-star" data-status="Starred" title="Starred"><i class="fas fa-star text-yellow"></i></button>');
                    }
                    toastr.info( response.message, "Info", {"closeButton": true,"newestOnTop": true,"progressBar": true,"preventDuplicates": true});
                },
                statusCode:{ 404: function(){ alert( "page not found" ); } },
                beforeSend: function( xhr ) { $(".ajax-loader").show(); },
                complete: function( jqXHR, textStatus ) { $(".ajax-loader").hide(); },
            });
        });
    </script>

    {{--BROADCAST_DRIVER=pusher--}}
    {{--PUSHER_APP_ID=859368--}}
    {{--PUSHER_APP_KEY=6aad04b33647d824b8d8--}}
    {{--PUSHER_APP_SECRET=04b1ff6b3d9f1e788961--}}
    {{--PUSHER_APP_CLUSTER=AP2--}}

    {{--MIX_PUSHER_APP_KEY="${PUSHER_APP_KEY}"--}}
    {{--MIX_PUSHER_APP_CLUSTER="${PUSHER_APP_CLUSTER}"--}}

@endsection
