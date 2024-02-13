<aside class="main-sidebar hidden-print">
    <nav class="sidebar">
        <ul class="sidebar-menu">
            <li class="treeview">
                <a href="#">
                    <img src="<?php $user_photo = !empty( Auth::user()->user_photo ) ? upload_url("user-photo/". Auth::user()->user_photo ) : get_gravatar( Auth::user()->email ); echo $user_photo; ?>" class="user-image" alt="Photo of {{ Auth::user()->name }}">
                    <span>{{ Auth::user()->name }}</span>
                    <i class="fa fa-angle-right float-right"></i>
                </a>
                <ul class="treeview-menu">
                    @if(is_user_role('SuperAdmin'))
                    <li><a href="{{ URL::to('admin/user-management') }}"><i class="fa fa-wrench text-success"></i> <span>User Management</span><span class="badge badge-success float-right"><?php echo DB::table('users')->count(); ?></span></a></li>
                    <!--<li class="nav-item { Route::is('log-viewer::dashboard') ? 'active' : '' }}"><a href="{ route('log-viewer::dashboard') }}" class="nav-link"><i class="fa fa-dashboard"></i> LogViewer</a></li>-->
                    <!--<li><a href="{ URL::to('log-viewer') }}"><i class="fa fa-life-ring text-danger"></i> <span>Log Viewer</span></a></li>-->
                    <!--<li><a href="{ URL::to('activity-log') }}"><i class="fa fa-eye text-warning"></i> <span>Activity Log</span></a></li>-->
                    @endif

                    <hr style="margin: 5px auto; border-top: 1px solid rgba(0,0,0,.2);">

                    <li><a href="{{ URL::to('/user/user-profile') }}"><i class="fa fa-user text-success"></i> My Profile</a></li>
                    <li><a href="{{ url('/user/update-profile' ) }}"><i class="fa fa-edit text-warning"> </i> Update Profile</a></li>
                    <li>@if(Auth::user()) <a href="{{ URL::to( '/user/change-password') }}"><i class="fa fa-sync-alt text-info"> </i> Change Password</a> @endif</li>
                    <li><a href="{{ URL::to('/user/account-settings') }}"><i class="fas fa-user-cog text-success"></i> Account Settings</a></li>
                    <li><a href="{{ url('lockscreen') }}"><i class="fa fa-eye-slash text-warning"> </i> {{ __('Lock Screen') }}</a></li>
                    <li><a href="{{ url('logout') }}"><i class="fa fa-sign-out-alt text-danger"> </i> {{ __('Logout') }}</a></li>
                </ul>
            </li>
            <li class="header">MAIN NAVIGATION</li>
            <li><a href="{{ url('/dashboard') }}"><i class="fa fa-tachometer-alt"></i> <span>Dashboard</span></a></li>

            <li><a href="{{ url('/employee/employee-management') }}"><i class="fa fa-id-card text-primary"></i><span>Employees</span><span class="badge badge-warning float-right"><?php echo DB::table('employees')->count(); ?></span></a></li>
            <li class="treeview">
                <a href="#"><i class="fa fa-envelope" aria-hidden="true"></i><span>Email & SMS</span><i class="fa fa-angle-right float-right"></i></a>
                <ul class="treeview-menu">
                    <li><a href="{{ URL::to('/email/compose') }}"><i class="fa fa-edit text-success" aria-hidden="true"></i> Compose<span class="badge badge-success float-right"><?php //echo $total_site_qty_res; ?></span></a></li>
                    <li><a href="{{ URL::to('/email/inbox') }}"><i class="fa fa-inbox text-yellow"></i>Inbox <span class="badge badge-primary float-right"><?php echo DB::table('emails')->where('email_type', '=', 'inbox')->count(); ?></span></a></li>
                    <li><a href="{{ URL::to('/email/sent') }}"><i class="fa fa-envelope text-info"></i>Sent <span class="badge badge-primary float-right"><?php echo DB::table('emails')->where('email_type', '=', 'sent')->count(); ?></span></a></li>
                    <li><a href="{{ URL::to('/email/drafts') }}"><i class="fa fa-file text-default"></i>Drafts <span class="badge badge-primary float-right"><?php echo DB::table('emails')->where('email_type', '=', 'drafts')->count(); ?></span></a></li>
                    <li><a href="{{ URL::to('/email/trash') }}"><i class="fa fa-trash text-default"></i>Trash <span class="badge badge-primary float-right"><?php echo DB::table('emails')->where('email_type', '=', 'trash')->count(); ?></span></a></li>
                    <li><a href="{{ URL::to('/email/spam') }}"><i class="fa fa-filter text-default"></i>Spam <span class="badge badge-primary float-right"><?php echo DB::table('emails')->where('email_type', '=', 'spam')->count(); ?></span></a></li>
                    <li><a href="{{ URL::to('/notification/sms') }}"><i class="fa fa-comments text-info" aria-hidden="true"></i> SMS</a></li>
                </ul>
            </li>
            <li class="header">IMPORTANT INFO ON THIS MONTH</li>
            <li><a href="{{ url('current-month-po') }}"><i class="far fa-circle text-aqua"></i><span> PO Received</span><span class="badge badge-info float-right"><?php //echo $po_received_qty_res; ?>00</span></a></li>
            <li><a href="{{ url('current-month-running-job') }}"><i class="far fa-circle text-fuchsia"></i><span> Running Job</span><span class="badge badge-danger float-right"><?php //echo $job_running_qty_res; ?>00</span></a></li>
            <li><a href="{{ url('current-month-submitted-bill') }}"><i class="far fa-circle text-success"></i><span> Submitted Bill</span><span class="badge badge-success float-right"><?php //echo $submitted_bill_qty_res; ?>00</span></a></li>
            <li><a href="{{ url('current-month-pending-bill') }}"><i class="far fa-circle text-yellow"></i><span> Pending Bill</span><span class="badge badge-warning float-right"><?php //echo $pending_bill_qty_res; ?>00</span></a></li>
            <li class="treeview">
                <a href="#"><i class="fa fa-shopping-bag text-success"></i><span>Inventory</span><i class="fa fa-angle-right float-right"></i></a>
                <ul class="treeview-menu">
                    <li><a href="{{ URL::to('/inventory/inventory-management') }}"><i class="fa fa-shopping-bag text-success"></i>Inventory</a></li>
                </ul>
            </li>
            <li class="treeview">
                <a href="#"><i class="fas fa-chart-bar"></i> <span>Report</span><i class="fa fa-angle-right float-right"></i></a>
                <ul class="treeview-menu">
                    <li class="treeview">
                        <a href="#"><i class="fa fa-tasks"></i> <span>Month wise Report</span><i class="fa fa-angle-right float-right"></i></a>
                        <ul class="treeview-menu">
                            <li><a href="{{ URL::to('archive-previous-month') }}"><i class="far fa-circle text-fuchsia"></i> Previous Month <span class="badge badge-fuchsia float-right"><?php //echo $display_close_previous_month_res; ?></span></a></li>
                            <li><a href="{{ URL::to('archive-current-month') }}"><i class="far fa-circle text-aqua"></i> Current Month <span class="badge badge-aqua float-right"><?php //echo $display_close_cur_month_res; ?></span></a></li>
                            <li><a href="{{ URL::to('archive-next-month') }}"><i class="far fa-circle text-red"></i> Next Month <span class="badge badge-danger float-right"><?php //echo $display_close_next_month_res; ?></span></a></li>
                            <li><a href="{{ URL::to('archive-current-year') }}"><i class="far fa-circle text-info"></i> Current Year <span class="badge badge-info float-right"><?php //echo $display_close_cur_year_res; ?></span></a></li>
                            <li><a href="{{ URL::to('archive-first-jan-to-today') }}"><i class="far fa-circle text-yellow"></i> 1st Jan To Today <span class="badge badge-warning float-right"><?php //echo $display_close_jan_to_today_res; ?></span></a></li>
                            <li><a href="{{ URL::to('archive-next-year') }}"><i class="far fa-circle text-blue "></i> Next Year <span class="badge badge-primary float-right"><?php //echo $display_close_next_year_res; ?></span></a></li>
                            <li><a href="{{ URL::to('archive-previous-year') }}"><i class="far fa-circle text-green"></i> Previous Year <span class="badge badge-success float-right"><?php //echo $display_close_previous_year_res; ?></span></a></li>
                            <li><a href="{{ URL::to('archive-custom-date') }}"><i class="fa fa-calendar text-info"></i> Custom Date</a></li>
                        </ul>
                    </li>
                    <li><a href="{{ URL::to('archive-previous-month') }}"><i class="far fa-circle text-fuchsia"></i> Stock Balance Report <span class="badge badge-fuchsia float-right"><?php //echo $display_close_previous_month_res; ?></span></a></li>
                    <li><a href="{{ URL::to('archive-current-month') }}"><i class="far fa-circle text-aqua"></i> Daily Summary Report <span class="badge badge-aqua float-right"><?php //echo $display_close_cur_month_res; ?></span></a></li>
                    <li><a href="{{ URL::to('archive-next-month') }}"><i class="far fa-circle text-red"></i> Sale History Report <span class="badge badge-danger float-right"><?php //echo $display_close_next_month_res; ?></span></a></li>
                    <li><a href="{{ URL::to('archive-current-year') }}"><i class="far fa-circle text-info"></i> Sale Deleted Report <span class="badge badge-info float-right"><?php //echo $display_close_cur_year_res; ?></span></a></li>
                    <li><a href="{{ URL::to('archive-first-jan-to-today') }}"><i class="far fa-circle text-yellow"></i> Sale Detail Report <span class="badge badge-warning float-right"><?php //echo $display_close_jan_to_today_res; ?></span></a></li>
                    <li><a href="{{ URL::to('archive-next-year') }}"><i class="far fa-circle text-blue "></i> Sale Stock Report <span class="badge badge-primary float-right"><?php //echo $display_close_next_year_res; ?></span></a></li>
                    <li><a href="{{ URL::to('archive-previous-year') }}"><i class="far fa-circle text-green"></i> Sale Discount Report <span class="badge badge-success float-right"><?php //echo $display_close_previous_year_res; ?></span></a></li>
                    <li><a href="{{ URL::to('archive-custom-date') }}"><i class="fa fa-calendar text-info"></i> Sale Graph Report</a></li>
                </ul>
            </li>
            <li class="treeview">
                <a href="#"><i class="fa fa-cog text-aqua"></i> <span>System Settings</span><i class="fa fa-angle-right float-right"></i></a>
                <ul class="treeview-menu">
                    <li><a href="{{ url('settings/system-settings') }}"><i class="fa fa-cog text-fuchsia fa-lg" aria-hidden="true"></i> System Settings <span class="badge badge-fuchsia float-right"><?php //echo $display_close_previous_month_res; ?></span></a></li>
                    <li><a href="{{ url('/system-info') }}"><i class="fa fa-info text-info fa-lg" aria-hidden="true"></i> System Info <span class="badge badge-info float-right"><?php //echo $display_close_previous_month_res; ?></span></a></li>
                    <li><a href="{{ URL::to('database-backup-restore') }}"><i class="fa fa-database text-warning"></i> Database Backup & Restore <span class="badge badge-warning float-right"><?php //echo $display_close_previous_month_res; ?></span></a></li>
                    <li><a href="{{ URL::to('archive-current-month') }}"><i class="far fa-circle text-aqua"></i> Daily Summary Report <span class="badge badge-aqua float-right"><?php //echo $display_close_cur_month_res; ?></span></a></li>
                    <li><a href="{{ URL::to('/store/store-management') }}"><i class="fa fa-store text-danger"></i>Store Management</a></li>
                    <li><a href="{{ URL::to('/warehouse/warehouse-management') }}"><i class="fa fa-warehouse"></i>Warehouse Management</a></li>
                </ul>
            </li>
        </ul>

        <!-- /menu footer buttons -->
        <div class="sidebar-footer hidden-small">
            <a href="{{ url('settings/system-settings') }}" data-toggle="tooltip" data-placement="top" title="System Settings"><i class="fa fa-cog fa-spin" aria-hidden="true"></i></a>
            <a href="#" id="fullscreen" data-toggle="tooltip" data-placement="top" title="FullScreen"><i class="fa fa-arrows-alt" aria-hidden="true"></i></a>
            <a href="#" id="exitFullscreen" style="display: none;"><i class="fa fa-arrows-alt" aria-hidden="true"></i></a>
            <a href="{{ url('lockscreen') }}" data-toggle="tooltip" data-placement="top" title="Lock"><i class="fa fa-eye-slash" aria-hidden="true"></i></a>
            <a href="{{ url('logout') }}" data-toggle="tooltip" data-placement="top" title="Logout"><i class="fa fa-power-off" aria-hidden="true"></i></a>
        </div>
    </nav><!-- /.sidebar -->
</aside>

<div class="control-sidebar-bg"></div>
