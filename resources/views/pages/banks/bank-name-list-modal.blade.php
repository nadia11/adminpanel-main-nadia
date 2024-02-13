<div class="modal fade" id="bankNameListModal">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">

            <!-- Modal Header -->
            <div class="modal-header">
                <h4 class="modal-title">Bank Name list</h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>

            <!-- Modal body -->
            <div class="modal-body">
                <table id="bank_name_table" class="table table-bordered table-input-form m-0">
                    <thead class="thead-light">
                        <tr>
                            <th>#</th>
                            <th>Bank Name</th>
                            <th data-orderable="false" style="width:130px;">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $all_bank_names = DB::table('bank_name_lists')->orderBy('bank_name_id', 'desc')->get(); ?>

                        @if (count($all_bank_names) < 1) <tr style="height: 50px;"><td colspan="3">No Items Found</td></tr> @endif

                        @foreach($all_bank_names as $bank_name)
                            <tr id="cat-{{ $bank_name->bank_name_id }}">
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $bank_name->bank_name }}</td>
                                <td>
                                    <button type="button" class="btn btn-warning btn-sm editBankName" id="{{ $bank_name->bank_name_id }}" style="margin: 5px 0;"><i class="fa fa-edit" aria-hidden="true"> Edit</i></button>
                                    <button type="button" class="ajaxDelete btn btn-danger btn-sm" data-href="{{ URL::to('/bank/delete-bank-name/' . $bank_name->bank_name_id) }}" data-title="{{ $bank_name->bank_name }}" id="{{ $bank_name->bank_name_id }}" style="margin: 5px 0;"><i class="far fa-trash-alt" aria-hidden="true"> Delete</i></button>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div><!-- Modal Body -->

            <!-- Modal footer -->
            <div class="modal-footer">
                <div class="input-group">
                    <input type="text" name="bank_name" id="bank_name" placeholder="Bank name" class="form-control" required="required" tabindex="1" autocomplete="off" />
                    <div class="input-group-append">
                        <span class="input-group-btn">
                            <button type="submit" name="create_bank_name" id="create_bank_name" class="btn btn-success float-right" tabindex="8"><i class="fa fa-plus" aria-hidden="true"></i> Add Bank</button>
                        </span>
                    </div>
                </div>
            </div><!-- Modal footer -->
        </div>
    </div>
</div>
