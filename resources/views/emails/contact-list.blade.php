@extends('dashboard')
@section('main_content')

<section class="content">
    <div class="box box-success animated fadeInLeft">
        <div class="box-header with-border">
            <h2 class="box-title"><i class="fa fa-tags" aria-hidden="true"></i> All Contact List</h2>
            <div class="box-tools float-right">
                <button type="button" class="btn btn-info btn-sm showNewContactModal" data-toggle="tooltip" data-placement="top" title="Add New Contact Modal"><i class="fa fa-plus"></i> New Contact</button>
                <button type="button" class="btn btn-box-tool" id="refresh" data-toggle="tooltip" data-placement="top" title="Refresh"><i class="fa fa-sync-alt"></i></button>
            </div><!-- /.box-tools -->
        </div><!-- /.box-header -->

        <div class="box-body table-responsive">
            <table id="general_datatable" class="table table-striped table-custom">
                <thead class="thead-inverse">
                    <tr>
                        <th>#</th>
                        <th>Name</th>
                        <th>Mobile</th>
                        <th>Email</th>
                        <th>Operator</th>
                        <th>Group</th>
                        <th>Status</th>
                        <th data-orderable="false" class="no-print" style="width:50px;">Action</th>
                    </tr>
                </thead>
                <tbody>
                @php $operators_array = array('017'=>'GP - 017', '013'=>"GP - 013", '019'=>"BL - 019", '014'=>'BL - 014', '018'=>'Robi - 018', '016'=>'Robi - 016', '015'=>'Teletalk - 015') @endphp

                @foreach($all_contact_info as $contact)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $contact->contact_name }}</td>
                        <td>{{ $contact->contact_mobile }}</td>
                        <td>{{ $contact->contact_email }}</td>
                        <td>{{ $operators_array[$contact->operator] }}</td>
                        <td>{{ $contact->group_name ?? "-" }}</td>
                        <td>{{ str_snack($contact->contact_status) }}</td>
                        <td>
                            <button type="button" class="btn btn-warning btn-sm editContact" id="{{ $contact->contact_id }}"><i class="fa fa-edit" aria-hidden="true"></i></button>
                            <button type="button" class="ajaxDelete btn btn-danger btn-sm" data-href="{{ URL::to('/notification/delete-contact/' . $contact->contact_id) }}" data-title="{{ $contact->contact_name }}" id="{{ $contact->contact_id }}" data-toggle="tooltip" data-placement="top" title="Delete this Contact"><i class="far fa-trash-alt" aria-hidden="true"></i></button>
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

@include('emails.contact-new-modal')
@include('emails.contact-edit-modal')

@endsection


@section('custom_js')
<script type="text/javascript">
$(document).ready(function(){
    $('button.showNewContactModal').on('click', function () {
        var modal = $("#newContactModal");
        modal.modal({ backdrop: "static", keyboard: true });
        modal.on('shown.bs.modal', function(){ $(":input[type='text']:enabled:visible:first").focus(); });
    });

    $(document).on('click', 'button.editContact', function () {
        var id = $(this).attr('id');
        var modal = $("#editContactModal");

        $.ajax({
            url: "{{ url('/notification/edit-contact') }}/" + id,
            method: "get",
            dataType: "json",
            success: function( response ) {
                modal.find('.modal-title').text( "Update Contact" );
                modal.find('input[name=contact_id]').val( response.contact_id );
                modal.find('#contact_name').val( response.contact_name );
                modal.find('#contact_mobile').val( response.contact_mobile );
                modal.find('#contact_email').val( response.contact_email );
                modal.find('select#operator option[value="' + response.operator +'"]').prop("selected", true);
                modal.find('select#group_id option[value="' + response.group_id +'"]').prop("selected", true);

                modal.modal({ backdrop: "static", keyboard: true });
                modal.on('shown.bs.modal', function(){ $(":input[type='text']:enabled:visible:first").focus(); });
            },
            beforeSend: function( xhr ) { $(".ajax-loader").show(); },
            complete: function( jqXHR, textStatus ) { $(".ajax-loader").hide(); },
        });
    });
}); //End of Document ready

</script>
@endsection

