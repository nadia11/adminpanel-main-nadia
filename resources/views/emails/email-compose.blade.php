@extends('dashboard')
@section('main_content')

<section class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-2">
                @include('emails.email-sidebar')
            </div><!-- /.col-2 -->

            <div class="col-10">
                <div class="email-content">
                    <div class="box box-info">
                        <form action="{{ route('send-email') }}" id="send-email" method="POST" enctype="multipart/form-data" class="form-horizontal">
                        @csrf
                            <div class="box-header with-border">
                                <h3 class="box-title">Compose New Message</h3>
                            </div>
                            <div class="box-body">
                                <div class="form-group"><input class="form-control" name="recipients" placeholder="To:" required></div>
                                <div class="form-group"><input class="form-control" name="subject" placeholder="Subject: "></div>
                                <div class="form-group"><textarea id="compose-textarea" name="message" class="form-control" rows="10"></textarea></div>
                            </div><!-- /.box-body -->
                            <div class="box-footer">
                                <div class="float-left">
                                  <div class="btn btn-default btn-file">
                                    <i class="fa fa-paperclip"></i> Attachment
                                    <input type="file" name="attachment" data-toggle="tooltip" data-placement="top" title="Max. 25MB">
                                  </div>
                                </div>
                                <div class="float-right">
                                    <a href="{{ route('inbox') }}" id="resetButton" class="btn btn-outline-danger"><i class="fa fa-times"></i> Discard</a>
                                    <button type="button" id="draftButton" class="btn btn-default"><i class="fa fa-pencil-alt"></i> Draft</button>
                                    <button type="submit" id="submit" class="btn btn-primary"><i class="fa fa-send"></i> Send</button>
                                </div>
                            </div><!-- /.box-footer -->
                        </form>
                      </div>
                </div>
            </div><!-- /.col-3 -->
        </div><!-- /.row -->

        <div class="overlay" style="display: none;">
            <i class="fa fa-sync-alt fa-spin"></i>
        </div>
    </div><!-- ./container -->
</section>

@endsection
