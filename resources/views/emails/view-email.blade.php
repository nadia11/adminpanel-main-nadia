@extends('dashboard')
@section('main_content')

    <section class="content">
        <div class="row">
            <div class="col-2">
                @include('emails.email-sidebar')
            </div>

            <div class="col-10">
                <div class="email-content box box-info animated fadeInRight">
                    <div class="box-header with-border">
                        <h2 class="box-title">
                            {{ $email_data->subject }}
                        </h2>
                        <div class="box-tools float-right">
                            <button type="button" class="btn btn-box-tool" id="refresh" data-toggle="tooltip" data-placement="top" title="Refresh"><i class="fa fa-sync-alt"></i></button>
                            <button type="button" class="btn btn-box-tool" data-toggle="tooltip" data-placement="top" title="Collapse"><i class="fa fa-minus"></i></button>
                            <button type="button" class="btn btn-box-tool" data-toggle="tooltip" data-placement="top" title="Remove"><i class="fa fa-times"></i></button>
                        </div>
                    </div><!-- /.box-header -->

                    <div class="box-body">
                        <h5>{{ $email_data->from }}</h5>
                        <p>{{ $email_data->message }}</p>
                    </div>
                    <div class="box-footer">
                        {{ $email_data->attachment }}
                    </div>
                </div>
            </div>
        </div><!-- /.row -->

        <div class="overlay" style="display: none;">
            <i class="fa fa-sync-alt fa-spin"></i>
        </div>
    </section>
@endsection


