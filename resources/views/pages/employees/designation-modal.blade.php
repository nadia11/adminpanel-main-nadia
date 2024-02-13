<div class="modal fade" id="designationModal">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">

            <!-- Modal Header -->
            <div class="modal-header">
                <h4 class="modal-title">Designation</h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>

            <!-- Modal body -->
            <div class="modal-body">
                <table id="designation_table" class="table table-custom table-input-form m-0">
                    <thead class="thead-light">
                        <tr>
                            <th>#</th>
                            <th>Department</th>
                            <th>Designation Name</th>
                            <th>Assigned Employee</th>
                            <th>Employee Qty.</th>
                            <th data-orderable="false" style="width:130px;">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $all_designations = DB::table('designations')->leftjoin('departments', 'designations.department_id', 'departments.department_id')->select('designations.*', 'departments.department_name')->get(); ?>

                        @if (count($all_designations) < 1) <tr style="height: 50px;"><td colspan="5">No Items Found</td></tr> @endif

                        @foreach($all_designations as $designation)
                        <tr id="cat-{{ $designation->designation_id }}">
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $designation->department_name }}</td>
                            <td>{{ $designation->designation_name }}</td>
                            <td><a href="{{ URL::to('/employee/designation/view-employee/' . $designation->designation_id) }}" target="_blank">View Employee</a></td>
                            <td>{{ DB::table('employees')->where('designation_id', $designation->designation_id)->count() }}</td>
                            <td>
                                <div class="btn-group" role="group">
                                    <button type="button" class="btn btn-warning btn-sm btn-flat editDesignation" id="{{ $designation->designation_id }}" style="margin: 5px 0;"><i class="fa fa-edit" aria-hidden="true"> Edit</i></button>
                                    <button type="button" class="btn btn-danger btn-sm btn-flat ajaxDelete" data-href="{{ URL::to('/employee/delete-designation/' . $designation->designation_id) }}" data-title="{{ $designation->designation_name }}" id="{{ $designation->designation_id }}" style="margin: 5px 0;"><i class="far fa-trash-alt" aria-hidden="true"> Delete</i></button>
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div><!-- Modal Body -->

            <!-- Modal footer -->
            <div class="modal-footer">
                <div class="input-group">
                    <select id="department_id" class="custom-select" required>
                        <option value="">--Select Department--</option>
                        <?php $departments = DB::table('departments')->orderBy('department_name', 'ASC')->pluck("department_name", "department_id"); ?>

                        @foreach($departments as $id => $name )
                            <option value="{{ $id }}">{{ $name }}</option>
                        @endforeach
                    </select>
                    <input type="text" id="designation_name" placeholder="Designation name" class="form-control" required="required" autocomplete="off" style="width: 40%;" />
                    <div class="input-group-append">
                        <span class="input-group-btn">
                            <button type="submit" id="create_designation" class="btn btn-success float-right" tabindex="8"><i class="fa fa-plus" aria-hidden="true"></i> Add Designation</button>
                        </span>
                    </div>
                </div>
            </div><!-- Modal footer -->
        </div>
    </div>
</div>
