<div class="modal fade" id="userRoleModal">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">

            <!-- Modal Header -->
            <div class="modal-header">
                <h4 class="modal-title">User Role</h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            
            <!-- Modal body -->
            <div class="modal-body">
                <table id="user_role_table" class="table table-bordered table-input-form m-0">
                    <thead class="thead-light">
                    <tr>
                        <th>#</th>
                        <th>Role Name</th>
                        <th>Users Count</th>
                        <th>Role description</th>
                        <th data-orderable="false" class="no-print" style="width:130px;">Action</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php $user_roles = DB::table('user_roles')->orderBy('role_id', "ASC")->get(); ?>
                    @foreach($user_roles as $role)
                        <tr id="{{ $role->role_id }}">
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ str_snack($role->role_name) }}</td>
                            <td><a href="{{ URL::to('/admin/role-wise-users/' . $role->role_id) }}" target="_blank">{{ DB::table('users')->where('role_id', $role->role_id)->count() }}</a></td>
                            <td>{{ $role->role_description }}</td>
                            <td>
                                <div class="btn-group" role="group">
                                    <button type="button" class="btn btn-warning btn-sm btn-flat editRole" id="{{ $role->role_id }}" style="margin: 5px 0;"><i class="fa fa-edit" aria-hidden="true"> Edit</i></button>
                                    <button type="button" class="btn btn-danger btn-sm btn-flat ajaxDelete" data-href="{{ URL::to('/admin/delete-role/' . $role->role_id) }}" data-title="{{ $role->role_name }}" id="{{ $role->role_id }}" style="margin: 5px 0;"><i class="fa fa-trash" aria-hidden="true"> Delete</i></button>
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
                    <input type="text" name="role_name" id="role_name" placeholder="Role Name" class="form-control" tabindex="1" autocomplete="off" style="width: 10%; text-align: center;" />
                    <input type="text" name="role_description" id="role_description" placeholder="Role Description" class="form-control" tabindex="2" autocomplete="off" style="width: 80%;" />
                    <div class="input-group-append">
                        <span class="input-group-btn">
                            <button type="submit" id="create_role" class="btn btn-success float-right" tabindex="3"><i class="fa fa-plus" aria-hidden="true"></i> Add Role</button>
                        </span>
                    </div>
                </div>
            </div><!-- Modal footer -->
        </div>
    </div>
</div>




