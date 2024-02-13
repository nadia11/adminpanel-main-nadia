@extends('dashboard')
@section('main_content')

<section class="content">
    <div class="box box-success animated fadeInLeft">
        <div class="box-header with-border">
            <h2 class="box-title"><i class="fa fa-file-alt" aria-hidden="true"></i> Showing Searching Trips</h2>
            <div class="box-tools float-right">
                <button type="button" class="btn btn-box-tool" id="refresh" data-toggle="tooltip" data-placement="top" title="Refresh"><i class="fa fa-sync-alt"></i></button>
            </div><!-- /.box-tools -->
        </div><!-- /.box-header -->

        <div class="box-body">
            <table id="general_datatable" class="table table-custom table-center">
                <thead class="thead-inverse">
                    <tr>
                        <th>#</th>
                        <th>Rider Name</th>
                        <th>Trip From</th>
                        <th>Trip To</th>
                        <th>Date & Time</th>
                        <th>Distance</th>
                        <th>Fare</th>
                        <th>Platform</th>
                        <th class="hide">Rider Mobile</th>
                        <th class="hide">Today's Trip Search Filter</th>
                        <th class="hide">This Month Trip Search Filter</th>
                    </tr>
                </thead>
                <tbody>
                @foreach($all_searching_info as $trip)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>@if($trip->rider_name)<a href="{{ url('rider/all-riders?rider_mobile='.$trip->rider_mobile)}}" target="_blank" data-toggle="tooltip" data-placement="top" title="Go to see Driver's details">{{ $trip->rider_name }}</a>@else - @endif</td>
                        <td>{{ Illuminate\Support\Str::limit($trip->trip_from, 30, '...') }}</td>
                        <td>{{ Illuminate\Support\Str::limit($trip->trip_to, 30, '...') }}</td>
                        <td>{{ date('d/m/y h:s A', strtotime($trip->searching_time)) }}</td>
                        <td>{{ $trip->distance }}</td>
                        <td>{{ $trip->fare ? taka_format('', $trip->fare) : "0.00" }}</td>
                        <td>{{ str_snack($trip->platform) }}</td>
                        <td class="hide">{{ $trip->rider_mobile }}</td>
                        <td class="hide">{{ date('d/m/Y', strtotime($trip->searching_time)) }}</td>
                        <td class="hide">{{ date('m/Y', strtotime($trip->searching_time)) }}</td>
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


@section('custom_js')
<script type="text/javascript">
$(document).ready(function(){

}); //End of Document ready
</script>
@endsection

