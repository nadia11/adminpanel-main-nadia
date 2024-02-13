@extends('dashboard')
@section('main_content')

<section class="content">
    <div class="box box-success animated fadeInRight">
        <div class="box-header with-border">
            <h2 class="box-title">Department wise Employee List</h2>
            <div class="box-tools float-right">
                <button type="button" class="btn btn-box-tool" id="refresh" data-toggle="tooltip" data-placement="top" title="Refresh"><i class="fa fa-sync-alt"></i></button>
                <button type="button" class="btn btn-box-tool" data-toggle="tooltip" data-placement="top" title="Collapse"><i class="fa fa-minus"></i></button>
                <button type="button" class="btn btn-box-tool" data-toggle="tooltip" data-placement="top" title="Remove"><i class="fa fa-times"></i></button>
            </div><!-- /.box-tools -->
        </div><!-- /.box-header -->

        <div class="box-body">
            <table id="general_datatable" class="table table-custom">
                <thead class="thead-inverse">
                    <tr>
                        <th>#</th>
                        <th>Card ID</th>
                        <th>Employee Name</th>
                        <th>District Name</th>
                        <th>Mobile</th>
                        <th>Branch</th>
                        <th>Designation</th>
                        <th>Department</th>
                        <th>Gender</th>
                        <th>Joining Date</th>
                    </tr>
                </thead>
                <tbody>
                @foreach($all_employee_info as $employee)
                    <tr id="{{ $employee->employee_id }}" class="animated slideInUp">
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $employee->employee_id }}</td>
                        <td style="text-align: left;">
                            <img src="<?php if(!empty($employee->employee_photo)){ echo upload_url( $employee->employee_photo ); }else{ echo image_url('defaultAvatar.jpg'); } ?>" style="border-radius: 50%; width: 30px; height: 30px; border: 1px solid #eee; box-shadow: 0 0 3px rgba(0,0,0,.3); padding: 1px;" />
                            {{ $employee->employee_name }}
                        </td>
                        <td>{{ $employee->district_name }}</td>
                        <td>{{ $employee->employee_mobile }}</td>
                        <td>{{ $employee->branch_id }}</td>
                        <td>{{ $employee->designation_name }}</td>
                        <td>{{ $employee->department_name }}</td>
                        <td>{{ $employee->employee_gender }}</td>
                        <td>{{ $employee->joining_date }}</td>
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

@endsection
