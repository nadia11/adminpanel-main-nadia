@extends('dashboard')
@section('main_content')

<section class="content">
    <div class="box box-success animated fadeInLeft">
        <div class="box-header with-border">
            <h2 class="box-title"><i class="fa fa-file-alt" aria-hidden="true"></i> Showing All Vehicle Types</h2>
            <div class="box-tools float-right">
                <button type="button" class="btn btn-info btn-sm" data-toggle="modal" data-target="#vehicleTypeModal">Vehicle Type</button>
                <button type="button" class="btn btn-box-tool" id="refresh" data-toggle="tooltip" data-placement="top" title="Refresh"><i class="fa fa-sync-alt"></i></button>
            </div><!-- /.box-tools -->
        </div><!-- /.box-header -->

        <div class="box-body table-responsive">
            <table id="general_datatable" class="table table-custom">
                <thead class="thead-light">
                <tr>
                    <th>#</th>
                    <th>Vehicle Type</th>
                    <th>Seat Capacity</th>
                    <th>Color</th>
                    <th data-orderable="false">Vehicle Photo</th>
                    <th>Assigned Vehicle Qty.</th>
                    <th data-orderable="false" class="no-print" style="width:100px;">Action</th>
                </tr>
                </thead>
                <tbody>
                <?php $all_vehicle_types = DB::table('vehicle_types')->get(); ?>

                @foreach($all_vehicle_types as $vehicle_type)
                    <tr id="cat-{{ $vehicle_type->vehicle_type_id }}">
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ str_snack($vehicle_type->vehicle_type) }}</td>
                        <td>{{ $vehicle_type->seat_capacity }} Persons</td>
                        <td style="font-weight: bold;color: {{ strtolower($vehicle_type->vehicle_color) }}">{{ str_snack($vehicle_type->vehicle_color) ?: "-" }}</td>
                        <td><img src="<?php if(!empty($vehicle_type->vehicle_photo)){ echo upload_url( "vehicle-photo/". $vehicle_type->vehicle_photo ); }else{ echo image_url('defaultAvatar.jpg'); } ?>" style="width: 40px;" /></td>
                        <td><a href="{{ URL::to('/vehicle/vehicle-management?vehicle_type=' .$vehicle_type->vehicle_type) }}" target="_blank">{{ DB::table('vehicles')->where('vehicle_type_id', $vehicle_type->vehicle_type_id)->count() }} Vehicles</a></td>
                        <td>
                            <div class="btn-group" role="group">
                                <button type="button" class="btn btn-warning btn-sm btn-flat editVehicleType " id="{{ $vehicle_type->vehicle_type_id }}" style="margin: 5px 0;"><i class="fa fa-edit" aria-hidden="true"> Edit</i></button>
                                {{--<button type="button" class="btn btn-danger btn-sm btn-flat ajaxDelete" data-href="{{ URL::to('/vehicle-type/delete-vehicle-type/' . $vehicle_type->vehicle_type_id) }}" data-title="{{ $vehicle_type->vehicle_type }}" id="{{ $vehicle_type->vehicle_type_id }}" style="margin: 5px 0;"><i class="far fa-trash-alt" aria-hidden="true"> Delete</i></button>--}}
                            </div>
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

@include('pages.vehicles.vehicle-type-new-modal')
@include('pages.vehicles.vehicle-type-edit-modal')
{{--include('pages.vehicles.vehicle-type-view-modal')--}}

@endsection



@section('custom_js')
<script type="text/javascript">
    $(document).ready(function(){
        $(document).on('click', 'button.editVehicleType', function () {

            var id = $(this).attr('id');
            var modal = $("#editVehicleTypeModal");

            $.ajax({
                url: "{{ url('/vehicle-type/edit-vehicle-type') }}/"+id,
                method: "get",
                dataType: "json",
                success: function( response ) {
                    modal.find('.modal-title').text( "Update Vehicle Type" );
                    modal.find('input[name=vehicle_type_id]').val( response[0].vehicle_type_id );
                    modal.find('#vehicle_type').val( response[0].vehicle_type );
                    modal.find('#note').val( response[0].note );
                    modal.find("select#seat_capacity option[value="+ response[0].seat_capacity +"]").prop("selected", true);
                    modal.find("select#vehicle_color option[value="+ response[0].vehicle_color +"]").prop("selected", true);

                    modal.find('#vehicle_photo_prev').val( response[0].vehicle_photo );
                    modal.find('#vehicle_photo').parent('.custom-file').find('label.custom-file-label').html( response[0].vehicle_photo ? response[0].vehicle_photo : "No Attachment"  );
                    if(response[0].vehicle_photo){ modal.find('#vehicle_photo').removeAttr('required'); }

                    modal.modal({ backdrop: "static", keyboard: true });
                    modal.on('shown.bs.modal', function(){ $(":input[type='text']:enabled:visible:first").focus(); });
                },
                beforeSend: function( xhr ) { $(".ajax-loader").show(); },
                complete: function( jqXHR, textStatus ) { $(".ajax-loader").hide(); },
            });
        });

        $(document).on('click', 'button.view-vehicle-type', function () {
            var id = $(this).attr('id');
            var modal = $("#view_vehicle_type_modal");

            $.ajax({
                url: "{{ url('/vehicle-type/view-vehicle-type') }}/" + id,
                method: "get",
                dataType: "json",
                cache:false,
                async: false,
                success: function( response ) {
                    modal.find('.modal-title').text( "View Details of Vehicle Type ("+ response[0].vehicle_type +")" );
                    modal.find('.vehicle-type_name').text( response[0].vehicle_type );
                    modal.find('.mobile').html('<a href="tel:'+response[0].mobile+'">'+response[0].mobile+'</a>');
                    modal.find('.email').html('<a href="mailto:'+response[0].email+'">'+response[0].email+'</a>');
                    modal.find('.division_name').text( response.division_name );
                    modal.find('.district_name').text( response.district_name );
                    modal.find('.branch_name').text( response['branch'].branch_name );
                    modal.find('.branch_address').text( response[0].branch_address );

                    modal.find('.note').text( response[0].note );
                    modal.modal("show");
                },
                beforeSend: function( xhr ) { $(".ajax-loader").show('slow'); },
                complete: function( jqXHR, textStatus ) { $(".ajax-loader").hide('fast'); },
            });
        });
    }); //End of Document ready
</script>
@endsection

