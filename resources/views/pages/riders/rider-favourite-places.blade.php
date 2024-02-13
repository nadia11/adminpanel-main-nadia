@extends('dashboard')
@section('main_content')

<section class="content">
    <div class="box box-success animated fadeInLeft">
        <div class="box-header with-border">
            <h2 class="box-title"><i class="fa fa-file-alt" aria-hidden="true"></i> Showing Favourite Places</h2>
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
                        <th>Title</th>
                        <th>Location Name</th>
                        <th>LatLong</th>
                        <th>Date</th>
                        <th class="hide">Rider Mobile</th>
                    </tr>
                </thead>
                <tbody>
                @foreach($all_favorite_place_info as $places)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>@if($places->rider_name)<a href="{{ url('rider/all-riders?rider_mobile='.$places->rider_mobile)}}" target="_blank" data-toggle="tooltip" data-placement="top" title="Go to see Rider's details">{{ $places->rider_name }}</a>@else - @endif</td>
                        <td>{{ $places->main_text }}</td>
                        <td>{{ $places->secondary_text }}</td>
                        <td>{{ $places->latitude .",". $places->longitude }}</td>
                        <td>{{ date('d/m/Y', strtotime($places->created_at)) }}</td>
                        <td class="hide">{{ $places->rider_mobile }}</td>
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

