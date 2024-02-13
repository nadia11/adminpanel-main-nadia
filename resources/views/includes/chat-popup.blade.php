<div class="col-md-6">
    <div class="card direct-chat direct-chat-primary">
        <div class="card-header">
            <h3 class="card-title">Direct Chat</h3>

            <div class="card-tools">
                <span data-toggle="tooltip" title="3 New Messages" class="badge badge-primary">3</span>
                <button type="button" class="btn btn-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
                <button type="button" class="btn btn-tool" data-toggle="tooltip" title="Contacts" data-widget="chat-pane-toggle"><i class="fa fa-comments"></i></button>
                <button type="button" class="btn btn-tool" data-widget="remove"><i class="fa fa-times"></i>
                </button>
            </div>
        </div>

        <div class="card-body">
            <div class="direct-chat-messages">
                <div class="direct-chat-msg">
                    <div class="direct-chat-info clearfix">
                        <span class="direct-chat-name float-left">Alexander Pierce</span>
                        <span class="direct-chat-timestamp float-right">23 Jan 2:00 pm</span>
                    </div>
                    <img class="direct-chat-img" src="{{ image_url('avatar4.png') }}" alt="message user image">
                    <div class="direct-chat-text">
                        Is this template really for free? That's unbelievable!
                    </div>
                </div>

                <div class="direct-chat-msg right">
                    <div class="direct-chat-info clearfix">
                        <span class="direct-chat-name float-right">Sarah Bullock</span>
                        <span class="direct-chat-timestamp float-left">23 Jan 2:05 pm</span>
                    </div>
                    <img class="direct-chat-img" src="{{ image_url('avatar3.png') }}" alt="message user image">
                    <div class="direct-chat-text">
                        You better believe it!
                    </div>
                </div>
            </div><!--/.direct-chat-messages-->


            <!-- Contacts are loaded here -->
            <div class="direct-chat-contacts">
                {{ Str::uuid('mehedi') }}

                <ul class="contacts-list">
                    <?php $user_data = DB::table('users')->join('user_roles', 'users.role_id', '=', 'user_roles.role_id')->select('users.*', 'user_roles.role_name')->get(); ?>
                    @foreach( $user_data as $user )
                        <li id="{{ $user->id }}">
                            <a href="#">
                                @if(Cache::has('user-is-online-'.$user->id)) <i class="online-indicator"></i> @else <i class="text-mute"></i> @endif
                                <img class="contacts-list-img"  src="<?php if(!empty($user->photo)){ echo public_url( "user-photo/". $user->photo ); }else{ echo image_url('defaultAvatar.jpg'); } ?>" style="border-radius: 50%; width: 35px; height: 35px; border: 1px solid #eee; box-shadow: 0 0 3px rgba(0,0,0,.3); padding: 1px; margin: -10px;" />
                                <div class="contacts-list-info">
                                    <span class="contacts-list-name">{{ $user->name }}</span>
                                    <small class="contacts-list-date float-right">2/28/2015</small>
                                </div>
                            </a>
                        </li>
                    @endforeach
                </ul>
            </div>
        </div>

        <div class="card-footer">
            <form action="#" method="post">
                <div class="input-group">
                    <input type="text" name="message" placeholder="Type Message ..." class="form-control">
                    <span class="input-group-append">
                        <button type="button" class="btn btn-primary">Send</button>
                    </span>
                </div>
            </form>
        </div><!-- /.card-footer-->
    </div>
</div><!-- /.col :: Left Side -->