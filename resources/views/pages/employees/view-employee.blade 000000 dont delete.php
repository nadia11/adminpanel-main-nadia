@extends('dashboard')
@section('main_content')

<section class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="member-mgmt-list">
                    <?php $active_tab = isset($_GET['tab']) ? $_GET['tab'] : 'detail'; ?>

                    <ul class="nav nav-tabs">
                        <li class="nav-item"><a class="nav-link <?php echo $active_tab == 'detail' ? 'active' : ''; ?>" href="?tab=detail"><i class="fa fa-list"></i> Detail</a></li>
                        <li class="nav-item"><a class="nav-link <?php echo $active_tab == 'qualification' ? 'active' : ''; ?>" href="?tab=qualification"><i class="fa fa-file-invoice"></i> Voucher</a></li>
                        <li class="nav-item"><a class="nav-link <?php echo $active_tab == 'payroll' ? 'active' : ''; ?>" href="?tab=payroll"><i class="fa fa-tags"></i> Sale Orders</a></li>
                        <li class="nav-item"><a class="nav-link <?php echo $active_tab == 'loan' ? 'active' : ''; ?>" href="?tab=loan"><i class="fa fa-money-check"></i> Cheque</a></li>
                        <li class="nav-item"><a class="nav-link <?php echo $active_tab == 'leave' ? 'active' : ''; ?>" href="?tab=leave"><i class="fa fa-exchange-alt"></i> Transactions</a></li>
                    </ul>

                    <div class="tab-content">
                        <div class="tab-pane <?php echo $active_tab == 'detail' ? 'active' : ''; ?>" id="detail">
                            @include('pages.employees.view-employee-detail')
                        </div>
                        <div class="tab-pane <?php echo $active_tab == 'qualification' ? 'active' : ''; ?>" id="qualification">
                            @include('pages.employees.view-employee-qualification')
                        </div>
                        <div class="tab-pane <?php echo $active_tab == 'payroll' ? 'active' : ''; ?>" id="payroll">
                            @include('pages.employees.view-employee-Payroll')
                        </div>
                        <div class="tab-pane <?php echo $active_tab == 'loan' ? 'active' : ''; ?>" id="loan">
                            @include('pages.employees.view-employee-loan')
                        </div>
                        <div class="tab-pane <?php echo $active_tab == 'leave' ? 'active' : ''; ?>" id="leave">
                            @include('pages.employees.view-employee-leave')
                        </div>
                    </div>
                </div>
            </div><!-- /.col-12 -->  
        </div><!-- /.row -->
    </div><!-- ./container -->
</section>

@endsection


@section('custom_js')
<script type="text/javascript">
$('a[data-toggle="tab"]').on( 'shown.bs.tab', function (e) {
    $.fn.dataTable.tables( {visible: true, api: true} ).columns.adjust();
} );
    
$("#employee_education_table").DataTable({
    responsive: true
});
$("#employee_training_table").DataTable({
    responsive: true
});
    
</script>
@endsection

