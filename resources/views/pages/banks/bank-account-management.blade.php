@extends('dashboard')
@section('main_content')

<section class="content">
    <div class="box box-success animated fadeInRight">
        <div class="box-header with-border">
            <h2 class="box-title">All Bank Account List</h2>
            <div class="box-tools float-right" style="margin-right: 3%;">
                <div class="float-left" style="margin-right: 5px; width: 130px;">
                    <select id="bank_account_id" name="bank_account_id" class="custom-select custom-select-sm">
                        <option value="">-- Account Name --</option>
                        <?php $bank_accounts = DB::table('bank_accounts')->select('account_name', 'account_number', 'bank_account_id')->get(); ?>

                        @foreach($bank_accounts as $bank_account )
                        <option value="{{ $bank_account->bank_account_id }}">{{ $bank_account->account_name . " (" . $bank_account->account_number . ")" }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="input-group float-left" style="margin-right: 5px; width: 250px;">
                    <div class="input-group-prepend"><span class="input-group-text" style="padding: 3px;">Account No</span></div>
                    <input type="text" name="account_number" id="account_number" class="form-control form-control-sm" placeholder="Account No" />
                </div>
                <div class="float-left" style="margin-right: 5px; width: 110px;">
                    <label for="bank_name" class="control-label sr-only">Bank Name:</label>
                    <select id="bank_name" name="bank_name" class="custom-select custom-select-sm">
                        <option value="" selected="selected">{{ __('--Bank Name--') }}</option>
                        <?php $bank_name_lists = DB::table('bank_name_lists')->pluck("bank_name", "bank_name_id"); ?>
                        @foreach( $bank_name_lists as $key => $bank_name )
                        <option value="{{ $key }}">{{ $bank_name }}</option>
                        @endforeach
                    </select>
                </div>
                <button type="button" class="btn btn-info btn-sm" data-toggle="modal" data-target="#bankNameListModal"><i class="fa fa-box"></i> Bank Name List</button>
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
                        <th>Account No.</th>
                        <th>Account Type</th>
                        <th>Bank Name</th>
                        <th>Branch</th>
                        <th>Current Balance</th>
                        <th data-orderable="false" class="no-print">Action</th>
                    </tr>
                </thead>
                <tbody>
                @foreach($all_bank_ac_info as $bank_ac)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $bank_ac->account_name }}</td>
                        <td>{{ $bank_ac->account_number }}</td>
                        <td>{{ $bank_ac->account_type }}</td>
                        <td>{{ $bank_ac->bank_name }}</td>
                        <td>{{ $bank_ac->branch }}</td>
                        <td><?php $balance_query = DB::table('bank_transactions')->where('bank_account_id', $bank_ac->bank_account_id)->select(DB::raw('SUM(credit) as credit, SUM(debit) as debit'))->first(); echo taka_format('', $balance_query->credit - $balance_query->debit); ?></td>
                        <td style="width:90px;">
                            <button type="button" class="btn btn-info btn-sm view-bank-account" id="{{ $bank_ac->bank_account_id }}" data-url="{{ url('/bank/view-bank-account/' . $bank_ac->bank_account_id) }}"><i class="fa fa-eye" aria-hidden="true"></i></button>
                            <button type="button" class="btn btn-warning btn-sm editBankAccount" id="{{ $bank_ac->bank_account_id }}" data-url="{{ url('/bank/edit-bank-account/' .  $bank_ac->bank_account_id) }}" disabled><i class="fa fa-edit" aria-hidden="true"></i></button>
                            <button type="button" class="ajaxDelete btn btn-danger btn-sm" data-href="{{ URL::to('/bank/delete-bank-account/' . $bank_ac->bank_account_id) }}" data-title="{{ $bank_ac->bank_name }}" id="{{ $bank_ac->bank_account_id }}" disabled><i class="far fa-trash-alt" aria-hidden="true"></i></button>
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

