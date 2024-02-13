<div class="modal fade" id="agent_status_modal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-sm modal-dialog-centered">
        <div class="modal-content">

            <!-- Modal Header -->
            <div class="modal-header">
                <h4 class="modal-title">Change Status</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">&times;</button>
            </div>

            <form action="{{ route('change-agent-status') }}" id="changeAgentStatus" method="post" enctype="multipart/form-data" class="form-horizontal" role="form">
            @csrf

                <!-- Modal body -->
                <div class="modal-body">
                    <div class="form-group">
                        <label for="agent_status" class="control-label">{{ __('Agent Status') }}</label>
                        <select name="agent_status" id="agent_status" class="custom-select" required>
                            <option value="active">{{ __('Active') }}</option>
                            <option value="pending">{{ __('Pending') }}</option>
                            <option value="banned">{{ __('Banned') }}</option>
                            <option value="suspend">{{ __('Suspend') }}</option>
                        </select>
                    </div>
                </div><!-- Modal Body -->

                <!-- Modal footer -->
                <div class="modal-footer">
                    <input type="hidden" name="agent_id" />
                    <button type="submit" class="btn btn-dark"><i class="fa fa-check"></i> {{ __('Save') }}</button>
                </div>
            </form>
        </div>
    </div>
</div>
