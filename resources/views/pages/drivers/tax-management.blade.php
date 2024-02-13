@extends('dashboard')
@section('main_content')

<section class="content">
    <div class="box box-success animated fadeInLeft">
        <div class="box-header with-border">
            <h2 class="box-title"><i class="fa fa-file-alt" aria-hidden="true"></i> Showing All Tax</h2>
            <div class="box-tools float-right">
                <div class="float-left" style="margin-right: 5px; width: 125px;">
                    <select id="tax_status_filter" class="custom-select custom-select-sm" onchange="filter_column_serverside(this.value, 'member_datatable')">
                        <option value="">--Tax Status--</option>
                        <option value="pending">Pending</option>
                        <option value="paid">Paid</option>
                        <option value="unpaid">Unpaid</option>
                    </select>
                </div>
                <button type="button" class="btn btn-box-tool" id="refresh" data-toggle="tooltip" data-placement="top" title="Refresh"><i class="fa fa-sync-alt"></i></button>
            </div><!-- /.box-tools -->
        </div><!-- /.box-header -->

        <div class="box-body">
            <table id="general_datatable" class="table table-custom table-center">
                <thead class="thead-inverse">
                    <tr>
                        <th>#</th>
                        <th>Year</th>
                        <th>Payment Date</th>
                        <th>Days Left</th>
                        <th>Tax Type</th>
                        <th>Status</th>
                        <th>Amount</th>
                        <th>Driver</th>
                        <th>Vehicle Reg. Number</th>
                        {{--<th data-orderable="false" class="no-print">Action</th>--}}
                    </tr>
                </thead>
                <tbody>
                @foreach($all_tax_info as $tax)
                    @php $status_class = array('pending'=>'btn-warning', 'unpaid'=>"btn-danger", 'paid'=>'btn-success') @endphp
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $tax->year }}</td>
                        <td>{{ date('d/m/Y', strtotime($tax->payment_date)) }}</td>
                        <td>--</td>
                        <td>{{ $tax->tax_type }}</td>
                        <td><button type="button" class="btn {{ $status_class[$tax->tax_status] }} btn-sm tax-status" data-status="{{ $tax->tax_status }}" id="{{ $tax->tax_id }}" data-href="{{ URL::to('tax-status/'. $tax->tax_id) }}">{{ str_snack($tax->tax_status) }}</button></td>
                        <td>{{ $tax->payment_amount }}</td>
                        <td><a href="{{ url('driver/all-drivers?driver_mobile='.$tax->mobile)}}" target="_blank" data-toggle="tooltip" data-placement="top" title="Go to see Driver's details">{{ $tax->driver_name }}</a></td>
                        <td><a href="{{ url('vehicle/vehicle-management?vehicle_reg_number='.$tax->vehicle_reg_number)}}" target="_blank" data-toggle="tooltip" data-placement="top" title="Go to see Driver's details">{{ $tax->vehicle_reg_number }}</a></td>
                        {{--<td style="white-space: nowrap; width:60px;">--}}
                        {{--<button type="button" class="btn btn-info btn-sm view-tax" id="{{ $tax->tax_id }}"><i class="fa fa-eye" aria-hidden="true"></i> View</button>--}}
                        {{--<button type="button" class="btn btn-warning btn-sm editTax" id="{{ $tax->tax_id }}"><i class="fa fa-edit" aria-hidden="true"></i></button>--}}
                        {{--<button type="button" class="ajaxDelete btn btn-danger btn-sm" data-href="{{ URL::to('/tax/delete-tax/' . $tax->tax_id) }}" data-title="{{ $tax->tax_number }} - {{ $tax->project_name }}" id="{{ $tax->tax_id }}"><i class="far fa-trash-alt" aria-hidden="true"></i></button>--}}
                        {{--</td>--}}
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

{{--include('pages.drivers.tax-edit-modal')--}}
{{--include('pages.drivers.tax-view-modal')--}}
{{--include('pages.drivers.tax-status-modal')--}}

@endsection


