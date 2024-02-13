<div class="box box-success animated fadeInRight">
    <div class="box-header">
        <h2 class="box-title">Database Backup list</h2>
        <div class="box-tools float-right">
            <button type="button" class="btn btn-primary btn-sm create_new_backup"><i class="fa fa-plus"></i> Create New Backup</button>
        </div><!-- /.box-tools -->
    </div><!-- /.box-header -->

    <div class="box-body">
        <table class="table table-simple database_backup_table">
            <thead class="thead-light">
            <tr>
                <th>#</th>
                <th>File Name</th>
                <th>File Size</th>
                <th>Backup Date</th>
                <th>Age</th>
                <th data-orderable="false" class="no-print" style="width:250px;">Action</th>
            </tr>
            </thead>
            <tbody>
            @php $backup_data = DB::table('backup_restores')->orderBy('backup_id', 'DESC')->get(); @endphp

            @if($backup_data->count() < 1) <tr><td colspan="6">No data found.</td></tr> @endif

            @foreach($backup_data as $backup)
                <tr id="{{ $backup->backup_id }}" class="animated slideInUp">
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $backup->file_name }}</td>
                    <td>@if( Storage::disk('backup')->exists("$backup->file_name")) {{ formatBytes(Storage::disk('backup')->size("$backup->file_name")) }} @else - @endif</td>
                    <td>{{ date('F jS Y, h:i:sa', strtotime($backup->backup_date)) }}</td>
                    <td>{{ human_date( $backup->backup_date ) }}</td>
                    <td>
                        <button type="button" class="btn btn-outline-warning btn-sm restoreBackupDB" id="{{ $backup->backup_id }}" data-file_name="{{ $backup->file_name }}"><i class="fa fa-undo" aria-hidden="true"></i> Restore</button>
                        {{--<button type="button" class="btn btn-outline-info btn-sm downloadBackupDB" id="{{ $backup->backup_id }}" data-file_name="{{ $backup->file_name }}"><i class="fa fa-cloud-download" aria-hidden="true"> Download</i></button>--}}
                        <a href="{{ url('storage/backup') ."/". $backup->file_name }}" class="btn btn-outline-info btn-sm downloadBackupFile" download onclick="return confirm('Are you sure want to download this backup')"> <i class="fa fa-cloud-download-alt"></i> Download</a>
                        <button type="button" class="btn btn-outline-danger btn-sm deleteBackupDB ajaxDelete" data-href="{{ URL::to('settings/delete-database-backup/' . $backup->backup_id) }}" data-title="{{ $backup->file_name }}" id="{{ $backup->backup_id }}"><i class="fa fa-times" aria-hidden="true"></i> Delete</button>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div><!-- /.box-body -->

    <div class="overlay" style="display: none;">
        <i class="fa fa-sync-alt fa-spin"></i>
    </div>
</div><!-- /.box -->



<div class="box box-success animated fadeInRight">
    <div class="box-header">
        <h2 class="box-title">File Backup list</h2>
        <div class="box-tools float-right">
            {{--<a href="{{ route('create-new-file-backup') }}" class="btn btn-danger btn-sm create_new_file_backup" ><i class="fa fa-plus"></i> Create New File Backup</a>--}}
            <a href="{{ route('create-new-file-backup', ['download'=>'zip']) }}" class="btn btn-danger btn-sm create_new_file_backup" ><i class="fa fa-plus"></i> Create New File Backup</a>
            {{--if($request->has('download')) {}--}}
            {{--<button type="button" class="btn btn-danger btn-sm create_new_file_backup"><i class="fa fa-plus"></i> Create New File Backup</button>--}}
        </div><!-- /.box-tools -->
    </div><!-- /.box-header -->

    <div class="box-body">
        <table class="table table-simple database_file_backup_table">
            <thead class="thead-light">
            <tr>
                <th>#</th>
                <th>File Name</th>
                <th>File Size</th>
                <th>Backup Date</th>
                <th>Age</th>
                <th data-orderable="false" class="no-print" style="width:250px;">Action</th>
            </tr>
            </thead>
            <tbody>
            @php $backup_data = DB::table('files_backup')->orderBy('file_backup_id', 'DESC')->get(); @endphp

            @if($backup_data->count() < 1) <tr><td colspan="6">No data found.</td></tr> @endif
            @foreach($backup_data as $backup)
                <tr id="{{ $backup->file_backup_id }}" class="animated slideInUp">
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $backup->file_name }}</td>
                    <td>@if( Storage::disk('backup')->exists("$backup->file_name")) {{ formatBytes(Storage::disk('backup')->size("$backup->file_name")) }} @else - @endif</td>
                    <td>{{ date('F jS Y, h:i:sa', strtotime($backup->backup_date)) }}</td>
                    <td>{{ human_date( $backup->backup_date ) }}</td>
                    <td>
                        <button type="button" class="btn btn-outline-warning btn-sm extractFileBackup" id="{{ $backup->file_backup_id }}" data-file_name="{{ $backup->file_name }}"><i class="fa fa-share-square" aria-hidden="true"></i> Extract</button>
                        <a href="{{ url('storage/backup') ."/". $backup->file_name }}" class="btn btn-outline-info btn-sm downloadFileBackup" download onclick="return confirm('Are you sure want to download this backup')"> <i class="fa fa-cloud-download-alt"></i> Download</a>
                        <button type="button" class="btn btn-outline-danger btn-sm deleteFileBackup ajaxDelete" data-href="{{ URL::to('settings/delete-file-backup/' . $backup->file_backup_id) }}" data-title="{{ $backup->file_name }}" id="{{ $backup->file_backup_id }}"><i class="fa fa-times" aria-hidden="true"></i> Delete</button>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div><!-- /.box-body -->

    <div class="overlay" style="display: none;">
        <i class="fa fa-sync-alt fa-spin"></i>
    </div>
