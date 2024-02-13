<div class="modal fade todo-list" id="todoModal">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">

            <!-- Modal Header -->
            <div class="modal-header">
                <h4 class="modal-title"><i class="ion ion-clipboard mr-1"></i> To Do List</h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>

            <form role="form" method="POST" enctype="multipart/form-data" class="form-horizontal">
            @csrf

                <!-- Modal body -->
                <div class="modal-body">
                    <div class="todo-tabs">
                        <ul class="nav nav-tabs nav-justified">
                            <li class="nav-item"><a class="nav-link active" data-toggle="tab" href="#active_todo_list">Active</a></li>
                            <li class="nav-item"><a class="nav-link archived" data-toggle="tab" href="#archived_todo_list">Archived</a></li>
                        </ul>
                        <div class="tab-content">
                            <i class="fa fa-spin fa-spinner" style="display: none;"></i>
                            <div class="tab-pane fade show animated fadeInRight active" id="active_todo_list">
                                <?php //$all_todos = DB::table('todo_lists')->orderBy('todo_id', 'desc')->paginate(3); ?>
                                <?php $all_todos = DB::table('todo_lists')->where('user_id', Auth::id())->where('archived_status', 'active')->orderBy('list_order', 'DESC')->get(); ?>

                                <ul class="todo-list">
                                    @foreach($all_todos as $todo)
                                        <li id="todo-{{ $todo->todo_id }}" class="{{ $todo->status }}" style="border-left: 2px solid {{ $todo->color_name }};">
                                            <span class="handle"><i class="fa fa-ellipsis-v"></i><i class="fa fa-ellipsis-v"></i></span>
                                            <input type="checkbox" id="{{ $todo->todo_id }}" data-status="{{ $todo->status === "done" ? "active" : "done" }}" {{ $todo->status === "done" ? "checked" : "" }} value="{{ $loop->iteration }}">
                                            <span class="text">{{ $todo->todo_name }} -- <i>{{ $todo->todo_description }}</i></span>
                                            <small class="badge <?php echo carbon_diff( $todo->created_at ); ?>" style="position: absolute;left: 82%;top: 35%;"><i class="fa fa-clock-o"></i><?php echo human_date( $todo->created_at ); ?></small>
                                            <div class="tools">
                                                <div class="btn-group" role="group">
                                                    <button type="button" class="btn-icon text-warning btn-flat editTodo" id="{{ $todo->todo_id }}" style="margin: 3px 0;"><i class="fa fa-edit" aria-hidden="true"></i></button>
                                                    <button type="button" class="btn-icon text-danger btn-flat archiveTodo" data-href="{{ URL::to('/todo/archive-todo/' . $todo->todo_id) }}" id="{{ $todo->todo_id }}" style="margin: 3px 0;"><i class="far fa-archive" aria-hidden="true"></i></button>
                                                </div>
                                            </div>
                                        </li>
                                    @endforeach
                                </ul>
                                @if(DB::table('todo_lists')->where('user_id', Auth::id())->where('archived_status', 'active')->doesntExist()) <div class="py-5 text-center noItemFound">No Items Found</div> @endif
                            </div>
                            <div class="tab-pane fade animated fadeInRight" id="archived_todo_list">
                                <?php //$all_todos = DB::table('todo_lists')->orderBy('todo_id', 'desc')->paginate(3); ?>
                                <?php $all_todos = DB::table('todo_lists')->where('user_id', Auth::id())->where('archived_status', 'archived')->orderBy('list_order', 'DESC')->get(); ?>

                                <ul class="todo-list">
                                    @foreach($all_todos as $todo)
                                        <li id="todo-{{ $todo->todo_id }}" class="{{ $todo->status }}" style="border-left: 2px solid {{ $todo->color_name }};">
                                            <span class="handle"><i class="fa fa-ellipsis-v"></i><i class="fa fa-ellipsis-v"></i></span>
                                            <input type="checkbox" id="{{ $todo->todo_id }}" data-status="{{ $todo->status === "done" ? "active" : "done" }}" {{ $todo->status === "done" ? "checked" : "" }} value="{{ $loop->iteration }}">
                                            <span class="text">{{ $todo->todo_name }} -- <i>{{ $todo->todo_description }}</i></span>
                                            <small class="badge <?php echo carbon_diff( $todo->created_at ); ?>" style="position: absolute;left: 82%;top: 35%;"><i class="fa fa-clock-o"></i><?php echo human_date( $todo->created_at ); ?></small>
                                            <div class="tools">
                                                <div class="btn-group" role="group">
                                                    <button type="button" class="btn-icon text-warning btn-flat editTodo" id="{{ $todo->todo_id }}" style="margin: 3px 0;"><i class="fa fa-edit" aria-hidden="true"></i></button>
                                                    <button type="button" class="btn-icon text-danger btn-flat deleteTodo" data-href="{{ URL::to('/todo/delete-todo/' . $todo->todo_id) }}" data-title="{{ $todo->todo_name }}" id="{{ $todo->todo_id }}" style="margin: 3px 0;"><i class="far fa-trash-alt" aria-hidden="true"></i></button>
                                                </div>
                                            </div>
                                        </li>
                                    @endforeach
                                </ul>
                                @if(DB::table('todo_lists')->where('user_id', Auth::id())->where('archived_status', 'archived')->doesntExist()) <div class="py-5 text-center noItemFound">No Items Found</div> @endif
                            </div>
                        </div>
                    </div>

                </div><!-- Modal Body -->

                <!-- Modal footer -->
                <div class="modal-footer">
                    <!--<ul class="pagination pagination-sm">{ $all_todos->links() }}</ul>-->
                    <div class="input-group">
                        <div id="color_name_wrap" class="input-group-prepend" style="min-width: 2%; padding: 0;" title="Select Color for priority basis">
                            <div class="dropdown">
                                <button type="button" class="btn dropdown-toggle" data-toggle="dropdown" style="background-color: #ddd;"><input type="hidden" value="#ddd" class="form-control" name="color_name" id="color_name" /></button>
                                <div class="dropdown-menu custom-scroll" style="max-height: 150px; overflow-y: scroll;">
                                    <?php $color_array = array('GRAY', 'BLACK', 'RED', 'MAROON', 'DarkRed', 'DarkMagenta', 'DarkOrchid', 'DarkSlateBlue', 'DeepPink', 'DodgerBlue', 'DarkOliveGreen', 'PaleGreen', 'PaleTurquoise', 'PaleVioletRed', 'Olive', 'Orange', 'OrangeRed', 'Gold', 'DarkOrange', 'Tomato', 'YELLOW', 'Wheat', 'GreenYellow', 'OLIVE', 'LIME', 'GREEN', 'DarkGreen', 'YellowGreen', 'AQUA', 'TEAL', 'BLUE', 'NAVY', 'MidnightBlue', 'PowderBlue', 'RoyalBlue', 'FUCHSIA', 'PURPLE', 'Indigo', 'Khaki', 'SandyBrown', 'DarkGoldenRod', 'DarkCyan', 'SlateBlue', 'Teal', 'SeaGreen', 'LightSkyBlue', 'LightGreen', 'LightPink', 'LightSeaGreen'); ?>
                                    @foreach($color_array as $color) <a class="dropdown-item colorSelector" href="#" data-color="{{ $color }}"><i style="background: {{ $color }};"></i>{{ $color }}</a> @endforeach
                                </div>
                            </div>
                        </div>
                        <input type="text" name="todo_name" id="todo_name" placeholder="To Do name" class="form-control" autocomplete="off" style="max-width: 25%;" />
                        <input name="todo_description" id="todo_description" placeholder="Description" class="form-control" style="max-width: 60%;" />
                        <div class="input-group-append">
                            <button type="submit" class="btn btn-info float-right add-todo-item"><i class="fa fa-plus"></i> Add item</button>
                        </div>
                    </div>
                </div><!-- Modal footer -->
            </form>
        </div>
    </div>
