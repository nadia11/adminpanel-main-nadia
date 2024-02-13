@extends('dashboard')
@section('main_content')

<section class="content">
    <div class="box box-success animated fadeInLeft">
        <div class="box-header with-border">
            <h2 class="box-title"><i class="fa fa-file-alt" aria-hidden="true"></i> Showing Agent Commissions</h2>
            <div class="box-tools float-right">
                <div class="float-left" style="margin-right: 5px; width: 125px;">
                    <select id="payment_status_filter" class="custom-select custom-select-sm" onchange="filter_column_exact_value(this.value, 'general_datatable', 4)">
                        <option value="">--Payment Status--</option>
                        <option value="paid">Paid</option>
                        <option value="unpaid">Unpaid</option>
                        <option value="pending">Pending</option>
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
                        <th>Trip Number</th>
                        <th>Date Time</th>
                        <th>Distance</th>
                        <th>Payment Status</th>
                        <th>Driver</th>
                        <th>Vehicle</th>
                        <th>Total Fare</th>
                        <th>Commission Percent</th>
                        <th>Commission</th>
                        {{--<th data-orderable="false" class="no-print">Action</th>--}}
                    </tr>
                </thead>
                <tbody>
                @foreach($all_commission_info as $commission)
                    @php $status_class = array('pending'=>'btn-warning', 'unpaid'=>"btn-danger", 'paid'=>'btn-success') @endphp
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td><a href="{{ url('driver/trip/driver-trips?trip_number='.$commission->trip_number)}}" target="_blank" data-toggle="tooltip" data-placement="top" title="Go to see Trip details">{{ $commission->trip_number }}</a></td>
                        <td>{{ date('d/m/Y h:m:s', strtotime($commission->created_at)) }}</td>
                        <td>{{ $commission->distance }}</td>
                        <td><button type="button" class="btn {{ $status_class[$commission->payment_status] }} btn-sm payment-status" data-status="{{ $commission->payment_status }}" id="{{ $commission->commission_id }}" data-href="{{ URL::to('payment-status/'. $commission->commission_id) }}">{{ str_snack($commission->payment_status) }}</button></td>
                        <td><a href="{{ url('driver/all-drivers?driver_mobile='.$commission->mobile)}}" target="_blank" data-toggle="tooltip" data-placement="top" title="Go to see Driver's details">{{ $commission->driver_name }}</a></td>
                        <td><a href="{{ url('vehicle/vehicle-management?vehicle_reg_number='.$commission->vehicle_reg_number)}}" target="_blank" data-toggle="tooltip" data-placement="top" title="Go to see Vehicle's details">{{ $commission->vehicle_reg_number }}</a></td>
                        <td>{{ taka_format('', $commission->total_fare ) }}</td>
                        <td>{{ $commission->commission_percent."%"}}</td>
                        <td>{{ taka_format('', $commission->commission ) }}</td>
                        {{--<td style="white-space: nowrap; width:60px;">--}}
                        {{--<button type="button" class="btn btn-info btn-sm view-commission" id="{{ $commission->commission_id }}"><i class="fa fa-eye" aria-hidden="true"></i> View</button>--}}
                            {{--<button type="button" class="btn btn-warning btn-sm editEarning" id="{{ $commission->commission_id }}"><i class="fa fa-edit" aria-hidden="true"></i></button>--}}
                            {{--<button type="button" class="ajaxDelete btn btn-danger btn-sm" data-href="{{ URL::to('/commission/delete-commission/' . $commission->commission_id) }}" data-title="{{ $commission->commission_number }} - {{ $commission->project_name }}" id="{{ $commission->commission_id }}"><i class="far fa-trash-alt" aria-hidden="true"></i></button>--}}
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

{{--include('pages.commissions.commission-edit-modal')--}}
{{--include('pages.drivers.commission-view-modal')--}}
@include('pages.drivers.driver-payment-status-modal')

@endsection


