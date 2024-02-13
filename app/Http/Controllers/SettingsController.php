<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use Mail;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Response;
use ZipArchive;
use RecursiveIteratorIterator;
use RecursiveDirectoryIterator;


class SettingsController extends Controller
{
    public function system_settings()
    {
        $system_settings = view('settings/system-settings')->with('Timezones', $this->tz_list());

        return view('dashboard')->with('main_content', $system_settings);
    }

    public function updateSettings(Request $request) {
        $settings = array(
            'company_name'  => $request->company_name,
            'logo'          => $request->logo,
            'company_phone' => $request->company_phone,
            'company_email' => $request->company_email,
            'currency'      => $request->currency,
            'menu_position' => $request->menu_position,
            'discount'      => $request->discount,
            'tax'           => $request->tax,
            'decimals'      => $request->decimals,
            'keyboard'      => $request->keyboard,
            'timezone'      => $request->timezone,
            'receiptheader' => $request->receiptheader,
            'receiptfooter' => $request->receiptfooter,
            'stripe'        => $request->stripe,
            'stripe_secret_key' => $request->stripe_secret_key,
            'stripe_publishable_key' => $request->stripe_publishable_key,
            'theme'         => $request->theme,
            'updated_at'    => date('Y-m-d H:i:s'),
        );
        DB::table('settings')->where('setting_id', 1)->update( $settings );
        return redirect('settings/system-settings')->with('success', 'Update Settings Successfully!');
    }

    public function tz_list() {
        $zones_array = array();
        $timestamp = time();
        foreach(timezone_identifiers_list() as $key => $zone) {
            date_default_timezone_set($zone);
            $zones_array[$key]['zone'] = $zone;
            $zones_array[$key]['diff_from_GMT'] = '(UTC/GMT' . date('P', $timestamp) . ")";
        }
        usort($zones_array, function($a, $b) {
            return strcmp($a['diff_from_GMT'], $b['diff_from_GMT']);
        });
        return $zones_array;
    }

    public function view_settings_tab(Request $request, $tab_id ) {

        $data = view('settings.tab-' . $tab_id)->with('Timezones', $this->tz_list());

        return response($data, 200)->header('Content-Type', 'text/plain');
    }



    /***********************************
     * Backup & Restore
     * *********/
    public function create_new_backup(Request $request) {
        if ( $request->ajax() ) {
            $filename   = "database-backup-" . Carbon::now()->format('Ymd-Hi') . ".sql.gz";
            $return_var = NULL;
            $output     = NULL;
            $command    = "mysqldump --user=" . env('DB_USERNAME') ." --password=" . env('DB_PASSWORD') . " --host=" . env('DB_HOST') . " " . env('DB_DATABASE') . "  | gzip > " . storage_path() . "/backup/" . $filename;
            exec($command, $output, $return_var);


            $data = array(
                'file_name' => $filename,
                //'file_size' => ,
                'backup_date' => date('Y-m-d H:i:s'),
                'created_at' => date('Y-m-d H:i:s'),
            );
            $lastId = DB::table('backup_restores')->insertGetId( $data );
            $backup_date = date('F jS Y, h:i:sa', strtotime($data['backup_date']));
            $age = human_date( $data['backup_date'] );
            $file_name = $data['file_name'];

            return response()->json(['message' => 'Database Backup created Successfully!', 'backup_id'=>$lastId, 'file_name'=>$file_name, 'backup_date'=>$backup_date, 'age'=>$age, 'status' => 'success']);
        }
    }

    public function restore_backup_db(Request $request) {
        if ( $request->ajax() ) {
            $return_var = NULL;
            $output     = NULL;
            $command    = "mysql --user=" . env('DB_USERNAME') ." --password=" . env('DB_PASSWORD') . " --host=" . env('DB_HOST') . " " . env('DB_DATABASE') . "  | gzip < " . storage_path() . "/backup/" . $request->file_name;
            exec($command, $output, $return_var);

            return response()->json(['message' => 'Database Backup Restore Successfully!']);
        }
    }



//    public function download_backup_db(Request $request) {
//        if ( $request->ajax() ) {
//            //$bank_info = DB::table('backup_restores')->where('backup_id', $request->backup_id)->first();
//            //if( Storage::disk('backup')->exists("$request->file_name")) { Storage::disk('backup')->download("$request->file_name"); }
//        //return response::download(storage_path('backup') ."/". $request->file_name);
////        return response::download(storage_path('backup/a.jpg'), time().'.jpg', ['Content-Disposition:attachment', 'filename="a.jpg"', 'Content-Length:137', 'Content-Transfer-Encoding:binary', 'Content-Type: application/octet-stream']);
//        return response::download(storage_path('backup') ."/". $request->file_name, 'filename.sql.gz', ['Content-Disposition:attachment', 'filename="'.$request->file_name.'"', 'Content-Length:137', 'Content-Transfer-Encoding:binary', 'Content-Type: application/octet-stream']);
//            //return response()->json( [$request->file_name, 'row_index' => $request->row_index] );
//        }
//    }


