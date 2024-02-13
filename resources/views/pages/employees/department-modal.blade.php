<div class="modal fade" id="departmentModal">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">

            <!-- Modal Header -->
            <div class="modal-header">
                <h4 class="modal-title">Department</h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>

            <!-- Modal body -->
            <div class="modal-body">
                <table id="department_table" class="table table-bordered table-input-form m-0">
                    <thead class="thead-light">
                        <tr>
                            <th>#</th>
                            <th>Department Name</th>
                            <th>Assigned Employee</th>
                            <th>Employee Qty.</th>
                            <th data-orderable="false" class="no-print" style="width:130px;">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $all_departments = DB::table('departments')->get(); ?>

                        @if (count($all_departments) < 1) <tr style="height: 50px;"><td colspan="5">No Items Found</td></tr> @endif

                        @foreach($all_departments as $department)
                        <tr id="cat-{{ $department->department_id }}">
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $department->department_name }}</td>
                            <td><a href="{{ URL::to('/employee/department/view-employee/' . $department->department_id) }}" target="_blank">View Employee</a></td>
                            <td>{{ DB::table('employees')->where('department_id', $department->department_id)->count() }}</td>
                            <td>
                                <div class="btn-group" role="group">
                                    <button type="button" class="btn btn-warning btn-sm btn-flat editDepartment" id="{{ $department->department_id }}" style="margin: 5px 0;"><i class="fa fa-edit" aria-hidden="true"> Edit</i></button>
                                    <button type="button" class="btn btn-danger btn-sm btn-flat ajaxDelete" data-href="{{ URL::to('/employee/delete-department/' . $department->department_id) }}" data-title="{{ $department->department_name }}" id="{{ $department->department_id }}" style="margin: 5px 0;"><i class="far fa-trash-alt" aria-hidden="true"> Delete</i></button>
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
                    <input type="text" name="department_name" id="department_name" placeholder="Department name" class="form-control" required="required" tabindex="1" autocomplete="off" />
                    <div class="input-group-append">
                        <span class="input-group-btn">
                            <button type="submit" name="create_department" id="create_department" class="btn btn-success float-right" tabindex="8"><i class="fa fa-plus" aria-hidden="true"></i> Add Department</button>
                        </span>
                    </div>
                </div>
            </div><!-- Modal footer -->
        </div>
    </div>
</div>
