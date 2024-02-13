@extends('dashboard')
@section('main_content')

<section class="content">
    <div class="box box-success animated fadeInRight">
        <div class="box-header with-border">
            <h2 class="box-title">Showing All Employee Bank Accounts</h2>
            <div class="box-tools float-right" style="margin-right: 2%;">
                <div class="float-left" style="margin-right: 5px; width: 130px;">
                    <select id="bank_account_id" class="custom-select custom-select-sm">
                        <option value="">-- Account Name --</option>
                        <?php $bank_accounts = DB::table('employee_bank_accounts')->join('employees', 'employee_bank_accounts.employee_id', '=', 'employees.employee_id')->select('employee_bank_accounts.bank_account_id', 'employee_bank_accounts.account_number', 'employees.employee_name')->get(); ?>

                        @foreach($bank_accounts as $account )
                        <option value="{{ $account->bank_account_id }}">{{ $account->employee_name }} - {{ $account->account_number }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="input-group float-left" style="margin-right: 5px; width: 250px;">
                    <div class="input-group-prepend"><span class="input-group-text" style="padding: 3px;">Account No</span></div>
                    <input type="text" name="account_number" id="account_number" class="form-control form-control-sm" placeholder="Account No" />
                </div>
                <div class="float-left" style="margin-right: 5px; width: 110px;">
                    <label for="bank_name" class="control-label sr-only">Bank Name:</label>
                    <select id="bank_name" class="custom-select custom-select-sm">
                        <option value="" selected="selected">{{ __('--Bank Name--') }}</option>
                        <?php $bank_name_lists = DB::table('bank_name_lists')->pluck("bank_name", "bank_name_id"); ?>
                        @foreach( $bank_name_lists as $key => $bank_name )
                        <option value="{{ $key }}">{{ $bank_name }}</option>
                        @endforeach
                    </select>
                </div>
                <button type="button" class="btn btn-dark btn-sm showNewBankAccountModal" data-toggle="tooltip" data-placement="top" title="Add New Bank Account Modal"><i class="fa fa-plus"></i> New Bank Account</button>
            </div><!-- /.box-tools -->

            <div class="box-tools float-right">
                <button type="button" class="btn btn-box-tool" id="refresh" data-toggle="tooltip" data-placement="top" title="Refresh"><i class="fa fa-sync-alt"></i></button>
            </div><!-- /.box-tools -->
        </div><!-- /.box-header -->

        <div class="box-body">
            <table id="general_datatable" class="table table-striped table-custom">
                <thead class="thead-inverse">
                    <tr>
                        <th>#</th>
                        <th>Account Name</th>
                        <th>Account Number</th>
                        <th>Account Type</th>
                        <th>Bank Name</th>
                        <th>Branch</th>
                        <th data-orderable="false" class="no-print">Action</th>
                    </tr>
                </thead>
                <tbody>
                @foreach($all_bank_ac_info as $bank_ac)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $bank_ac->employee_name }}</td>
                        <td>{{ $bank_ac->account_number }}</td>
                        <td>{{ $bank_ac->account_type }}</td>
                        <td>{{ $bank_ac->bank_name }}</td>
                        <td>{{ $bank_ac->branch }}</td>
                        <td style="width:90px;">
                            <button type="button" class="btn btn-info btn-sm view-bank-account" id="{{ $bank_ac->bank_account_id }}" data-url="{{ url('/employee/view-bank-account/' . $bank_ac->bank_account_id) }}"><i class="fa fa-eye" aria-hidden="true"></i></button>
                            <button type="button" class="btn btn-warning btn-sm editBankAccount" id="{{ $bank_ac->bank_account_id }}" data-url="{{ url('/employee/edit-bank-account/' .  $bank_ac->bank_account_id) }}" disabled><i class="fa fa-edit" aria-hidden="true"></i></button>
                            <button type="button" class="ajaxDelete btn btn-danger btn-sm" data-href="{{ URL::to('/employee/delete-bank-account/' . $bank_ac->bank_account_id) }}" data-title="{{ $bank_ac->bank_name }}" id="{{ $bank_ac->bank_account_id }}" disabled><i class="far fa-trash-alt" aria-hidden="true"></i></button>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div><!-- /.box-body -->

        <div class="overlay" style="display: none;">
            <i class="fa fa-sync-alt fa-spin"></i>
        </div>
    </div><!-- /.box -->
