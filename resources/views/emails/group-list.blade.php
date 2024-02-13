@extends('dashboard')
@section('main_content')

<section class="content">
    <div class="box box-success animated fadeInLeft">
        <div class="box-header with-border">
            <h2 class="box-title"><i class="fa fa-tags" aria-hidden="true"></i> All Group List</h2>
            <div class="box-tools float-right">
                <button type="button" class="btn btn-info btn-sm showNewGroupModal" data-toggle="tooltip" data-placement="top" title="Add New Group Modal"><i class="fa fa-plus"></i> New Group</button>
                <button type="button" class="btn btn-box-tool" id="refresh" data-toggle="tooltip" data-placement="top" title="Refresh"><i class="fa fa-sync-alt"></i></button>
            </div><!-- /.box-tools -->
        </div><!-- /.box-header -->

        <div class="box-body table-responsive">
            <table id="general_datatable" class="table table-striped table-custom">
                <thead class="thead-inverse">
                    <tr>
                        <th>#</th>
                        <th>Group Name</th>
                        <th>Used Contact Qty.</th>
                        <th>Create Date</th>
                        <th data-orderable="false" class="no-print" style="width:50px;">Action</th>
                    </tr>
                </thead>
                <tbody>
                @foreach($all_group_info as $group)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $group->group_name }}</td>
                        <td>{{ DB::table('contacts')->where('group_id', $group->group_id)->count() }}</td>
                        <td>{{ date('d/m/Y', strtotime($group->created_at)) }}</td>
                        <td>
                            <button type="button" class="btn btn-warning btn-sm editGroup" id="{{ $group->group_id }}"><i class="fa fa-edit" aria-hidden="true"></i></button>
                            <button type="button" class="ajaxDelete btn btn-danger btn-sm" data-href="{{ URL::to('/notification/delete-group/' . $group->group_id) }}" data-title="{{ $group->group_name }}" id="{{ $group->group_id }}" data-toggle="tooltip" data-placement="top" title="Delete this Group"><i class="far fa-trash-alt" aria-hidden="true"></i></button>
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

@include('emails.group-new-modal')
@include('emails.group-edit-modal')

@endsection


@section('custom_js')
<script type="text/javascript">
$(document).ready(function(){
    $('button.showNewGroupModal').on('click', function () {
        var modal = $("#newGroupModal");
        modal.modal({ backdrop: "static", keyboard: true });
        modal.on('shown.bs.modal', function(){ $(":input[type='text']:enabled:visible:first").focus(); });
    });


    $(document).on('click', 'button.editGroup', function () {
        var id = $(this).attr('id');
        var modal = $("#editGroupModal");

        $.ajax({
            url: "{{ url('/notification/edit-group') }}/" + id,
            method: "get",
            dataType: "json",
            success: function( response ) {
                modal.find('.modal-title').text( "Update Group" );
                modal.find('input[name=group_id]').val( response.group_id );
                modal.find('#group_name').val( response.group_name );

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