@include('pages.banks.bank-account-new-modal')
@include('pages.banks.bank-account-edit-modal')
@include('pages.banks.bank-name-list-modal')
@include('pages.banks.bank-account-view-modal')

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
                    modal.find('#opening_date').val( response.opening_date.split('-')[2]+"/"+response.opening_date.split('-')[1]+"/"+response.opening_date.split('-')[0] );
                    modal.find('#balance').val( response.balance );
                    modal.find('#website').val( response.website );
                    modal.find('#email').val( response.email );
                    modal.find('#phone').val( response.phone );
                    modal.find('#alt_phone').val( response.alt_phone );
                    modal.find('#percent').val( response.percent );
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
        $("body").on("click", "button#create_bank_name", function(event){
            event.preventDefault();

            var parent = $(this).parents('.modal-footer');
            var bank_name = parent.find('#bank_name').val();
            var token = $('meta[name="csrf-token"]').attr('content');

            $.ajaxSetup({
                headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') }
            });

            if(bank_name){
                $.ajax({
                    type: "POST",
                    url: "{{ url('/bank/new-bank-name-save') }}",
                    data: {bank_name: bank_name, _token: token} ,
                    dataType: 'json',
                    success: function (data) {
                        $("#bank_name_table").find('tbody').prepend(
                            '<tr id="cat-'+ data[0].bank_name_id +'">'
                            + '<td>'+ data[0].bank_name_id +'</td>'
                            + '<td>'+ data[0].bank_name +'</td>'
                            + '<td>'
                            + '<button type="button" class="btn btn-warning btn-sm editBankName" id="'+ data[0].bank_name_id +'" style="margin: 5px 0;"><i class="fa fa-edit" aria-hidden="true"> Edit</i></button>'
                            + '<button type="button" class="ajaxDelete btn btn-danger btn-sm" data-href="{{ URL::to('/bank/delete-bank-name') }}/'+ data[0].bank_name_id +'" data-title="'+ data[0].bank_name +'" id="'+ data[0].bank_name_id +'" style="margin: 5px 0;"><i class="far fa-trash-alt" aria-hidden="true"> Delete</i></button>'
                            + '</td>'
                            + '</tr>'
                        );
                       parent.find('#bank_name').val('');
                    },
                    error: function (xhr, textStatus, errorThrown) { alert(errorThrown); },
                });
            }else{
                alert('Please enter something');
            }
        });


        $(document).on('click', 'button.editBankName', function () {
            var id = $(this).attr('id');

            $.ajax({
                url: "{{ url('bank/edit-bank-name') }}/" + id,
                method: "get",
                //data: { id: id },
                dataType: "json",
                success: function( response ) {
                    $("#bank_name_table tr#cat-" + response.bank_name_id).html(
                        '<td colspan="2"><input type="text" name="bank_name" id="bank_name" value="'+ response.bank_name +'" class="form-control" /></td>'
                        + '<td>'
                        + '<button type="button" class="btn btn-purple btn-sm btn-flat updateBankName" id="'+ response.bank_name_id +'" style="margin: 5px 0;"><i class="fa fa-edit" aria-hidden="true"> Save</i></button>'
                        + '<button type="button" class="btn btn-tomato btn-sm btn-flat cancelUpdateBankName" id="'+ response.bank_name_id +'" style="margin: 5px 0;"><i class="fa fa-times" aria-hidden="true"> Cancel</i></button>'
                        + '</td>'
                    );
                },
                statusCode:{ 404: function(){ alert( "page not found" ); } },
                beforeSend: function( xhr ) { $(".ajax-loader").show(); },
                complete: function( jqXHR, textStatus ) { $(".ajax-loader").hide(); },
            });
        });


        $("body").on("click", "button.updateBankName", function(){
            var id = $(this).attr('id');
            var bank_name = $(this).closest('tr').find('#bank_name').val();
            var token = $('meta[name="csrf-token"]').attr('content');

            if (!confirm("Are you sure want to update this record?")) return;

            $.ajaxSetup({
                headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') }
            });

            $.ajax({
                type: "POST",
                url: "{{ url('bank/update-bank-name') }}",
                data: { id: id, bank_name: bank_name, _token: token },
                success: function (data) {
                    $("#bank_name_table tr#cat-" + data[0].bank_name_id).html(
                        '<td>'+ data[0].bank_name_id +'</td>'
                        + '<td>'+ data[0].bank_name +'</td>'
                        + '<td>'
                        + '<button type="button" class="btn btn-warning btn-sm editBankName" id="'+ data[0].bank_name_id +'" data-url="{{ url('bank/edit-bank-name') }}/'+ data[0].bank_name_id +'" style="margin: 5px 3px;"><i class="fa fa-edit" aria-hidden="true"> Edit</i></button>'
                        + '<button type="button" class="ajaxDelete btn btn-danger btn-sm" data-href="{{ URL::to('/bank/delete-bank-name/') }}'+ data[0].bank_name_id +'" data-title="'+ data[0].bank_editBankName +'" id="'+ data[0].bank_name_id +'" style="margin: 5px 0;"><i class="far fa-trash-alt" aria-hidden="true"> Delete</i></button>'
                        + '</td>'
                    );
                },
                error: function (xhr, textStatus, errorThrown) { alert(errorThrown); }
            });

        });

        $("body").on("click", "button.cancelUpdateBankName", function(){
            var id = $(this).attr('id');

            $.ajaxSetup({
                headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') }
            });

            $.ajax({
                type: "get",
                url: "{{ url('bank/cancel-update-bank-name') }}",
                data: { id: id },
                success: function (data) {
                    $("#bank_name_table tr#cat-" + data.bank_name_id).html(
                        '<td>'+ data.bank_name_id +'</td>'
                        + '<td>'+ data.bank_name +'</td>'
                        + '<td>'
                        + '<button type="button" class="btn btn-warning btn-sm editBankName" id="'+ data.bank_name_id +'" data-url="{{ url('bank/edit-bank-name') }}/'+ data.bank_name_id +'" style="margin: 5px 4px;"><i class="fa fa-edit" aria-hidden="true"> Edit</i></button>'
                        + '<button type="button" class="ajaxDelete btn btn-danger btn-sm" data-href="{{ URL::to('/bank/delete-bank-name/') }}'+ data.bank_name_id +'" data-title="'+ data.bank_editBankName +'" id="'+ data.bank_name_id +'" style="margin: 5px 0;"><i class="far fa-trash-alt" aria-hidden="true"> Delete</i></button>'
                        + '</td>'
                    );
                },
                error: function (xhr, textStatus, errorThrown) { alert(errorThrown); }
            });
        });
    }); //End of Document ready

    $(document).ready(function(){
        $(document).on('click', 'button.view-bank-account', function () {

            var url = $(this).data('url');
            var id = $(this).attr('id');
            var modal = $("#view_bank_account_modal");

            $.ajax({
                url: url,
                method: "get",
                //data: { id: id },
                dataType: "json",
                cache:false,
                async: false,
                success: function( data ) {
                    modal.find('.modal-title').text( "View Account ("+ data[0].account_name +")" );
                    modal.find('.account_name').text( data[0].account_name );
                    modal.find('.account_number').text( data[0].account_number );
                    modal.find('.bank_name_id').text( data.bank_name );
                    modal.find('.branch').text( data[0].branch );
                    modal.find('.bank_address').text( data[0].bank_address );
                    modal.find('.account_type').text( data[0].account_type );
                    modal.find('.swift_code').text( data[0].swift_code );
                    modal.find('.opening_date').text( data[0].opening_date.split('-')[2]+"/"+data[0].opening_date.split('-')[1]+"/"+data[0].opening_date.split('-')[0] );
                    modal.find('.opening_balance').text( takaFormat( data[0].opening_balance ) );
                    modal.find('.website').text( data[0].website );
                    modal.find('.email').text( data[0].email );
                    modal.find('.phone').text( data[0].phone );
                    modal.find('.alt_phone').text( data[0].alt_phone );
                    modal.find('.percent').text( data[0].percent );
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

