<div class="profile-details">
    <p style="font-size: 30px; margin: 0 0 30px; font-weight: bold; color: #c0392b; border-bottom: 1px solid #ccc;">Tax Details</p>

    <table id="general_datatable" class="table table-bordered text-center">
        <thead class="thead-inverse">
            <tr>
                <th>#</th>
                <th>Year</th>
                <th>Payment Date</th>
                <th>Tax Type</th>
                <th>Status</th>
                <th>Amount</th>
                <th>Vehicle Number</th>
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
{{--            </tr>--}}
{{--        endforeach--}}
        </tbody>
    </table>
</div>

<div class="profile-details" style="margin-top: -5% !important">
    <p style="font-size: 30px; margin: 0 0 30px; font-weight: bold; color: #c0392b; border-bottom: 1px solid #ccc;">Insurance Details</p>

    <table id="general_datatable" class="table table-bordered text-center">
        <thead class="thead-inverse">
        <tr>
            <th>#</th>
            <th>Year</th>
            <th>Payment Date</th>
            <th>Insurance Type</th>
            <th>Status</th>
            <th>Amount</th>
            <th>Vehicle Number</th>
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
        {{--            </tr>--}}
        {{--        endforeach--}}
        </tbody>
    </table>
</div>