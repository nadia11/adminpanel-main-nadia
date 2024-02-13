@extends('dashboard')
@section('main_content')

<section class="content">
    <div class="box box-success animated fadeInRight">
        <div class="box-header with-border">
            <h2 class="box-title">Cheque Book List</h2>
            <div class="box-tools float-right" style="margin-right: 3%;">
                <div class="float-left" style="margin-right: 5px;">
                    <input type="text" name="cheque_book" id="cheque_book" class="form-control form-control-sm" placeholder="Cheque Book" />
                </div>
                <div class="float-left" style="margin-right: 5px">
                    <select id="bank_account_id" name="bank_account_id" class="custom-select custom-select-sm">
                        <option value="">-- Account Name --</option>
                        <?php $bank_accounts = DB::table('bank_accounts')->select('account_name', 'account_number', 'bank_account_id')->get(); ?>

                        @foreach($bank_accounts as $bank_account )
                        <option value="{{ $bank_account->bank_account_id }}">{{ $bank_account->account_name . " (" . $bank_account->account_number . ")" }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="float-left" style="margin-right: 5px;">
                    <label for="bank_name" class="control-label sr-only">Bank Name:</label>
                    <select id="bank_name" name="bank_name" class="custom-select custom-select-sm">
                        <option value="" selected="selected">{{ __('Bank Name') }}</option>
                        <?php $bank_name_lists = DB::table('bank_name_lists')->pluck("bank_name", "bank_name_id"); ?>
                        @foreach( $bank_name_lists as $key => $bank_name )
                        <option value="{{ $key }}">{{ $bank_name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="float-left" style="margin-right: 5px;">
                    <select id="bank_branch" name="bank_branch" class="custom-select custom-select-sm">
                        <option value="" selected="selected">{{ __('Bank Branch') }}</option>
                        <?php $bank_branches = DB::table('bank_accounts')->pluck("branch", "bank_account_id"); ?>
                        @foreach( $bank_branches as $key => $branch_name )
                        <option value="{{ $key }}">{{ $branch_name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="float-left" style="margin-right: 5px;">
                    <button type="button" class="btn btn-dark btn-sm showNewChequeBookModal"data-toggle="tooltip" data-placement="top" title="Add New Cheque Book"><i class="fa fa-plus"></i> New Cheque Book</button>
                </div>
            </div>
            <div class="box-tools float-right">
                <button type="button" class="btn btn-box-tool btn-light" id="refresh" data-toggle="tooltip" data-placement="top" title="Refresh"><i class="fa fa-sync-alt"></i></button>
            </div><!-- /.box-tools -->
        </div><!-- /.box-header -->

        <div class="box-body">
            <table id="general_datatable" class="table table-striped table-custom">
                <thead class="thead-inverse">
                     <tr>
                        <th>#</th>
                        <th>Cheque Book No</th>
                        <th>Bank Name</th>
                        <th>Account Name</th>
                        <th>Account No</th>
                        <th>Issue Date</th>
                        <th>Used Leaf</th>
                        <th>Unused Leaf</th>
                        <th>Wasted Leaf</th>
                        <th>Error Leaf</th>
                        <th>Total Leaf</th>
                        <th data-orderable="false" class="no-print" style="width:110px;">Action</th>
                    </tr>
                </thead>
                <tbody>

                @foreach($cheque_book_info as $cheque_book)
                    <?php $query = DB::table('bank_cheque_leafs')->where('cheque_book_id', $cheque_book->cheque_book_id); ?>
                    <?php $used_leaf_count = $query->where('cheque_leaf_status', "Used")->count(); ?>
                    <?php $wasted_leaf_count = $query->where('cheque_leaf_status', "Wasted")->count(); ?>
                    <?php $error_leaf_count = $query->where('cheque_leaf_status', "Error")->count(); ?>

                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $cheque_book->cheque_book_no }}</td>
                        <td>{{ $cheque_book->bank_name }}</td>
                        <td>{{ $cheque_book->account_name }}</td>
                        <td>{{ $cheque_book->account_number }}</td>
                        <td>@if($cheque_book->issue_date > 0) {{ date('d/m/Y', strtotime($cheque_book->issue_date)) }} @endif</td>
                        <td>{{ $used_leaf_count }}</td>
                        <td>{{ ($cheque_book->number_of_leafs ) - $used_leaf_count - $wasted_leaf_count - $error_leaf_count }}</td>
                        <td>{{ $wasted_leaf_count }}</td>
                        <td>{{ $error_leaf_count }}</td>
                        <td>{{ $cheque_book->number_of_leafs }}</td>
                        <td>
                            <a href="{{ URL::to('/bank/view-cheque-book/' . $cheque_book->cheque_book_id) }}" class="btn btn-info btn-sm"><i class="fa fa-eye" aria-hidden="true"></i></a>
                            <button type="button" class="btn btn-warning btn-sm editChequeBook" id="{{ $cheque_book->cheque_book_id }}" data-url="{{ url('/bank/edit-cheque-book/' .  $cheque_book->cheque_book_id) }}"><i class="fa fa-edit" aria-hidden="true"></i></button>
                            <button type="button" class="ajaxDelete btn btn-danger btn-sm" data-href="{{ URL::to('/bank/delete-cheque-book/' . $cheque_book->cheque_book_id) }}" data-title="{{ $cheque_book->cheque_book_no }}" id="{{ $cheque_book->cheque_book_id }}"><i class="far fa-trash-alt" aria-hidden="true"></i></button>
                            <button type="button" class="btn <?php echo $cheque_book->cheque_book_status == 'open' ? 'btn-success' : 'btn-danger'; ?> btn-sm changeChequeBookStatus" id="{{ $cheque_book->cheque_book_id }}" data-status="<?php echo $cheque_book->cheque_book_status == 'open' ? 'close' : 'open'; ?>"><i class="fas <?php echo $cheque_book->cheque_book_status == 'open' ? 'fa-folder-open' : 'fa-folder'; ?>" aria-hidden="true"></i></button>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div><!-- /.box-body -->

        <div class="overlay" style="display: none;">
            <i class="fa fa-sync-alt fa-spin"></i>
        </div>
    </div>
</section>

@include('pages.banks.cheque-book-new-modal')
@include('pages.banks.cheque-book-edit-modal')

@endsection


@section('custom_js')
<script type="text/javascript">
//    function lpad(n, e, d) {
//        var o = ''; if(typeof(d) === 'undefined'){ d='0'; } if(typeof(e) === 'undefined'){ e=2; }
//        if(n.length < e){ for(var r=0; r < e - n.length; r++){ o += d; } o += n; } else { o=n; }
//        return o;
//    }


    function generate_last_leaf_number(){
        var leaf_count = $('#number_of_leafs').val();
        var first_leaf = $('#first_cheque_no').val();
        if (leaf_count && first_leaf){
            var number_length = first_leaf.length;
            var first_leaf_int = parseInt(first_leaf);
            var leaf_count_int = parseInt(leaf_count)-1;
            var value = first_leaf_int + leaf_count_int;

            $('#last_cheque_no').val(value);
        }
    }
    $('#number_of_leafs').change(generate_last_leaf_number);
    $('#first_cheque_no').change(generate_last_leaf_number);


    $(document).ready(function(){
        $('button.showNewChequeBookModal').on('click', function () {
            var modal = $("#newChequeBookModal");
            modal.modal({ backdrop: "static", keyboard: true });
            modal.on('shown.bs.modal', function(){ $(":input[type='text']:enabled:visible:first").focus(); });
        });

        $(document).on('change', 'select#bank_account_id', function () {
            var bank_account_id = $(this).find('option:selected').val();
            if(!bank_account_id) return;

            $.ajax({
                url : "{{ url('/bank/get-account-data') }}",
                type : "GET",
                dataType : "json",
                data: {id: bank_account_id },
                success:function( data ){
                    $("input#account_number").val( data[0].account_number );
                    $("input#bank_name").val( data.bank_name );
                    $("input#branch").val( data[0].branch );
                },
                beforeSend: function( xhr ) { $(".ajax-loader").show('slow'); },
                complete: function( jqXHR, textStatus ) { $(".ajax-loader").hide('fast'); },
            });
        });


        $(document).on('click', 'button.changeChequeBookStatus', function () {
            var status = $(this).data('status');
            var id = $(this).attr('id');
            var $this = $(this);
            var parent = $(this).parent('td');

            $.ajaxSetup({
                headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') }
            });

            if( !confirm("Are you sure to Cheque Book. If close then this Cheque Book are not show to all location.")){ return; }

            $.ajax({
                url : "{{ url('/bank/cheque-book-status') }}/"+ id +"/"+ status,
                type : "POST",
                dataType : "json",
                //data: {cheque_book_id: cheque_book_id },
                success:function( data ){
                    if(data.cheque_book_status == "open"){
                        $this.remove();
                        parent.append('<button type="button" class="btn btn-success btn-sm changeChequeBookStatus" id="'+data.cheque_book_id+'" data-status="close"><i class="fas fa-folder-open" aria-hidden="true"></i></button>');
                    }else{
                        $this.remove();
                        parent.append('<button type="button" class="btn btn-danger btn-sm changeChequeBookStatus" id="'+data.cheque_book_id+'" data-status="open"><i class="fas fa-folder" aria-hidden="true"></i></button>');
                    }
                },
                beforeSend: function( xhr ) { $(".ajax-loader").show('slow'); },
                complete: function( jqXHR, textStatus ) { $(".ajax-loader").hide('fast'); },
            });
        });
    }); //End of Document ready


    $(document).ready(function(){
        $(document).on('click', 'button.editChequeBook', function () {

            if( !confirm("Are you sure to edit Cheque Book. If edited then this Cheque Book's old leafs are deleted permanently and created newly.")){ return; }

            var url = $(this).data('url');
            var id = $(this).attr('id');
            var modal = $("#editChequeBookModal");

            $.ajax({
                url: url,
                method: "get",
                data: { id: id },
                dataType: "json",
                success: function( response ) {
                    modal.find('.modal-title').text( "Update Cheque Book" );
                    modal.find('input[name=cheque_book_id]').val( response.cheque_book_id );
                    modal.find('#cheque_book_no').val( response.cheque_book_no );
                    modal.find('#bank_name').val( response.bank_name );
                    modal.find('#branch').val( response.branch );
                    modal.find("select#bank_account_id option[value=" + response.bank_account_id +"]").prop("selected", true);

                    //modal.find('select#bank_account_id').html( '<option value="'+response.bank_account_id+'">'+response.account_name+'</option>' );
                    modal.find('#account_number').val( response.account_number );
                    modal.find('#issue_date').val( response.issue_date.split('-')[2]+"/"+response.issue_date.split('-')[1]+"/"+response.issue_date.split('-')[0] );
                    modal.find('#leaf_prefix').val( response.leaf_prefix );
                    modal.find('#number_of_leafs').val( response.number_of_leafs );
                    modal.find('#first_cheque_no').val( response.first_cheque_no );
                    modal.find('#last_cheque_no').val( response.last_cheque_no );

                    modal.modal({ backdrop: "static", keyboard: true });
                    modal.on('shown.bs.modal', function(){ $(":input[type='text']:enabled:visible:first").focus(); });
                },
                statusCode:{ 404: function(){ alert( "page not found" ); } },
                beforeSend: function( xhr ) { $(".ajax-loader").show(); },
                complete: function( jqXHR, textStatus ) { $(".ajax-loader").hide(); },
            });
        });
    }); //End of Document ready

</script>
@endsection

