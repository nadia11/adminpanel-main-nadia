@extends('dashboard')
@section('main_content')

<section class="content">
    <div class="row">
        <div class="col-2">
            @include('emails.email-sidebar')
        </div>

        <div class="col-10">
            <div class="email-content box box-info animated fadeInRight" style="background: none;">
                <div class="box-header with-border" style="background: #ffffff;">
                    <h2 class="box-title">Spam</h2>
                    <div class="box-tools float-right">
                        <button type="button" class="btn btn-box-tool" id="refresh" data-toggle="tooltip" data-placement="top" title="Refresh"><i class="fa fa-sync-alt"></i></button>
                        <button type="button" class="btn btn-box-tool" data-toggle="tooltip" data-placement="top" title="Collapse"><i class="fa fa-minus"></i></button>
                        <button type="button" class="btn btn-box-tool" data-toggle="tooltip" data-placement="top" title="Remove"><i class="fa fa-times"></i></button>
                    </div>
                </div><!-- /.box-header -->

                <div class="box-body" style="padding: 0;">
                    <table class="table table-custom email-content">
                        <tbody>
                        @foreach($email_data as $email)
                            <tr id="{{ $email->email_id }}" class="animated slideInUp view-email">
                                <td class="view-btn">
                                    <div class="email-action-btn1">
                                        <input type="checkbox" name="id[]" id="{{ $email->email_id }}" class="filled-in" value="{{ $email->email_id }}" /><label for="{{ $email->email_id }}"></label>
                                        <button class="btn btn-sm" type="button"><i class="fa fa-star text-yellow"></i></button>
                                    </div>
                                </td>
                                <td>{{ $email->from }}</td>
                                <td>{{ $email->subject }} - {{ $email->message }}</td>
                                <td class="view-btn">
                                    <div class="email-action-btn">
                                        <button type="button" class="btn btn-sm softDelete" id="{{ $email->email_id }}"><i class="fa fa-trash fa-lg" aria-hidden="true"></i></button>
                                        <button type="button" class="btn btn-sm read-unread-email" data-toggle="tooltip" data-placement="bottom" title="Mark as unread" id="1"><i class="fa fa-envelope fa-lg"></i></button>
                                    </div>
                                </td>
                                <td class="attachment">@if($email->attachment)<i class="fa fa-paperclip"></i>@endif</td>
                                <td class="date">{{ human_date($email->email_date) }}</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div><!-- /.box -->
            </div><!-- /.box-body -->
        </div><!-- /.col-3 -->
    </div><!-- /.row -->

    <div class="overlay" style="display: none;">
        <i class="fa fa-sync-alt fa-spin"></i>
    </div>
</section>

@endsection

