<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Session;
use DB;
use URL;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Carbon;

class EmployeeController extends Controller
{
    public function employee_management() {
        $manage_employee = view('pages.employees.employee-management-ajax');
        return view('dashboard')->with('main_content', $manage_employee);
    }

    public function employee_management_ajax_data(Request $request)
    {
        $datatable_query = DB::table('employees')
            ->leftjoin('districts', 'employees.district_id', '=', 'districts.district_id')
            ->leftjoin('departments', 'employees.department_id', '=', 'departments.department_id')
            ->leftjoin('designations', 'employees.designation_id', '=', 'designations.designation_id')
            ->select('employees.*', 'districts.district_name', 'departments.department_name', 'designations.designation_name')
            //->join('users', function($join){ $join->on('employees.id', '=', 'employees.employee_id'); })
            ;


//        $datatable_query = DB::table('employees')
//            ->leftJoin('divisions', 'employees.division_id', '=', 'divisions.division_id')
//            ->leftJoin('bma_branches', 'employees.branch_id', '=', 'bma_branches.branch_id')
//            ->leftJoin('transfer_histories', 'employees.employee_id', '=', 'transfer_histories.transfer_employee_id')
//            ->select('employees.employee_id', 'employees.employeeship_number', 'employees.category_of_employeeship', 'bma_branches.branch_id', 'employees.employee_name', 'employees.branch_id', 'employees.mobile', 'employees.employee_status', 'employees.bmdc_reg', 'employees.employee_photo', 'divisions.division_name', 'divisions.division_id', 'employees.corrected_data', 'transfer_histories.transfer_employee_id')
//            ->orderBy('divisions.division_name', 'ASC')
//            ->orderBy('employees.employeeship_number', 'ASC');


        /*
        $columns = array(
            0  => 'index_column',
            1  => 'division_name',
            2  => 'district_name',
            3  => 'employee_name',
            4  => 'mobile',
            5 => 'action',
        );
        $order = $columns[$request->input('order.0.column')]; //Column name
        $dir = $request['order'][0]['dir']; //asc or desc
        */

        $totalData = $datatable_query->count();
        $totalFiltered = $totalData;
        $start = $request->input('start');
        $limit = $request->input('length'); //Rows display per page filter
        $columnIndex = $request['order'][0]['column']; //Column index dynamic
        $order = $request['columns'][$columnIndex]['data']; //Column name dynamic
        $dir = $request->input('order.0.dir'); //asc or desc
        $search_value = $request['search']['value']; //$request->input('search.value');


        /*************employeeship_number_filter_from_url************/
//        if( $request->branch_name_filter_from_url_param ) {
//            $datatable_query->where('branch_name', $request->branch_name_filter_from_url_param)->get();
//            $totalFiltered = $datatable_query->count();
//        }
//        if( $request->employeeship_number_filter_from_url ) {
//            $datatable_query->where('employeeship_number', null)->orWhere('employeeship_number', "")->get();
//            $totalFiltered = $datatable_query->count();
//        }
        if( $request->department_filter ) {
            $datatable_query->Where('department_name', $request->department_filter)->get();
            $totalFiltered = $datatable_query->count();
        }
        if( $request->designation_filter ) {
            $datatable_query->Where('designation_name', $request->designation_filter)->get();
            $totalFiltered = $datatable_query->count();
        }
        if( $request->gender_filter ) {
            $datatable_query->Where('employee_gender', $request->gender_filter)->get();
            $totalFiltered = $datatable_query->count();
        }
        if( $request->blood_group_filter ) {
            $datatable_query->where('blood_group', $request->blood_group_filter)->get();
            $totalFiltered = $datatable_query->count();
        }
        if( $request->marital_status_filter ) {
            $datatable_query->where('marital_status', $request->marital_status_filter)->get();
            $totalFiltered = $datatable_query->count();
        }
        if( $request->employee_status_filter ) {
            $datatable_query->where('employee_status', $request->employee_status_filter)->get();
            $totalFiltered = $datatable_query->count();
        }
//        if( $request->degree_filter ) {
//            $datatable_query->where('degree_name_a', 'LIKE', "%{$request->degree_filter}%")
//                ->orWhere('degree_name_b', 'LIKE', "%{$request->degree_filter}%")
//                ->orWhere('degree_name_c', 'LIKE', "%{$request->degree_filter}%")
//                ->orWhere('degree_name_d', 'LIKE', "%{$request->degree_filter}%")
//                ->orWhere('degree_name_e', 'LIKE', "%{$request->degree_filter}%")
//                ->get();
//
//            $totalFiltered = $datatable_query->count();
//        }
//        if( $request->institute_filter ) {
//            $datatable_query->where('institute_name_a', 'LIKE', "%{$request->institute_filter}%")
//                ->orWhere('institute_name_b', 'LIKE', "%{$request->institute_filter}%")
//                ->orWhere('institute_name_c', 'LIKE', "%{$request->institute_filter}%")
//                ->orWhere('institute_name_d', 'LIKE', "%{$request->institute_filter}%")
//                ->orWhere('institute_name_e', 'LIKE', "%{$request->institute_filter}%")
//                ->get();
//
//            $totalFiltered = $datatable_query->count();
//        }
//        if( $request->board_filter ) {
//            $datatable_query->where('board_a', 'LIKE', "%{$request->board_filter}%")
//                ->orWhere('board_b', 'LIKE', "%{$request->board_filter}%")
//                ->orWhere('board_c', 'LIKE', "%{$request->board_filter}%")
//                ->orWhere('board_d', 'LIKE', "%{$request->board_filter}%")
//                ->orWhere('board_e', 'LIKE', "%{$request->board_filter}%")
//                ->get();
//
//            $totalFiltered = $datatable_query->count();
//        }
//

        if ( isset($request['search']) && $search_value != '' ) {
            $datatable_query->where('employee_name', 'LIKE', "%{$search_value}%")
                ->orWhere('district_name', 'LIKE', "%{$search_value}%")
                ->orWhere('employee_mobile', 'LIKE', "%{$search_value}%")
                ->orWhere('branch_id', 'LIKE', "%{$search_value}%")
                ->orWhere('department_name', 'LIKE', "%{$search_value}%")
                ->orWhere('designation_name', 'LIKE', "%{$search_value}%")
                ->orWhere('employee_gender', 'LIKE', "%{$search_value}%")
                ->orWhere('joining_date', 'LIKE', "%{$search_value}%")
                ->orWhere('employee_status', 'LIKE', "%{$search_value}%")
                ->get();

            $totalFiltered = $datatable_query->count();
        }

        if ( isset($request['order']) && count($request['order']) ) {
            $datatable_query->orderBy($order, $dir)->get();
        }

        /******* 1 lac pcs********/
        if ( isset($request['start']) && $request['length'] === 1000000 ) {
            $datatable_query->offset($request['start'])->limit($request['length'])->get();
        }

        /*******Total number of records without filtering*****/
        $table_generate_data = $datatable_query->offset($start)->limit($limit)->orderBy($order, $dir)->get();


        //$per_page = $limit;
        //$total_pages = $totalData / $limit;

        $data = array();
        $status_class = array('approved'=>'text-success', 'pending'=>'text-primary', 'denied'=>'text-warning' );
        if(!empty($table_generate_data)){

            foreach ($table_generate_data as $key=>$row)
            {
                $nestedData['DT_RowClass']   = "row_".$row->employee_id . ($row->employee_status == 'Expired' ? ' bg-expired' : "");
                $nestedData['employee_id']     = $key+1+$start; /*Index Column*/
                $nestedData['employee_name']   = '<img src="'. (!empty($row->employee_photo) ? upload_url( "/employee-image/". $row->employee_photo ) : image_url('defaultAvatar.jpg')) .'" style="border-radius: 50%; width: 40px; height: 40px; border: 1px solid #eee; box-shadow: 0 0 3px rgba(0,0,0,.3); padding: 1px;" />' . $row->employee_name;
                $nestedData['district_name'] = $row->district_name ?? "-";
                $nestedData['employee_mobile']        = $row->employee_mobile ?? "-";
                $nestedData['branch_id']        = $row->branch_id ?? "-";
                $nestedData['department_name']        = $row->department_name ?? "-";
                $nestedData['designation_name']        = $row->designation_name ?? "-";
                $nestedData['employee_gender']        = $row->employee_gender ?? "-";
                $nestedData['joining_date']        = $row->joining_date > 0 ? date('d/m/Y', strtotime($row->joining_date)) : "-";
                $nestedData['employee_status'] = '<a href="#" class="'. ($row->employee_status ? $status_class[$row->employee_status] : "") .' employee-status" id="'.$row->employee_id.'" data-href="'. url( 'employee-status/' . $row->employee_id) .'" data-status="'. $row->employee_status.'">'.str_snack($row->employee_status ?? "-").'</a>';
                //$nestedData['employee_photo']  = '<img src="'. (!empty($row->employee_photo) ? upload_url( "/employee-image/". $row->employee_photo ) : image_url('defaultAvatar.jpg')) .'" style="border-radius: 50%; width: 40px; height: 40px; border: 1px solid #eee; box-shadow: 0 0 3px rgba(0,0,0,.3); padding: 1px; margin: 0px;" />';

                $nestedData['action']   = '<a href="'. URL::to("/employee/view/" . $row->employee_id) .'" class="btn btn-success btn-sm" data-toggle="tooltip" data-placement="top" title="View this Employee Details"><i class="fa fa-eye" aria-hidden="true"></i></a>';
                $nestedData['action']  .= '<button type="button" class="btn btn-outline-success btn-sm editEmployee" id="'.$row->employee_id.'" data-toggle="tooltip" data-placement="top" title="Edit this Employee"><i class="fa fa-edit"></i></button>';
                $nestedData['action']  .= '<button type="button" class="btn btn-warning btn-sm sendSMS" id="'.$row->employee_id.'" data-toggle="tooltip" data-placement="top" title="Send SMS to This Employee"><i class="fa fa-envelope"></i></button>';
                //$nestedData['action']  .= '<a href="'. url('employee/print-employee' ."/". $row->employee_id) .'" target="_blank" class="btn btn-primary btn-sm" data-toggle="tooltip" data-placement="top" title="Print Employee Details"><i class="fa fa-print"></i></a>';
                if(is_user_role('SuperAdmin')) {
                    $nestedData['action'] .= '<button type="button" class="ajaxDelete btn btn-danger btn-sm" data-href="'. url('employee/delete-employee/'. $row->employee_id) .'" data-title="'. $row->employee_name .'" id="' . $row->employee_id .'" data-toggle="tooltip" data-placement="top" title="Delete this Employee"><i class="far fa-trash-alt"></i></button>';
                }

                //Final data
                $data[]      = $nestedData;
            }
        }
        $json_data = array(
            "draw"            => isset ( $request['draw'] ) ? intval($request->input('draw')) : 0,
            "recordsTotal"    => intval($totalData),
            "recordsFiltered" => intval($totalFiltered),
            "data"            => $data
        );
        return response()->json($json_data);
    }