<script type="text/javascript">
    $(document).ready(function (){
        $("body").on("click", "button#create_role", function(event){
            event.preventDefault();

            var role_name = $(this).parents('.modal-footer').find('#role_name').val();
            var role_description = $(this).parents('.modal-footer').find('#role_description').val();

            if(!role_name) return;

            $.ajaxSetup({
                headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') }
            });

            $.ajax({
                type: "POST",
                url: "{{ url('/admin/new-role-save') }}",
                data: {role_name: role_name, role_description:role_description } ,
                dataType: 'json',
                success: function (data) {
                    $("#user_role_table").find('tbody').prepend(
                        '<tr id="'+ data[0].role_id +'">'
                        + '<td>'+ data[0].role_id +'</td>'
                        + '<td>'+ data[0].role_name +'</td>'
                        +'<td><a href="{{ URL::to('/admin/role-wise-users') }}'+'/'+data[0].role_id+'" target="_blank">0</a></td>'
                        + '<td>'+ (data[0].role_description ? data[0].role_description : "-") +'</td>'
                        + '<td>'
                        + '<button type="button" class="btn btn-warning btn-sm btn-flat editRole" id="'+ data[0].role_id +'" style="margin: 5px 0;"><i class="fa fa-edit" aria-hidden="true"> Edit</i></button>'
                        + '<button type="button" class="btn btn-danger btn-sm btn-flat ajaxDelete" data-href="<?php echo URL::to('/admin/delete-role'); ?>/'+ data[0].role_id +'" data-title="'+ data[0].role_name +'" id="'+ data[0].role_id +'" style="margin: 5px 0;"><i class="fa fa-trash" aria-hidden="true"> Delete</i></button>'
                        + '</td>'
                        + '</tr>'
                    );
                    $("#role_name").val('');
                    $(":input[type='text']:enabled:visible:first").focus();
                },
                error: function (xhr, textStatus, errorThrown) { alert(errorThrown); }
            });
        });


        $(document).on('click', 'button.editRole', function () {
            var id = $(this).attr('id');
            var tr_id = $(this).closest('tr').attr('id');
            var user_count = $(this).closest('tr').find('a').text();

            $.ajax({
                url: "{{ url('/admin/edit-role') }}/" + id,
                method: "get",
                dataType: "json",
                success: function( response ) {
                    $("#user_role_table tr#" + response.role_id).html(
                        '<td id="'+tr_id+'">'+tr_id+'</td>'
                        +'<td><input type="text" name="role_name" id="role_name" placeholder="Role Name" class="form-control" value="'+ response.role_name +'" style="width: 100%; text-align: center;" /></td>'
                        +'<td><a href="{{ URL::to('/admin/role-wise-users') }}'+'/'+response.role_id+'" target="_blank">'+user_count+'</a></td>'
                        +'<td><input type="text" name="role_description" id="role_description" placeholder="Role Description" class="form-control" value="'+ (response.role_description ? response.role_description: "") +'" style="width: 100%; text-align: center;" /></td>'
                        + '<td>'
                        + '<button type="button" class="btn btn-purple btn-sm btn-flat updateRole" id="'+ response.role_id +'" style="margin: 5px 0;"><i class="fa fa-edit" aria-hidden="true"> Save</i></button>'
                        + '<button type="button" class="btn btn-tomato btn-sm btn-flat cancelUpdateRole" id="'+ response.role_id +'" style="margin: 5px 0;"><i class="fa fa-times" aria-hidden="true"> Cancel</i></button>'
                        + '</td>'
                    );
                },
                statusCode:{ 404: function(){ alert( "page not found" ); } },
                beforeSend: function( xhr ) { $(".ajax-loader").show(); },
                complete: function( jqXHR, textStatus ) { $(".ajax-loader").hide(); },
            });
        });


        $("body").on("click", "button.updateRole", function(){
            var id = $(this).attr('id');
            var role_name = $(this).closest('tr').find('#role_name').val();
            var role_description = $(this).closest('tr').find('#role_description').val();
            var user_count = $(this).closest('tr').find('a').text();

            if (!confirm("Are you sure want to update this record?")) return;

            $.ajaxSetup({
                headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') }
            });

            $.ajax({
                type: "POST",
                url: "{{ url('/admin/update-role') }}",
                data: { id:id, role_name:role_name, role_description:role_description },
                success: function (data) {
                    $("#user_role_table tr#" + data[0].role_id).html(
                        '<td>'+ data[0].role_id +'</td>'
                        + '<td>'+ data[0].role_name +'</td>'
                        +'<td><a href="{{ URL::to('/admin/role-wise-users') }}'+'/'+data[0].role_id+'" target="_blank">'+user_count+'</a></td>'
                        + '<td>'+ (data[0].role_description ? data[0].role_description : "-") +'</td>'
                        + '<td>'
                        + '<button type="button" class="btn btn-warning btn-sm btn-flat editRole" id="'+ data[0].role_id +'" style="margin: 5px 0;"><i class="fa fa-edit" aria-hidden="true"> Edit</i></button>'
                        + '<button type="button" class="btn btn-danger btn-sm btn-flat ajaxDelete" data-href="<?php echo URL::to('/admin/delete-role'); ?>/'+ data[0].role_id +'" data-title="'+ data[0].role_name +'" id="'+ data[0].role_id +'" style="margin: 5px 0;"><i class="fa fa-trash" aria-hidden="true"> Delete</i></button>'
                        + '</td>'
                        + '</tr>'
                    );
                },
                error: function (xhr, textStatus, errorThrown) { alert(errorThrown); }
            });
        });


        $("body").on("click", "button.cancelUpdateRole", function(){
            var role_id = $(this).attr('id');
            var user_count = $(this).closest('tr').find('a').text();

            $.ajaxSetup({
                headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') }
            });

            $.ajax({
                type: "get",
                url: "{{ url('/admin/cancel-update-role') }}",
                data: { role_id: role_id },
                success: function (data) {
                    $("#user_role_table tr#" + data.role_id).html(
                        '<td>'+ data.role_id +'</td>'
                        + '<td>'+ data.role_name +'</td>'
                        +'<td><a href="{{ URL::to('/admin/role-wise-users') }}'+'/'+data.role_id+'" target="_blank">'+user_count+'</a></td>'
                        + '<td>'+ (data.role_description ? data.role_description : "-") +'</td>'
                        + '<td>'
                        + '<button type="button" class="btn btn-warning btn-sm btn-flat editRole" id="'+ data.role_id +'" style="margin: 5px 0;"><i class="fa fa-edit" aria-hidden="true"> Edit</i></button>'
                        + '<button type="button" class="btn btn-danger btn-sm btn-flat ajaxDelete" data-href="<?php echo URL::to('/admin/delete-role'); ?>/'+ data.role_id +'" data-title="'+ data.device_spec +'" id="'+ data.role_id +'" style="margin: 5px 0;"><i class="fa fa-trash" aria-hidden="true"> Delete</i></button>'
                        + '</td>'
                    );
                },
                error: function (xhr, textStatus, errorThrown) { alert(errorThrown); }
            });
        });
    });
</script>

