<div class="modal fade" id="newNotificationModal">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">

            <!-- Modal Header -->
            <div class="modal-header">
                <h4 class="modal-title">New Notification</h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>

            <form name="send-notification-form" id="send-notification-form" action="{{ route('new-notification-save') }}" method="POST" enctype="multipart/form-data" class="form-horizontal software-style-label" role="form">
            @csrf

                <!-- Modal body -->
                <div class="modal-body">
                    <div class="form-group contact_group">
                        <label for="recipient" class="control-label">Recipient</label>
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <div class="input-group-text"><i class="fad fa-users"></i></div>
                            </div>
                            <select id="recipient" name="recipient" class="custom-select" required>
                                @php $group_names = DB::table('contact_groups')->orderBy('group_name', 'ASC')->pluck("group_name", "group_id") @endphp

                                <option value="">--Select Receipient--</option>
                                <option value="all-riders">All Riders</option>
                                <option value="all-drivers">All Drivers</option>
                                <option value="all-agents">All Agents</option>
                                @foreach( $group_names as $key => $name )
                                    <option value="{{ $key }}">{{ ucwords($name) }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="notification_title" class="control-label">Title</label>
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text"><i class="fa fa-tags" aria-hidden="true"></i></span>
                            </div>
                            <input type="text" name="notification_title" class="form-control" placeholder="Title" required>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="notification_type" class="control-label">Notification Type</label>
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <div class="input-group-text"><i class="fad fa-users"></i></div>
                            </div>
                            <select id="notification_type" name="notification_type" class="custom-select">
                                <option value="general">General Notification</option>
                                <option value="notice">Notice</option>
                                <option value="info">Info</option>
                            </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="platform" class="control-label">Platform</label>
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <div class="input-group-text"><i class="fad fa-users"></i></div>
                            </div>
                            <select id="platform" name="platform" class="custom-select">
                                <option value="all_platform">All Platform</option>
                                <option value="android">Android</option>
                                <option value="IOS">IOS</option>
                                <option value="web">Web</option>
                            </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="notification_body" class="control-label">Notification Body</label>
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text"><i class="fa fa fa-angle-double-right" aria-hidden="true"></i></span>
                            </div>
                            <textarea name="notification_body" class="form-control" id="notification_body" cols="30" rows="3" placeholder="Notification Body" required></textarea>
                            <div class="notification-counter-wrap" style="width: 100%;display: none;"> <span class="charCount"></span><span class="notificationCount"></span></div>
                        </div>
                    </div>
                </div><!-- Modal Body -->

                <!-- Modal footer -->
                <div class="modal-footer">
                    <button type="button" class="btn btn-outline-dark mr-auto" data-dismiss="modal">Close</button>
                    <button type="submit" name="create_notification" id="create_notification" class="btn btn-success float-right" tabindex="7"><i class="fa fa-paper-plane" aria-hidden="true"></i> Send Now</button>
                </div><!-- Modal footer -->
            </form>
        </div>
    </div>
</div>
