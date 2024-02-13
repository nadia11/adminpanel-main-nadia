@extends('dashboard')
@section('main_content')

<section class="content">
    <div class="box box-success animated fadeInLeft">
        <div class="box-header with-border">
            <h2 class="box-title"><i class="fa fa-file-alt" aria-hidden="true"></i> Showing All Promo Code</h2>
            <div class="box-tools float-right">
                <button type="button" class="btn btn-info btn-sm" data-toggle="modal" data-target="#showNewPromoCodeModal"><i class="fa fa-plus"></i> New Promo Code</button>
                <button type="button" class="btn btn-box-tool" id="refresh" data-toggle="tooltip" data-placement="top" title="Refresh"><i class="fa fa-sync-alt"></i></button>
            </div><!-- /.box-tools -->
        </div><!-- /.box-header -->

        <div class="box-body table-responsive">
            <table id="general_datatable" class="table table-custom">
                <thead class="thead-inverse">
                    <tr>
                        <th>#</th>
                        <th>Promo Name</th>
                        <th>Promo Code</th>
                        <th>Create Date</th>
                        <th>Expiry Date</th>
                        <th>Promo Amount</th>
                        <th>Promo Count</th>
                        <th>Promo Used Count</th>
                        <th>Balance Promo</th>
                        <th>Promo Status</th>
                        <th data-orderable="false" class="no-print" style="width:60px;">Action</th>
                    </tr>
                </thead>
                <tbody>
                @php $status_class = array('active'=>'btn-success', 'pending'=>'btn-warning', 'expired'=>"btn-danger", 'hold'=>'btn-info') @endphp
                @foreach($all_promo_code_info as $promo_code)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $promo_code->promo_name }}</td>
                        <td>{{ $promo_code->promo_code }}</td>
                        <td>{{ date('d/m/Y', strtotime($promo_code->create_date)) }}</td>
                        <td>{{ date('d/m/Y', strtotime($promo_code->expiry_date)) }}</td>
                        <td>{{ taka_format("", $promo_code->promo_amount) }}</td>
                        <td>{{ $promo_code->promo_code_count }}</td>
                        <td>{{ $promo_code->promo_code_used_count ?: 0 }}</td>
                        <td>{{ ($promo_code->promo_code_count - $promo_code->promo_code_used_count) ?: 0 }}</td>
                        <td><button type="button" class="btn {{ $status_class[$promo_code->promo_code_status] }} btn-sm promo-code-status" data-status="{{ $promo_code->promo_code_status }}" id="{{ $promo_code->promo_code_id }}" data-href="{{ URL::to('promo-code-status/'. $promo_code->promo_code_id) }}">{{ str_snack($promo_code->promo_code_status) }}</button></td>
                        <td style="white-space: nowrap;">
                            <button type="button" class="btn btn-info btn-sm view-promo-code" id="{{ $promo_code->promo_code_id }}"><i class="fa fa-eye" aria-hidden="true"></i></button>
                            <button type="button" class="btn btn-warning btn-sm editPromoCode" id="{{ $promo_code->promo_code_id }}"><i class="fa fa-edit" aria-hidden="true"></i></button>
                            <button type="button" class="ajaxDelete btn btn-danger btn-sm" data-href="{{ URL::to('/promo-code/delete-promo-code/' . $promo_code->promo_code_id) }}" data-title="{{ $promo_code->promo_name }} - {{ $promo_code->promo_code }}" id="{{ $promo_code->promo_code_id }}"><i class="far fa-trash-alt" aria-hidden="true"></i></button>
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

@include('pages.promo-codes.promo-code-new-modal')
@include('pages.promo-codes.promo-code-edit-modal')
@include('pages.promo-codes.promo-code-view-modal')
@include('pages.promo-codes.promo-code-status-modal')

@endsection