    public function delete_database_backup( Request $request, $backup_id) {
        if ( $request->ajax() ) {
            $file_name = DB::table('backup_restores')->where('backup_id', $backup_id)->value('file_name');

            DB::table('backup_restores')->where('backup_id', $backup_id)->delete();
            Storage::disk('backup')->delete($file_name);

            return response()->json(['message' => 'Backup file has been deleted successfully!']);
        }
        return response(['message' => 'Failed deleting the Backup file']);
    }

    public function create_new_file_backup(Request $request) {
        if($request->has('download')) {
            $file_name   = "documents-backup-" . Carbon::now()->format('Ymd-Hi') . ".zip";

            $data = array(
                'file_name' => $file_name,
                //'file_size' => ,
                'backup_date' => date('Y-m-d H:i:s'),
                'created_at' => date('Y-m-d H:i:s'),
            );
            $lastId = DB::table('files_backup')->insertGetId( $data );
            $backup_date = date('F jS Y, h:i:sa', strtotime($data['backup_date']));
            $age = human_date( $data['backup_date'] );


            $zip = new ZipArchive;
            $backup_dir = storage_path('/uploads');
            $file_save_path = storage_path() . "/backup" .'/'.$file_name;

            if ($zip->open($file_save_path, ZipArchive::CREATE | ZipArchive::OVERWRITE) === TRUE) {

                //Only files download with zip
                //foreach($files as $file) { $zip->addFile($file->path, $file->name); }
                //foreach (glob("target_folder/*") as $file) { $zip->addFile($file); if ($file != 'target_folder/important.txt') unlink($file); }
                //$zip->addFile($storage_dir . '/a.jpg');

                //For download all files & folder in directory
                $files = new RecursiveIteratorIterator(new RecursiveDirectoryIterator($backup_dir), RecursiveIteratorIterator::LEAVES_ONLY);
                foreach ($files as $name => $file){
                    // Skip directories (they would be added automatically)
                    if (!$file->isDir()){
                        // Get real and relative path for current file
                        $filePath = $file->getRealPath();
                        $relativePath = substr($filePath, strlen($backup_dir) + 0);
                        $zip->addFile($filePath, $relativePath);
                    }
                }
                $zip->close();
            }

            $headers = array(
                'Expires' => 'Sat, 26 Jul 1997 05:00:00 GMT',
                'Content-Type' => 'application/octet-stream',
                'Content-Disposition' => 'attachment; filename="'.$file_name.'"',
                'Accept-Ranges' => 'bytes',
                'Content-Length' => storage::disk('backup')->size($file_name),
            );

//            ->header('Content-Type', "audio/mpeg, audio/x-mpeg, audio/x-mpeg-3, audio/mpeg3")
//            ->header('Content-Disposition', 'filename="' . basename($filePath) . '"')
//            ->header('Content-length:' . filesize($filePath))
//            ->header('Content-Transfer-Encoding', 'binary')
//            ->header('Expires', 0)
//            ->header('Cache-Control', 'no-cache')
//            ->header('Pragma', 'public')
//            ->header('X-Pad', 'avoid browser bug');

            // Create Download Response
            if(file_exists($file_save_path)){
                return response::download($file_save_path, $file_name, $headers);
            }
        }
    }

    public function extract_file_backup(Request $request) {
        if ( $request->ajax() ) {
            $zip = new ZipArchive;

            $file_path = storage_path() . "/backup" .'/'.$request->file_name;
            $zip->open($file_path);

            $zip->extractTo(storage_path('/uploads'));
            $zip->close();

            return response()->json(['message' => 'Files Extracted Successfully!']);
        }
    }

    public function delete_file_backup( Request $request, $backup_id) {
        if ( $request->ajax() ) {
            $file_name = DB::table('files_backup')->where('file_backup_id', $backup_id)->value('file_name');

            DB::table('files_backup')->where('file_backup_id', $backup_id)->delete();
            Storage::disk('backup')->delete($file_name);

            return response()->json(['message' => 'Files Backup has been deleted successfully!']);
        }
        return response(['message' => 'Failed deleting the Files Backup']);
    }
}