</div><!-- /.box -->





<script type="text/javascript">
    $(document).ready(function(){
        $(document).on('click', 'button.create_new_backup', function () {
            var row_count = $("table.database_backup_table").find('tbody').find('tr').length;

            $.ajaxSetup({
                headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') }
            });

            $.ajax({
                url: "{{ url('settings/create-new-backup') }}",
                method: "POST",
                dataType: "json",
                success: function( response ) {
                    $("table.database_backup_table").find('tbody').prepend(
                            '<tr id="'+ response.backup_id +'">'
                            + '<td>'+ (row_count+1) +'</td>'
                            + '<td>'+ response.file_name +'</td>'
                            + '<td> - </td>'
                            + '<td>'+ response.backup_date +'</td>'
                            + '<td>'+ response.age +'</td>'
                            + '<td>'
                            +'<button type="button" class="btn btn-outline-warning btn-sm restoreBackupFile" id="'+ response.backup_id +'"  data-file_name="'+ response.file_name +'"><i class="fa fa-undo" aria-hidden="true"></i> Restore</button>'
                            //+'<button type="button" class="btn btn-outline-info btn-sm downloadBackupFile" id="'+ response.backup_id +'"><i class="fa fa-cloud-download" aria-hidden="true"> Download</i></button>'
                            +'<a href="<?php echo url('storage/backup'); ?>/'+ response.file_name +'" class="btn btn-outline-info btn-sm downloadBackupFile" download onclick="return confirm("Are you sure want to download this backup")"> <i class="fa fa-cloud-download-alt"></i> Download</a>'
                            + '<button type="button" class="btn btn-outline-danger btn-sm deleteDatabaseBackup ajaxDelete" data-href="<?php echo URL::to('settings/delete-database-backup'); ?>/'+ response.backup_id +'" data-title="'+ response.file_name +'" id="'+ response.backup_id +'"><i class="fa fa-trash" aria-hidden="true"></i> Delete</button>'
                            + '</td>'
                            + '</tr>'
                    );
                    toastr.success( response.success, "Success", {"closeButton": true,"newestOnTop": true,"progressBar": true,"preventDuplicates": true});
                },
                statusCode:{ 404: function(){ alert( "page not found" ); } },
                beforeSend: function( xhr ) { $(".ajax-loader").show(); },
                complete: function( jqXHR, textStatus ) { $(".ajax-loader").hide(); },
            });
        });


        {{--$(document).on('click', 'button.downloadBackupDB', function () {--}}
            {{--var id = $(this).data('id');--}}
            {{--var file_name = $(this).data('file_name');--}}

            {{--if (!confirm("Are you sure want to download this backup?")) return;--}}

            {{--$.ajax({--}}
                {{--url: "{{ url('/download-backup-db') }}",--}}
                {{--method: "get",--}}
                {{--data: {id: id, file_name: file_name},--}}
                {{--//dataType: "json",--}}
                {{--success: function( response ) {--}}
                    {{--toastr.success( response.success );--}}
                {{--},--}}
                {{--statusCode:{ 404: function(){ alert( "page not found" ); } },--}}
                {{--beforeSend: function( xhr ) { $(".ajax-loader").show(); },--}}
                {{--complete: function( jqXHR, textStatus ) { $(".ajax-loader").hide(); },--}}
            {{--});--}}
        {{--});--}}


        $(document).on('click', 'button.restoreBackupDB', function () {
            var id = $(this).data('id');
            var file_name = $(this).data('file_name');

            if (!confirm("Are you sure want to restore this database backup?")) return;

            $.ajax({
                url: "{{ url('settings/restore-backup-db') }}",
                method: "get",
                data: {id: id, file_name: file_name},
                //dataType: "json",
                success: function( response ) {
                    toastr.info( response.message, "Info", {"closeButton": true,"newestOnTop": true,"progressBar": true,"preventDuplicates": true});
                },
                statusCode:{ 404: function(){ alert( "page not found" ); } },
                beforeSend: function( xhr ) { $(".ajax-loader").show(); },
                complete: function( jqXHR, textStatus ) { $(".ajax-loader").hide(); },
            });
        });
    }); //End of Document ready



    $(document).ready(function(){
        $(document).on('click', 'a.create_new_file_backup', function () {
            var row_count = $("table.database_file_backup_table").find('tbody').find('tr').length;

            $.ajaxSetup({
                headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') }
            });

            $.ajax({
                url: "{{ url('settings/create-new-file-backup') }}",
                method: "get",
                dataType: "json",
                success: function( response ) {
                    $("table.database_file_backup_table").find('tbody').prepend(
                            '<tr id="'+ response.file_backup_id +'">'
                            + '<td>'+ (row_count+1) +'</td>'
                            + '<td>'+ response.file_name +'</td>'
                            + '<td> - </td>'
                            + '<td>'+ response.backup_date +'</td>'
                            + '<td>'+ response.age +'</td>'
                            + '<td>'
                            +'<button type="button" class="btn btn-outline-warning btn-sm extractFileBackup" id="'+ response.file_backup_id +'" data-file_name="'+ response.file_name +'"><i class="fa fa-share-square" aria-hidden="true"></i> Extract</button>'
                                //+'<button type="button" class="btn btn-outline-info btn-sm downloadBackupFile" id="'+ response.backup_id +'"><i class="fa fa-cloud-download" aria-hidden="true"> Download</i></button>'
                            +'<a href="<?php echo url('storage/backup'); ?>/'+ response.file_name +'" class="btn btn-outline-info btn-sm downloadBackupFile" download onclick="return confirm("Are you sure want to download this backup")"> <i class="fa fa-cloud-download-alt"></i> Download</a>'
                            + '<button type="button" class="btn btn-outline-danger btn-sm deleteFileBackup ajaxDelete" data-href="<?php echo URL::to('settings/delete-file-backup'); ?>/'+ response.file_backup_id +'" data-title="'+ response.file_name +'" id="'+ response.file_backup_id +'"><i class="fa fa-trash" aria-hidden="true"></i> Delete</button>'
                            + '</td>'
                            + '</tr>'
                    );
                    //window.location.assign("new-job");
                    //setTimeout(function(){ window.location.reload(); },1000);
                    toastr.info( response.message, "Info", {"closeButton": true,"newestOnTop": true,"progressBar": true,"preventDuplicates": true} );
                },
                statusCode:{ 404: function(){ alert( "page not found" ); } },
                beforeSend: function( xhr ) { $(".ajax-loader").show(); },
                complete: function( jqXHR, textStatus ) { $(".ajax-loader").hide(); },
            });
        });

        $(document).on('click', 'button.extractFileBackup', function () {
            var id = $(this).data('id');
            var file_name = $(this).data('file_name');

            if (!confirm("If extract old files will be deleted & backup file will be replaced. Are you sure want to extract this backup?")) return;

            $.ajax({
                url: "{{ url('settings/extract-file-backup') }}",
                method: "get",
                data: {id: id, file_name: file_name},
                //dataType: "json",
                success: function( response ) {
                    toastr.info( response.message, "Info", {"closeButton": true,"newestOnTop": true,"progressBar": true,"preventDuplicates": true});
                },
                statusCode:{ 404: function(){ alert( "page not found" ); } },
                beforeSend: function( xhr ) { $(".ajax-loader").show(); },
                complete: function( jqXHR, textStatus ) { $(".ajax-loader").hide(); },
            });
        });
    }); //End of Document ready
</script>


