@extends('dashboard')
@section('main_content')

<section class="content">
    <div class="box box-success animated fadeInLeft">
        <div class="box-header with-border">
            <h2 class="box-title"><i class="fa fa-tags" aria-hidden="true"></i> All Asset List</h2>
            <div class="box-tools float-right">
                <button type="button" class="btn btn-info btn-sm showNewAssetModal" data-toggle="tooltip" data-placement="top" title="Add New Asset Modal"><i class="fa fa-plus"></i> New Asset</button>
                <button type="button" class="btn btn-box-tool" id="refresh" data-toggle="tooltip" data-placement="top" title="Refresh"><i class="fa fa-sync-alt"></i></button>
            </div><!-- /.box-tools -->
        </div><!-- /.box-header -->

        <div class="box-body table-resassetnsive">
            <table id="general_datatable" class="table table-striped table-custom">
                <thead class="thead-inverse">
                    <tr>
                        <th>#</th>
                        <th>Asset Date</th>
                        <th>Asset Type</th>
                        <th>Asset Name</th>
                        <th>UOM</th>
                        <th>Rate</th>
                        <th>Qty.</th>
                        <th>Asset Amount</th>
                        <th data-orderable="false" class="no-print" style="width:50px;">Action</th>
                    </tr>
                </thead>
                <tbody>
                @foreach($all_asset_info as $asset)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>@if($asset->asset_opening_date > 0) {{ date('d/m/Y', strtotime($asset->asset_opening_date)) }} @endif</td>
                        <td>{{ $asset->asset_type }}</td>
                        <td>{{ $asset->asset_name }}</td>
                        <td>{{ $asset->asset_uom }}</td>
                        <td>{{ $asset->asset_rate }}</td>
                        <td>{{ $asset->asset_qty }}</td>
                        <td>{{ $asset->asset_total_amount }}</td>
                        <td>
                            <button type="button" class="btn btn-warning btn-sm editAsset" id="{{ $asset->asset_id }}" data-url="{{ url('/account/edit-asset/' .  $asset->asset_id) }}"><i class="fa fa-edit" aria-hidden="true"></i></button>
                            <button type="button" class="ajaxDelete btn btn-danger btn-sm" data-href="{{ URL::to('/account/delete-asset/' . $asset->asset_id) }}" data-title="{{ $asset->asset_name }}" id="{{ $asset->asset_id }}" data-toggle="tooltip" data-placement="top" title="Delete this Asset"><i class="far fa-trash-alt" aria-hidden="true"></i></button>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
                <tfoot class="total_row">
                    <tr>
                        <th colspan="6">Total </th>
                        <th><?php echo taka_format('', $total_value->qty ); ?></th>
                        <th><?php echo taka_format('', $total_value->total_amount ); ?></th>
                        <th></th>
                    </tr>
                </tfoot>
            </table>
        </div><!-- /.box-body -->

        <div class="overlay" style="display: none;">
            <i class="fa fa-sync-alt fa-spin"></i>
        </div>
    </div><!-- /.box -->
</section>

@include('pages.accounts.asset-new-modal')
@include('pages.accounts.asset-edit-modal')

@endsection


@section('custom_js')
<script type="text/javascript">
$(document).ready(function(){
    $('button.showNewAssetModal').on('click', function () {
        var modal = $("#newAssetModal");
        modal.modal({ backdrop: "static", keyboard: true });
        modal.on('shown.bs.modal', function(){ $(":input[type='text']:enabled:visible:first").focus(); });
    });

    $('form').on('keyup', '#asset_qty, #asset_rate', function(){

        var asset_qty = parseInt( $('#asset_qty').val() );
        var asset_qty = asset_qty ? asset_qty : 1;

        var asset_rate  = parseInt( $('#asset_rate').val() );
        var asset_rate  = asset_rate ? asset_rate : 1;

        $('#asset_total_amount').val( asset_qty * asset_rate );
    });


    $(document).on('click', 'button.editAsset', function () {

        var url = $(this).data('url');
        var id = $(this).attr('id');
        var modal = $("#editAssetModal");

        $.ajax({
            url: url,
            method: "get",
            //data: { id: id },
            dataType: "json",
            success: function( response ) {
                modal.find('.modal-title').text( "Update Asset" );
                modal.find('input[name=asset_id]').val( response.asset_id );
                modal.find('#asset_opening_date').val( response.asset_opening_date.split('-')[2]+"/"+response.asset_opening_date.split('-')[1]+"/"+response.asset_opening_date.split('-')[0] );
                modal.find('select#asset_type option[value="' + response.asset_type +'"]').prop("selected", true);
                modal.find('#asset_name').val( response.asset_name );
                modal.find('#asset_uom').val( response.asset_uom );
                modal.find('#asset_qty').val( response.asset_qty );
                modal.find('#asset_rate').val( response.asset_rate );
                modal.find('#asset_total_amount').val( response.asset_total_amount );
                modal.find('#asset_description').val( response.asset_description );

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