@section('custom_js')
<script type="text/javascript">
$(document).ready(function(){
    $(document).on('click', 'button.view-tax', function () {
        var id = $(this).attr('id');
        var modal = $("#view_tax_modal");

        $.ajax({
            url: "{{ url('/tax/view-tax') }}/" + id,
            method: "get",
            dataType: "json",
            success: function( response ) {
                modal.find('.modal-title').text( "View Details of Tax Name: " + response[0].tax_name );
                modal.find('.tax_name').text( response.tax_name );
                modal.find('.mobile').find('var').text( response[0].mobile );
                {{--modal.find('.tax_number').find('.attachment-btn a').attr("href", "{{ url('storage/client-tax') }}/"+ response[0].tax_photo).addClass( response[0].tax_photo ? "btn-info" : "disabled btn-outline-info");--}}
                modal.find('.date_of_birth').text( response[0].date_of_birth ? (response[0].date_of_birth.split('-')[2]+"/"+response[0].date_of_birth.split('-')[1]+"/"+response[0].date_of_birth.split('-')[0]) : "-" );
                modal.find('.email').text( response[0].email );
                modal.find('.blood_group').text( response[0].blood_group );
                modal.find('.gender').text( response[0].gender );
                modal.find('.nationality').text( response[0].nationality );
                modal.find('.national_id').text( response[0].national_id );
                modal.find('.driving_licence').text( response[0].driving_licence );
                modal.find('.tax_status').text( response[0].tax_status );
                modal.find('.trip_count').text( response[0].trip_count );
                modal.find('.wallet_balance').text( response[0].wallet_balance );
                modal.find('.division_id').text( response[0].division_id );
                modal.find('.district_id').text( response[0].district_id );
                modal.find('.branch_id').text( response[0].branch_id );
                modal.find('.address').text( response[0].address );
                modal.find('.referral_name').text( response[0].referral_name );
                modal.find('.referral_mobile').text( response[0].referral_mobile );
                modal.find('.reg_date').text( response[0].reg_date.split('-')[2]+"/"+response[0].reg_date.split('-')[1]+"/"+response[0].reg_date.split('-')[0] );
                {{--if( response['employee_data'] ){ modal.find('.employee_name').html( '<a href="<?php echo URL::to( 'employee/view' ); ?>/' + response['employee_data'].employee_id +'">'+ response['employee_data'].employee_name +'</a>' ); }--}}
                modal.find('.latitude').text( response[0].latitude );
                modal.find('.longitude').text( response[0].longitude );
                modal.find('.note').text( response[0].note );
                modal.modal("show");
            },
            beforeSend: function( xhr ) { $(".ajax-loader").show('slow'); },
            complete: function( jqXHR, textStatus ) { $(".ajax-loader").hide('fast'); },
        });
    });


    $(document).on('click', 'button.tax-status', function (e) {
        e.preventDefault();
        var modal = $("#tax_status_modal");

        modal.find("select#tax_status option[value="+ $(this).data('status') +"]").prop("selected", true);
        modal.find('input[name=tax_id]').val( $(this).attr('id') );
        modal.modal('show');
    });

    function capitalizeFirstLetter(string) {
        return string.charAt(0).toUpperCase() + string.slice(1);
    }

    $("form#changeTaxStatus").submit(function (event) {
        event.preventDefault();
        $("button[type=submit]").attr('disabled', 'disabled').html("<i class='fa fa-floppy-disk'></i> Saving...");

        var form = $(this);
        var tax_status = form.find('select#tax_status').val();
        var tax_id = form.find('input[name=tax_id]').val();
        var url = form.attr("action");
        var status_class_array = { 'pending':'btn-warning', 'banned':"btn-danger", 'suspend':"btn-outline-danger", 'leave':'btn-primary', 'available':'btn-info', 'on_trip':'btn-success' };

        $.ajaxSetup({
            headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') }
        });

        $.ajax({
            type: "POST",
            url: url,
            data: {tax_id: tax_id, tax_status: tax_status},
            dataType: 'json',
            success: function (response) {
                $("button#"+tax_id+".tax-status").text( capitalizeFirstLetter(response.tax_status.replace('_', ' ').replace('_', ' ')) );
                $("button#"+tax_id+".tax-status").attr('data-status', response.tax_status.replace('_', ' ').replace('_', ' ') );
                $("button#"+tax_id+".tax-status").removeAttr('class').attr('class', 'btn btn-sm tax-status '+ status_class_array[response.tax_status]);

                toastr.success( response.success );
                $('#tax_status_modal').modal('hide');
                $("button[type=submit]").removeAttr('disabled').html("<i class='fa fa-save'></i> Change Status");
            },
            statusCode:{ 404: function(){ alert( "page not found" ); } },
            error: function (xhr, textStatus, errorThrown) { alert(errorThrown); },
            beforeSend: function( xhr ) { $(".ajax-loader").show('slow'); },
            complete: function( jqXHR, textStatus ) { $(".ajax-loader").hide('fast'); },
        });
        return false;
    });
}); //End of Document ready
</script>
@endsection

