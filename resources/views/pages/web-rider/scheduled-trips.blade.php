<div class="profile-details">
    <p style="font-size: 30px; margin: 0 0 30px; font-weight: bold; color: #c0392b; border-bottom: 1px solid #ccc;">Scheduled Trips</p>

    <table id="general_datatable" class="table table-bordered text-center">
        <thead class="thead-inverse">
            <tr>
                <th>#</th>
                <th>Trip ID</th>
                <th>Driver Name</th>
                <th>Trip From</th>
                <th>Trip To</th>
                <th>Start Date & Time</th>
            </tr>
        </thead>
        <tbody>
            <tr><td colspan="10" class="py-5 text-center">No records to view</td></tr>

        {{--        foreach($all_shareholder_info as $shareholder)--}}
{{--            <tr>--}}
{{--                <td>{{ $loop->iteration }}</td>--}}
{{--                <td>{{ $shareholder->shareholder_name }}</td>--}}
{{--                <td>{{ $shareholder->mobile }}</td>--}}
{{--                <td>{{ $shareholder->email }}</td>--}}
{{--                <td>{{ $shareholder->district_id }}</td>--}}
{{--                <td>{{ $shareholder->branch_id }}</td>--}}
{{--                <td>{{ taka_format("", $shareholder->comission) }}</td>--}}
{{--                <td>---</td>--}}
{{--                <td>{{ $shareholder->status }}</td>--}}
{{--                <td><img src="<?php if(!empty($shareholder->shareholder_photo)){ echo upload_url( "shareholder-photo/". $shareholder->shareholder_photo ); }else{ echo image_url('defaultAvatar.jpg'); } ?>" style="border-radius: 50%; width: 40px; height: 40px; border: 1px solid #eee; box-shadow: 0 0 3px rgba(0,0,0,.3); padding: 1px; margin: 0px;" /></td>--}}
{{--                <td style="white-space: nowrap;">--}}
{{--                    <button type="button" class="btn btn-info btn-sm view-shareholder" id="{{ $shareholder->shareholder_id }}"><i class="fa fa-eye" aria-hidden="true"></i></button>--}}
{{--                    <button type="button" class="btn btn-warning btn-sm editShareholder" id="{{ $shareholder->shareholder_id }}"><i class="fa fa-edit" aria-hidden="true"></i></button>--}}
{{--                    --}}{{--<button type="button" class="ajaxDelete btn btn-danger btn-sm" data-href="{{ URL::to('/shareholder/delete-shareholder/' . $shareholder->shareholder_id) }}" data-title="{{ $shareholder->shareholder_number }} - {{ $shareholder->project_name }}" id="{{ $shareholder->shareholder_id }}"><i class="far fa-trash-alt" aria-hidden="true"></i></button>--}}
{{--                </td>--}}
{{--            </tr>--}}
{{--        endforeach--}}
        </tbody>
    </table>
</div>