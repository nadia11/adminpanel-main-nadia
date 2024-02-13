
<div class="table-responsive" style="min-height: 250px; border: 1px solid #ddd;">
    <table class="table table-striped table-custom">
        <thead class="thead-light">
        <tr>
            <th>#</th>
            <th>Client Name</th>
            <th>Client Address</th>
            <th>Contract Person</th>
            <th>Contract Person Mobile</th>
        </tr>
        </thead>
        <tbody>
        @php $employee_id = $employee_data->employee_id @endphp
        @php $exist_account = DB::table('clients')->where('employee_id', $employee_id)->exists() @endphp

        @if( $exist_account )
            @php $all_client_info = DB::table('clients')->where('employee_id', $employee_id)->get() @endphp
            @foreach($all_client_info as $client)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td><a href="{{ url('client/view/' . $client->client_id) }}" target="_blank" data-toggle="tooltip" data-placement="right" title="Click to see client details">{{ $client->client_name }}</a></td>
                    <td>{{ $client->client_address }}</td>
                    <td>{{ $client->contract_person_name }}</td>
                    <td>{{ $client->contract_person_mobile }}</td>
                </tr>
            @endforeach

        @else
            <tr><td colspan="5" style="height: 100px; text-align:center; font-size: 16px;">No Account Found. Please Create Account first.</td></tr>
        @endif
        </tbody>
    </table>
</div>