@section('custom_js')
<script type="text/javascript">
$(document).ready(function(){
    $(document).on('click', 'button.editPromoCode', function () {

        var id = $(this).attr('id');
        var modal = $("#editPromoCodeModal");

        $.ajax({
            url: "{{ url('/promo-code/edit-promo-code') }}/"+id,
            method: "get",
            dataType: "json",
            success: function( response ) {
                modal.find('.modal-title').text( "Update Promo Code" );
                modal.find('input[name=promo_code_id]').val( response[0].promo_code_id );
                modal.find('#promo_name').val( response[0].promo_name );
                modal.find('#promo_code').val( response[0].promo_code );
                modal.find('#create_date_edit').val( response[0].create_date.split('-')[2]+"/"+response[0].create_date.split('-')[1]+"/"+response[0].create_date.split('-')[0] );
                modal.find('#expiry_date_edit').val( response[0].expiry_date.split('-')[2]+"/"+response[0].expiry_date.split('-')[1]+"/"+response[0].expiry_date.split('-')[0] );
                modal.find('#promo_amount').val( response[0].promo_amount );
                modal.find('#promo_code_count').val( response[0].promo_code_count );
                modal.find('#promo_code_note').val( response[0].promo_code_note );
                modal.modal({ backdrop: "static", keyboard: true });
            },
            beforeSend: function( xhr ) { $(".ajax-loader").show(); },
            complete: function( jqXHR, textStatus ) { $(".ajax-loader").hide(); },
        });
    });

    $(document).on('click', 'button.view-promo-code', function () {
        var id = $(this).attr('id');
        var modal = $("#view_promo_code_modal");

        $.ajax({
            url: "{{ url('/promo-code/view-promo-code') }}/" + id,
            method: "get",
            dataType: "json",
            cache:false,
            async: false,
            success: function( response ) {
                modal.find('.modal-title').text( "View Details of Promo Name: " + response[0].promo_name );
                modal.find('.promo_name').text( response[0].promo_name );
                modal.find('.promo_code').text( response[0].promo_code );
                modal.find('.create_date').text( response[0].create_date.split('-')[2]+"/"+response[0].create_date.split('-')[1]+"/"+response[0].create_date.split('-')[0] );
                modal.find('.expiry_date').text( response[0].expiry_date.split('-')[2]+"/"+response[0].expiry_date.split('-')[1]+"/"+response[0].expiry_date.split('-')[0] );
                modal.find('.promo_amount').text( takaFormat(response[0].promo_amount) );
                modal.find('.promo_code_count').text( takaFormat(response[0].promo_code_count) );
                modal.find('.promo_used_count').text( response[0].promo_used_count ? takaFormat(response[0].promo_used_count) : '0.00' );
                modal.find('.balance_promo').text( response[0].promo_used_count ? takaFormat(parseInt(response[0].promo_code_count) - parseInt(response[0].promo_used_count)) : '0.00' );
                modal.find('.promo_status').text( response[0].promo_code_status );
                modal.modal("show");
            },
            beforeSend: function( xhr ) { $(".ajax-loader").show('slow'); },
            complete: function( jqXHR, textStatus ) { $(".ajax-loader").hide('fast'); },
        });
    });


    $(document).on('click', 'button.promo-code-status', function (e) {
        e.preventDefault();
        var modal = $("#promo_code_status_modal");
        modal.find("select#promo_code_status option[value="+ $(this).data('status') +"]").prop("selected", true);
        modal.find('input[name=promo_code_id]').val( $(this).attr('id') );
        modal.modal('show');
    });

    $("form#changePromoCodeStatus").submit(function (event) {
        event.preventDefault();
        $("button[type=submit]").attr('disabled', 'disabled').html("<i class='fa fa-floppy-disk'></i> Saving...");

        var form = $(this);
        var promo_code_status = form.find('select#promo_code_status').val();
        var promo_code_id = form.find('input[name=promo_code_id]').val();
        var url = form.attr("action");
        var status_class_array = { 'active':'btn-success', 'pending':'btn-warning', 'expired':"btn-danger", 'hold':'btn-info' };

        $.ajax({
            type: "POST",
            url: url,
            headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
            data: {promo_code_id: promo_code_id, promo_code_status: promo_code_status},
            dataType: 'json',
            success: function (response) {
                $("button#"+promo_code_id+".promo-code-status").text( capitalizeFirstLetter(response.promo_code_status.replace('_', ' ').replace('_', ' ')) );
                $("button#"+promo_code_id+".promo-code-status").attr('data-status', response.promo_code_status.replace('_', ' ').replace('_', ' ') );
                $("button#"+promo_code_id+".promo-code-status").removeAttr('class').attr('class', 'btn btn-sm promo-code-status '+ status_class_array[response.promo_code_status]);

                toastr.success( response.success );
                $('#promo_code_status_modal').modal('hide');
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

