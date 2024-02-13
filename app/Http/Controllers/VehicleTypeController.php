<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Session;
use DB;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;
use File;


class VehicleTypeController extends Controller
{
    public function vehicle_type_management()
    {
        $vehicle_type_info = DB::table('vehicle_types')->orderBy('created_at', 'DESC')->get();
        $manage_vehicle = view('pages.vehicles.vehicle-type-management')->with('all_vehicle_info', $vehicle_type_info);

        return view('dashboard')->with('main_content', $manage_vehicle);
    }

    public function new_vehicle_type_save( Request $request)
    {
        //$input = $request->all();
        //dd($input); //Dump and Die

//        $validatedData = $request->validate([
//            'title' => 'required|unique:posts|max:255',
//            'body' => 'required',
//        ]);
//        dd($request->all());

        $data = array(
            'vehicle_type'  => strtolower($request->vehicle_type),
            'seat_capacity' => $request->seat_capacity,
            'vehicle_color' => $request->vehicle_color,
            'note'          => $request->note,
            'created_at'    => date('Y-m-d H:i:s'),
        );
        if ($request->hasFile('vehicle_photo')) {
            $upload_dir = upload_path('/vehicle-photo/' );
            $files = $request->file('vehicle_photo');

            $file_name_WithExt = $files->getClientOriginalName();
            $extension = strtolower( $files->getClientOriginalExtension() );
            $vehicle_photo = Str::slug( pathinfo($file_name_WithExt, PATHINFO_FILENAME) ) . ".".$extension;
            $success = $files->move( $upload_dir, $vehicle_photo );

            $data['vehicle_photo'] = $vehicle_photo;
        }
        DB::table('vehicle_types')->insert( $data );

        return redirect('/vehicle-type/vehicle-type-management')->with('success', 'Created New Purchase Successfully!');
    }

    public function edit_vehicle_type(Request $request, $vehicle_type_id )
    {
        if ( $request->ajax() ) {
            $vehicle_info = DB::table('vehicle_types')->where('vehicle_type_id', $vehicle_type_id)->first();

            return response()->json( [$vehicle_info] );
        }
    }

    public function update_vehicle_type( Request $request )
    {
        $vehicle_type_id = $request->vehicle_type_id;

        $data = array(
            'vehicle_type'  => $request->vehicle_type,
            'seat_capacity' => $request->seat_capacity,
            'vehicle_color' => $request->vehicle_color,
            'note'          => $request->note,
            'updated_at'    => date('Y-m-d H:i:s'),
        );

        if ($request->hasFile('vehicle_photo')) {
            $upload_dir = upload_path('/vehicle-photo/' );
            $files = $request->file('vehicle_photo');

            $file_name_WithExt = $files->getClientOriginalName();
            $extension = strtolower( $files->getClientOriginalExtension() );
            $vehicle_photo = Str::slug( pathinfo($file_name_WithExt, PATHINFO_FILENAME) ) . ".".$extension;
            $success = $files->move( $upload_dir, $vehicle_photo );

            if( $request->vehicle_photo_prev ){
                //Storage::disk('local')->delete('client-vehicle/' . $request->vehicle_photo_prev);.
                if(file_exists($upload_dir . $request->vehicle_photo_prev)) {
                    unlink( $upload_dir . $request->vehicle_photo_prev ); //delete previous image from upload folder
                }
            }
            $data['vehicle_photo'] = $vehicle_photo;
        }else{
            $data['vehicle_photo'] = $request->vehicle_photo_prev;
        }
        DB::table('vehicle_types')->where('vehicle_type_id', $vehicle_type_id)->update( $data );

        return redirect('/vehicle-type/vehicle-type-management')->with('success', 'Update Vehicle Type Successfully!');
    }


    public function delete_vehicle_type( Request $request, $vehicle_type_id)
    {
        if ( $request->ajax() ) {
            DB::table('vehicle_types')->where('vehicle_type_id', $vehicle_type_id)->delete();
            return response()->json(['success' => 'Vehicle Type has been deleted successfully!', 'status' => 'success']);
        }
        return response(['error' => 'Failed deleting the Vehicle Type', 'status' => 'failed']);
    }
}
