@extends('dashboard')
@section('main_content')

<section class="content">
    <div class="member-mgmt-list">
        <ul class="nav nav-tabs">
            <li class="nav-item"><a class="nav-link active" data-toggle="tab" href="#detail" onclick="pushstate('#detail')"><i class="fa fa-list"></i> Employee Detail</a></li>
            <li class="nav-item"><a class="nav-link" data-toggle="tab" href="#qualification" onclick="pushstate('#qualification')"><i class="fa fa-file-invoice"></i> Qualification</a></li>
            <li class="nav-item"><a class="nav-link" data-toggle="tab" href="#payroll" onclick="pushstate('#payroll')"><i class="fas fa-shopping-cart"></i> Payroll</a></li>
            <li class="nav-item"><a class="nav-link" data-toggle="tab" href="#loan" onclick="pushstate('#loan')"><i class="fa fa-wrench"></i> Loan</a></li>
            <li class="nav-item"><a class="nav-link" data-toggle="tab" href="#leave" onclick="pushstate('#leave')"><i class="fa fa-money-check"></i> Leave</a></li>
            <li class="nav-item"><a class="nav-link" data-toggle="tab" href="#bank_account" onclick="pushstate('#bank_account')"><i class="fa fa-university"></i> Bank Account</a></li>
            <li class="nav-item"><a class="nav-link" data-toggle="tab" href="#sales_target" onclick="pushstate('#sales_target')"><i class="fa fa-dot-circle"></i> Sales Target</a></li>
            <li class="nav-item"><a class="nav-link" data-toggle="tab" href="#client" onclick="pushstate('#client')"><i class="fa fa-user-tie"></i> Client</a></li>
        </ul>
        <div class="tab-content">
            <i class="fa fa-spin fa-spinner" style="display: none;"></i>

            <div class="tab-pane fade show animated fadeInRight active" id="detail">
                @include('pages.employees.tab-employee-detail')
            </div>
            <div class="tab-pane fade animated fadeInRight" id="qualification">
                @include('pages.employees.tab-employee-qualification')
            </div>
            <div class="tab-pane fade animated fadeInRight" id="payroll">
                @include('pages.employees.tab-employee-Payroll')
            </div>
            <div class="tab-pane fade animated fadeInRight" id="loan">
                @include('pages.employees.tab-employee-loan')
            </div>
            <div class="tab-pane fade animated fadeInRight" id="leave">
                @include('pages.employees.tab-employee-leave')
            </div>
            <div class="tab-pane fade animated fadeInRight" id="bank_account">
                @include('pages.employees.tab-employee-bank-account')
            </div>
            <div class="tab-pane fade animated fadeInRight" id="sales_target">
                @include('pages.employees.tab-employee-sales-target')
            </div>
            <div class="tab-pane fade animated fadeInRight" id="client">
                @include('pages.employees.tab-employee-client')
            </div>
        </div>
    </div>
</section>

@include('pages.employees.education-add-modal')
@include('pages.employees.education-edit-modal')
@include('pages.employees.training-add-modal')
@include('pages.employees.training-edit-modal')
@include('pages.employees.experience-add-modal')
@include('pages.employees.experience-edit-modal')
@include('pages.employees.prof-certificate-add-modal')
@include('pages.employees.prof-certificate-edit-modal')

@endsection





@section('custom_js')
<script type="text/javascript">

// $(document).ready(function() {
//    $('a[data-toggle="tab"]').on( 'shown.bs.tab', function (e) {
//        $.fn.dataTable.tables( {visible: true, api: true} ).columns.adjust();
//         var target = $(e.target).attr("href"); // activated tab
//    } );
//     $("table.multi_datatable").DataTable({
//         responsive: true
//     });
// });

// function pushstate( id ) {
//     var url = id.replace('#', '#tab=');
//     //var currentState = history.state;
//
//     return window.history.pushState(null, null, url);
// };
//
// $(window).on('hashchange', function () {
//     var tab = window.location.hash != "" ? window.location.hash.split("#tab=")[1] : ""
//     $("ul.nav").find("a[href='#" +tab + "']").trigger('click');
// });