    public function get_district(Request $request, $id)
    {
        if ( $request->ajax() ) {
            $districts = DB::table("districts")->where("division_id", $id)->pluck("district_name","district_id");
            //return json_encode( $districts );
            return response()->json( $districts );
        }
    }

    public function new_employee_save( Request $request)
    {
//        $validatedData = $request->validate([
//            'title' => 'required|unique:posts|max:255',
//            'body' => 'required',
//        ]);

        $data = array(
            'employee_type'           => $request->employee_type,
            'employee_name'           => $request->employee_name,
            'employee_code'           => $request->employee_code,
            'cardID'                  => $request->cardID,
            'employee_fathers_name'   => $request->employee_fathers_name,
            'employee_mothers_name'   => $request->employee_mothers_name,
            'employee_mobile'         => $request->employee_mobile,
            'employee_alt_mobile'     => $request->employee_alt_mobile,
            'employee_email'          => $request->employee_email,
            'department_id'           => $request->department_id,
            'designation_id'          => $request->designation_id,
            //'branch_id'             => $request->branch_id,
            'employee_gender'         => $request->employee_gender,
            'marital_status'          => $request->marital_status,
            'employee_dob'            => Carbon::createFromFormat('d/m/Y', $request->employee_dob )->format('Y-m-d H:i:s'),
            'employee_religion'       => $request->employee_religion,
            'employee_nationality'    => $request->employee_nationality,
            'employee_nid'            => $request->employee_nid,
            'birth_certificate'       => $request->birth_certificate,
            'passport_no'             => $request->passport_no,
            'joining_date'            => Carbon::createFromFormat('d/m/Y', $request->joining_date )->format('Y-m-d H:i:s'),
            'blood_group'             => $request->blood_group,
            'employee_photo'          => $request->employee_photo,
            'division_id'             => $request->division_id,
            'district_id'             => $request->district_id,
            'employee_address'        => $request->employee_address,
            'created_at'              => date('Y-m-d H:i:s'),
        );

        if ($request->hasFile('employee_photo')) {
            $files      = $request->file('employee_photo');
            $file_name_WithExt   = $files->getClientOriginalName();
            $extension  = strtolower($files->getClientOriginalExtension());
            $file_name = Str::slug(pathinfo($file_name_WithExt, PATHINFO_FILENAME)) . "." . $extension;
            //$size       = $files->getSize();
            //$fileType   = $files->getClientMimeType();
            $dest_path = storage_path() . '/uploads/employee-photo/';
            $success    = $files->move( $dest_path, $file_name );

            if ($success) { $data['employee_photo'] = $file_name; }
        }

        DB::table('employees')->insert( $data );

        return redirect('/employee/employee-management')->with('success', 'Created New Employees Successfully!');
    }


