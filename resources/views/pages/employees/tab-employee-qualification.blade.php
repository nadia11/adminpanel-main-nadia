<div style="margin: 20px 0;">
    <h2 class="float-left">Employee Education Information</h2>
    <button type="button" class="btn btn-info btn-sm btn-square showNewEducationModal float-right"><i class="fa fa-plus"></i> Add Education Information</button>
</div>

<div class="table-responsive" style="min-height: 200px; border: 1px solid #ddd;">
    <table class="table table-striped table-custom" id="employee_education_table">
        <thead class="thead-dark">
            <tr>
                <th>#</th>
                <th id="degree_level">Degree Level</th>
                <th id="degree_name">Degree</th>
                <th id="passing_year">Passing Year</th>
                <th id="board_university">Board / University</th>
                <th id="major_subject">Major</th>
                <th id="education_result">Result</th>
                <th data-orderable="false" class="no-print" style="width:80px;">Action</th>
            </tr>
        </thead>
        <tbody>
        @php $employee_id = $employee_data->employee_id @endphp
        @php $education_info = DB::table('employee_educations')->where('employee_id', $employee_id)->get() @endphp
        @foreach( $education_info as $education )
            <tr id="{{ $education->education_id }}">
                <td>{{ $loop->iteration }}</td>
                <td>{{ $education->degree_level }}</td>
                <td>{{ $education->degree_name }}</td>
                <td>{{ $education->passing_year }}</td>
                <td>{{ $education->board_university }}</td>
                <td>{{ $education->major_subject }}</td>
                <td>{{ $education->education_result }}</td>
                <td>
                    <button type="button" class="btn btn-warning btn-sm editEducation" id="{{ $education->education_id }}" data-url="{{ url('/employee/edit-employee-education/' .  $education->education_id) }}" data-toggle="tooltip" data-placement="top" title="Edit Education"><i class="fa fa-edit" aria-hidden="true"></i></button>
                    <button type="button" class="ajaxDelete btn btn-danger btn-sm" data-href="{{ URL::to('/employee/delete-employee-education/' . $education->education_id) }}" data-title="{{ $education->degree_level }}" id="{{ $education->education_id }}" data-toggle="tooltip" data-placement="top" title="Delete this Education"><i class="far fa-trash-alt" aria-hidden="true"></i></button>
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>
</div>



<div style="margin: 30px 0;">
    <h2 class="float-left">Employee Training Information</h2>
    <button type="button" class="btn btn-info btn-sm btn-square showNewTrainingModal float-right"><i class="fa fa-plus"></i> Add Training Information</button>
</div>
<div class="table-responsive" style="min-height: 200px; border: 1px solid #ddd;">
    <table class="table table-striped table-custom" id="employee_training_table">
        <thead class="thead-dark">
            <tr>
                <th>#</th>
                <th>Training Name</th>
                <th>Start Date</th>
                <th>End Date</th>
                <th>Duration (Hours)</th>
                <th>Result</th>
                <th>Certified By</th>
                <th data-orderable="false" class="no-print" style="width:80px;">Action</th>
            </tr>
        </thead>
        <tbody>
            @php $employee_id = $employee_data->employee_id @endphp
            @php $training_info = DB::table('employee_trainings')->where('employee_id', $employee_id)->get() @endphp
            @foreach( $training_info as $training )
            <tr id="{{ $training->training_id }}">
                <td>{{ $loop->iteration }}</td>
                <td>{{ $training->training_name }}</td>
                <td>{{ $training->start_date }}</td>
                <td>{{ $training->end_date }}</td>
                <td>{{ $training->training_duration }}</td>
                <td>{{ $training->training_result }}</td>
                <td>{{ $training->certified_by }}</td>
                <td>
                    <button type="button" class="btn btn-warning btn-sm editTraining" id="{{ $training->training_id }}" data-url="{{ url('/employee/edit-employee-training/' .  $training->training_id) }}" data-toggle="tooltip" data-placement="top" title="Edit Training"><i class="fa fa-edit" aria-hidden="true"></i></button>
                    <button type="button" class="ajaxDelete btn btn-danger btn-sm" data-href="{{ URL::to('/employee/delete-employee-training/' . $training->training_id) }}" data-title="{{ $training->training_name }}" id="{{ $training->training_id }}" data-toggle="tooltip" data-placement="top" title="Delete this Training"><i class="far fa-trash-alt" aria-hidden="true"></i></button>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>