</div>


<style type="text/css">
    .todo-list { margin: 0; padding: 0; list-style: none; /*overflow: hidden;*/ }
    .todo-list > li { border-radius: 2px; padding: 10px; background: #fff; margin-bottom: 5px; border-left: 2px solid #ddd; color: #444; position: relative; }
    .todo-list > li:last-of-type { margin-bottom: 0; }
    .todo-list > li > input[type='checkbox'] { margin: 0 10px 0 5px; position: static; left: 0; opacity: 1; vertical-align: middle; }
    .todo-list > li .text { display: inline-block; margin-left: 5px; font-weight: 600; }
    .todo-list > li .label { margin-left: 10px; font-size: 9px; }
    .todo-list > li .tools { /*display: none;*/ color: #dc3545; right: 2px; top: 2px; position: absolute; }
    .todo-list > li .tools > .fa, .todo-list > li .tools > .glyphicon,
    .todo-list > li .tools > .ion { margin-right: 5px; cursor: pointer; }
    .todo-list > li:hover .tools { display: inline-block; }
    .todo-list > li.done { color: #999; }
    .todo-list > li.done .text { text-decoration: line-through; font-weight: 500; }
    .todo-list > li.done .label { background: #adb5bd !important; }
    .todo-list .danger { border-left-color: #dc3545; }
    .todo-list .warning { border-left-color: #ffc107; }
    .todo-list .info { border-left-color: #17a2b8; }
    .todo-list .success { border-left-color: #28a745; }
    .todo-list .primary { border-left-color: #007bff; }
    .todo-list .handle { display: inline-block; cursor: move; margin: 0 5px; }
    .todo-list .colorpicker:after,
    .todo-list .colorpicker:before{ content: none; }
    .todo-list .colorpicker i{ height: 30px; vertical-align: middle; width: 20px; }


    .colorSelector i{ width: 17px; height: 17px;display: inline-block; color: #fff; margin-right: 5px; vertical-align: middle;}
    .todo-tabs{}
    span.text{ color: #333;font-weight: normal !important;width: 72%;overflow: hidden;max-height: 15px;line-height: 15px;white-space: nowrap;text-overflow: ellipsis;vertical-align: text-top; }
    .todo-tabs ul.nav-tabs{ position: relative; top: 0px; margin: 0 auto 10px; font-size: 16px; line-height: 24px; color: #555; border: none; width: 50%; }
    .todo-tabs .tab-content .tab-pane{}
    .todo-tabs ul.nav-tabs .nav-link { border: 1px solid #2da5da; background-color: #fff; font-weight: normal; }
    .todo-tabs ul.nav-tabs li:first-child a{ border-right: none !important; border-radius: 30px 0 0 30px; transition: all 0.3s ease-in-out; }
    .todo-tabs ul.nav-tabs li:last-child a{ border-left: none !important; border-radius: 0 30px 30px 0; }
    .todo-tabs ul.nav-tabs .nav-link.active { color: #fff; background-color: #2da5da !important; border: 1px solid transparent; }
    .todo-tabs ul.nav-tabs,
    .todo-tabs ul.nav-tabs a {}
    .todo-tabs .tab-content{ padding: 15px; border: 3px double #9AC8FA; min-height: 300px; }
    .todo-tabs .tab-content i.fa-spin{ position: absolute; left: 50%; top: 40%; z-index: 99999; transform: translate(-50%, -50%); font-size: 60px; }
    .todo-tabs ul.nav-tabs li:hover span{}
    .todo-list > li .text:hover{ max-height: 100% !important; white-space: normal !important; }
</style>

<script type="text/javascript">
$(document).ready(function(){
    $(document).on("click", "#todoModalShow", function(event) {
        event.preventDefault();
        $('#todoModal').modal("show");
    });

    $(document).on("click", "a.colorSelector", function(event) {
        event.preventDefault();
        var parent_div = $(this).parents('#color_name_wrap');
        $(this).closest('li').css("border-left", ("2px solid "+$(this).data('color')));
        parent_div.find('button').css("background-color", $(this).data('color'));
        parent_div.find('input#color_name').val($(this).data('color'));
    });

    $(document).on("click", "button.add-todo-item", function(event){
        event.preventDefault();

        var color_name = $(this).parents('.modal-footer').find('#color_name').val();
        var todo_name = $(this).parents('.modal-footer').find('#todo_name').val();
        var todo_description = $(this).parents('.modal-footer').find('#todo_description').val();

        if(todo_name){
            $.ajax({
                type: "POST",
                url: "{{ url('/todo/new-todo-save') }}",
                headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
                data: { color_name: color_name, todo_name: todo_name, todo_description: todo_description } ,
                dataType: 'json',
                success: function (data) {
                    $("ul.todo-list").prepend(
                        '<li id="todo-'+ data[0].todo_id +'" style="border-left: 2px solid '+ data[0].color_name +'">'
                        + '<span class="handle"><i class="fa fa-ellipsis-v"></i><i class="fa fa-ellipsis-v"></i></span>'
                        + '<input type="checkbox" name="" value="'+ data[0].todo_id +'">'
                        + '<span class="text">'+ data[0].todo_name +'</span>'
                        + '<span class="text">'+ data[0].todo_name +' -- <i style="color: #333;font-weight: normal;">'+ data[0].todo_description +'</i></span>'

                        + '<small class="badge badge-danger"><i class="fa fa-clock-o"></i>'+ data[0].human_date +'</small>'
                        + '<div class="tools">'
                        + '<div class="btn-group" role="group"><button type="button" class="btn-icon text-warning btn-flat editTodo" id="'+ data[0].todo_id +'" style="margin: 5px 0;"><i class="fa fa-edit" aria-hidden="true"></i></button>'
                        + '<button type="button" class="btn-icon text-danger btn-flat archiveTodo" data-href="{{ URL::to('/todo/archive-todo') }}/'+ data[0].todo_id +'" id="'+ data[0].todo_id +'" style="margin: 5px 0;"><i class="far fa-archive" aria-hidden="true"></i></button>'
                        + '</div></div>'
                        + '</li>'
                    );
                    $("input#todo_name").val('');
                    $("#todo_description").val('');
                    $(":input[type='text']:enabled:visible:first").focus();
                },
                error: function (xhr, textStatus, errorThrown) { alert(errorThrown); },
            });
        }else{
            alert('Please enter something');
        }
    });


    $(document).on('click', 'button.editTodo', function (event) {
        event.preventDefault();
        var id = $(this).attr('id');

        $.ajax({
            url: "{{ url('todo/edit-todo') }}/" + id,
            method: "get",
            dataType: "json",
            success: function( response ) {
                $("ul.todo-list li#todo-"+ response.todo_id).html(
                    '<div class="input-group">'
                    + '<div id="color_name_wrap" class="input-group-prepend" style="min-width: 2%; padding: 0;" title="Select Color for priority basis"><div class="dropdown"><button type="button" class="btn dropdown-toggle" data-toggle="dropdown" style="background-color: #ddd;"><input type="hidden" value="#ddd" class="form-control" name="color_name" id="color_name" /></button><div class="dropdown-menu custom-scroll" style="max-height: 150px; overflow-y: scroll;">@php $color_array = array('GRAY', 'BLACK', 'RED', 'MAROON', 'DarkRed', 'DarkMagenta', 'DarkOrchid', 'DarkSlateBlue', 'DeepPink', 'DodgerBlue', 'DarkOliveGreen', 'PaleGreen', 'PaleTurquoise', 'PaleVioletRed', 'Olive', 'Orange', 'OrangeRed', 'Gold', 'DarkOrange', 'Tomato', 'YELLOW', 'Wheat', 'GreenYellow', 'OLIVE', 'LIME', 'GREEN', 'DarkGreen', 'YellowGreen', 'AQUA', 'TEAL', 'BLUE', 'NAVY', 'MidnightBlue', 'PowderBlue', 'RoyalBlue', 'FUCHSIA', 'PURPLE', 'Indigo', 'Khaki', 'SandyBrown', 'DarkGoldenRod', 'DarkCyan', 'SlateBlue', 'Teal', 'SeaGreen', 'LightSkyBlue', 'LightGreen', 'LightPink', 'LightSeaGreen') @endphp @foreach($color_array as $color) <a class="dropdown-item colorSelector" href="#" data-color="{{ $color }}"><i style="background: {{ $color }};"></i>{{ $color }}</a> @endforeach</div></div></div>'
                    + '<input type="text" name="todo_name" id="todo_name" placeholder="To do name" class="form-control" tabindex="1" autocomplete="off" value="'+ response.todo_name +'" />'
                    + '<input name="todo_description" id="todo_description" placeholder="Description" class="form-control" style="width: 63%;" value="'+ response.todo_description +'" />'
                        + '<div class="input-group-append">'
                            + '<div class="btn-group" role="group"><button type="button" class="btn btn-purple btn-sm btn-flat updateTodo" id="'+ response.todo_id +'"><i class="fa fa-edit" aria-hidden="true"> Save</i></button>'
                            + '<button type="button" class="btn btn-tomato btn-sm btn-flat cancelUpdatetodo" id="'+ response.todo_id +'"><i class="fa fa-times" aria-hidden="true"> Cancel</i></button>'
                            + '</div>'
                        + '</div>'
                    + '</div>'
                );
            },
            statusCode:{ 404: function(){ alert( "page not found" ); } },
            beforeSend: function( xhr ) { $(".ajax-loader").show(); },
            complete: function( jqXHR, textStatus ) { $(".ajax-loader").hide(); },
        });
    });

    $(document).on("click", "button.updateTodo", function(event){
        event.preventDefault();

        var id = $(this).attr('id');
        var li = $("ul.todo-list li#todo-"+ id);
        var color_name = li.find('#color_name').val();
        var todo_name = $(this).closest('li').find('#todo_name').val();
        var todo_description = $(this).closest('li').find('#todo_description').val();

        if( !confirm("Are you sure want to update this record?")){ return; }

        $.ajax({
            type: "POST",
            url: "{{ url('todo/update-todo') }}",
            headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
            data: { todo_id:id, color_name:color_name, todo_name:todo_name, todo_description:todo_description },
            success: function (response) {
                $("ul.todo-list li#todo-"+ response[0].todo_id).html(
                    '<span class="handle"><i class="fa fa-ellipsis-v"></i><i class="fa fa-ellipsis-v"></i></span>'
                    + '<input type="checkbox" name="" value="'+ response[0].todo_id +'">'
                    + '<span class="text">'+ response[0].todo_name +' -- <i style="color: #333;font-weight: normal;">'+ response[0].todo_description +'</i></span>'
                    + '<small class="badge badge-danger"><i class="fa fa-clock-o"></i>'+ response[0].human_date +'</small>'
                    + '<div class="tools">'
                    + '<div class="btn-group" role="group"><button type="button" class="btn-icon text-warning btn-flat editTodo" id="'+ response[0].todo_id +'" style="margin: 5px 0;"><i class="fa fa-edit" aria-hidden="true"></i></button>'
                    + '<button type="button" class="btn-icon text-danger btn-flat archiveTodo" data-href="{{ URL::to('/todo/archive-todo') }}/'+ response[0].todo_id +'" id="'+ response[0].todo_id +'" style="margin: 5px 0;"><i class="far fa-archive" aria-hidden="true"></i></button>'
                    + '</div></div>'
                );
                $("ul.todo-list li#todo-"+ response[0].todo_id).css("borderLeft", '2px solid #'+color_name)
            },
            error: function (xhr, textStatus, errorThrown) { alert(errorThrown); }
        });
    });


    $(document).on("click", "button.cancelUpdatetodo", function(event){
        event.preventDefault();
        var id = $(this).attr('id');

        $.ajax({
            type: "get",
            url: "{{ url('todo/cancel-update-todo') }}",
            data: { todo_id: id },
            headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
            success: function (response) {
                $("ul.todo-list li#todo-"+ response[0].todo_id).html(
                    '<span class="handle"><i class="fa fa-ellipsis-v"></i><i class="fa fa-ellipsis-v"></i></span>'
                    + '<input type="checkbox" name="" value="'+ response[0].todo_id +'">'
                    + '<span class="text">'+ response[0].todo_name +' -- <i style="color: #333;font-weight: normal;">'+ response[0].todo_description +'</i></span>'
                    + '<small class="badge '+ response.carbon_diff +'"><i class="fa fa-clock-o"></i>'+ response.human_date +'</small>'
                    + '<div class="tools">'
                    + '<div class="btn-group" role="group"><button type="button" class="btn-icon text-warning btn-flat editTodo" id="'+ response[0].todo_id +'" style="margin: 5px 0;"><i class="fa fa-edit" aria-hidden="true"></i></button>'
                    + '<button type="button" class="btn-icon text-danger btn-flat archiveTodo" data-href="{{ URL::to('/todo/archive-todo') }}/'+ response[0].todo_id +'" id="'+ response[0].todo_id +'" style="margin: 5px 0;"><i class="far fa-archive" aria-hidden="true"></i></button>'
                    + '</div></div>'
                );
            },
            error: function (xhr, textStatus, errorThrown) { alert(errorThrown); }
        });
    });

    $(document).on("click", "button.deleteTodo", function(){
        var id = $(this).attr('id');
        var url = $(this).data('href');
        var token = $('meta[name="csrf-token"]').attr('content');
        var parentLi = $(this).closest('li');

        if( !confirm("Are you sure want to delete this record?")){ return; }

        $.ajax({
            url: url,
            method: "POST",
            data: { _method: 'DELETE', _token : token, id: id },
            dataType: "json",
            cache:false,
            async: true,
            success: function( msg ) {
                if ( msg.status === 'success' ) {
                    toastr.success( msg.success );
                    parentLi.animate({ backgroundColor: "#e74c3c", color: "#fff" }, "slow").animate({ opacity: "hide" }, "slow");
                }
            },
            error: function (xhr, textStatus, errorThrown) { alert(errorThrown); },
            statusCode:{ 404: function(){ alert( "page not found" ); } },
            beforeSend: function( xhr ) { $(".ajax-loader").show('slow'); },
            complete: function( jqXHR, textStatus ) { $(".ajax-loader").hide('fast'); },
        });
    });

    $('ul.todo-list').sortable({
        placeholder: "ui-state-highlight",
        forcePlaceholderSize: true,
        handle: '.handle',
        cursor: "move",
        axis: "y",
        zIndex: 999999,
        opacity: 0.75,
        tolerance: "pointer",
        update: function(event, ui) {
            var sorting = [];
            $(this).find('li').each(function(index,element) {
                sorting.push({ id: $(this).attr('id'), position: index+1 });
            });

            $.ajax({
                type: "POST",
                url: "{{ URL::to('/todo/update-todo-sorting') }}",
                data: { sorting: sorting, _token: '{{csrf_token()}}' },
                success: function(res) { console.log(res) }
            });
        }

        /*
        stop: function(event, ui) {
            $.map($(this).find('li'), function(el) {
                var id = el.id;
                var sorting = $(el).index();
                $.ajax({
                    type: "POST",
                    url: "{ URL::to('/todo/update-todo-sorting') }}",
                    data: { id: id, sorting: sorting },
                    headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
                    success: function(res) {
                        console.log(res)
                    }
                });
            });
        }*/
    });


    $(document).on('click', 'button.archiveTodo', function () {
        var id = $(this).attr('id');
        var parent = $(this).parents('.tab-content');
        var parentLi = $(this).closest('li');

        if( !confirm("Are you sure to Archived.")){ return; }

        $.ajax({
            url : "{{ url('todo/archive-todo') }}/"+ id,
            type : "POST",
            dataType : "json",
            headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
            success:function( data ){
                parent.find('#archived_todo_list ul').append(parentLi[0].outerHTML);
                parent.find('#archived_todo_list .noItemFound').hide();
                setTimeout(function(){ parentLi.animate({ padding: 0, height: 0, backgroundColor: "#ff8080" }, 500).slideUp( function(){ parentLi.remove(); }); },1000);
            },
            beforeSend: function( xhr ) { $(".ajax-loader").show('slow'); },
            complete: function( jqXHR, textStatus ) { $(".ajax-loader").hide('fast'); },
        });
    });


    $('#todoModal').on('click', 'input[type="checkbox"]', function () {
        var $this = $(this);
        var status = $(this).data('status');
        var modal = $("#todoModal");
        var todo_id = $(this).attr('id');
        var parent_li = $(this).closest('li');

        $(this).is(":checked") ? $(parent_li).addClass('done') : $(parent_li).removeClass('done');

        $.ajax({
            url : "{{ route('change-todo-status') }}",
            type : "POST",
            dataType : "json",
            data: {todo_id: todo_id, status:status },
            headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
            success:function( data ){
                modal.find("input#"+todo_id).data('status', (data.status === "done" ? "active" : 'done') );
                toastr.success( data.success );
            },
            beforeSend: function( xhr ) { $(".ajax-loader").show('slow'); },
            complete: function( jqXHR, textStatus ) { $(".ajax-loader").hide('fast'); },
        });
        modal.modal('show');
    });
}); //End of Document ready
</script>
