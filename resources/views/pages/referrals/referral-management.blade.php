@extends('dashboard')
@section('main_content')

<section class="content">
    <div class="box box-success animated fadeInLeft">
        <div class="box-header with-border">
            <h2 class="box-title"><i class="fa fa-file-alt" aria-hidden="true"></i> Showing All Referral</h2>
            <div class="box-tools float-right">
                <button type="button" class="btn btn-box-tool" id="refresh" data-toggle="tooltip" data-placement="top" title="Refresh"><i class="fa fa-sync-alt"></i></button>
            </div><!-- /.box-tools -->
        </div><!-- /.box-header -->

        <div class="box-body table-responsive">
            <table id="general_datatable" class="table table-custom">
                <thead class="thead-inverse">
                    <tr>
                        <th>#</th>
                        <th>Referrer Type</th>
                        <th>Referral Code</th>
                        <th>Referral NID</th>
                        <th>Referral Links</th>
                        <th>Referral Used Count</th>
                        <th>Created Date</th>
                    </tr>
                </thead>
                <tbody>
                @foreach($all_referral_info as $referral)
                    <?php $driver_referral_nid = $referral->referrer_type == 'Driver' ? DB::table('drivers')->where('invitation_code', $referral->referral_code)->value('national_id') : ""; ?>
                    <?php $rider_referral_nid = $referral->referrer_type == 'Rider' ? DB::table('riders')->where('invitation_code', $referral->referral_code)->value('national_id') : ""; ?>
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $referral->referrer_type }}</td>
                        <td>{{ $referral->referral_code }}</td>
                        <td>{{ $driver_referral_nid ?? "-" }} {{ $rider_referral_nid ?? "-" }}</td>
                        <td>{{ $driver_referral_nid ? url('/driver') ."/". $referral->referral_code : "" }} {{ $rider_referral_nid ? url('/rider') ."/". $referral->referral_code : "" }}</td>
                        <td>{{ $referral->referral_count ?? 0 }}</td>
                        <td>{{ date('d/m/Y', strtotime($referral->created_at)) }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div><!-- /.box-body -->

        <div class="overlay" style="display: none;">
            <i class="fa fa-sync-alt fa-spin"></i>
        </div>
    </div><!-- /.box -->
</section>

@include('pages.referrals.referral-new-modal')
@include('pages.referrals.referral-edit-modal')
@include('pages.referrals.referral-view-modal')

@endsection


@section('custom_js')
<script type="text/javascript">
$(document).ready(function(){
    $(document).on('click', 'button.editReferral', function () {
        var id = $(this).attr('id');
        var modal = $("#editReferralModal");

        $.ajax({
            url: "{{ url('/referral/edit-referral') }}/"+id,
            method: "get",
            dataType: "json",
            success: function( response ) {

                // modal.find('.modal-title').text( "Update Referral" );
                // modal.find('input[name=referral_id]').val( response[0].referral_id );
                // modal.find("select#client_id option[value=" + response[0].client_id +"]").prop("selected", true);
                // modal.find('input#employee_id').val( response[0].employee_id );
                // modal.find('#employee_name').val( response['employee'].employee_name );
                // modal.find('#employee_mobile').val( response['employee'].employee_mobile );
                // modal.find('#designation_name').val( response.designation_name );
                // modal.find('.referral_note').val( response[0].referral_note );
                modal.modal("show");
            },
            beforeSend: function( xhr ) { $(".ajax-loader").show(); },
            complete: function( jqXHR, textStatus ) { $(".ajax-loader").hide(); },
        });
    });

    $(document).on('click', 'button.view-referral', function () {
        var id = $(this).attr('id');
        var modal = $("#view_referral_modal");

        $.ajax({
            url: "{{ url('/referral/view-referral') }}/" + id,
            method: "get",
            dataType: "json",
            cache:false,
            async: false,
            success: function( response ) {
                modal.find('.modal-title').text( "View Details of Referral No: " + response[0].referral_number );
                modal.find('.client_name').text( response.client_name );
                {{--modal.find('.referral_number').find('.attachment-btn a').attr("href", "{{ url('storage/client-referral') }}/"+ response[0].referral_photo).addClass( response[0].referral_photo ? "btn-info" : "disabled btn-outline-info");--}}
                modal.find('.referral_note').text( response[0].referral_note );
                modal.modal("show");
            },
            beforeSend: function( xhr ) { $(".ajax-loader").show('slow'); },
            complete: function( jqXHR, textStatus ) { $(".ajax-loader").hide('fast'); },
        });
    });
}); //End of Document ready

</script>
@endsection

