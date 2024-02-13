<section class="navbar topbar-menu" role="navigation">
    <div class="container-fluid">
        <ul>
            <li>
                <a href="#">Drivers</a>
                <ul>
                    <li><a href="{{ url('driver/all-drivers') }}">All Drivers</a></li>
                    <li><a href="{{ url('driver/unapproved-drivers') }}">Unapproved Drivers</a></li>
                    <li><a href="{{ URL::to('driver/trip/driver-trips') }}">Driver Trip History</a></li>
                    <li><a href="{{ URL::to('driver/trip/driver-upcoming-trip') }}">Upcoming Trips</a></li>
                    <li><a href="{{ URL::to('driver/trip/driver-cancelled-trip') }}">Driver Cancelled Trips</a></li>
                    <li><a href="{{ URL::to('driver/payment/all-payments') }}">Driver Payments</a></li>
                    <li><a href="{{ URL::to('driver/tax/tax-management') }}">Driver Taxes</a></li>
                    <li><a href="{{ URL::to('driver/insurance/insurance-management') }}">Driver Insurances</a></li>
                    <li><a href="{{ URL::to('driver/earning/driver-earnings') }}">Driver Earnings</a></li>
                </ul>
            </li>
            <li>
                <a href="#">Riders</a>
                <ul>
                    <li><a href="{{ url('rider/all-riders') }}">All Riders</a></li>
                    <li><a href="{{ url('rider-trip/rider-all-trips') }}">All Trips</a></li>
                    <li><a href="{{ url('rider-trip/active-rider-trips') }}">Active Trips</a></li>
                    <li><a href="{{ URL::to('rider-trip/completed-rider-trips') }}">completed Trips</a></li>
                    <li><a href="{{ URL::to('rider-trip/cancelled-rider-trips') }}">Cancelled Trips</a></li>
                    <li><a href="{{ URL::to('rider-trip/booked-rider-trips') }}">Booked Trips</a></li>
                    <li><a href="{{ URL::to('rider-trip/searching-trips') }}">Searching Trips</a></li>
                    <li><a href="{{ URL::to('rider/rider-favorite-places') }}">Rider Favourite Places</a></li>
                    <li><a href="{{ URL::to('rider/credit-cards') }}">Rider Credit Cards</a></li>
                </ul>
            </li>
            <li>
                <a href="#">Vehicles</a>
                <ul>
                    <li><a href="{{ url('vehicle/vehicle-management') }}">Vehicle Management</a></li>
                    <li><a href="{{ url('vehicle-type/vehicle-type-management') }}">Vehicle Type Management</a></li>
                </ul>
            </li>
            {{--<li><a href="{{ url('area/restricted-area') }}">Restricted Area</a></li>--}}
            <li><a href="{{ url('fare/fare-management') }}">Fare Management</a></li>
            <li><a href="{{ url('promo-code/promo-code-management') }}">Promo Code</a></li>
            <li><a href="{{ url('referral/referral-management') }}">Referrals</a></li>
            <li><a href="{{ url('agent/agent-management') }}">Agents</a></li>
            <li>
                <a href="#">Accounts</a>
                <ul>
                    <li><a href="{{ URL::to('/account/cashbook') }}">Cashbook</a></li>
                    {{--<li><a href="{{ URL::to('/account/voucher-list') }}">Voucher List</a></li>--}}
                    <li>
                        <a href="#">Commissions</a>
                        <ul>
                            <li><a href="{{ URL::to('/account/commission-settings') }}">Commission Settings</a></li>
                            <li><a href="{{ URL::to('/account/agent-commission-list') }}">Agents Commission List</a></li>
                            <li><a href="{{ URL::to('/account/agency-commission-list') }}">Esojai Commission List</a></li>
                            {{--<li><a href="{{ URL::to('/account/referral-commission-list') }}">Referral Commission List</a></li>--}}
                        </ul>
                    </li>
                    <li><a href="{{ URL::to('/account/asset-list') }}">Asset List</a></li>
                    {{--<li><a href="{{ URL::to('/account/add-balance-to-driver') }}">Add Balance to Driver</a></li>--}}
                </ul>
            </li>
            <li>
                <a href="#">Bank Information</a>
                <ul>
                    <li><a href="{{ URL::to('/bank/bank-account-management') }}">Bank Account Management</a></li>
                    <li><a href="{{ URL::to('/bank/cheque-book-list') }}">Cheque Book List</a></li>
                    <li><a href="{{ URL::to('/bank/cash-deposit-list') }}">Cash Deposit List</a></li>
                    <li><a href="{{ URL::to('/bank/received-cheques') }}">Received Cheques</a></li>
                    <li><a href="{{ URL::to('/bank/bank-transfer-list') }}">Bank Transfer List</a></li>
                    <li><a href="{{ URL::to('/bank/cheque-payment-list') }}">Cheque Payment List</a></li>
                    <li><a href="{{ URL::to('/bank/cash-withdraw-list') }}">Cash Withdraw List</a></li>
                    <li><a href="{{ URL::to('/bank/bank-transaction') }}">Bank Transaction</a></li>
                    <li><a href="{{ URL::to('/bank/bank-transaction-summery') }}">Bank Transaction Summery</a></li>
                </ul>
            </li>
            <li>
                <a href="#">Employees</a>
                <ul>
                    <li><a href="{{ url('/employee/employee-management') }}">Employees Management</a></li>
                    {{--<li><a href="{{ URL::to('/payroll/employee-ledger') }}">Employee Ledger</a></li>--}}
                    {{--<a href="{{ url('/sales-target/sales-target-management') }}">Sales Target</a></li>--}}
                    {{--<li><a href="{{ URL::to('/loan/loan-management') }}">Loan Management</a></li>--}}
                </ul>
            </li>
            <li>
                <a href="#">Email & SMS</a>
                <ul>
                    <li><a href="{{ URL::to('/email/inbox') }}">Inbox</a></li>
                    <li><a href="{{ URL::to('/notification/sms') }}">SMS List</a></li>
                    <li><a href="{{ URL::to('/notification/contact-list') }}">Contact List</a></li>
                    <li><a href="{{ URL::to('/notification/contact-group') }}">Contact Group</a></li>
                    <li><a href="{{ URL::to('/notification/notification-list') }}">Notification List</a></li>
                    <li><a href="{{ URL::to('/news/news-list') }}">Event & News List</a></li>
                </ul>
            </li>
{{--            <li>--}}
{{--                <a href="#">Report</a>--}}
{{--                <ul>--}}
{{--                    <li>--}}
{{--                        <a href="#">Member Report</a>--}}
{{--                        <ul>--}}
{{--                            <li><a href="{{ URL::to('/member/board-expiry-due-list') }}">Board Expiry Due List</a></li>--}}
{{--                            <li><a href="{{ URL::to('/member/board-expired-list') }}">Board Expired List</a></li>--}}
{{--                            <li><a href="{{ url('board-expense/locationwise-expense-summery') }}">Location Wise Expense Summery</a></li>--}}
{{--                            <li><a href="{{ url('board-expense/datewise-expense-summery') }}">Date Wise Expense Summery</a></li>--}}
{{--                            <li><a href="{{ URL::to('board-expense/current-year-expense-summery') }}">Current Year Expense Summery</a></li>--}}
{{--                        </ul>--}}
{{--                    </li>--}}
{{--                </ul>--}}
{{--            </li>--}}
        </ul>
    </div>
    @if(is_user_role('SuperAdmin'))
    <a href="{{ url('settings/system-settings') }}" data-toggle="tooltip" data-placement="top" title="System Settings" class="setting-link" tabindex="-1"><i class="fa fa-cog fa-spin"></i></a>
    @endif
</section><!-- /.topbar -->
