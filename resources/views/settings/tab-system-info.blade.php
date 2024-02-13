<section class="content">
    <div class="container-fluid">
        <h2 class="box-title">System Info</h2>
        <table class="table table-bordered table-verticle">   
            <tr>
                <th style="width: 20%;">App Name</th>
                <td style="width: 1%;">:</td>
                <td>{{ config('app.name') }}</td>
            </tr>
            <tr>
                <th>Laravel Version</th>
                <td>:</td>
                <td><strong>{{ App::VERSION() }}</strong> Current Installed Version</td>
            </tr>
            <tr>
                <th>Current Application Environment</th>
                <td>:</td>
                <td>{{ App::environment() }}</td>
            </tr>
            <tr>
                <th>Timezone</th>
                <td>:</td>
                <td>{{ Config::get('app.timezone') }}</td>
            </tr>
            <tr>
                <th>Current PHP version</th>
                <td>:</td>
                <td>PHP {{ phpversion() }}</td>
            </tr>
            <tr>
                <th>Curl version</th>
                <td>:</td>
                <td><?php if ( function_exists( 'curl_version' ) ) { curl_version(); } else{ echo 'cURL installed but unable to retrieve version.'; } ?></td>
            </tr>
            <tr>
                <th>Server Name</th>
                <td>:</td>
                <td>{{ $_SERVER['SERVER_SOFTWARE'] }}</td>
            </tr>
            <tr>
                <th>WP memory limit</th>
                <td>:</td>
                <td>{{ @ini_get( 'memory_limit' ) }}</td>
            </tr>
            <tr>
                <th>PHP post max size</th>
                <td>:</td>
                <td>{{ @ini_get( 'post_max_size' ) }}</td>
            </tr>
            <tr>
                <th>Upload max filesize</th>
                <td>:</td>
                <td>{{ @ini_get( 'upload_max_filesize' ) }}</td>
            </tr>
            <tr>
                <th>Max Execution Time</th>
                <td>:</td>
                <td>{{ @ini_get( 'max_execution_time' ) }}</td>
            </tr>
            <tr>
                <th>Max Input Vars</th>
                <td>:</td>
                <td>{{ @ini_get( 'max_input_vars' ) }}</td>
            </tr>
            <tr>
                <th>Language</th>
                <td>:</td>
                <td>{{ Config::get('app.locale') }}</td>
            </tr>
            <tr>
                <th>CTYPE PHP Extension</th>
                <td>:</td>
                <td><?php if(extension_loaded("ctype")){ echo 'Enabled <i class="fa fa-check text-green"></i>'; }else{ echo 'Not Enabled <i class="fa fa-times text-danger"></i>'; } ?></td>
            </tr>
            <tr>
                <th>BCMath PHP Extension</th>
                <td>:</td>
                <td><?php if(extension_loaded("php_bcmath")){ echo 'Enabled <i class="fa fa-check text-green"></i>'; }else{ echo 'Not Enabled <i class="fa fa-times text-danger"></i>'; } ?></td>
            </tr>
            <tr>
                <th>JSON PHP Extension</th>
                <td>:</td>
                <td><?php if(extension_loaded("json")){ echo 'Enabled <i class="fa fa-check text-green"></i>'; }else{ echo 'Not Enabled <i class="fa fa-times text-danger"></i>'; } ?></td>
            </tr>
            <tr>
                <th>Mbstring PHP Extension</th>
                <td>:</td>
                <td><?php if(extension_loaded("Mbstring")){ echo 'Enabled <i class="fa fa-check text-green"></i>'; }else{ echo 'Not Enabled <i class="fa fa-times text-danger"></i>'; } ?> </td>
            </tr>
            <tr>
                <th>OpenSSL PHP Extension</th>
                <td>:</td>
                <td><?php if(extension_loaded("openssl")){ echo 'Enabled <i class="fa fa-check text-green"></i>'; }else{ echo 'Not Enabled <i class="fa fa-times text-danger"></i>'; } ?></td>
            </tr>
            <tr>
                <th>PDO PHP Extension</th>
                <td>:</td>
                <td><?php if(extension_loaded("pdo")){ echo 'Enabled <i class="fa fa-check text-green"></i>'; }else{ echo 'Not Enabled <i class="fa fa-times text-danger"></i>'; } ?></td>
            </tr>
            <tr>
                <th>Tokenizer PHP Extension</th>
                <td>:</td>
                <td><?php if(extension_loaded("Tokenizer")){ echo 'Enabled <i class="fa fa-check text-green"></i>'; }else{ echo 'Not Enabled <i class="fa fa-times text-danger"></i>'; } ?></td>
            </tr>
            <tr>
                <th>XML PHP Extension</th>
                <td>:</td>
                <td><?php if(extension_loaded("xml")){ echo 'Enabled <i class="fa fa-check text-green"></i>'; }else{ echo 'Not Enabled <i class="fa fa-times text-danger"></i>'; } ?></td>
            </tr>
        </table>
    </div><!-- ./container -->
</section>