    public function update_employee( Request $request ){
        if ($request->isMethod('get')){
            if ( $request->ajax() ) {
                $employee_info = DB::table('employees')->where('employee_id', $request->id)
                    ->leftjoin('divisions', 'employees.division_id', '=', 'divisions.division_id')
                    ->leftjoin('districts', 'employees.district_id', '=', 'districts.district_id')
                    ->select('employees.*', 'districts.district_id', 'districts.district_name')
                    ->first();

                $designation_name = DB::table('designations')->where('designation_id', $employee_info->designation_id)->value('designation_name');
                return response()->json( [$employee_info, 'designation_name'=>$designation_name] );
            }
        }else{
            $data = array(
                'employee_type'           => $request->employee_type,
                'employee_name'           => $request->employee_name,
                'employee_code'           => $request->employee_code,
                'cardID'                  => $request->cardID,
                'employee_fathers_name'   => $request->employee_fathers_name,
                'employee_mothers_name'   => $request->employee_mothers_name,
                'employee_mobile'         => $request->employee_mobile,
                'employee_alt_mobile'     => $request->employee_alt_mobile,
                'employee_email'          => $request->employee_email,
                'department_id'           => $request->department_id,
                'designation_id'          => $request->designation_id,
                //'branch_id'             => $request->branch_id,
                'employee_gender'         => $request->employee_gender,
                'marital_status'          => $request->marital_status,
                'employee_dob'            => Carbon::createFromFormat('d/m/Y', $request->employee_dob )->format('Y-m-d H:i:s'),
                'employee_religion'       => $request->employee_religion,
                'employee_nationality'    => $request->employee_nationality,
                'employee_nid'            => $request->employee_nid,
                'birth_certificate'            => $request->birth_certificate,
                'passport_no'            => $request->passport_no,
                'joining_date'            => Carbon::createFromFormat('d/m/Y', $request->joining_date )->format('Y-m-d H:i:s'),
                'blood_group'            => $request->blood_group,
                'employee_photo'          => $request->employee_photo,
                'division_id'             => $request->division_id,
                'district_id'             => $request->district_id,
                'employee_address'        => $request->employee_address,
                'updated_at'              => date('Y-m-d H:i:s'),
            );

            if ($request->hasFile('employee_photo')) {
                $files      = $request->file('employee_photo');
                $file_name_WithExt   = $files->getClientOriginalName();
                $extension  = strtolower($files->getClientOriginalExtension());
                $file_name = Str::slug(pathinfo($file_name_WithExt, PATHINFO_FILENAME)) . "." . $extension;
                //$size       = $files->getSize();
                //$fileType   = $files->getClientMimeType();
                $dest_path = storage_path() . '/uploads/employee-photo/';
                $success    = $files->move( $dest_path, $file_name );

                if ($success) { $data['employee_photo'] = $file_name; }

                //Delete Old file
                if($request->employee_photo_prev){ unlink( $dest_path . $request->employee_photo_prev ); }
            }else{
                $data['employee_photo'] = $request->employee_photo_prev;
            }
            DB::table('employees')->where('employee_id', $request->employee_id)->update( $data );

            return redirect('/employee/employee-management')->with('success', 'Update Employees Successfully!');
        }
    }

