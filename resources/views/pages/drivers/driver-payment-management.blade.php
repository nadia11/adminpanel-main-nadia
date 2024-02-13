@extends('dashboard')
@section('main_content')

<section class="content">
    <div class="box box-success animated fadeInLeft">
        <div class="box-header with-border">
            <h2 class="box-title"><i class="fa fa-file-alt" aria-hidden="true"></i> Showing All Driver Payments</h2>
            <div class="box-tools float-right">
                <div class="float-left" style="margin-right: 5px; width: 125px;">
                    <select id="driver_status_filter" class="custom-select custom-select-sm" onchange="filter_column_serverside(this.value, 'member_datatable')">
                        <option value="">--Payments Status--</option>
                        <option value="pending">Pending</option>
                        <option value="paid">Paid</option>
                        <option value="unpaid">unpaid</option>
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
                        <th>Transaction ID</th>
                        <th>Driver Name</th>
                        <th>Payment Date</th>
                        <th>Payment Amount</th>
                        <th>Status</th>
                        <th>Commission</th>
                        <th data-orderable="false" class="no-print">Action</th>
                    </tr>
                </thead>
                <tbody>
                @php $status_class = array('pending'=>'btn-warning', 'unpaid'=>"btn-danger", 'paid'=>'btn-success') @endphp
                @foreach($all_driver_info as $driver)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $driver->trx_id }}</td>
                        <td>{{ $driver->driver_id }}</td>
                        <td>{{ date('d/m/Y', strtotime($trip->payment_date)) }}</td>
                        <td>{{ taka_format('', $driver->payment_amount ) }}</td>
                        <td class="{{ $status_class[$driver->payment_status] }} text-bold">{{ str_snack($driver->payment_status) }}</td>
                        <td>{{ $driver->commission ?: "-" }}</td>
                        <td style="white-space: nowrap; width:60px;">
                            <button type="button" class="btn btn-info btn-sm view-driver" id="{{ $driver->driver_id }}"><i class="fa fa-eye" aria-hidden="true"></i> View</button>
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

{{--include('pages.drivers.driver-edit-modal')--}}
{{--include('pages.drivers.driver-view-modal')--}}
@include('pages.drivers.driver-status-modal')

@endsection


@section('custom_js')
<script type="text/javascript">
$(document).ready(function(){
    $(document).on('click', 'button.view-driver', function () {
        var id = $(this).attr('id');
        var modal = $("#view_driver_modal");

        $.ajax({
            url: "{{ url('/driver/view-driver') }}/" + id,
            method: "get",
            dataType: "json",
            success: function( response ) {
                modal.find('.modal-title').text( "View Details of Driver Name: " + response[0].driver_name );
                modal.find('.driver_name').text( response.driver_name );
                modal.find('.mobile').find('var').text( response[0].mobile );
                {{--modal.find('.driver_number').find('.attachment-btn a').attr("href", "{{ url('storage/client-driver') }}/"+ response[0].driver_photo).addClass( response[0].driver_photo ? "btn-info" : "disabled btn-outline-info");--}}
                modal.find('.date_of_birth').text( response[0].date_of_birth ? (response[0].date_of_birth.split('-')[2]+"/"+response[0].date_of_birth.split('-')[1]+"/"+response[0].date_of_birth.split('-')[0]) : "-" );
                modal.find('.email').text( response[0].email );
                modal.find('.blood_group').text( response[0].blood_group );
                modal.find('.gender').text( response[0].gender );
                modal.find('.nationality').text( response[0].nationality );
                modal.find('.national_id').text( response[0].national_id );
                modal.find('.driving_licence').text( response[0].driving_licence );
                modal.find('.driver_status').text( response[0].driver_status );
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


    $(document).on('click', 'button.driver-status', function (e) {
        e.preventDefault();
        var modal = $("#driver_status_modal");

        modal.find("select#driver_status option[value="+ $(this).data('status') +"]").prop("selected", true);
        modal.find('input[name=driver_id]').val( $(this).attr('id') );
        modal.modal('show');
    });

    function capitalizeFirstLetter(string) {
        return string.charAt(0).toUpperCase() + string.slice(1);
    }

    $("form#changeDriverStatus").submit(function (event) {
        event.preventDefault();
        $("button[type=submit]").attr('disabled', 'disabled').html("<i class='fa fa-floppy-disk'></i> Saving...");

        var form = $(this);
        var driver_status = form.find('select#driver_status').val();
        var driver_id = form.find('input[name=driver_id]').val();
        var url = form.attr("action");
        var status_class_array = { 'pending':'btn-warning', 'banned':"btn-danger", 'suspend':"btn-outline-danger", 'leave':'btn-primary', 'available':'btn-info', 'on_trip':'btn-success' };

        $.ajaxSetup({
            headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') }
        });

        $.ajax({
            type: "POST",
            url: url,
            data: {driver_id: driver_id, driver_status: driver_status},
            dataType: 'json',
            success: function (response) {
                $("button#"+driver_id+".driver-status").text( capitalizeFirstLetter(response.driver_status.replace('_', ' ').replace('_', ' ')) );
                $("button#"+driver_id+".driver-status").attr('data-status', response.driver_status.replace('_', ' ').replace('_', ' ') );
                $("button#"+driver_id+".driver-status").removeAttr('class').attr('class', 'btn btn-sm driver-status '+ status_class_array[response.driver_status]);

                toastr.success( response.success );
                $('#driver_status_modal').modal('hide');
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

