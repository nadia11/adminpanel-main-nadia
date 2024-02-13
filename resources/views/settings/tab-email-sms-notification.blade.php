<section class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="box box-success">
                    <div class="box-header with-border">
                        <i class="fa fa-wrench"></i>
                        <h2 class="box-title">Emails & Notification</h2>
                        <div class="box-tools float-right">
                            <button type="button" class="btn btn-box-tool" id="refresh" data-widget="Refresh" data-toggle="tooltip" title="Refresh"><i class="fa fa-sync-alt"></i></button>
                            <button class="btn btn-box-tool" data-widget="collapse" data-toggle="tooltip" title="Collapse"><i class="fa fa-minus"></i></button>
                            <button class="btn btn-box-tool" data-widget="remove" data-toggle="tooltip" title="Remove"><i class="fa fa-times"></i></button>
                        </div><!-- /.box-tools -->
                    </div><!-- /.box-header -->

                    <div class="box-body">
                        <div class="row">
                            <div class="form-group col-md-2">
                                <label for="company_email" class="control-label">Email</label>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <div class="input-group-text"><i class="fa fa-envelope"></i></div>
                                    </div>
                                    <input type="text" value="" name="port" class="form-control" id="port" placeholder="Port" required>
                                </div>
                            </div>

                            <div class="col-md-2">
                                <div class="form-group">
                                    <label>Host</label>
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <div class="input-group-text"><i class="fa fa-envelope"></i></div>
                                        </div>
                                        <input type="text" name="host" value="smtp.mailtrap.io" class="form-control">
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-2">
                                <div class="form-group">
                                    <label>Encryption</label>
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <div class="input-group-text"><i class="fa fa-envelope"></i></div>
                                        </div>
                                        <select name="encryption" class="form-control">
                                            <option value="ssl">SSL</option>
                                            <option value="tls">TLS</option>
                                            <option selected="selected" value="">None</option>
                                        </select>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-3">
                                <div class="form-group">
                                    <label>Email</label>
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <div class="input-group-text"><i class="fa fa-envelope"></i></div>
                                        </div>
                                        <input type="text" name="username" value="" class="form-control">
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-3">
                                <div class="form-group">
                                    <label>Password</label>
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <div class="input-group-text"><i class="fa fa-envelope"></i></div>
                                        </div>
                                        <input type="password" name="password" value="" class="form-control">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div><!-- /.box-body -->
                </div><!-- /.box -->
            </div><!-- /.col-12 -->  
        </div><!-- /.row -->
    </div><!-- ./container -->
</section>