{{--$(document).ready(function(){--}}
{{--    $(document).on('click', '.nav-link', function () {--}}
{{--        var id = $(this).attr('href');--}}

{{--        $.ajax({--}}
{{--            url: "{{ url()->current() }}" + id.replace('#', '/').replace('_', '-'),--}}
{{--            type: "get",--}}
{{--            success: function(data){ $('.tab-content .tab-pane' + id).html( data ); },--}}
{{--            error: function (jqXHR, textStatus, errorThrown){ alert("error"); },--}}
{{--            statusCode:{ 404: function(){ alert( "page not found" ); } },--}}
{{--            beforeSend: function( xhr ) { $(".tab-content i.fa-spin").show(); },--}}
{{--            complete: function( jqXHR, textStatus ) { $(".tab-content i.fa-spin").hide(); },--}}
{{--        });--}}
{{--    });--}}
{{--}); //End of Document ready--}}







$(document).ready(function(){
    $(document).on('click', 'button.showNewEducationModal', function () {

        var modal = $("#educationModal");
        modal.modal({ backdrop: "static", keyboard: true });
        modal.find('.modal-title').text( "Add Education Info of Mr. {{ $employee_data->employee_name }}" );

        $("form#add_employee_edu_form").submit(function (event) {
            event.preventDefault();

            var form = $(this);
            var data = form.serialize();
            var url = form.attr("action");

            $.ajaxSetup({
                headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') }
            });

            $.ajax({
                url: url,
                method: "post",
                data: data,
                dataType: "json",
                success: function( response ) {
                    $("#employee_education_table").find('tbody').prepend(
                        '<tr>'
                        + '<td>'+ response[0].education_id +'</td>'
                        + '<td>'+ response[0].degree_level +'</td>'
                        + '<td>'+ response[0].degree_name +'</td>'
                        + '<td>'+ response[0].passing_year +'</td>'
                        + '<td>'+ response[0].board_university +'</td>'
                        + '<td>'+ response[0].major_subject +'</td>'
                        + '<td>'+ response[0].education_result +'</td>'
                        + '<td>'
                        + '<button type="button" class="btn btn-warning btn-sm editEducation" id="'+ response[0].education_id +'" data-url="{{ url('employee/edit-employee-education') }}/'+ response[0].education_id +'"><i class="fa fa-edit" aria-hidden="true"></i></button>'
                        + '<button type="button" class="ajaxDelete btn btn-danger btn-sm" data-href="{{ URL::to('/employee/delete-employee-education/') }}'+ response[0].education_id +'" data-title="'+ response[0].education_level +'" id="'+ response[0].education_id +'"><i class="far fa-trash-alt" aria-hidden="true"></i></button>'
                        + '</td>'
                        + '</tr>'
                    );
                    form.trigger('reset');
                    modal.modal('hide');
                },
                statusCode:{ 404: function(){ alert( "page not found" ); } },
                beforeSend: function( xhr ) { $(".ajax-loader").show(); },
                complete: function( jqXHR, textStatus ) { $(".ajax-loader").hide(); },
            });
            return false;
        });
    });

    $(document).on('click', 'button.editEducation', function () {

        var url = $(this).data('url');
        var id = $(this).attr('id');
        var modal = $("#editEducationModal");

        $.ajax({
            url: url,
            method: "get",
            data: { id: id },
            dataType: "json",
            success: function( response ) {
                modal.find('.modal-title').text( "Update Education Information" );
                modal.find('input[name=education_id]').val( response.education_id );
                modal.find("select#degree_level option[value=" + response.degree_level +"]").prop("selected", true);
                modal.find('#degree_name').val( response.degree_name );
                modal.find('#passing_year').val( response.passing_year );
                modal.find('#board_university').val( response.board_university );
                modal.find('#major_subject').val( response.major_subject );
                modal.find('#education_result').val( response.education_result );

                modal.modal({ backdrop: "static", keyboard: true });
                modal.on('shown.bs.modal', function(){ $(":input[type='text']:enabled:visible:first").focus(); });
            },
            statusCode:{ 404: function(){ alert( "page not found" ); } },
            beforeSend: function( xhr ) { $(".ajax-loader").show(); },
            complete: function( jqXHR, textStatus ) { $(".ajax-loader").hide(); },
        });
    });

    $("form#edit_employee_edu_form").submit(function (event) {
        event.preventDefault();

        var form = $(this);
        var data = form.serialize();
        var url = form.attr("action");

        $.ajaxSetup({
            headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') }
        });

        $.ajax({
            url: url,
            method: "post",
            data: data,
            dataType: "json",
            success: function( response ) {
                //$("#employee_education_table").find('tbody').prepend(
                $("#employee_education_table tr#" + response[0].education_id).html(
                    '<td>'+ response[0].education_id +'</td>'
                    + '<td>'+ response[0].degree_level +'</td>'
                    + '<td>'+ response[0].degree_name +'</td>'
                    + '<td>'+ response[0].passing_year +'</td>'
                    + '<td>'+ response[0].board_university +'</td>'
                    + '<td>'+ response[0].major_subject +'</td>'
                    + '<td>'+ response[0].education_result +'</td>'
                    + '<td>'
                    + '<button type="button" class="btn btn-warning btn-sm editEducation" id="'+ response[0].education_id +'" data-url="{{ url('employee/edit-employee-education') }}/'+ response[0].education_id +'"><i class="fa fa-edit" aria-hidden="true"></i></button>'
                    + '<button type="button" class="ajaxDelete btn btn-danger btn-sm" data-href="{{ URL::to('/employee/delete-employee-education/') }}'+ response[0].education_id +'" data-title="'+ response[0].education_level +'" id="'+ response[0].education_id +'"><i class="far fa-trash-alt" aria-hidden="true"></i></button>'
                    + '</td>'
                );
                form.trigger('reset');
                $("#editEducationModal").modal('hide');
            },
            statusCode:{ 404: function(){ alert( "page not found" ); } },
            beforeSend: function( xhr ) { $(".ajax-loader").show(); },
            complete: function( jqXHR, textStatus ) { $(".ajax-loader").hide(); },
        });
        return false;
    });
}); //End of Document ready


$(document).ready(function(){
    $(document).on('click', 'button.showNewTrainingModal', function () {

        var modal = $("#trainingModal");
        modal.modal({ backdrop: "static", keyboard: true });
        modal.find('.modal-title').text( "Add Training Info of Mr. {{ $employee_data->employee_name }}" );

        $("form#add_employee_training_form").submit(function (event) {
            event.preventDefault();

            var form = $(this);
            var data = form.serialize();
            var url = form.attr("action");

            $.ajaxSetup({
                headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') }
            });

            $.ajax({
                url: url,
                method: "post",
                data: data,
                dataType: "json",
                success: function( response ) {
                    $("#employee_training_table").find('tbody').prepend(
                        '<tr>'
                        + '<td>'+ response[0].training_id +'</td>'
                        + '<td>'+ response[0].training_name +'</td>'
                        + '<td>'+ response[0].start_date +'</td>'
                        + '<td>'+ response[0].end_date +'</td>'
                        + '<td>'+ response[0].training_duration +'</td>'
                        + '<td>'+ response[0].training_result +'</td>'
                        + '<td>'+ response[0].certified_by +'</td>'
                        + '<td>'
                        + '<button type="button" class="btn btn-warning btn-sm editTraining" id="'+ response[0].training_id +'" data-url="{{ url('employee/edit-employee-training') }}/'+ response[0].training_id +'"><i class="fa fa-edit" aria-hidden="true"></i></button>'
                        + '<button type="button" class="ajaxDelete btn btn-danger btn-sm" data-href="{{ URL::to('/employee/delete-employee-training/') }}'+ response[0].training_id +'" data-title="'+ response[0].training_level +'" id="'+ response[0].training_id +'"><i class="far fa-trash-alt" aria-hidden="true"></i></button>'
                        + '</td>'
                        + '</tr>'
                    );
                    form.trigger('reset');
                    modal.modal('hide');
                },
                statusCode:{ 404: function(){ alert( "page not found" ); } },
                beforeSend: function( xhr ) { $(".ajax-loader").show(); },
                complete: function( jqXHR, textStatus ) { $(".ajax-loader").hide(); },
            });
            return false;
        });
    });

    $(document).on('click', 'button.editTraining', function () {

        var url = $(this).data('url');
        var id = $(this).attr('id');
        var modal = $("#editTrainingModal");

        $.ajax({
            url: url,
            method: "get",
            data: { id: id },
            dataType: "json",
            success: function( response ) {
                modal.find('.modal-title').text( "Update Training Information" );
                modal.find('input[name=training_id]').val( response.training_id );
                modal.find('#training_name').val( response.training_name );
                modal.find('#start_date').val( response.start_date.split('-')[2]+"/"+response.start_date.split('-')[1]+"/"+response.start_date.split('-')[0] );
                modal.find('#end_date').val( response.end_date.split('-')[2]+"/"+response.end_date.split('-')[1]+"/"+response.end_date.split('-')[0] );
                modal.find('#training_duration').val( response.training_duration );
                modal.find('#training_result').val( response.training_result );
                modal.find('#certified_by').val( response.certified_by );

                modal.modal({ backdrop: "static", keyboard: true });
                modal.on('shown.bs.modal', function(){ $(":input[type='text']:enabled:visible:first").focus(); });
            },
            statusCode:{ 404: function(){ alert( "page not found" ); } },
            beforeSend: function( xhr ) { $(".ajax-loader").show(); },
            complete: function( jqXHR, textStatus ) { $(".ajax-loader").hide(); },
        });
    });

    $("form#edit_employee_training_form").submit(function (event) {
        event.preventDefault();

        var form = $(this);
        var data = form.serialize();
        var url = form.attr("action");

        $.ajaxSetup({
            headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') }
        });

        $.ajax({
            url: url,
            method: "post",
            data: data,
            dataType: "json",
            success: function( response ) {
                //$("#employee_training_table").find('tbody').prepend(
                $("#employee_training_table tr#" + response[0].training_id).html(
                        '<td>'+ response[0].training_id +'</td>'
                        + '<td>'+ response[0].training_name +'</td>'
                        + '<td>'+ response[0].start_date +'</td>'
                        + '<td>'+ response[0].end_date +'</td>'
                        + '<td>'+ response[0].training_duration +'</td>'
                        + '<td>'+ response[0].training_result +'</td>'
                        + '<td>'+ response[0].certified_by +'</td>'
                    + '<td>'
                    + '<button type="button" class="btn btn-warning btn-sm editTraining" id="'+ response[0].training_id +'" data-url="{{ url('employee/edit-employee-training') }}/'+ response[0].training_id +'"><i class="fa fa-edit" aria-hidden="true"></i></button>'
                    + '<button type="button" class="ajaxDelete btn btn-danger btn-sm" data-href="{{ URL::to('/employee/delete-employee-training/') }}'+ response[0].training_id +'" data-title="'+ response[0].training_name +'" id="'+ response[0].training_id +'"><i class="far fa-trash-alt" aria-hidden="true"></i></button>'
                    + '</td>'
                );
                form.trigger('reset');
                $("#editTrainingModal").modal('hide');
            },
            statusCode:{ 404: function(){ alert( "page not found" ); } },
            beforeSend: function( xhr ) { $(".ajax-loader").show(); },
            complete: function( jqXHR, textStatus ) { $(".ajax-loader").hide(); },
        });
        return false;
    });
}); //End of Document ready



$(document).ready(function(){
    $(document).on('click', 'button.showNewExperienceModal', function () {

        var modal = $("#experienceModal");
        modal.modal({ backdrop: "static", keyboard: true });
        modal.find('.modal-title').text( "Add Experience Info of Mr. {{ $employee_data->employee_name }}" );

        $("form#add_employee_experience_form").submit(function (event) {
            event.preventDefault();

            var form = $(this);
            var data = form.serialize();
            var url = form.attr("action");

            $.ajaxSetup({
                headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') }
            });

            $.ajax({
                url: url,
                method: "post",
                data: data,
                dataType: "json",
                success: function( response ) {
                    $("#employee_experience_table").find('tbody').prepend(
                        '<tr>'
                        + '<td>'+ response[0].experience_id +'</td>'
                        + '<td>'+ response[0].company_name +'</td>'
                        + '<td>'+ response[0].position +'</td>'
                        + '<td>'+ response[0].start_date +'</td>'
                        + '<td>'+ response[0].end_date +'</td>'
                        + '<td>'+ response[0].experience_duration +'</td>'
                        + '<td>'+ response[0].responsibilities +'</td>'
                        + '<td>'
                        + '<button type="button" class="btn btn-warning btn-sm editExperience" id="'+ response[0].experience_id +'" data-url="{{ url('employee/edit-employee-experience') }}/'+ response[0].experience_id +'"><i class="fa fa-edit" aria-hidden="true"></i></button>'
                        + '<button type="button" class="ajaxDelete btn btn-danger btn-sm" data-href="{{ URL::to('/employee/delete-employee-experience/') }}'+ response[0].experience_id +'" data-title="'+ response[0].company_name +'" id="'+ response[0].experience_id +'"><i class="far fa-trash-alt" aria-hidden="true"></i></button>'
                        + '</td>'
                        + '</tr>'
                    );
                    form.trigger('reset');
                    modal.modal('hide');
                },
                statusCode:{ 404: function(){ alert( "page not found" ); } },
                beforeSend: function( xhr ) { $(".ajax-loader").show(); },
                complete: function( jqXHR, textStatus ) { $(".ajax-loader").hide(); },
            });
            return false;
        });
    });

    $(document).on('click', 'button.editExperience', function () {

        var url = $(this).data('url');
        var id = $(this).attr('id');
        var modal = $("#editExperienceModal");

        $.ajax({
            url: url,
            method: "get",
            data: { id: id },
            dataType: "json",
            success: function( response ) {
                modal.find('.modal-title').text( "Update Experience Information" );
                modal.find('input[name=experience_id]').val( response.experience_id );
                modal.find('#company_name').val( response.company_name );
                modal.find('#position').val( response.position );
                modal.find('#start_date').val( response.start_date.split('-')[2]+"/"+response.start_date.split('-')[1]+"/"+response.start_date.split('-')[0] );
                modal.find('#end_date').val( response.end_date.split('-')[2]+"/"+response.end_date.split('-')[1]+"/"+response.end_date.split('-')[0] );
                modal.find('#experience_duration').val( response.experience_duration );
                modal.find('#responsibilities').val( response.responsibilities );

                modal.modal({ backdrop: "static", keyboard: true });
                modal.on('shown.bs.modal', function(){ $(":input[type='text']:enabled:visible:first").focus(); });
            },
            statusCode:{ 404: function(){ alert( "page not found" ); } },
            beforeSend: function( xhr ) { $(".ajax-loader").show(); },
            complete: function( jqXHR, textStatus ) { $(".ajax-loader").hide(); },
        });
    });

    $("form#edit_employee_experience_form").submit(function (event) {
        event.preventDefault();

        var form = $(this);
        var data = form.serialize();
        var url = form.attr("action");

        $.ajaxSetup({
            headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') }
        });

        $.ajax({
            url: url,
            method: "post",
            data: data,
            dataType: "json",
            success: function( response ) {
                //$("#employee_experience_table").find('tbody').prepend(
                $("#employee_experience_table tr#" + response[0].experience_id).html(
                        '<td>'+ response[0].experience_id +'</td>'
                        + '<td>'+ response[0].company_name +'</td>'
                        + '<td>'+ response[0].position +'</td>'
                        + '<td>'+ response[0].start_date +'</td>'
                        + '<td>'+ response[0].end_date +'</td>'
                        + '<td>'+ response[0].experience_duration +'</td>'
                        + '<td>'+ response[0].responsibilities +'</td>'
                    + '<td>'
                    + '<button type="button" class="btn btn-warning btn-sm editExperience" id="'+ response[0].experience_id +'" data-url="{{ url('employee/edit-employee-experience') }}/'+ response[0].experience_id +'"><i class="fa fa-edit" aria-hidden="true"></i></button>'
                    + '<button type="button" class="ajaxDelete btn btn-danger btn-sm" data-href="{{ URL::to('/employee/delete-employee-experience/') }}'+ response[0].experience_id +'" data-title="'+ response[0].experience_name +'" id="'+ response[0].experience_id +'"><i class="far fa-trash-alt" aria-hidden="true"></i></button>'
                    + '</td>'
                );
                form.trigger('reset');
                $("#editExperienceModal").modal('hide');
            },
            statusCode:{ 404: function(){ alert( "page not found" ); } },
            beforeSend: function( xhr ) { $(".ajax-loader").show(); },
            complete: function( jqXHR, textStatus ) { $(".ajax-loader").hide(); },
        });
        return false;
    });
}); //End of Document ready


$(document).ready(function(){
    $(document).on('click', 'button.showNewCertificateModal', function () {

        var modal = $("#certificateModal");
        modal.modal({ backdrop: "static", keyboard: true });
        modal.find('.modal-title').text( "Add Professional Certificate of {{ $employee_data->employee_name }}" );

        $("form#add_employee_certificate_form").submit(function (event) {
            event.preventDefault();

            var form = $(this);
            var data = form.serialize();
            var url = form.attr("action");

            $.ajaxSetup({
                headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') }
            });

            $.ajax({
                url: url,
                method: "post",
                data: data,
                dataType: "json",
                success: function( response ) {
                    $("#employee_certificate_table").find('tbody').prepend(
                        '<tr>'
                        + '<td>'+ response[0].certificate_id +'</td>'
                        + '<td>'+ response[0].certificate_name +'</td>'
                        + '<td>'+ response[0].certificate_no +'</td>'
                        + '<td>'+ response[0].certified_by +'</td>'
                        + '<td>'+ response[0].certificate_year +'</td>'
                        + '<td>'
                        + '<button type="button" class="btn btn-warning btn-sm editCertificate" id="'+ response[0].certificate_id +'" data-url="{{ url('employee/edit-employee-certificate') }}/'+ response[0].certificate_id +'"><i class="fa fa-edit" aria-hidden="true"></i></button>'
                        + '<button type="button" class="ajaxDelete btn btn-danger btn-sm" data-href="{{ URL::to('/employee/delete-employee-certificate/') }}'+ response[0].certificate_id +'" data-title="'+ response[0].company_name +'" id="'+ response[0].certificate_id +'"><i class="far fa-trash-alt" aria-hidden="true"></i></button>'
                        + '</td>'
                        + '</tr>'
                    );
                    form.trigger('reset');
                    modal.modal('hide');
                },
                statusCode:{ 404: function(){ alert( "page not found" ); } },
                beforeSend: function( xhr ) { $(".ajax-loader").show(); },
                complete: function( jqXHR, textStatus ) { $(".ajax-loader").hide(); },
            });
            return false;
        });
    });

    $(document).on('click', 'button.editCertificate', function () {

        var url = $(this).data('url');
        var id = $(this).attr('id');
        var modal = $("#editCertificateModal");

        $.ajax({
            url: url,
            method: "get",
            data: { id: id },
            dataType: "json",
            success: function( response ) {
                modal.find('.modal-title').text( "Update Professional Certificate" );
                modal.find('input[name=certificate_id]').val( response.certificate_id );
                modal.find('#certificate_name').val( response.certificate_name );
                modal.find('#certificate_no').val( response.certificate_no );
                modal.find('#certified_by').val( response.certified_by );
                modal.find('#certificate_year').val( response.certificate_year );

                modal.modal({ backdrop: "static", keyboard: true });
                modal.on('shown.bs.modal', function(){ $(":input[type='text']:enabled:visible:first").focus(); });
            },
            statusCode:{ 404: function(){ alert( "page not found" ); } },
            beforeSend: function( xhr ) { $(".ajax-loader").show(); },
            complete: function( jqXHR, textStatus ) { $(".ajax-loader").hide(); },
        });
    });

    $("form#edit_employee_certificate_form").submit(function (event) {
        event.preventDefault();

        var form = $(this);
        var data = form.serialize();
        var url = form.attr("action");

        $.ajaxSetup({
            headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') }
        });

        $.ajax({
            url: url,
            method: "post",
            data: data,
            dataType: "json",
            success: function( response ) {
                //$("#employee_certificate_table").find('tbody').prepend(
                $("#employee_certificate_table tr#" + response[0].certificate_id).html(
                    '<td>'+ response[0].certificate_id +'</td>'
                    + '<td>'+ response[0].certificate_name +'</td>'
                    + '<td>'+ response[0].certificate_no +'</td>'
                    + '<td>'+ response[0].certified_by +'</td>'
                    + '<td>'+ response[0].certificate_year +'</td>'
                    + '<td>'
                    + '<button type="button" class="btn btn-warning btn-sm editCertificate" id="'+ response[0].certificate_id +'" data-url="{{ url('employee/edit-employee-certificate') }}/'+ response[0].certificate_id +'"><i class="fa fa-edit" aria-hidden="true"></i></button>'
                    + '<button type="button" class="ajaxDelete btn btn-danger btn-sm" data-href="{{ URL::to('/employee/delete-employee-certificate/') }}'+ response[0].certificate_id +'" data-title="'+ response[0].certificate_name +'" id="'+ response[0].certificate_id +'"><i class="far fa-trash-alt" aria-hidden="true"></i></button>'
                    + '</td>'
                );
                form.trigger('reset');
                $("#editCertificateModal").modal('hide');
            },
            statusCode:{ 404: function(){ alert( "page not found" ); } },
            beforeSend: function( xhr ) { $(".ajax-loader").show(); },
            complete: function( jqXHR, textStatus ) { $(".ajax-loader").hide(); },
        });
        return false;
    });
}); //End of Document ready

</script>
@endsection