</section>

@include('pages.employees.employee-bank-account-new-modal')
@include('pages.employees.employee-bank-account-edit-modal')
@include('pages.employees.employee-bank-account-view-modal')

@endsection


@section('custom_js')
<script type="text/javascript">
    $(document).ready(function(){
        $('button.showNewBankAccountModal').on('click', function () {
            var modal = $("#newBankAccountModal");
            modal.modal({ backdrop: "static", keyboard: true });
            modal.on('shown.bs.modal', function(){ $(":input[type='text']:enabled:visible:first").focus(); });
        });
    }); //End of Document ready

    $(document).ready(function(){
        $(document).on('click', 'button.editBankAccount', function () {

            var url = $(this).data('url');
            var id = $(this).attr('id');
            var modal = $("#editBankAccountModal");

            $.ajax({
                url: url,
                method: "get",
                data: { id: id },
                dataType: "json",
                success: function( response ) {
                    modal.find('.modal-title').text( "Update Bank Account" );
                    modal.find('input[name=bank_account_id]').val( response.bank_account_id );
                    modal.find('#account_name').val( response.account_name );
                    modal.find('#account_number').val( response.account_number );
                    modal.find('#bank_name_id').val( response.bank_name_id );
                    modal.find('#branch').val( response.branch );
                    modal.find('#account_type').val( response.account_type );
                    modal.find('#swift_code').val( response.swift_code );
                    modal.find('#website').val( response.website );
                    modal.find('#email').val( response.email );
                    modal.find('#phone').val( response.phone );
                    modal.find('#alt_phone').val( response.alt_phone );
                    modal.find('#bank_address').val( response.bank_address );
                    modal.find('#bank_note').val( response.bank_note );

                    modal.modal({ backdrop: "static", keyboard: true });
                    modal.on('shown.bs.modal', function(){ $(":input[type='text']:enabled:visible:first").focus(); });
                },
                statusCode:{ 404: function(){ alert( "page not found" ); } },
                beforeSend: function( xhr ) { $(".ajax-loader").show(); },
                complete: function( jqXHR, textStatus ) { $(".ajax-loader").hide(); },
            });
        });
    }); //End of Document ready

    $(document).ready(function(){
        $(document).on('click', 'button.view-bank-account', function () {

            var url = $(this).data('url');
            var id = $(this).attr('id');
            var modal = $("#view_employee_bank_account_modal");

            $.ajax({
                url: url,
                method: "get",
                //data: { id: id },
                dataType: "json",
                cache:false,
                async: false,
                success: function( data ) {
                    modal.find('.modal-title').text( "View Account ("+ data.account_name +")" );
                    modal.find('.account_name').text( data.account_name );
                    modal.find('.account_number').text( data[0].account_number );
                    modal.find('.bank_name_id').text( data.bank_name );
                    modal.find('.branch').text( data[0].branch );
                    modal.find('.bank_address').text( data[0].bank_address );
                    modal.find('.account_type').text( data[0].account_type );
                    modal.find('.swift_code').text( data[0].swift_code );
                    modal.find('.website').text( data[0].website );
                    modal.find('.email').text( data[0].email );
                    modal.find('.phone').text( data[0].phone );
                    modal.find('.alt_phone').text( data[0].alt_phone );
                    modal.find('.bank_note').text( data[0].bank_note );

                    modal.modal("show");
                },
                beforeSend: function( xhr ) { $(".ajax-loader").show('slow'); },
                complete: function( jqXHR, textStatus ) { $(".ajax-loader").hide('fast'); },
            });
        });
    }); //End of Document ready

</script>
@endsection