    public function view_employee(Request $request, $employee_id ) {

        //To get employee id in first load (fix error)
        $employee_data = DB::table('employees')->where('employee_id', $employee_id)->first();
        $manage_employee = view('pages.employees.view-employee')
                //->with('all_employee_info', $employee_info)
                ->with('employee_data', $employee_data);

        return view('dashboard')->with('main_content', $manage_employee);
    }

    public function view_employee_tab(Request $request, $employee_id, $tab_id ) {
//        $employee_info = DB::table('employees')
//        ->leftjoin('districts', 'employees.district_id', '=', 'districts.district_id')
//        ->leftjoin('departments', 'employees.department_id', '=', 'departments.department_id')
//        ->leftjoin('designations', 'employees.designation_id', '=', 'designations.designation_id')
//        ->select('employees.*', 'districts.district_name', 'departments.department_name', 'designations.designation_name')
//        ->where('employee_id', $employee_id)
//        ->get();

        //To get employee id in tabs
        $employee_data = DB::table('employees')->where('employee_id', $employee_id)->first();

        $data = view('pages.employees.tab-employee-' . $tab_id)->with('employee_data', $employee_data);

        return response($data, 200)->header('Content-Type', 'text/plain');
    }

	public function delete_employee( Request $request, $employee_id) {
        if ( $request->ajax() ) {
            DB::table('employees')->where('employee_id', $employee_id)->delete();
            $photo = DB::table('employees')->where('employee_id', $employee_id)->value('employee_photo');

            if ($photo){
                //$directory = strtolower(storage_path() . '/uploads/employee-photo');
                //unlink( $directory ."/". $photo );
                Storage::disk('uploads')->delete('employee-photo/'.$photo);
            }
            return response()->json(['success' => 'Employee has been deleted successfully!', 'status' => 'success']);
        }
        return response(['error' => 'Failed deleting the employee', 'status' => 'failed']);
    }


