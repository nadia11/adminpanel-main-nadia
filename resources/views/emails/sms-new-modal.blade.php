<div class="modal fade" id="newsmsModal">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">

            <!-- Modal Header -->
            <div class="modal-header">
                <h4 class="modal-title">New Message</h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>

            <form name="" id="send-sms-form" action="{{ route('send-sms') }}" method="POST" enctype="multipart/form-data" class="form-horizontal software-style-label" role="form">
            @csrf

                <!-- Modal body -->
                <div class="modal-body">
                    <div class="form-group">
                        <label for="recipient_type" class="control-label">Recipient Type</label>
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <div class="input-group-text"><i class="fad fa-layer-group"></i></div>
                            </div>
                            <select id="recipient_type" name="recipient_type" class="custom-select">
                                <option value="single_recipient">Single Recipient</option>
                                <option value="group_recipient">Group Recipient</option>
                            </select>
                            <div style="width: 100%;display: block;">{{ file_get_contents('http://www.btssms.com/miscapi/'. 'C20000855ef07d1a0c3bb6.30671475' .'/getBalance') }}</div>
                        </div>
                    </div>
                    <div class="form-group phone_number">
                        <label for="phone_number" class="control-label">Phone Number</label>
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text">+880</span>
                            </div>
                            <input type="number" name="phone_number" id="phone_number" class="form-control" placeholder="Your Phone Number" min="13" required>
                        </div>
                    </div>
                    <div class="form-group contact_group" style="display: none">
                        <label for="contact_group" class="control-label">Contact Group</label>
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <div class="input-group-text"><i class="fad fa-users"></i></div>
                            </div>
                            <select id="contact_group" name="contact_group" class="custom-select">
                                <option value="">--Select Group--</option>
                                <option value="all-riders" data-recipient_count="{{ DB::table('riders')->count() }}">All Riders</option>
                                <option value="all-drivers" data-recipient_count="{{ DB::table('drivers')->count() }}">All Drivers</option>
                                <option value="all-agents" data-recipient_count="{{ DB::table('agents')->count() }}">All Agents</option>

                                @php $group_names = DB::table('contact_groups')->orderBy('group_name', 'ASC')->pluck("group_name", "group_id") @endphp
                                @foreach( $group_names as $key => $name )
                                    <option value="{{ $key }}"  data-recipient_count="{{ DB::table('contact_groups')->where('group_name', $name)->count() }}">{{ ucwords($name) }}</option>
                                @endforeach
                            </select>
                            <div style="width: 100%;display: none; color: red;" id="smsCheckMessage"><span id="smsRecipientCount"></span> SMS will be send, please check credit first and then send. Otherwise some people will not get sms.</div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="subject" class="control-label">Subject</label>
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text"><i class="fa fa-tags" aria-hidden="true"></i></span>
                            </div>
                            <input type="text" name="subject" class="form-control" placeholder="Subject" required>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="sms_type" class="control-label">SMS Type</label>

                        <div class="form-check-inline">
                            <label class="form-check-label">
                                <input type="radio" class="form-check-input" id="text" name="sms_type" value="text" checked>Text SMS
                            </label>
                        </div>
                        <div class="form-check-inline">
                            <label class="form-check-label">
                                <input type="radio" class="form-check-input" id="unicode" name="sms_type" value="unicode">Unicode SMS
                            </label>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="message_body" class="control-label">Message Body</label>
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text"><i class="fa fa fa-angle-double-right" aria-hidden="true"></i></span>
                            </div>
                            <textarea name="message_body" class="form-control" id="message_body" cols="30" rows="3" placeholder="Message Body" required></textarea>
                            <div class="sms-counter-wrap" style="width: 100%;display: none;"> <span class="charCount"></span><span class="smsCount"></span></div>
                        </div>
                    </div>
                </div><!-- Modal Body -->

                <!-- Modal footer -->
                <div class="modal-footer">
                    <button type="button" class="btn btn-outline-dark mr-auto" data-dismiss="modal">Close</button>
                    <button type="submit" name="create_sms" id="create_sms" class="btn btn-success float-right" tabindex="7"><i class="fa fa-paper-plane" aria-hidden="true"></i> Send Now</button>
                </div><!-- Modal footer -->
            </form>
        </div>
    </div>
</div>