<div style="margin: 30px 0;">
    <h2 class="float-left">Employee Experience Information</h2>
    <button type="button" class="btn btn-info btn-sm btn-square showNewExperienceModal float-right"><i class="fa fa-plus"></i> Add Experience Information</button>
</div>

<div class="table-responsive" style="min-height: 200px; border: 1px solid #ddd;">
    <table class="multi_datatable table table-striped table-custom" id="employee_experience_table">
        <thead class="thead-dark">
            <tr>
                <th>#</th>
                <th>Company Name</th>
                <th>Position</th>
                <th>Start Date</th>
                <th>End Date</th>
                <th>Duration</th>
                <th>Responsibilities</th>
                <th data-orderable="false" class="no-print" style="width:80px;">Action</th>
            </tr>
        </thead>
        <tbody>
            @php $employee_id = $employee_data->employee_id @endphp
            @php $experience_info = DB::table('employee_experiences')->where('employee_id', $employee_id)->get() @endphp
            @foreach( $experience_info as $experience )
            <tr id="{{ $experience->experience_id }}">
                <td>{{ $loop->iteration }}</td>
                <td>{{ $experience->company_name }}</td>
                <td>{{ $experience->position }}</td>
                <td>{{ $experience->start_date }}</td>
                <td>{{ $experience->end_date }}</td>
                <td>{{ $experience->experience_duration }}</td>
                <td>{{ $experience->responsibilities }}</td>
                <td>
                    <button type="button" class="btn btn-warning btn-sm editExperience" id="{{ $experience->experience_id }}" data-url="{{ url('/employee/edit-employee-experience/' .  $experience->experience_id) }}" data-toggle="tooltip" data-placement="top" title="Edit Training"><i class="fa fa-edit" aria-hidden="true"></i></button>
                    <button type="button" class="ajaxDelete btn btn-danger btn-sm" data-href="{{ URL::to('/employee/delete-employee-experience/' . $experience->experience_id) }}" data-title="{{ $experience->company_name }}" id="{{ $experience->experience_id }}" data-toggle="tooltip" data-placement="top" title="Delete this Experience"><i class="far fa-trash-alt" aria-hidden="true"></i></button>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>



<div style="margin: 30px 0;">
    <h2 class="float-left">Professional Certificate Information</h2>
    <button type="button" class="btn btn-info btn-sm btn-square showNewCertificateModal float-right"><i class="fa fa-plus"></i> Add Professional Certificate Information</button>
</div>

<div class="table-responsive" style="min-height: 200px; border: 1px solid #ddd;">
    <table class="multi_datatable table table-striped table-custom" id="employee_certificate_table">
        <thead class="thead-dark">
            <tr>
                <th>#</th>
                <th>Certificate Name</th>
                <th>Certificate No</th>
                <th>Certified By</th>
                <th>Year</th>
                <th data-orderable="false" class="no-print" style="width:80px;">Action</th>
            </tr>
        </thead>
        <tbody>
            @php $employee_id = $employee_data->employee_id @endphp
            @php $certificate_info = DB::table('employee_certificates')->where('employee_id', $employee_id)->get() @endphp
            @foreach( $certificate_info as $certificate )
            <tr id="{{ $certificate->certificate_id }}">
                <td>{{ $loop->iteration }}</td>
                <td>{{ $certificate->certificate_name }}</td>
                <td>{{ $certificate->certificate_no }}</td>
                <td>{{ $certificate->certified_by }}</td>
                <td>{{ $certificate->certificate_year }}</td>
                <td>
                    <button type="button" class="btn btn-warning btn-sm editCertificate" id="{{ $certificate->certificate_id }}" data-url="{{ url('/employee/edit-employee-certificate/' .  $certificate->certificate_id) }}" data-toggle="tooltip" data-placement="top" title="Edit Training"><i class="fa fa-edit" aria-hidden="true"></i></button>
                    <button type="button" class="ajaxDelete btn btn-danger btn-sm" data-href="{{ URL::to('/employee/delete-employee-certificate/' . $certificate->certificate_id) }}" data-title="{{ $certificate->certificate_name }}" id="{{ $certificate->certificate_id }}" data-toggle="tooltip" data-placement="top" title="Delete this Certificate"><i class="far fa-trash-alt" aria-hidden="true"></i></button>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
