@extends('dashboard')
@section('main_content')

<section class="content">
    <div class="box box-success animated fadeInLeft">
        <div class="box-header with-border">
            <h2 class="box-title"><i class="fa fa-file-alt" aria-hidden="true"></i> Showing Credit Card</h2>
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
                        <th>Icon</th>
                        <th>Card Type</th>
                        <th>Card Holder Name</th>
                        <th>Card Number</th>
                        <th>Expires Date</th>
                        <th>CVV Number</th>
                        <th>Date</th>
                        <th class="hide">Rider Mobile</th>
                    </tr>
                </thead>
                <tbody>
                @foreach($all_card_info as $card)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>@if($card->rider_name)<a href="{{ url('rider/all-riders?rider_mobile='.$card->rider_mobile)}}" target="_blank" data-toggle="tooltip" data-placement="top" title="Go to see Driver's details">{{ $card->rider_name }}</a>@else - @endif</td>
                        <td><i class="fa fa-{{ $card->icon }}"></i> </td>
                        <td>{{ $card->card_type }}</td>
                        <td>{{ str_snack($card->card_holder_name) }}</td>
                        <td>{{ $card->card_number }}</td>
                        <td>{{ $card->expires_at }}</td>
                        <td>{{ $card->cvv_number }}</td>
                        <td>{{ date('d/m/Y', strtotime($card->created_at)) }}</td>
                        <td class="hide">{{ $card->rider_mobile }}</td>
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
