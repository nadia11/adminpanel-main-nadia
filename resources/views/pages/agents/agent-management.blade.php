@extends('dashboard')
@section('main_content')

<section class="content">
    <div class="box box-success animated fadeInLeft">
        <div class="box-header with-border">
            <h2 class="box-title"><i class="fa fa-file-alt" aria-hidden="true"></i> Showing All Agent</h2>
            <div class="box-tools float-right">
                <button type="button" class="btn btn-info btn-sm" data-toggle="modal" data-target="#showNewAgentModal"><i class="fa fa-plus"></i> New Agent</button>
                <button type="button" class="btn btn-box-tool" id="refresh" data-toggle="tooltip" data-placement="top" title="Refresh"><i class="fa fa-sync-alt"></i></button>
            </div><!-- /.box-tools -->
        </div><!-- /.box-header -->

        <div class="box-body table-responsive">
            <table id="general_datatable" class="table table-custom">
                <thead class="thead-inverse">
                    <tr>
                        <th>#</th>
                        <th>Agent Name</th>
                        <th>Mobile</th>
                        <th class="hide">Division ID</th>
                        <th>District</th>
                        <th>Branch Name</th>
                        <th>Total Drivers</th>
                        <th>Driver's Earnings</th>
                        <th>Commission</th>
                        <th>Total Earnings</th>
                        <th>Status</th>
                        <th data-orderable="false">Photo</th>
                        <th data-orderable="false" class="no-print" style="width:60px;">Action</th>
                    </tr>
                </thead>
                <tbody>
                @php $status_class = array('active'=>'btn-success', 'pending'=>'btn-warning', 'banned'=>"btn-danger", 'suspend'=>"btn-outline-danger") @endphp
                @foreach($all_agent_info as $agent)
                <?php $driver_earnings = DB::table('driver_earnings')->leftJoin('drivers', 'driver_earnings.driver_id', '=', 'drivers.driver_id')->where('district_id', $agent->district_id)->SUM('total_earnings'); ?>
                <?php $agent_commission = '30'; ?>

                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $agent->agent_name }}</td>
                        <td>{{ $agent->mobile }}</td>
                        <td class="hide">{{ $agent->division_id ? $agent->division_id : "" }}</td>
                        <td>{{ $agent->district_name }}</td>
                        <td>{{ ucwords($agent->branch_name) }}</td>
                        <td>{{ DB::table('drivers')->where('district_id', $agent->district_id)->COUNT() }}</td>
                        <td><?php echo $driver_earnings ? taka_format('', $driver_earnings) : "0.00"; ?></td>
                        <td>{{ $agent_commission . "%" }}</td>
                        <td>{{ $driver_earnings ? taka_format('', $driver_earnings * $agent_commission /100) : "0.00" }}</td>
                        <td><button type="button" class="btn {{ $status_class[$agent->agent_status] }} btn-sm agent-status" data-status="{{ $agent->agent_status }}" id="{{ $agent->agent_id }}" data-href="{{ URL::to('agent-status/'. $agent->agent_id) }}">{{ str_snack($agent->agent_status) }}</button></td>
                        <td><img src="<?php if(!empty($agent->agent_photo)){ echo upload_url( "agents/". $agent->agent_photo ); } else { echo image_url('defaultAvatar.jpg'); } ?>" style="border-radius: 50%; width: 40px; height: 40px; border: 1px solid #eee; box-shadow: 0 0 3px rgba(0,0,0,.3); padding: 1px; margin: 0px;" /></td>
                        <td style="white-space: nowrap;">
                            <button type="button" class="btn btn-info btn-sm view-agent" id="{{ $agent->agent_id }}"><i class="fa fa-eye" aria-hidden="true"></i></button>
                            <button type="button" class="btn btn-warning btn-sm editAgent" id="{{ $agent->agent_id }}"><i class="fa fa-edit" aria-hidden="true"></i></button>
                            <a href="{{ url('map/view-in-map/agent?lat='. $agent->latitude ."&lng=".$agent->longitude) }}" class="btn btn-primary btn-sm viewInMap" id="{{ $agent->agent_id }}" target="_blank"><i class="fa fa-map-marker-alt" aria-hidden="true"></i></a>
                            <button type="button" class="ajaxDelete btn btn-danger btn-sm" data-href="{{ URL::to('/agent/delete-agent/' . $agent->agent_id) }}" data-title="{{ $agent->agent_name }} - {{ $agent->district_name }}, {{ $agent->branch_id }}" id="{{ $agent->agent_id }}"><i class="far fa-trash-alt" aria-hidden="true"></i></button>
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

@include('pages.agents.agent-new-modal')
@include('pages.agents.agent-edit-modal')
@include('pages.agents.agent-view-modal')
@include('pages.agents.agent-status-modal')

@endsection


