<div class="profile-details">
    <p style="font-size: 30px; margin: 0; font-weight: bold; color: #c0392b;">{{ $driver_info->driver_name }}</p>
    <table class="table table-bordered">
        <tr>
            <th width="25%">Name</th>
            <td>{{ $driver_info->driver_name }}</td>
        </tr>
        <tr>
            <th>Address</th>
            <td>{{ $driver_info->address }}</td>
        </tr>
        <tr>
            <th>Mobile No</th>
            <td>{{ $driver_info->mobile }}</td>
        </tr>
        <tr>
            <th>Date of Birth</th>
            <td>@if($driver_info->date_of_birth > 0) {{ date('d/m/Y', strtotime($driver_info->date_of_birth)) }} @endif</td>
        </tr>
        <tr>
            <th>Blood Group</th>
            <td>{{ str_replace("_pos", "+", str_replace("_neg", "-", $driver_info->blood_group) ) }}</td>
        </tr>
        <tr>
            <th>Gender</th>
            <td>{{ $driver_info->gender }}</td>
        </tr>
        <tr>
            <th>Registration Date</th>
            <td>@if($driver_info->reg_date>0) {{ date('d/m/Y', strtotime($driver_info->reg_date)) }} @endif</td>
        </tr>
        <tr>
            <th>E-mail</th>
            <td>{{ $driver_info->email }}</td>
        </tr>
        <tr>
            <th>User Name</th>
            <td>@php //$user_info = get_userdata( $driver_info->user_id ); echo $user_info->user_login; //echo get_user_meta( $driver_info->user_id, 'user_login', true ) @endphp</td>
        </tr>
        <tr>
            <th>Language</th>
            <td>English</td>
        </tr>
    </table>
</div><!-- .site-main -->