    public function get_designation(Request $request, $id)
    {
        if ( $request->ajax() ) {
            $designations = DB::table("designations")->where("department_id", $id)->orderBy('designation_name', 'ASC')->pluck("designation_name","designation_id");
            return response()->json( $designations );
        }
    }



    /***********************************
     * Employee Education
     * *********/
    public function add_employee_education(Request $request) {
        if ( $request->ajax() ) {
            $data = array(
                'employee_id'     => $request->employee_id,
                'degree_level'     => $request->degree_level,
                'degree_name'      => $request->degree_name,
                'major_subject'    => $request->major_subject,
                'board_university' => $request->board_university,
                'passing_year'     => $request->passing_year,
                'education_result' => $request->education_result,
                'created_at'       => date('Y-m-d H:i:s'),
            );
            $lastId = DB::table('employee_educations')->insertGetId( $data );

            $data['education_id'] = $lastId;
            return response()->json(['success' => 'Save Education Successfully!', $data, 'status' => 'success']);
        }
    }

    public function edit_employee_education(Request $request, $education_id) {
        if ( $request->ajax() ) {

            $education_info = DB::table('employee_educations')->where('education_id', $education_id)->first();
            return response()->json( $education_info );
        }
    }

    public function update_employee_education( Request $request ){
        if ( $request->ajax() ) {

            $education_id = $request->education_id;

            $data = array(
                'employee_id'      => $request->employee_id,
                'degree_level'     => $request->degree_level,
                'degree_name'      => $request->degree_name,
                'major_subject'    => $request->major_subject,
                'board_university' => $request->board_university,
                'passing_year'     => $request->passing_year,
                'education_result' => $request->education_result,
                'updated_at'       => date('Y-m-d H:i:s'),
            );
            DB::table('employee_educations')->where('education_id', $education_id)->update( $data );

            $data['education_id'] = $education_id;
            return response()->json(['success' => 'Record has been updated successfully!', $data, 'status' => 'success']);
        }
    }

    public function delete_employee_education( Request $request, $education_id) {
        if ( $request->ajax() ) {
            DB::table('employee_educations')->where('education_id', $education_id)->delete();

            return response()->json(['success' => 'Education has been deleted successfully!', 'status' => 'success']);
        }
        return response(['error' => 'Failed deleting the Education', 'status' => 'failed']);
    }



    /***********************************
     * Employee Training
     * *********/
    public function add_employee_training(Request $request) {
        if ( $request->ajax() ) {
            $data = array(
                'employee_id'       => $request->employee_id,
                'training_name'     => $request->training_name,
                'start_date'        => Carbon::createFromFormat('d/m/Y', $request->start_date )->format('Y-m-d H:i:s'),
                'end_date'          => Carbon::createFromFormat('d/m/Y', $request->end_date )->format('Y-m-d H:i:s'),
                'training_duration' => $request->training_duration,
                'training_result'   => $request->training_result,
                'certified_by'      => $request->certified_by,
                'created_at'        => date('Y-m-d H:i:s'),
            );
            $lastId = DB::table('employee_trainings')->insertGetId( $data );

            $data['training_id'] = $lastId;
            return response()->json(['success' => 'Save Training Successfully!', $data, 'status' => 'success']);
        }
    }

    public function edit_employee_training(Request $request, $training_id) {
        if ( $request->ajax() ) {

            $training_info = DB::table('employee_trainings')->where('training_id', $training_id)->first();
            return response()->json( $training_info );
        }
    }

    public function update_employee_training( Request $request ){
        if ( $request->ajax() ) {

            $training_id = $request->training_id;

            $data = array(
                'employee_id'      => $request->employee_id,
                'training_name'     => $request->training_name,
                'start_date'        => Carbon::createFromFormat('d/m/Y', $request->start_date )->format('Y-m-d H:i:s'),
                'end_date'          => Carbon::createFromFormat('d/m/Y', $request->end_date )->format('Y-m-d H:i:s'),
                'training_duration' => $request->training_duration,
                'training_result'   => $request->training_result,
                'certified_by'      => $request->certified_by,
                'updated_at'       => date('Y-m-d H:i:s'),
            );
            DB::table('employee_trainings')->where('training_id', $training_id)->update( $data );

            $data['training_id'] = $training_id;
            return response()->json(['success' => 'Record has been updated successfully!', $data, 'status' => 'success']);
        }
    }

    public function delete_employee_training( Request $request, $training_id) {
        if ( $request->ajax() ) {
            DB::table('employee_trainings')->where('training_id', $training_id)->delete();

            return response()->json(['success' => 'Training has been deleted successfully!', 'status' => 'success']);
        }
        return response(['error' => 'Failed deleting the Training', 'status' => 'failed']);
    }


