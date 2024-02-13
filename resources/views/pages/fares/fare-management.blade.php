@extends('dashboard')
@section('main_content')

<section class="content">
    <div class="box box-success animated fadeInLeft">
        <div class="box-header with-border">
            <h2 class="box-title"><i class="fa fa-file-alt" aria-hidden="true"></i> Showing All Fare</h2>
            <div class="box-tools float-right">
                <button type="button" class="btn btn-info btn-sm" data-toggle="modal" data-target="#showNewFareModal"><i class="fa fa-plus"></i> New Fare</button>
                <button type="button" class="btn btn-box-tool" id="refresh" data-toggle="tooltip" data-placement="top" title="Refresh"><i class="fa fa-sync-alt"></i></button>
            </div><!-- /.box-tools -->
        </div><!-- /.box-header -->

        <div class="box-body table-responsive">
            <table id="general_datatable" class="table table-custom">
                <thead class="thead-inverse">
                    <tr>
                        <th>#</th>
                        <th>Vehicle Type</th>
                        <th>Period Type</th>
                        <th>Time</th>
                        <th>Fare Per KM</th>
                        <th>Waiting Fare</th>
                        <th>Min Fare</th>
                        <th>Min Distance</th>
                        <th>Dest. Change Fee</th>
                        <th>Delay Can. Time</th>
                        <th>Delay Can. Fee</th>
                        {{--<th style="width: 15%">Note</th>--}}
                        <th data-orderable="false" class="no-print" style="width:50px;">Action</th>
                    </tr>
                </thead>
                <tbody>
                @foreach($all_fare_info as $fare)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ ucwords($fare->vehicle_type) }}</td>
                        <td>{{ str_snack($fare->period_type) }}</td>
                        <td>{{ $fare->start_time  }} - {{ $fare->end_time  }}</td>
                        <td>{{ taka_format("", $fare->fare_per_km) }}</td>
                        <td>{{ taka_format("", $fare->waiting_fare) }}</td>
                        <td>{{ taka_format("", $fare->minimum_fare) }}</td>
                        <td>{{ $fare->minimum_distance }} KM</td>
                        <td>{{ taka_format("", $fare->destination_change_fee) }}</td>
                        <td>{{ $fare->delay_cancellation_minute }}</td>
                        <td>{{ taka_format("", $fare->delay_cancellation_fee) }}</td>
                        {{--<td>{{ $fare->note ?? "-" }}</td>--}}
                        <td style="white-space: nowrap;">
                            <button type="button" class="btn btn-warning btn-sm editFare" id="{{ $fare->fare_id }}"><i class="fa fa-edit" aria-hidden="true"></i></button>
                            <button type="button" class="ajaxDelete btn btn-danger btn-sm" data-href="{{ URL::to('/fare/delete-fare/' . $fare->fare_id) }}" data-title="{{ $fare->fare_per_km }}" id="{{ $fare->fare_id }}"><i class="far fa-trash-alt" aria-hidden="true"></i></button>
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

@include('pages.fares.fare-new-modal')
@include('pages.fares.fare-edit-modal')
@endsection


@section('custom_js')
<script type="text/javascript">
$(document).ready(function(){
    $(document).on('click', 'button.editFare', function () {
        var id = $(this).attr('id');
        var modal = $("#editFareModal");

        $.ajax({
            url: "{{ url('/fare/edit-fare') }}/"+id,
            method: "get",
            dataType: "json",
            success: function( response ) {
                modal.find('.modal-title').text( "Update Fare" );
                modal.find('input[name=fare_id]').val( response[0].fare_id );
                modal.find("select#vehicle_type_id option[value="+ response[0].vehicle_type_id +"]").prop("selected", true);
                modal.find("select#period_type option[value="+ response[0].period_type +"]").prop("selected", true);
                modal.find('#fare_per_km').val( response[0].fare_per_km );
                modal.find('#waiting_fare').val( response[0].waiting_fare );
                modal.find('#minimum_fare').val( response[0].minimum_fare );
                modal.find('#minimum_distance').val( response[0].minimum_distance );
                modal.find("select#start_time option:contains("+ response[0].start_time +")").attr('selected', 'selected');
                modal.find("select#end_time option:contains("+ response[0].end_time +")").attr('selected', 'selected');
                modal.find('#destination_change_fee').val( response[0].destination_change_fee );
                modal.find('#delay_cancellation_fee').val( response[0].delay_cancellation_fee );
                modal.find('#delay_cancellation_time').val( response[0].delay_cancellation_time );
                modal.find('#note').val( response[0].note );
                modal.modal("show");
            },
            beforeSend: function( xhr ) { $(".ajax-loader").show(); },
            complete: function( jqXHR, textStatus ) { $(".ajax-loader").hide(); },
        });
    });
}); //End of Document ready

</script>
@endsection

