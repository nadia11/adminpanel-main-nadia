@extends('dashboard')
@section('main_content')

<section class="content-wrapper">
    <div class="box box-primary">
        <div class="box-header with-border">
            <i class="fa fa-users"></i>
            <h2 class="box-title">Rolewise User List</h2>
            <div class="box-tools float-right">
                <a class="btn btn-warning float-left" href="{{ URL::to('/admin/user-management') }}"><i class="fa fa-chevron-left" aria-hidden="true"></i> Back to User Management</a>
            </div><!-- /.box-tools -->
        </div><!-- /.box-header -->

        <div class="box-body">
            <table id="general_datatable" class="table table-custom">
                <thead class="thead-inverse">
                <tr>
                    <th>#</th>
                    <th data-orderable="false" style="width: 5px;"><input type="checkbox" class="select-all filled-in" name="select_all" id="select-all" value="all" /><label for="select-all"></label></th>
                    <th>User Name</th>
                    <th>Mobile</th>
                    <th>Email</th>
                    <th>User Role</th>
                    <th>Status</th>
                    <th data-orderable="false">Photo</th>
                </tr>
                </thead>
                <tbody>
                @foreach( $user_data as $user )
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td><input type="checkbox" name="id[]" id="{{ $user->id }}" class="filled-in" value="{{ $user->id }}" /><label for="{{ $user->id }}"></label></td>
                        <td class="text-left">{{ $user->name }}</td>
                        <td>{{ $user->mobile }}</td>
                        <td>{{ $user->email }}</td>
                        <td>{{ str_snack($user->role_name) }}</td>
                        <td><button type="button" class="btn <?php if($user->status == 'Pending'){ echo 'btn-warning'; }else if($user->status == 'Denied'){ echo 'badge-danger'; }else{ echo 'badge-success'; } ?> btn-sm change-status" id="{{ $user->id }}"><?php if($user->status == 'Pending'){ echo 'Pending'; }else if($user->status == 'Denied'){ echo 'Denied'; }else{ echo 'Approved'; } ?></button></td>
                        <td><img src="<?php if(!empty($user->photo)){ echo public_url( "user-photo/". $user->photo ); }else{ echo image_url('defaultAvatar.jpg'); } ?>" style="border-radius: 50%; width: 35px; height: 35px; border: 1px solid #eee; box-shadow: 0 0 3px rgba(0,0,0,.3); padding: 1px; margin: -10px;" /></td>
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
