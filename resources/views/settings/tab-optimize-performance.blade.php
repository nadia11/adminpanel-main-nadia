<div class="box box-success animated fadeInRight">
    <div class="box-header">
        <h2 class="box-title">Optimize & Performance</h2>
    </div><!-- /.box-header -->

    <div class="box-body">
        <table class="table table-borderless">
            <tr>
                <td style="width: 20%;">Clear application cache:</td>
                <td><button type="button" class="btn btn-warning btn-sm clear_cache" data-url="{{ url('settings/clear-cache') }}"> Clear application cache</button></td>
            </tr>
            <tr>
                <td style="width: 20%;">Clear view cache</td>
                <td><button type="button" class="btn btn-warning btn-sm clear_cache" data-url="{{ url('settings/view-clear') }}"> Clear view cache</button></td>
            </tr>
            <tr>
                <td style="width: 20%;">Clear route cache</td>
                <td><button type="button" class="btn btn-warning btn-sm clear_cache" data-url="{{ url('settings/route-clear') }}"> Clear route cache</button></td>
            </tr>
            <tr>
                <td style="width: 20%;">Clear config cache</td>
                <td><button type="button" class="btn btn-warning btn-sm clear_cache" data-url="{{ url('settings/config-clear') }}"> Clear config cache</button></td>
            </tr>
            <tr>
                <td style="width: 20%;">Clear compiled classes</td>
                <td><button type="button" class="btn btn-warning btn-sm clear_cache" data-url="{{ url('settings/clear-compiled') }}"> Clear compiled classes</button></td>
            </tr>
            <tr>
                <td style="width: 20%;">Set Caching</td>
                <td><button type="button" class="btn btn-danger btn-sm clear_cache" data-url="{{ url('settings/set-cache') }}"> Set Caching</button></td>
            </tr>
        </table>
    </div><!-- /.box-body -->

    <div class="overlay" style="display: none;">
        <i class="fa fa-sync-alt fa-spin"></i>
    </div>
</div><!-- /.box -->




<script type="text/javascript">
    $(document).ready(function(){
        $(document).on('click', 'button.clear_cache', function (event) {
            event.preventDefault();
            var url = $(this).data('url');

            $.ajax({
                url: url,
                method: "get",
                //data: {id: id, file_name: file_name},
                dataType: "json",
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


