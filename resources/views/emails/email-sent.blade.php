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
                    <h2 class="box-title">Sent Items</h2>
                    <div class="box-tools float-right">
                        <form method="get" class="search-contact-form" action="#" role="search">
                            <div class="input-group">
                                <input type="search" id="s" name="s" class="form-control" placeholder="Search for a username" />
                                <div class="input-group-append">
                                    <button type="reset" class="btn btn-danger close-search-contact-form"><i class="fa fa-times"></i></button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div><!-- /.box-header -->

                <div class="box-body" style="padding: 0;">
                    <div class="mail-option">
                        <div class="chk-all btn-group hidden-phone select-checkbox-wrap">
                            <nav class="navbar navbar-expand-sm">
                                <input type="checkbox" class="mail-checkbox mail-group-checkbox">
                                <a data-toggle="dropdown" href="#" aria-expanded="false"> <i class="fa fa-angle-down"></i></a>
                                <ul class="dropdown-menu animated fadeInDown">
                                    <li class="nav-item"><a href="#" class="nav-link">None</a></li>
                                    <li class="nav-item"><a href="#" class="nav-link">None</a></li>
                                    <li class="nav-item"><a href="#" class="nav-link">Read</a></li>
                                    <li class="nav-item"><a href="#" class="nav-link">Unread</a></li>
                                </ul>
                            </nav>
                        </div>


                        <div class="btn-group">
                            <button type="button" class="btn btn-light" id="refresh" data-toggle="tooltip" data-placement="top" title="Refresh"><i class="fa fa-sync-alt"></i></button>
                        </div>
                        <div class="btn-group hidden-phone">
                            <nav class="navbar navbar-expand-sm">
                                <a data-toggle="dropdown" href="#" class="btn mini blue" aria-expanded="false">More <i class="fa fa-angle-down"></i></a>
                                <ul class="dropdown-menu animated fadeInDown">
                                    <li class="nav-item"><a href="#" class="nav-link"><i class="fa fa-pencil"></i> Mark as Read</a></li>
                                    <li class="nav-item"><a href="#" class="nav-link"><i class="fa fa-ban"></i> Spam</a></li>
                                    <li class="divider"></li>
                                    <li class="nav-item"><a href="#" class="nav-link"><i class="fa fa-trash-o"></i> Delete</a></li>
                                </ul>
                            </nav>
                        </div>
                        <div class="btn-group">
                            <nav class="navbar navbar-expand-sm">
                                <a data-toggle="dropdown" href="#" class="btn">Move to <i class="fa fa-angle-down"></i></a>

                                <ul class="dropdown-menu animated fadeInDown">
                                    <li class="nav-item"><a href="#" class="nav-link"><i class="fa fa-pencil"></i> Mark as Read</a></li>
                                    <li class="nav-item"><a href="#" class="nav-link"><i class="fa fa-ban"></i> Spam</a></li>
                                    <li class="divider"></li>
                                    <li class="nav-item"><a href="#" class="nav-link"><i class="fa fa-trash-o"></i> Delete</a></li>
                                </ul>
                            </nav>
                        </div>

                        <ul class="unstyled inbox-pagination">
                            <li><span>1-50 of 234</span></li>
                            <li><a class="np-btn" href="#"><i class="fa fa-angle-left  pagination-left"></i></a></li>
                            <li><a class="np-btn" href="#"><i class="fa fa-angle-right pagination-right"></i></a></li>
                        </ul>
                    </div>
                    <table class="table table-custom email-content">
                        <tbody>
                        @foreach($email_data as $email)
                            <tr id="{{ $email->email_id }}" class="animated slideInUp view-email {{ $email->email_status =="read" ? "read" : "unread" }}">
                                <td class="view-btn">
                                    <div class="email-action-btn1">
                                        <input type="checkbox" name="id[]" id="{{ $email->email_id }}" class="filled-in" value="{{ $email->email_id }}" /><label for="{{ $email->email_id }}"></label>
                                        <button type="button" id="{{ $email->email_id }}" class="btn btn-sm set-email-star-btn" data-attribute="{{ $email->email_attribute == 'Starred' ? 'Starred' : 'Not starred' }}" title="{{ $email->email_attribute == 'Starred' ? 'Starred' : 'Not starred' }}"><i class="{{ $email->email_attribute == 'Starred' ? 'fas fa-star text-yellow' : 'far fa-star' }}" aria-hidden="true"></i></button>
                                    </div>
                                </td>
                                <td>To: {{ $email->to }}</td>
                                <td>{{ $email->subject }} - {{ $email->message }}</td>
                                <td class="view-btn">
                                    <div class="email-action-btn">
                                        <button type="button" class="btn btn-sm softDelete" id="{{ $email->email_id }}"><i class="fa fa-trash fa-lg" aria-hidden="true"></i></button>
                                        <button type="button" id="{{ $email->email_id }}" class="btn btn-sm change-email-status-btn" data-status="{{ $email->email_status == 'read' ? 'unread' : 'read' }}" data-toggle="tooltip" data-placement="bottom" title="Mark as {{ $email->email_status =="read" ? "unread" : "read" }}"><i class="fa fa-envelope{{ $email->email_status =="unread" ? "-open" : "" }} fa-lg" aria-hidden="true"></i></button>
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

