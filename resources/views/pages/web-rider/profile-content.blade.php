<div class="profile-details">
    <p style="font-size: 30px; margin: 0; font-weight: bold; color: #c0392b;">{{ $rider_info->rider_name }}</p>
    <table class="table table-bordered">
        <tr>
            <th width="25%">Name</th>
            <td>{{ $rider_info->rider_name }}</td>
        </tr>
        <tr>
            <th>Address</th>
            <td>{{ $rider_info->address }}</td>
        </tr>
        <tr>
            <th>Mobile No</th>
            <td>{{ $rider_info->mobile }}</td>
        </tr>
        <tr>
            <th>Date of Birth</th>
            <td>@if($rider_info->dob>0) {{ date('d/m/Y', strtotime($rider_info->dob)) }} @endif</td>
        </tr>
        <tr>
            <th>Blood Group</th>
            <td>{{ str_replace("_pos", "+", str_replace("_neg", "-", $rider_info->blood_group) ) }}</td>
        </tr>
        <tr>
            <th>Gender</th>
            <td>{{ $rider_info->gender }}</td>
        </tr>
        <tr>
            <th>Registration Date</th>
            <td>@if($rider_info->reg_date>0) {{ date('d/m/Y', strtotime($rider_info->reg_date)) }} @endif</td>
        </tr>
        <tr>
            <th>E-mail</th>
            <td>{{ $rider_info->email }}</td>
        </tr>
        <tr>
            <th>User Name</th>
            <td>@php //$user_info = get_userdata( $rider_info->user_id ); echo $user_info->user_login; //echo get_user_meta( $rider_info->user_id, 'user_login', true ) @endphp</td>
        </tr>
        <tr>
            <th>Wallet Balance</th>
            <td></td>
        </tr>
        <tr>
            <th>Language</th>
            <td>English</td>
        </tr>
    </table>
</div><!-- .site-main -->