@section('custom_js')
<script type="text/javascript">
$(document).ready(function(){
    $(document).on('click', 'button.editAgent', function () {

        var id = $(this).attr('id');
        var modal = $("#editAgentModal");

        $.ajax({
            url: "{{ url('/agent/edit-agent') }}/"+id,
            method: "get",
            dataType: "json",
            success: function( response ) {
                modal.find('.modal-title').text( "Update Agent" );
                modal.find('input[name=agent_id]').val( response[0].agent_id );
                modal.find('#agent_name').val( response[0].agent_name );
                modal.find('#fathers_name').val( response[0].fathers_name );
                modal.find('#mothers_name').val( response[0].mothers_name );
                modal.find('#branch_name').val( response[0].branch_name );
                modal.find('#branch_address').val( response[0].branch_address );
                modal.find("select#division_id option[value=" + response[0].division_id +"]").prop("selected", true);
                modal.find('select#district_id').html( '<option value="'+response[0].district_id+'">'+response.district_name+'</option>' );
                modal.find('#date_of_birth').val( response[0].date_of_birth.split('-')[2]+"/"+response[0].date_of_birth.split('-')[1]+"/"+response[0].date_of_birth.split('-')[0] );
                modal.find("select#blood_group option[value=" + response[0].blood_group +"]").prop("selected", true);
                modal.find("select#gender option[value=" + response[0].gender +"]").prop("selected", true);
                modal.find('#mobile').val( response[0].mobile );
                modal.find('#religion').val( response[0].religion );
                modal.find('#nationality').val( response[0].nationality );
                modal.find('#national_id').val( response[0].national_id );
                modal.find('#email').val( response[0].email );
                modal.find('#password').attr('readonly', 'readonly').removeAttr('required');
                modal.find('#trade_licence_number').val( response[0].trade_licence_number );
                modal.find('#tin_number').val( response[0].tin_number );
                modal.find('#vat_number').val( response[0].vat_number );
                modal.find('#latitude').val( response[0].latitude );
                modal.find('#longitude').val( response[0].longitude );
                modal.find('#note').val( response[0].note );

                modal.find('#agent_photo_prev').val( response[0].agent_photo );
                modal.find('#agent_photo').parent('.custom-file').find('label.custom-file-label').html( response[0].agent_photo ? response[0].agent_photo : "No Attachment"  );
                if(response[0].agent_photo){ modal.find('#agent_photo').removeAttr('required'); }

                modal.find('#trade_licence_prev').val( response[0].trade_licence );
                modal.find('#trade_licence').parent('.custom-file').find('label.custom-file-label').html( response[0].trade_licence ? response[0].trade_licence : "No Attachment"  );
                if(response[0].trade_licence){ modal.find('#trade_licence').removeAttr('required'); }

                modal.find('#tin_certificate_prev').val( response[0].tin_certificate );
                modal.find('#tin_certificate').parent('.custom-file').find('label.custom-file-label').html( response[0].tin_certificate ? response[0].tin_certificate : "No Attachment"  );
                if(response[0].tin_certificate){ modal.find('#tin_certificate').removeAttr('required'); }

                modal.find('#vat_certificate_prev').val( response[0].vat_certificate );
                modal.find('#vat_certificate').parent('.custom-file').find('label.custom-file-label').html( response[0].vat_certificate ? response[0].vat_certificate : "No Attachment"  );
                if(response[0].vat_certificate){ modal.find('#vat_certificate').removeAttr('required'); }

                modal.modal({ backdrop: "static", keyboard: true });
                modal.on('shown.bs.modal', function(){ $(":input[type='text']:enabled:visible:first").focus(); });
            },
            beforeSend: function( xhr ) { $(".ajax-loader").show(); },
            complete: function( jqXHR, textStatus ) { $(".ajax-loader").hide(); },
        });
    });

    $(document).on('click', 'button.view-agent', function () {
        var id = $(this).attr('id');
        var modal = $("#view_agent_modal");

        $.ajax({
            url: "{{ url('/agent/view-agent') }}/" + id,
            method: "get",
            dataType: "json",
            success: function( response ) {
                modal.find('.modal-title').text( "View Details of Agent ("+ response[0].agent_name +")" );
                modal.find('.agent_name').text( response[0].agent_name );
                modal.find('.fathers_name').text( response[0].fathers_name );
                modal.find('.mothers_name').text( response[0].mothers_name );
                modal.find('.agent_status').text( response[0].agent_status );
                modal.find('.mobile').html('<a href="tel:'+response[0].mobile+'">'+response[0].mobile+'</a>');
                modal.find('.email').html('<a href="mailto:'+response[0].email+'">'+response[0].email+'</a>');
                modal.find('.division_name').text( response.division_name );
                modal.find('.district_name').text( response.district_name );
                modal.find('.branch_name').text( response['branch'] ? response['branch'].branch_name : "-" );
                modal.find('.branch_address').text( response[0].branch_address );
                modal.find('.latlng').find('var').text( response[0].latitude +", "+ response[0].longitude );
                modal.find('.latlng').find('.attachment-btn a').attr("href", "{{ url('/map/view-in-map/agent/') }}?lat="+ response[0].latitude+"&lng="+response[0].longitude).removeClass('disabled btn-outline-success btn-success').addClass( response[0].latitude ? "btn-outline-info" : "disabled btn-outline-info");

                modal.find('.trade_licence').find('var').text( response[0].trade_licence_number );
                modal.find('.trade_licence').find('.attachment-btn a').attr("href", "{{ url('storage/uploads/agents/') }}/"+ response[0].trade_licence).addClass( response[0].trade_licence ? "btn-outline-info" : "disabled btn-outline-info");

                modal.find('.tin_certificate').find('var').text( response[0].tin_number );
                modal.find('.tin_certificate').find('.attachment-btn a').attr("href", "{{ url('storage/uploads/agents/') }}/"+ response[0].tin_certificate).addClass( response[0].tin_certificate ? "btn-info" : "disabled btn-outline-info");

                modal.find('.vat_certificate').find('var').text( response[0].vat_number );
                modal.find('.vat_certificate').find('.attachment-btn a').attr("href", "{{ url('storage/uploads/agents/') }}/"+ response[0].vat_certificate).addClass( response[0].vat_certificate ? "btn-info" : "disabled btn-outline-info");

                modal.find('.total_drivers').text( "-" );
                modal.find('.total_trips').text( "-" );
                modal.find('.commission_rate').text( response[0].commission );
                modal.find('.wallet_balance').text( takaFormat(response[0].wallet_balance ?? "0") );
                modal.find('.date_of_birth').text( response[0].date_of_birth ? (response[0].date_of_birth.split('-')[2]+"/"+response[0].date_of_birth.split('-')[1]+"/"+response[0].date_of_birth.split('-')[0]) : "-" );
                modal.find('.blood_group').text( (response[0].blood_group).replace('_pos', "+").replace('_neg', "-") );

                modal.find('.reg_date').text( response[0].reg_date.split('-')[2]+"/"+response[0].reg_date.split('-')[1]+"/"+response[0].reg_date.split('-')[0] );
                modal.find('.gender').text( response[0].gender );
                modal.find('.note').text( response[0].note );
                modal.modal("show");
            },
            beforeSend: function( xhr ) { $(".ajax-loader").show('slow'); },
            complete: function( jqXHR, textStatus ) { $(".ajax-loader").hide('fast'); },
        });
    });

    $(document).on('click', 'button.agent-status', function (e) {
        e.preventDefault();
        var modal = $("#agent_status_modal");
        var prev_status = $(this).data('status').toLowerCase();

        modal.find("select#agent_status option[value="+ prev_status +"]").prop("selected", true);
        modal.find('input[name=agent_id]').val( $(this).attr('id') );
        modal.modal('show');
    });

    $("form#changeAgentStatus").submit(function (event) {
        event.preventDefault();
        $("button[type=submit]").attr('disabled', 'disabled').html("<i class='fa fa-floppy-disk'></i> Saving...");

        var form = $(this);
        var agent_status = form.find('select#agent_status').val();
        var agent_id = form.find('input[name=agent_id]').val();
        var url = form.attr("action");
        var status_class_array = { 'active':'btn-success', 'pending':'btn-warning', 'banned':"btn-danger", 'suspend':"btn-outline-danger" };

        $.ajaxSetup({
            headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') }
        });

        $.ajax({
            type: "POST",
            url: url,
            data: {agent_id: agent_id, agent_status: agent_status},
            dataType: 'json',
            success: function (response) {
                $("button#"+agent_id+".agent-status").text( capitalizeFirstLetter(response.agent_status.replace('_', ' ').replace('_', ' ')) );
                $("button#"+agent_id+".agent-status").attr('data-status', response.agent_status.replace('_', ' ').replace('_', ' ') );
                $("button#"+agent_id+".agent-status").removeAttr('class').attr('class', 'btn btn-sm agent-status '+ status_class_array[response.agent_status]);

                toastr.success( response.success );
                $('#agent_status_modal').modal('hide');
                $("button[type=submit]").removeAttr('disabled').html("<i class='fa fa-save'></i> Change Status");
            },
            statusCode:{ 404: function(){ alert( "page not found" ); } },
            error: function (xhr, textStatus, errorThrown) { alert(errorThrown); },
            beforeSend: function( xhr ) { $(".ajax-loader").show('slow'); },
            complete: function( jqXHR, textStatus ) { $(".ajax-loader").hide('fast'); },
        });
        return false;
    });


    $('select[name="division_id"]').on('change', function(){
        var division_id = $(this).val();
        var modal = $(this).parents('.modal');

        $.ajax({
            url : "{{ url('/get_info/get-district') }}/" + division_id,
            type : "GET",
            dataType : "json",
            data: {id: division_id },
            success:function( data ){
                modal.find('select[name="district_id"]').empty();
                var district = '<option value="" selected="selected">--Select District--</option>';
                $.each(data, function(key, value){
                    district += '<option value="'+ key +'">'+ value +'</option>';
                });
                modal.find('select[name="district_id"]').append( district );
            },
            beforeSend: function( xhr ) { modal.find('select#district_id').parents(".input-group").append('<i class="loader-spin fa fa-spin fa-spinner fa-lg" style="position: absolute; left: 85%; top:28%; background: #fff;"></i>'); },
            complete: function( jqXHR, textStatus ) { modal.find('.loader-spin').delay(1000).hide('slow'); modal.find('.loader-spin').remove(); },
        });
    });
}); //End of Document ready

</script>
@endsection

