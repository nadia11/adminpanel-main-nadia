<div class="modal fade" id="accountsHeadModal">
    <div class="modal-dialog modal-dialog-centered" style="max-width: 45%;">
        <div class="modal-content">

            <!-- Modal Header -->
            <div class="modal-header">
                <h4 class="modal-title">Accounts Head List</h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>

            <!-- Modal body -->
            <div class="modal-body">
                <table id="account_head_table" class="table table-bordered table-input-form m-0">
                    <thead class="thead-light">
                        <tr>
                            <th>#</th>
                            <th>Type</th>
                            <th>Accounts Head Name</th>
                            <th data-orderable="false" style="width:130px;">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $all_account_heads = DB::table('account_heads')->orderBy('account_head_type', 'asc')->get(); ?>
                        @php $i = 0 @endphp

                        @foreach($all_account_heads as $account_head)
                        @php $i++ @endphp
                        <tr id="cat-{{ $account_head->account_head_id }}">
                            <td>{{ $i }}</td>
                            <td class="text-capitalize">{{ str_replace("_", " ", $account_head->account_head_type) }}</td>
                            <td style="text-align: left; padding-left: 10px;">{{ $account_head->account_head_name }}</td>
                            <td>
                                <div class="btn-group" role="group">
                                    <button type="button" class="btn btn-warning btn-sm btn-flat editAccountHead" id="{{ $account_head->account_head_id }}" style="margin: 5px 0;"><i class="fa fa-edit" aria-hidden="true"> Edit</i></button>
                                    <button type="button" class="btn btn-danger btn-sm btn-flat ajaxDelete" data-href="{{ URL::to('/account/delete-account-head/' . $account_head->account_head_id) }}" data-title="{{ $account_head->account_head_name }}" id="{{ $account_head->account_head_id }}" style="margin: 5px 0;"><i class="far fa-trash-alt" aria-hidden="true"> Delete</i></button>
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div><!-- Modal Body -->

            <!-- Modal footer -->
            <div class="modal-footer">
                <div class="input-group">
                    <select id="account_head_type" name="account_head_type" class="custom-select" tabindex="1">
                        <option value="daily_expense_tab" selected="selected">{{ __('Daily Expense Tab') }}</option>
                        <option value="employee_expense_tab">{{ __('Employee Expense Tab') }}</option>
                        <option value="vendor_expense_tab">{{ __('Vendor Expense Tab') }}</option>
                        <option value="cash_receive_tab">{{ __('Cash Receive Tab') }}</option>
                    </select>
                    <input type="text" name="account_head_name" id="account_head_name" placeholder="Accounts Head" class="form-control" tabindex="2" autocomplete="off" style="width: 35%;" />
                    <div class="input-group-append">
                        <span class="input-group-btn">
                            <button type="submit" name="create_accounts_head" id="create_accounts_head" class="btn btn-success float-right" tabindex="3"><i class="fa fa-plus" aria-hidden="true"></i> Save</button>
                        </span>
                    </div>
                </div>
            </div><!-- Modal footer -->
        </div>
    </div>
</div>
