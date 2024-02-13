@extends('dashboard')
@section('main_content')

<section class="content">
    <div class="box box-success animated fadeInLeft">
        <div class="box-header with-border">
            <h2 class="box-title"><i class="fa fa-file-alt" aria-hidden="true"></i> Showing All News</h2>
            <div class="box-tools float-right">
                <button type="button" class="btn btn-info btn-sm" data-toggle="modal" data-target="#showNewNewsModal"><i class="fa fa-plus"></i> New News</button>
                <button type="button" class="btn btn-box-tool" id="refresh" data-toggle="tooltip" data-placement="top" title="Refresh"><i class="fa fa-sync-alt"></i></button>
            </div><!-- /.box-tools -->
        </div><!-- /.box-header -->

        <div class="box-body table-responsive">
            <table id="general_datatable" class="table table-custom">
                <thead class="thead-inverse">
                    <tr>
                        <th>#</th>
                        <th style="width: 20%;">News Title</th>
                        <th style="width: 50%;">News Body</th>
                        <th>Category</th>
                        <th>Status</th>
                        <th data-orderable="false">Photo</th>
                        <th data-orderable="false" class="no-print" style="width:60px;">Action</th>
                    </tr>
                </thead>
                <tbody>
                @php $status_class = array('published'=>'btn-success', 'draft'=>'btn-warning') @endphp
                @foreach($all_news_info as $news)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td class="text-left">{{ $news->news_title }}</td>
                        <td class="text-justify">{{ Str::limit($news->news_body, 150) }}</td>
                        <td>{{ $news->category_id ?? "-" }}</td>
                        <td><button type="button" class="btn {{ $status_class[$news->news_status] }} btn-sm news-status" data-status="{{ $news->news_status }}" id="{{ $news->news_id }}" data-href="{{ URL::to('news-status/'. $news->news_id) }}">{{ str_snack($news->news_status) }}</button></td>
                        <td><img src="<?php if(!empty($news->news_picture)){ echo upload_url( "/news/". $news->news_picture ); } else { echo image_url('defaultAvatar.jpg'); } ?>" style="width: 50px; height: 50px; border: 1px solid #eee; box-shadow: 0 0 2px rgba(0,0,0,.3); padding: 1px; margin: 0px;" /></td>
                        <td style="white-space: nowrap;">
                            <button type="button" class="btn btn-info btn-sm view-news" id="{{ $news->news_id }}"><i class="fa fa-eye" aria-hidden="true"></i></button>
                            <button type="button" class="btn btn-warning btn-sm editNews" id="{{ $news->news_id }}"><i class="fa fa-edit" aria-hidden="true"></i></button>
                            <button type="button" class="ajaxDelete btn btn-danger btn-sm" data-href="{{ URL::to('/news/delete-news/' . $news->news_id) }}" data-title="{{ $news->news_title }}" id="{{ $news->news_id }}"><i class="far fa-trash-alt" aria-hidden="true"></i></button>
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

@include('pages.event-and-news.news-new-modal')
@include('pages.event-and-news.news-edit-modal')
@include('pages.event-and-news.news-view-modal')
@include('pages.event-and-news.news-status-modal')

@endsection


@section('custom_js')
<script type="text/javascript">
$(document).ready(function(){
    $(document).on('click', 'button.editNews', function () {

        var id = $(this).attr('id');
        var modal = $("#editNewsModal");

        $.ajax({
            url: "{{ url('/news/edit-news') }}/"+id,
            method: "get",
            dataType: "json",
            success: function( response ) {
                modal.find('.modal-title').text( "Update News" );
                modal.find('input[name=news_id]').val( response[0].news_id );
                modal.find('#news_title').val( response[0].news_title );
                modal.find('#news_body').val( response[0].news_body );
                modal.find("select#news_status option[value=" + response[0].news_status +"]").prop("selected", true);
                modal.find("select#category_id option[value=" + response[0].category_id +"]").prop("selected", true);

                modal.find('#news_picture_prev').val( response[0].news_picture );
                modal.find('#news_picture').parent('.custom-file').find('label.custom-file-label').html( response[0].news_picture ? response[0].news_picture : "No Attachment"  );
                if(response[0].news_picture){ modal.find('#news_picture').removeAttr('required'); }

                modal.modal({ backdrop: "static", keyboard: true });
                modal.on('shown.bs.modal', function(){ $(":input[type='text']:enabled:visible:first").focus(); });
            },
            beforeSend: function( xhr ) { $(".ajax-loader").show(); },
            complete: function( jqXHR, textStatus ) { $(".ajax-loader").hide(); },
        });
    });

    $(document).on('click', 'button.view-news', function () {
        var id = $(this).attr('id');
        var modal = $("#view_news_modal");

        $.ajax({
            url: "{{ url('/news/view-news') }}/" + id,
            method: "get",
            dataType: "json",
            success: function( response ) {
                modal.find('.modal-title').text( "View Details of News ("+ response[0].news_title +")" );
                modal.find('.news_title').text( response[0].news_title );
                modal.find('.news_body').text( response[0].news_body );
                modal.find('.news_status').text( response[0].news_status );
                modal.find('.category_id').text( response[0].category_id );
                modal.find('#news_picture').attr('src', '{{ upload_url( "/news/") }}' + response[0].news_picture);

                modal.modal("show");
            },
            beforeSend: function( xhr ) { $(".ajax-loader").show('slow'); },
            complete: function( jqXHR, textStatus ) { $(".ajax-loader").hide('fast'); },
        });
    });

    $(document).on('click', 'button.news-status', function (e) {
        e.preventDefault();
        var modal = $("#news_status_modal");

        modal.find("select#news_status option[value="+ $(this).data('status') +"]").prop("selected", true);
        modal.find('input[name=news_id]').val( $(this).attr('id') );
        modal.modal('show');
    });

    $("form#changeNewsStatus").submit(function (event) {
        event.preventDefault();
        $("button[type=submit]").attr('disabled', 'disabled').html("<i class='fa fa-floppy-disk'></i> Saving...");

        var form = $(this);
        var news_status = form.find('select#news_status').val();
        var news_id = form.find('input[name=news_id]').val();
        var url = form.attr("action");
        var status_class_array = { 'draft':'btn-warning', 'published':"btn-success" };

        $.ajaxSetup({
            headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') }
        });

        $.ajax({
            type: "POST",
            url: url,
            data: {news_id: news_id, news_status: news_status},
            dataType: 'json',
            success: function (response) {
                $("button#"+news_id+".news-status").text( capitalizeFirstLetter(response.news_status.replace('_', ' ').replace('_', ' ')) );
                $("button#"+news_id+".news-status").attr('data-status', response.news_status.replace('_', ' ').replace('_', ' ') );
                $("button#"+news_id+".news-status").removeAttr('class').attr('class', 'btn btn-sm news-status '+ status_class_array[response.news_status]);

                toastr.success( response.success );
                $('#news_status_modal').modal('hide');
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

