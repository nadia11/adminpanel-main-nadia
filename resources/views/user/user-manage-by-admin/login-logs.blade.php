@extends('dashboard')
@section('main_content')

<section class="content-wrapper">
    <div class="box box-primary">
        <div class="box-header with-border">
            <i class="fa fa-sign-out-alt"></i>
            <h2 class="box-title">Login Logs</h2>
            <div class="box-tools float-right">
                <a class="btn btn-warning float-left" href="{{ URL::to('/admin/user-management') }}"><i class="fa fa-chevron-left" aria-hidden="true"></i> Back to User Management</a>
            </div><!-- /.box-tools -->
        </div><!-- /.box-header -->

        <div class="box-body">
            <table id="general_datatable" class="table table-custom table-bordered">
                <thead class="thead-inverse">
                    <tr>
                        <th>#</th>
                        <th>User Name</th>
                        <th>User Agent</th>
                        <th>Agent OS</th>
                        <th>IP Address</th>
                        <th>Login Time</th>
                        {{--<th style="min-width:110px;" data-orderable="false" class="no-print">Action</th>--}}
                    </tr>
                </thead>
                <tbody>
                    @foreach( $login_logs as $log )
                    <tr id="{{ $log->login_log_id }}">
                        <td>{{ $loop->iteration }}</td>
                        <td>@if( $log->user_id ) <a href="{{ URL::to('/admin/user-management?user_name='. $log->user_name ) }}" target="_blank">{{ $log->user_name }}</a>@else N/A @endif</td>
                        <td>{{ $log->user_agent }}</td>
                        <td>{{ $log->agent_os }}</td>
                        <td>{{ $log->login_ip }}</td>
                        <td>{{ $log->login_time }}</td>
                        {{--<td><button type="button" class="btn btn-link btn-lg text-danger ajaxDelete" data-href="{{ URL::to( '/admin/delete-login-log/' . $log->login_log_id) }}" data-title="{{ $log->user_name }}" id="{{ $log->login_log_id }}"><i class="fa fa-times" aria-hidden="true"></i></button></td>--}}
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

@endsection

