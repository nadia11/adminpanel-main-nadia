@php $employee_id = $employee_data->employee_id @endphp

<?php $employee_info = DB::table('employees')
        ->leftjoin('districts', 'employees.district_id', '=', 'districts.district_id')
        ->leftjoin('departments', 'employees.department_id', '=', 'departments.department_id')
        ->leftjoin('designations', 'employees.designation_id', '=', 'designations.designation_id')
        //->join('users', function($join){ $join->on('employees.id', '=', 'employees.employee_id'); })
        ->select('employees.*', 'districts.district_name', 'departments.department_name', 'designations.designation_name')
        ->where('employee_id', $employee_id)
        ->get();
        ?>

@foreach( $employee_info as $employee )
<div class="row">
    <div class="col-2 text-center">
        <img class="img-thumbnail" src="<?php if(!empty($employee->employee_photo)){ echo upload_url("employee-photo/". $employee->employee_photo); }else{ echo image_url('defaultAvatar.jpg'); } ?>" style="border-radius: 5%; width: 200px; border: 1px solid #eee; box-shadow: 0 0 3px rgba(0,0,0,.3); padding: 3px; margin-bottom: 5px;" />
        <h3 class="text-center">{{ $employee->employee_name }}</h3>

        Scan below QR code
        <?php $qr_data = "Name: ". $employee->employee_name .", Mobile: ". $employee->employee_mobile.", Designation: ".$employee->designation_name.", District: ".$employee->district_name.", NID: ".$employee->employee_nid; ?>
        <img src="{{ "https://chart.googleapis.com/chart?chs=300x300&cht=qr&chl=". htmlspecialchars($qr_data) ."&choe=UTF-8" }}" style="border-radius: 5px; width: 200px; border: 2px solid #eee; padding:0; display: block;" />
    </div>

    <div class="col-5">
        <h2>Basic Information</h2>
        <table class="table table-bordered table-verticle">
            <tr>
                <th style="width: 25%;">Employee Name</th>
                <td style="width: 1%;">:</td>
                <td class="code">{{ $employee->employee_name }}</td>
            </tr>
            <tr>
                <th>Father's Name</th>
                <td>:</td>
                <td>{{ $employee->employee_fathers_name }}</td>
            </tr>
            <tr>
                <th>Department</th>
                <td>:</td>
                <td>{{ $employee->department_name }}</td>
            </tr>
            <tr>
                <th>Designation</th>
                <td>:</td>
                <td>{{ $employee->designation_name }}</td>
            </tr>
            <tr>
                <th>Mother's Name</th>
                <td>:</td>
                <td>{{ $employee->employee_mothers_name }}</td>
            </tr>
            <tr>
                <th>Address</th>
                <td>:</td>
                <td>{{ $employee->employee_address }}</td>
            </tr>
            <tr>
                <th>City</th>
                <td>:</td>
                <td>Division: {{ $employee->district_name }}, District: {{ $employee->district_name }}</td>
            </tr>
            <tr>
                <th>Gender</th>
                <td>:</td>
                <td>{{ $employee->employee_gender }}</td>
            </tr>
            <tr>
                <th>Marital Status</th>
                <td>:</td>
                <td>{{ $employee->marital_status }}</td>
            </tr>
            <tr>
                <th>Date of Birth</th>
                <td>:</td>
                <td><?php if($employee->employee_dob > 0): echo "<strong>" . htmlspecialchars( date('d/m/Y', strtotime($employee->employee_dob))) . "</strong>";  echo " (" . get_age( $employee->employee_dob ) . ")"; else: echo ''; endif; ?></td>
            </tr>
        </table>
    </div>
    <div class="col-5">
        <h2 style="color: transparent;">0</h2>
        <table class="table table-bordered table-verticle">
            <tr>
                <th style="width: 25%;">Mobile</th>
                <td style="width: 1%;">:</td>
                <td>{{ $employee->employee_mobile }}</td>
            </tr>
            <tr>
                <th>Alt. Mobile</th>
                <td>:</td>
                <td></td>
            </tr>
            <tr>
                <th>Email</th>
                <td>:</td>
                <td>{{ $employee->employee_email }}</td>
            </tr>
            <tr>
                <th>Birth Cer. no.</th>
                <td>:</td>
                <td></td>
            </tr>
            <tr>
                <th>National ID</th>
                <td>:</td>
                <td>{{ $employee->employee_nid }}</td>
            </tr>
            <tr>
                <th>Passport No.</th>
                <td>:</td>
                <td></td>
            </tr>
            <tr>
                <th>Skype</th>
                <td>:</td>
                <td></td>
            </tr>
            <tr>
                <th>Facebook</th>
                <td>:</td>
                <td></td>
            </tr>
            <tr>
                <th>Whats app</th>
                <td>:</td>
                <td></td>
            </tr>
            <tr>
                <th>Employee Note</th>
                <td>:</td>
                <td></td>
            </tr>
        </table>
    </div>
</div>

@endforeach