@section('custom_js')
<script type="text/javascript">
$(document).ready(function(){
    $(document).on('click', 'button.view-commission', function () {
        var id = $(this).attr('id');
        var modal = $("#view_commission_modal");

        $.ajax({
            url: "{{ url('/commission/view-commission') }}/" + id,
            method: "get",
            dataType: "json",
            success: function( response ) {
                modal.find('.modal-title').text( "View Details of Earning Name: " + response[0].commission_name );
                modal.find('.commission_name').text( response.commission_name );
                modal.find('.mobile').find('var').text( response[0].mobile );
                {{--modal.find('.commission_number').find('.attachment-btn a').attr("href", "{{ url('storage/client-commission') }}/"+ response[0].commission_photo).addClass( response[0].commission_photo ? "btn-info" : "disabled btn-outline-info");--}}
                modal.find('.date_of_birth').text( response[0].date_of_birth ? (response[0].date_of_birth.split('-')[2]+"/"+response[0].date_of_birth.split('-')[1]+"/"+response[0].date_of_birth.split('-')[0]) : "-" );
                modal.find('.email').text( response[0].email );
                modal.find('.blood_group').text( response[0].blood_group );
                modal.find('.gender').text( response[0].gender );
                modal.find('.nationality').text( response[0].nationality );
                modal.find('.national_id').text( response[0].national_id );
                modal.find('.driving_licence').text( response[0].driving_licence );
                modal.find('.payment_status').text( response[0].payment_status );
                modal.find('.trip_count').text( response[0].trip_count );
                modal.find('.wallet_balance').text( response[0].wallet_balance );
                modal.find('.division_id').text( response[0].division_id );
                modal.find('.district_id').text( response[0].district_id );
                modal.find('.branch_id').text( response[0].branch_id );
                modal.find('.address').text( response[0].address );
                modal.find('.referral_name').text( response[0].referral_name );
                modal.find('.referral_mobile').text( response[0].referral_mobile );
                modal.find('.reg_date').text( response[0].reg_date.split('-')[2]+"/"+response[0].reg_date.split('-')[1]+"/"+response[0].reg_date.split('-')[0] );
                modal.find('.latitude').text( response[0].latitude );
                modal.find('.longitude').text( response[0].longitude );
                modal.find('.note').text( response[0].note );
                modal.modal("show");
            },
            beforeSend: function( xhr ) { $(".ajax-loader").show('slow'); },
            complete: function( jqXHR, textStatus ) { $(".ajax-loader").hide('fast'); },
        });
    });


    $(document).on('click', 'button.payment-status', function (e) {
        e.preventDefault();
        var modal = $("#payment_status_modal");

        modal.find("select#payment_status option[value="+ $(this).data('status') +"]").prop("selected", true);
        modal.find('input[name=commission_id]').val( $(this).attr('id') );
        modal.modal('show');
    });

    function capitalizeFirstLetter(string) {
        return string.charAt(0).toUpperCase() + string.slice(1);
    }

    $("form#changePaymentStatus").submit(function (event) {
        event.preventDefault();
        $("button[type=submit]").attr('disabled', 'disabled').html("<i class='fa fa-floppy-disk'></i> Saving...");

        var form = $(this);
        var payment_status = form.find('select#payment_status').val();
        var commission_id = form.find('input[name=commission_id]').val();
        var url = form.attr("action");
        var status_class_array = { 'paid':'btn-success', 'unpaid':"btn-danger" };

        $.ajaxSetup({
            headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') }
        });

        $.ajax({
            type: "POST",
            url: url,
            data: {commission_id: commission_id, payment_status: payment_status},
            dataType: 'json',
            success: function (response) {
                $("button#"+commission_id+".payment-status").text( capitalizeFirstLetter(response.payment_status.replace('_', ' ').replace('_', ' ')) );
                $("button#"+commission_id+".payment-status").attr('data-status', response.payment_status.replace('_', ' ').replace('_', ' ') );
                $("button#"+commission_id+".payment-status").removeAttr('class').attr('class', 'btn btn-sm commission-status '+ status_class_array[response.payment_status]);

                toastr.success( response.success );
                $('#payment_status_modal').modal('hide');
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