    /***********************************
     * Employee Experience
     * *********/
    public function add_employee_experience(Request $request) {
        if ( $request->ajax() ) {
            $data = array(
                'employee_id'         => $request->employee_id,
                'company_name'        => $request->company_name,
                'position'            => $request->position,
                'start_date'          => Carbon::createFromFormat('d/m/Y', $request->start_date )->format('Y-m-d H:i:s'),
                'end_date'            => Carbon::createFromFormat('d/m/Y', $request->end_date )->format('Y-m-d H:i:s'),
                'experience_duration' => $request->experience_duration,
                'responsibilities'    => $request->responsibilities,
                'created_at'          => date('Y-m-d H:i:s'),
            );
            $lastId = DB::table('employee_experiences')->insertGetId( $data );

            $data['experience_id'] = $lastId;
            return response()->json(['success' => 'Save Experience Successfully!', $data, 'status' => 'success']);
        }
    }

    public function edit_employee_experience(Request $request, $experience_id) {
        if ( $request->ajax() ) {

            $experience_info = DB::table('employee_experiences')->where('experience_id', $experience_id)->first();
            return response()->json( $experience_info );
        }
    }

    public function update_employee_experience( Request $request ){
        if ( $request->ajax() ) {

            $experience_id = $request->experience_id;

            $data = array(
                'employee_id'         => $request->employee_id,
                'company_name'        => $request->company_name,
                'position'            => $request->position,
                'start_date'          => Carbon::createFromFormat('d/m/Y', $request->start_date )->format('Y-m-d H:i:s'),
                'end_date'            => Carbon::createFromFormat('d/m/Y', $request->end_date )->format('Y-m-d H:i:s'),
                'experience_duration' => $request->experience_duration,
                'responsibilities'    => $request->responsibilities,
                'updated_at'       => date('Y-m-d H:i:s'),
            );
            DB::table('employee_experiences')->where('experience_id', $experience_id)->update( $data );

            $data['experience_id'] = $experience_id;
            return response()->json(['success' => 'Record has been updated successfully!', $data, 'status' => 'success']);
        }
    }

    public function delete_employee_experience( Request $request, $experience_id) {
        if ( $request->ajax() ) {
            DB::table('employee_experiences')->where('experience_id', $experience_id)->delete();

            return response()->json(['success' => 'Experience has been deleted successfully!', 'status' => 'success']);
        }
        return response(['error' => 'Failed deleting the Experience', 'status' => 'failed']);
    }



    /***********************************
     * Employee Certificate
     * *********/
    public function add_employee_certificate(Request $request) {
        if ( $request->ajax() ) {
            $data = array(
                'employee_id'      => $request->employee_id,
                'certificate_name' => $request->certificate_name,
                'certificate_no'   => $request->certificate_no,
                'certified_by'     => $request->certified_by,
                'certificate_year' => $request->certificate_year,
                'created_at'       => date('Y-m-d H:i:s'),
            );
            $lastId = DB::table('employee_certificates')->insertGetId( $data );

            $data['certificate_id'] = $lastId;
            return response()->json(['success' => 'Save Certificate Successfully!', $data, 'status' => 'success']);
        }
    }


    public function edit_employee_certificate(Request $request, $certificate_id) {
        if ( $request->ajax() ) {

            $certificate_info = DB::table('employee_certificates')->where('certificate_id', $certificate_id)->first();
            return response()->json( $certificate_info );
        }
    }

    public function update_employee_certificate( Request $request ){
        if ( $request->ajax() ) {

            $certificate_id = $request->certificate_id;

            $data = array(
                'employee_id'      => $request->employee_id,
                'certificate_name' => $request->certificate_name,
                'certificate_no'   => $request->certificate_no,
                'certified_by'     => $request->certified_by,
                'certificate_year' => $request->certificate_year,
                'updated_at'       => date('Y-m-d H:i:s'),
            );
            DB::table('employee_certificates')->where('certificate_id', $certificate_id)->update( $data );

            $data['certificate_id'] = $certificate_id;
            return response()->json(['success' => 'Record has been updated successfully!', $data, 'status' => 'success']);
        }
    }

    public function delete_employee_certificate( Request $request, $certificate_id) {
        if ( $request->ajax() ) {
            DB::table('employee_certificates')->where('certificate_id', $certificate_id)->delete();

            return response()->json(['success' => 'Certificate has been deleted successfully!', 'status' => 'success']);
        }
        return response(['error' => 'Failed deleting the Certificate', 'status' => 'failed']);
    }



    /***********************************
     * Department
     * *********/

