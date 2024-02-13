@extends('dashboard')
@section('main_content')

<section class="content">
    <div class="box box-success animated fadeInLeft">
        <div class="box-header with-border">
            <h2 class="box-title"><i class="fa fa-tags" aria-hidden="true"></i> All Commission List</h2>
            <div class="box-tools float-right">
                <button type="button" class="btn btn-info btn-sm showNewCommissionModal" data-toggle="tooltip" data-placement="top" title="Add New Commission Modal"><i class="fa fa-plus"></i> New Commission</button>
                <button type="button" class="btn btn-box-tool" id="refresh" data-toggle="tooltip" data-placement="top" title="Refresh"><i class="fa fa-sync-alt"></i></button>
            </div><!-- /.box-tools -->
        </div><!-- /.box-header -->

        <div class="box-body table-responsive">
            <table id="general_datatable" class="table table-striped table-custom">
                <thead class="thead-inverse">
                    <tr>
                        <th>#</th>
                        <th>Commission Name</th>
                        <th>Percent</th>
                        <th>Note</th>
                        <th data-orderable="false" class="no-print" style="width:50px;">Action</th>
                    </tr>
                </thead>
                <tbody>
                @foreach($all_commission_info as $commission)
                    <tr>
                        <td style="width: 100px;">{{ $loop->iteration }}</td>
                        <td style="width: 300px;">{{ $commission->commission_name }}</td>
                        <td style="width: 150px;">{{ $commission->commission_percent }}%</td>
                        <td>{{ $commission->note }}</td>
                        <td>
                            <button type="button" class="btn btn-warning btn-sm editCommission" id="{{ $commission->commission_id }}" data-url="{{ url('/account/edit-commission/' .  $commission->commission_id) }}"><i class="fa fa-edit" aria-hidden="true"> Edit</i></button>
                            {{--<button type="button" class="ajaxDelete btn btn-danger btn-sm" data-href="{{ URL::to('/account/delete-commission/' . $commission->commission_id) }}" data-title="{{ $commission->commission_name }}" id="{{ $commission->commission_id }}" data-toggle="tooltip" data-placement="top" title="Delete this Commission"><i class="far fa-trash-alt" aria-hidden="true"></i></button>--}}
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

@include('pages.accounts.commission-new-modal')
@include('pages.accounts.commission-edit-modal')

@endsection


@section('custom_js')
<script type="text/javascript">
$(document).ready(function(){
    $('button.showNewCommissionModal').on('click', function () {
        var modal = $("#newCommissionModal");
        modal.modal({ backdrop: "static", keyboard: true });
        modal.on('shown.bs.modal', function(){ $(":input[type='text']:enabled:visible:first").focus(); });
    });


    $(document).on('click', 'button.editCommission', function () {

        var url = $(this).data('url');
        var id = $(this).attr('id');
        var modal = $("#editCommissionModal");

        $.ajax({
            url: url,
            method: "get",
            //data: { id: id },
            dataType: "json",
            success: function( response ) {
                modal.find('.modal-title').text( "Update Commission" );
                modal.find('input[name=commission_id]').val( response.commission_id );
                modal.find('#commission_name').val( response.commission_name );
                modal.find('#commission_percent').val( response.commission_percent );
                modal.find('#note').val( response.note );

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

