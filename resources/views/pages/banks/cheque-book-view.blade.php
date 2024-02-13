@extends('dashboard')
@section('main_content')

<section class="content">
    <div class="box box-success animated fadeInRight">
        <div class="box-header with-border">
            <h2 class="box-title">View Cheque Book No: {{ $cheque_book_no }}</h2>
            <div class="filter-button float-right box-tools" style="margin-right: 7%; width: 90%;">
                <div class="float-right" style="margin-right: .5%;">
                    <button type="button" class="btn btn-warning btn-sm" id="daterange-btn">
                       <span>Date range picker </span><i class="fa fa-caret-down"></i>
                    </button>
                </div>
                <div class="float-right" style="margin-right: .5%; width: 150px;">
                    <div class="input-group">
                        <div class="input-group-prepend"><span class="input-group-text" style="padding: 2px 3px;">To</span></div>
                        <input type="datetime" id="custom_date_end" class="form-control form-control-sm" value="<?php echo date('Y-m-d'); ?>" />
                    </div>
                </div>
                <div class="float-right" style="margin-right: .5%; width: 150px;">
                    <div class="input-group">
                        <div class="input-group-prepend"><span class="input-group-text" style="padding: 2px 3px;">From</span></div>
                        <input type="datetime" id="custom_date_begin" class="form-control form-control-sm" value="<?php echo date('Y-m-d'); ?>" />
                    </div>
                </div>
                <div class="float-right" style="margin-right: .5%">
                    <select id="supplier__filter" class="custom-select custom-select-sm">
                        <option value="">--Supplier Name--</option>
                        <?php $suppliers = DB::table('suppliers')->pluck("supplier_name", "supplier_id"); ?>

                        @foreach($suppliers as $id => $name )
                        <option value="{{ $id }}">{{ $name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="float-right" style="margin-right: .5%;">
                    <select id="used_unused_cheque_leaf_filter" class="custom-select custom-select-sm">
                        <option value="" selected="selected">--Cheque Status--</option>
                        <option value="0">Unused</option>
                        <option value="2">Error</option>
                        <option value="3">Wasted</option>
                        <option value="1">Used</option>
                    </select>
                </div>
                <div class="float-right" style="margin-right: 1%;">
                    <input type="text" id="account_name_filter" class="form-control form-control-sm" placeholder="Cheque No" />
                </div>
            </div>

            <div class="box-tools float-right">
                <button type="button" class="btn btn-box-tool" id="refresh" data-toggle="tooltip" data-placement="top" title="Refresh"><i class="fa fa-sync-alt"></i></button>
                <button type="button" class="btn btn-box-tool" data-toggle="tooltip" data-placement="top" title="Collapse"><i class="fa fa-minus"></i></button>
                <button type="button" class="btn btn-box-tool" data-toggle="tooltip" data-placement="top" title="Remove"><i class="fa fa-times"></i></button>
            </div><!-- /.box-tools -->
        </div><!-- /.box-header -->

        <div class="box-body">
            <table id="general_datatable" class="table table-custom cheque_leaf_table">
                <thead class="thead-inverse">
                    <tr>
                        <th>#</th>
                        <th>Cheque Number</th>
                        <th>Status</th>
                        <th>Issue Date</th>
                        <th>Voucher</th>
                        <th>Client</th>
                        <th>Used by</th>
                        <th>Amount</th>
                    </tr>
                </thead>
                <tbody>
                @foreach( $cheque_leaf_info as $cheque_leaf )
                    <tr id="{{ $cheque_leaf->cheque_leaf_id }}">
                        <td>{{ $loop->iteration }}</td>
                        <td>@if( $cheque_leaf->cheque_leaf_status === 'Used' ) <a href="#" class="cheque-view" id="{{ $cheque_leaf->cheque_leaf_id }}" data-cheque_number="{{ $cheque_leaf->cheque_number }}">{{ $cheque_leaf->cheque_number }}</a> @else {{ $cheque_leaf->cheque_number }} @endif</td>
                        <td id="cheque_leaf_status">
                            @if( $cheque_leaf->cheque_leaf_status === 'Used' )<i class="fa fa-check-square fa-lg text-success" title="Used for- {{ $cheque_leaf->voucher_id }}" aria-hidden="true"></i>
                            @elseif($cheque_leaf->cheque_leaf_status === "Error") <a href="#" class="change-cheque-leaf-status text-danger" id="{{ $cheque_leaf->cheque_leaf_id }}" title="Error: {{ $cheque_leaf->leaf_unused_reason }}"><i class="fa fa-times fa-lg" aria-hidden="true"></i></a>
                            @elseif($cheque_leaf->cheque_leaf_status === "Wasted") <a href="#" class="change-cheque-leaf-status text-warning" id="{{ $cheque_leaf->cheque_leaf_id }}" title="Wasted: {{ $cheque_leaf->leaf_unused_reason }}"><i class="fa fa-times-circle fa-lg" aria-hidden="true"></i></a>
                            @else <a href="#" class="change-cheque-leaf-status" id="{{ $cheque_leaf->cheque_leaf_id }}"><i class="far fa-square fa-lg" aria-hidden="true"></i></a>
                            @endif
                        </td>
                        <td>@if( $cheque_leaf->leaf_issue_date )
                            @if($cheque_leaf->leaf_issue_date > 0) {{ date('d/m/Y', strtotime($cheque_leaf->leaf_issue_date)) }} @endif
                            @else N/A @endif
                        </td>
                        <td>@if( $cheque_leaf->voucher_id ) <a href="{{ URL::to('/voucher/'.$cheque_leaf->cheque_leaf_id ) }}" target="_blank">{{ $cheque_leaf->voucher_id }}</a>@else N/A @endif</td>
                        <td>@if( $cheque_leaf->party_id )<a href="{{ URL::to('/'. $cheque_leaf->party_type .'/view/'.$cheque_leaf->party_id ) }}" target="_blank">{{$cheque_leaf->party_type}}- {{ $cheque_leaf->party_name }}</a>@else N/A @endif</td>
                        <td>@if( $cheque_leaf->user_id ) <a href="{{ URL::to('/admin/user-management?user_name='. $cheque_leaf->name ) }}" target="_blank">{{ $cheque_leaf->name }}</a>@else N/A @endif</td>
                        <td>{{ taka_format('', $cheque_leaf->cheque_leaf_amount ) }}</td>
                    </tr>
                @endforeach
                </tbody>
                <tfoot class="total_row">
                    <tr>
                        <th colspan="7">Total </th>
                        <th><?php echo taka_format('', DB::table('bank_cheque_leafs')->where('cheque_book_id', $cheque_book_id)->sum('cheque_leaf_amount') ); ?></th>
                    </tr>
                </tfoot>
            </table>
        </div><!-- /.box-body -->

        <div class="overlay" style="display: none;">
            <i class="fa fa-sync-alt fa-spin"></i>
        </div>
    </div><!-- /.box -->
</section>


@include('pages.banks.cheque-leaf-status')
@include('pages.banks.view-cheque-leaf-modal')

@endsection





@section('custom_js')
<script type="text/javascript">
$(document).ready(function(){
    $(document).on('click', 'a.change-cheque-leaf-status', function (e) {
        e.preventDefault();

        var id = $(this).attr('id');

        var modal = $("#cheque_leaf_status_modal");
        modal.modal({ backdrop: "static", keyboard: true });
        modal.find('input[name=cheque_leaf_id]').val( id );

        $("form#change_cheque_leaf_status").submit(function (event) {
            event.preventDefault();

            var form = $(this);
            var data = form.serialize();
            var url = form.attr("action");

            $.ajaxSetup({
                headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') }
            });

            $.ajax({
                url: url,
                method: "post",
                data: data,
                dataType: "json",
                success: function( response ) {
                    var cheque_leaf_status = '';
                    if( response.cheque_leaf_status == "Wasted" ){
                        cheque_leaf_status += '<a href="#" class="change-cheque-leaf-status text-warning" id="'+response.cheque_leaf_id+'" title="'+response.cheque_leaf_status+": "+ response.leaf_unused_reason +'"><i class="fa fa-times-circle fa-lg" aria-hidden="true"></i></a>';
                    }else if( response.cheque_leaf_status == "Error" ){
                        cheque_leaf_status += '<a href="#" class="change-cheque-leaf-status text-danger" id="'+response.cheque_leaf_id+'" title="'+response.cheque_leaf_status+": "+ response.leaf_unused_reason +'"><i class="fa fa-times fa-lg" aria-hidden="true"></i></a>';
                    }else if(response.cheque_leaf_status == "Release" ){
                        cheque_leaf_status += '<a href="#" class="change-cheque-leaf-status" id="'+response.cheque_leaf_id+'" title="'+response.cheque_leaf_status+": "+ response.leaf_unused_reason +'"><i class="far fa-square fa-lg" aria-hidden="true"></i></a>';
                    }else{
                        cheque_leaf_status += '<a href="#" class="change-cheque-leaf-status" id="'+response.cheque_leaf_id+'" title="Unused Leaf"><i class="far fa-square fa-lg" aria-hidden="true"></i></a>';
                    }
                    $("table.cheque_leaf_table tr#"+ response.cheque_leaf_id).find("td#cheque_leaf_status").html( cheque_leaf_status );
                    modal.modal('hide');
                },
                statusCode:{ 404: function(){ alert( "page not found" ); } },
                beforeSend: function( xhr ) { $(".ajax-loader").show(); },
                complete: function( jqXHR, textStatus ) { $(".ajax-loader").hide(); },
            });
            return false;
        });
    });
}); //End of Document ready



$(document).ready(function(){
    $(document).on('click', 'a.cheque-view', function () {

        var cheque_number = $(this).data('cheque_number');
        var id = $(this).attr('id');
        var modal = $("#cheque_view_modal");

        $.ajax({
            url: "{{ url('/bank/view-cheque') }}/"+cheque_number,
            method: "get",
            //data: { id: id },
            dataType: "json",
            cache:false,
            async: false,
            success: function( data ) {
                modal.find('.modal-title').text( "View Account ("+ data.account_data.account_name +")" );
                modal.find('#account_name').text( data.account_data.account_name );
                modal.find('.bank_name').text( data.bank_name );
                modal.find('.branch span').text( data.account_data.branch );
                modal.find('.swift_code').text( data.account_data.swift_code );
                modal.find('#account_number').text( data[0].account_number );
                modal.find('.chequeQRCode').attr("src", "https://chart.googleapis.com/chart?chs=300x300&cht=qr&chl="+"Bank Name: "+data.bank_name+", branch: "+data.account_data.branch+", A/C Name: "+data.account_data.account_name+", A/C No. "+data[0].account_number+", Cheque Number: "+data[0].cheque_number+"&choe=UTF-8" );
                modal.find('#cheque_number').text( data[0].cheque_number );
                modal.find('#cheque_type').text( data[0].cheque_type );
                modal.find('.cheque-right .cheque_type').text( data[0].cheque_type );
                modal.find('#cheque_date').text( data[0].cheque_date.split('-')[2]+"/"+data[0].cheque_date.split('-')[1]+"/"+data[0].cheque_date.split('-')[0] );
                modal.find('.date_span span:eq(0)').text( data.date_span[0] );
                modal.find('.date_span span:eq(1)').text( data.date_span[1] );
                modal.find('.date_span span:eq(2)').text( data.date_span[2] );
                modal.find('.date_span span:eq(3)').text( data.date_span[3] );
                modal.find('.date_span span:eq(4)').text( data.date_span[4] );
                modal.find('.date_span span:eq(5)').text( data.date_span[5] );
                modal.find('.date_span span:eq(6)').text( data.date_span[6] );
                modal.find('.date_span span:eq(7)').text( data.date_span[7] );
                modal.find('#cheque_amount').text( takaFormat( data[0].debit ) );
                modal.find('#party_name').text( data[0].party_name );
                modal.find('#party_name2').text( data[0].party_name );
                modal.find('#in_word').text( data.in_word );

                modal.modal("show");
            },
            beforeSend: function( xhr ) { $(".ajax-loader").show('slow'); },
            complete: function( jqXHR, textStatus ) { $(".ajax-loader").hide('fast'); },
        });
    });
}); //End of Document ready

</script>
@endsection