    public function new_department_save(Request $request) {
        if ( $request->ajax() ) {
            $data = array(
                'department_name' => $request->department_name,
                'created_at' => date('Y-m-d H:i:s'),
            );
            $lastId = DB::table('departments')->insertGetId( $data );

            $data['department_id'] = $lastId;
            return response()->json(['success' => 'Save Department Successfully!', $data, 'status' => 'success']);
        }
    }

    public function edit_department(Request $request, $department_id) {
        if ( $request->ajax() ) {

            $department_info = DB::table('departments')->where('department_id', $department_id)->first();
            return response()->json( $department_info );
        }
    }

    public function update_department( Request $request ){
        if ( $request->ajax() ) {

            $department_id = $request->id;

            $data = array();
            $data['department_name'] = $request->department_name;
            $data['updated_at']     = date('Y-m-d H:i:s');
            DB::table('departments')->where('department_id', $department_id)->update( $data );

            $data['department_id'] = $department_id;
            return response()->json(['success' => 'Record has been updated successfully!', $data, 'status' => 'success']);
        }
    }

    public function delete_department( Request $request, $department_id) {
        if ( $request->ajax() ) {
            DB::table('departments')->where('department_id', $department_id)->delete();

            return response()->json(['success' => 'Record has been deleted successfully!', 'status' => 'success']);
        }
        return response(['error' => 'Failed deleting the Department', 'status' => 'failed']);
    }

    public function cancel_update_department(Request $request) {
        if ( $request->ajax() ) {
            $department_id = $request->id;

            $department_info = DB::table('departments')->where('department_id', $department_id)->first();
            return response()->json( $department_info );
        }
    }

    public function view_department_wise_employee($department_id) {
        $employee_info = DB::table('employees')
            ->leftjoin('districts', 'employees.district_id', '=', 'districts.district_id')
            ->leftjoin('departments', 'employees.department_id', '=', 'departments.department_id')
            ->leftjoin('designations', 'employees.designation_id', '=', 'designations.designation_id')
            ->select('employees.*', 'districts.district_name', 'departments.department_name', 'designations.designation_name')
            ->where('employees.department_id', $department_id)
            ->get();

        $manage_employee = view('pages.employees.department-wise-employee')->with('all_employee_info', $employee_info);

        return view('dashboard')->with('main_content', $manage_employee);
    }


    /***********************************
     * Designation
     * *********/

    public function new_designation_save(Request $request) {
        if ( $request->ajax() ) {
            $data = array(
                'designation_name' => $request->designation_name,
                'department_id'    => $request->department_id,
                'created_at'       => date('Y-m-d H:i:s'),
            );
            $lastId = DB::table('designations')->insertGetId( $data );

            $department_name = DB::table('departments')->where('department_id', $request->department_id)->value('department_name');
            $data['designation_id'] = $lastId;
            return response()->json(['success' => 'Save Designation Successfully!', $data, 'status' => 'success', 'department_name'=>$department_name ]);
        }
    }

    public function edit_designation(Request $request, $designation_id) {
        if ( $request->ajax() ) {
            $designation_info = DB::table('designations')->where('designation_id', $designation_id)->first();
            $department_info = DB::table('departments')->orderBy('department_name', 'ASC')->pluck("department_name", "department_id");

            return response()->json( [$designation_info, 'department_info'=>$department_info] );
        }
    }

    public function update_designation( Request $request ){
        if ( $request->ajax() ) {

            $designation_id = $request->id;

            $data = array(
                'designation_name' => $request->designation_name,
                'department_id'    => $request->department_id,
                'updated_at'       => date('Y-m-d H:i:s'),
            );
            DB::table('designations')->where('designation_id', $designation_id)->update( $data );

            $department_name = DB::table('departments')->where('department_id', $request->department_id)->value('department_name');
            $data['designation_id'] = $designation_id;
            return response()->json(['success' => 'Record has been updated successfully!', $data, 'status' => 'success', 'department_name'=>$department_name]);
        }
    }

    public function delete_designation( Request $request, $designation_id) {
        if ( $request->ajax() ) {
            DB::table('designations')->where('designation_id', $designation_id)->delete();

            return response()->json(['success' => 'Record has been deleted successfully!', 'status' => 'success']);
        }
        return response(['error' => 'Failed deleting the Designation', 'status' => 'failed']);
    }

    public function cancel_update_designation(Request $request) {
        if ( $request->ajax() ) {
            $designation_id = $request->id;

            $designation_info = DB::table('designations')->where('designation_id', $designation_id)->first();
            $department_name = DB::table('departments')->where('department_id', $designation_info->department_id)->value('department_name');

            return response()->json( [$designation_info, 'department_name'=>$department_name] );
        }
    }

