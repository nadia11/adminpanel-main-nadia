@extends('dashboard')
@section('main_content')

<section class="content">
    <div class="box box-success animated fadeInLeft">
        <div class="box-header with-border">
            <h2 class="box-title"><i class="fa fa-tags" aria-hidden="true"></i> Employee Loan List</h2>
            <div class="box-tools float-right">
                <button type="button" class="btn btn-info btn-sm showNewLoanModal" data-toggle="tooltip" data-placement="top" title="Add New Loan Modal"><i class="fa fa-plus"></i> New Loan</button>
                <button type="button" class="btn btn-box-tool" id="refresh" data-toggle="tooltip" data-placement="top" title="Refresh"><i class="fa fa-sync-alt"></i></button>
            </div><!-- /.box-tools -->
        </div><!-- /.box-header -->

        <div class="box-body table-responsive">
            <table id="general_datatable" class="table table-striped table-custom">
                <thead class="thead-inverse">
                    <tr>
                        <th>#</th>
                        <th>Loan Type</th>
                        <th>Employee Name</th>
                        <th>App. Date</th>
                        <th>Disburse Date</th>
                        <th>Total Installment</th>
                        <th>Paid Installment</th>
                        <th>Amount</th>
                        <th>Verification</th>
                        <th>Approval</th>
                        <th>Status</th>
                        <th data-orderable="false" class="no-print" style="width:50px;">Action</th>
                    </tr>
                </thead>
                <tbody>
                @foreach($all_loan_info as $loan)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $employee->loan_type }}</td>
                        <td><a href="{{ URL::to('/loan/' . $employee->employee_id) }}">{{ $employee->employee_name }}</a></td>
                        <td>@if($loan->application_date > 0) {{ date('d/m/Y', strtotime($loan->application_date)) }} @endif</td>
                        <td>@if($loan->disburse_date > 0) {{ date('d/m/Y', strtotime($loan->disburse_date)) }} @endif</td>
                        <td>{{ $employee->total_installment }}</td>
                        <td>{{ $employee->paid_installment }}</td>
                        <td>{{ $employee->paid_amount }}</td>
                        <td>
                            <b data-toggle="tooltip" data-placement="left" title="Verified Date">Date: </b>2018-04-18<br>
                            <b data-toggle="tooltip" data-placement="left" title="Verified By">By: </b>king<br>
                            <b data-toggle="tooltip" data-placement="left" title="Verified Amount">Amount: </b>2,000<br>
                            <b data-toggle="tooltip" data-placement="left" title="Verified Installment Amount">Installment Amount: </b>2,000<br>
                            <b data-toggle="tooltip" data-placement="left" title="Verified Total Installment">Total Installment: </b>1
                        </td>
                        <td>
                            <b data-toggle="tooltip" data-placement="left" title="Approved Date">Date: </b>2018-04-18<br>
                            <b data-toggle="tooltip" data-placement="left" title="Approved By">By: </b>king<br>
                            <b data-toggle="tooltip" data-placement="left" title="Approved Amount">Amount: </b>2,000<br>
                            <b data-toggle="tooltip" data-placement="left" title="Approved Installment Amount">Installment Amount: </b>2,000<br>
                            <b data-toggle="tooltip" data-placement="left" title="Approved Total Installment">Total Installment: </b>1
                        </td>
                        <td>{{ $employee->status }}</td>
                        <td>
                            <button type="button" class="btn btn-warning btn-sm editLoan" id="{{ $loan->loan_id }}" data-url="{{ url('/loan/edit-loan/' .  $loan->loan_id) }}"><i class="fa fa-edit" aria-hidden="true"></i></button>
                            <button type="button" class="ajaxDelete btn btn-danger btn-sm" data-href="{{ URL::to('/loan/delete-loan/' . $loan->loan_id) }}" data-title="{{ $loan->loan_name }}" id="{{ $loan->loan_id }}" data-toggle="tooltip" data-placement="top" title="Delete this Loan"><i class="far fa-trash-alt" aria-hidden="true"></i></button>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
                <tfoot class="total_row">
                    <tr>
                        <th colspan="6">Total </th>
                        <th><?php //echo taka_format('', $total_value->qty ); ?></th>
                        <th><?php //echo taka_format('', $total_value->total_amount ); ?></th>
                        <th></th>
                    </tr>
                </tfoot>
            </table>
        </div><!-- /.box-body -->

        <div class="overlay" style="display: none;">
            <i class="fa fa-sync-alt fa-spin"></i>
        </div>
    </div><!-- /.box -->
</section>

@include('pages.employees.loan-new-modal')
@include('pages.employees.loan-edit-modal')

@endsection


@section('custom_js')
<script type="text/javascript">
$(document).ready(function(){
    $('button.showNewLoanModal').on('click', function () {
        var modal = $("#newLoanModal");
        modal.modal({ backdrop: "static", keyboard: true });
        modal.on('shown.bs.modal', function(){ $(":input[type='text']:enabled:visible:first").focus(); });
    });

    $(document).on('click', 'button.editLoan', function () {

        var url = $(this).data('url');
        var id = $(this).attr('id');
        var modal = $("#editLoanModal");

        $.ajax({
            url: url,
            method: "get",
            //data: { id: id },
            dataType: "json",
            success: function( response ) {
                modal.find('.modal-title').text( "Update Loan" );
                modal.find('input[name=loan_id]').val( response.loan_id );
                modal.find('#loan_opening_date').val( response.loan_opening_date.split('-')[2]+"/"+response.loan_opening_date.split('-')[1]+"/"+response.loan_opening_date.split('-')[0] );
                modal.find('select#loan_type option[value="' + response.loan_type +'"]').prop("selected", true);
                modal.find('#loan_name').val( response.loan_name );
                modal.find('#loan_uom').val( response.loan_uom );
                modal.find('#loan_qty').val( response.loan_qty );
                modal.find('#loan_rate').val( response.loan_rate );
                modal.find('#loan_total_amount').val( response.loan_total_amount );
                modal.find('#loan_description').val( response.loan_description );

                modal.modal({ backdrop: "static", keyboard: true });
                modal.on('shown.bs.modal', function(){ $(":input[type='text']:enabled:visible:first").focus(); });
            },
            beforeSend: function( xhr ) { $(".ajax-loader").show(); },
            complete: function( jqXHR, textStatus ) { $(".ajax-loader").hide(); },
        });
    });



    $(document).on('change', 'select#employee_id', function () {
        var employee_id = $(this).find('option:selected').val();
        if(!employee_id) return;

        $.ajax({
            url : "{{ url('/loan/get-employee-data') }}",
            type : "GET",
            dataType : "json",
            data: {employee_id: employee_id },
            success:function( data ){
                $("#designation_name").val( data.designation_name );
                $("#employee_mobile").val( data[0].employee_mobile );
                $("#employee_gender").val( data[0].employee_gender );
                $("#cardID").val( data[0].cardID );
                $("#department_name").val( data.department_name );
                if( data[0].joining_date ){ $("#joining_date").val( data[0].joining_date.split('-')[2]+"/"+data[0].joining_date.split('-')[1]+"/"+data[0].joining_date.split('-')[0] ); }
            },
            beforeSend: function( xhr ) { $(".ajax-loader").show('slow'); },
            complete: function( jqXHR, textStatus ) { $(".ajax-loader").hide('fast'); },
        });
    });
}); //End of Document ready

</script>
@endsection