    public function view_designation_wise_employee($designation_id) {
        $employee_info = DB::table('employees')
            ->leftjoin('districts', 'employees.district_id', '=', 'districts.district_id')
            ->leftjoin('departments', 'employees.department_id', '=', 'departments.department_id')
            ->leftjoin('designations', 'employees.designation_id', '=', 'designations.designation_id')
            ->select('employees.*', 'districts.district_name', 'departments.department_name', 'designations.designation_name')
            ->where('employees.designation_id', $designation_id)
            ->get();

        $manage_employee = view('pages.employees.designation-wise-employee')->with('all_employee_info', $employee_info);

        return view('dashboard')->with('main_content', $manage_employee);
    }



    /***********************************
     * Employee Bank Account
     * *********/
    public function bank_account_management() {

        $bank_ac_info = DB::table('employee_bank_accounts')
            ->join('bank_name_lists', 'employee_bank_accounts.bank_name_id', '=', 'bank_name_lists.bank_name_id')
            ->join('employees', 'employee_bank_accounts.employee_id', '=', 'employees.employee_id')
            ->select('employee_bank_accounts.*', 'bank_name_lists.bank_name as bank_name', 'employees.employee_name')
            ->get();
        $manage_bank = view('pages.employees.employee-bank-account')->with('all_bank_ac_info', $bank_ac_info);

        return view('dashboard')->with('main_content', $manage_bank);
    }

    public function new_bank_account_save( Request $request)
    {
        //$input = $request->all();
        //dd($input); //Dump and Die

//        $validatedData = $request->validate([
//            'title' => 'required|unique:posts|max:255',
//            'body' => 'required',
//        ]);

        $data = array();
        $data['employee_id']    = $request->employee_id;
        $data['account_number']  = $request->account_number;
        $data['bank_name_id']    = $request->bank_name_id;
        $data['branch']          = $request->branch;
        $data['account_type']    = $request->account_type;
        $data['swift_code']      = $request->swift_code;
        $data['website']         = $request->website;
        $data['email']           = $request->email;
        $data['phone']           = $request->phone;
        $data['alt_phone']       = $request->alt_phone;
        $data['bank_address']    = $request->bank_address;
        $data['bank_note']       = $request->bank_note;
        $data['created_at']      = date('Y-m-d H:i:s');

        DB::table('employee_bank_accounts')->insert( $data );

        //Session::put('success', 'Created New Banks Successfully!');
        //return Redirect::to('/new-bank');
        return redirect('/employee/employee-bank-account')->with('success', 'New Bank Accounts Created Successfully!');
    }

    public function delete_bank_account( Request $request, $bank_account_id) {

        if ( $request->ajax() ) {
            DB::table('employee_bank_accounts')->where('bank_account_id', $bank_account_id)->delete();

            return response()->json(['success' => 'Bank Account has been deleted successfully!', 'status' => 'success']);
        }
        return response(['error' => 'Failed deleting the Bank Account', 'status' => 'failed']);
    }

    public function edit_bank_account(Request $request, $bank_account_id ) {
        if ( $request->ajax() ) {
            $bank_info = DB::table('employee_bank_accounts')->where('bank_account_id', $bank_account_id)->first();

            return response()->json( $bank_info );
        }
    }

    public function update_bank_account( Request $request ){

        $bank_account_id = $request->bank_account_id;

        $data = array();
        $data['employee_id']    = $request->employee_id;
        $data['account_number']  = $request->account_number;
        $data['bank_name_id']    = $request->bank_name_id;
        $data['branch']          = $request->branch;
        $data['account_type']    = $request->account_type;
        $data['swift_code']      = $request->swift_code;
        $data['website']         = $request->website;
        $data['email']           = $request->email;
        $data['phone']           = $request->phone;
        $data['alt_phone']       = $request->alt_phone;
        $data['bank_address']    = $request->bank_address;
        $data['bank_note']       = $request->bank_note;
        $data['updated_at']      = date('Y-m-d H:i:s');

        DB::table('employee_bank_accounts')->where('bank_account_id', $bank_account_id)->update( $data );

        return redirect('/employee/employee-bank-account')->with('success', 'Update Bank Account Successfully!');
    }

    public function view_bank_account( Request $request, $bank_account_id )
    {
        if ( $request->ajax() ) {
            $view_bank_accounts = DB::table('employee_bank_accounts')->where('bank_account_id', $bank_account_id )->first();
            $bank_name = DB::table('bank_name_lists')->where('bank_name_id', $view_bank_accounts->bank_name_id)->value('bank_name');
            $account_name = DB::table('employees')->where('employee_id', $view_bank_accounts->employee_id)->value('employee_name');

            return response()->json( array( $view_bank_accounts, 'bank_name' => $bank_name, 'account_name'=>$account_name) );
        }
    }
}
