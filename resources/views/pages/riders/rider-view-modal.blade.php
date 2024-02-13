<div class="modal fade" id="view_rider_modal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-extra-lg">
        <div class="modal-content">

            <!-- Modal Header -->
            <div class="modal-header">
                <h4 class="modal-title"></h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">&times;</button>
            </div>

            <!-- Modal body -->
            <div class="modal-body">
                <table class="table table-bordered">
                    <tr>
                        <th style="width: 14%;">Rider Name</th>
                        <td style="width: 1%;">:</td>
                        <td style="width: 34%;" class="rider_name text-capitalize"></td>
                        <td style="max-width: 3px; border: none; background: #F0F0F0;"></td>

                        <th style="width: 15%;">Rider Status</th>
                        <td style="width: 1%;">:</td>
                        <td style="width: 34%;" class="rider_status text-capitalize"></td>
                    </tr>
                    <tr>
                        <th>Mobile</th>
                        <td>:</td>
                        <td class="mobile"></td>
                        <td style="border: none; background: #F0F0F0;"></td>

                        <th>Email</th>
                        <td>:</td>
                        <td class="email"></td>
                    </tr>
                    <tr>
                        <th>National ID</th>
                        <td>:</td>
                        <td class="national_id"><var></var><div class="float-right attachment-btn"><a href="" class="btn btn-sm" download> <i class="fa fa-cloud-download-alt"></i> National ID</a></div></td>
                        <td style="border: none; background: #F0F0F0;"></td>

                        <th>Home LatLong</th>
                        <td>:</td>
                        <td class="latlng"><var></var><div class="float-right attachment-btn"><a href="" class="btn btn-sm" target="_blank"> <i class="fa fa-map-marker-alt"></i> View in Map</a></div></td>
                    </tr>
                    <tr>
                        <th>Gender</th>
                        <td>:</td>
                        <td class="gender text-capitalize"></td>
                        <td style="border: none; background: #F0F0F0;"></td>

                        <th>Nationality</th>
                        <td>:</td>
                        <td class="nationality text-capitalize"></td>
                    </tr>
                    <tr>
                        <th>Date of Birth</th>
                        <td>:</td>
                        <td class="date_of_birth"></td>
                        <td style="border: none; background: #F0F0F0;"></td>

                        <th>Blood Group</th>
                        <td>:</td>
                        <td class="blood_group"></td>
                    </tr>
                    <tr>
                        <th>Trip Count</th>
                        <td>:</td>
                        <td class="trip_count"></td>
                        <td style="border: none; background: #F0F0F0;"></td>

                        <th>Wallet Balance</th>
                        <td>:</td>
                        <td class="wallet_balance"></td>
                    </tr>
                    <tr>
                        <th>Ratings</th>
                        <td>:</td>
                        <td class="ratings"></td>
                        <td style="border: none; background: #F0F0F0;"></td>

                        <th>Referral Code</th>
                        <td>:</td>
                        <td class="referral_code"></td>
                    </tr>
                    <tr>
                        <th>Referral Name</th>
                        <td>:</td>
                        <td class="referral_name text-capitalize"></td>
                        <td style="border: none; background: #F0F0F0;"></td>

                        <th>Referral Mobile</th>
                        <td>:</td>
                        <td class="referral_mobile"></td>
                    </tr>
                    <tr>
                        <th>Invitation Code</th>
                        <td>:</td>
                        <td class="invitation_code text-capitalize"></td>
                        <td style="border: none; background: #F0F0F0;"></td>

                        <th>Registration Date</th>
                        <td>:</td>
                        <td colspan="5" class="reg_date"></td>
                    </tr>
                    <tr>
                        <th>Note</th>
                        <td>:</td>
                        <td colspan="5" class="rider_note"></td>
                    </tr>
                </table>

                <table class="table table-bordered table-summery">
                    <caption>Current Year Expense Report - {{ date('Y') }}</caption>
                    <thead>
                    <tr>
                        <?php foreach (range(1,'12') as $month){ echo "<th  style='width: 6%;'>".date("M",mktime(0,0,0,$month,10))."</th>"; } ?>
                        <th>Total Amount</th>
                        <th>Average</th>
                    </tr>
                    </thead>
                    <tbody>
                    {{--                    <?php  //$site_expenses = DB::table('site_expenses')->leftjoin('site_expense_purposes', 'site_expenses.purpose_id', '=', 'site_expense_purposes.purpose_id')->select('site_expense_purposes.purpose_name', 'site_expenses.purpose_id')->unionall($additional_expense)->groupBy('site_expense_purposes.purpose_name', 'site_expenses.purpose_id')->get(); ?>--}}
                    {{--                    <?php //$year = date('Y'); ?>--}}
                    {{--                    @foreach( $site_expenses as $expense )--}}
                    {{--                        <tr>--}}
                    {{--                            <td>{{ str_snack($expense->purpose_name) }}</td>--}}
                    {{--                            <td class="text-right">{{ taka_format("", DB::table('site_expenses')->where('purpose_id', $expense->purpose_id)->whereMonth('payment_date', '01')->whereYear('payment_date', $year)->SUM('payment_amount')) }}</td>--}}
                    {{--                            <td class="text-right">{{ taka_format("", DB::table('site_expenses')->where('purpose_id', $expense->purpose_id)->whereMonth('payment_date', '02')->whereYear('payment_date', $year)->SUM('payment_amount')) }}</td>--}}
                    {{--                            <td class="text-right">{{ taka_format("", DB::table('site_expenses')->where('purpose_id', $expense->purpose_id)->whereMonth('payment_date', '03')->whereYear('payment_date', $year)->SUM('payment_amount')) }}</td>--}}
                    {{--                            <td class="text-right">{{ taka_format("", DB::table('site_expenses')->where('purpose_id', $expense->purpose_id)->whereMonth('payment_date', '04')->whereYear('payment_date', $year)->SUM('payment_amount')) }}</td>--}}
                    {{--                            <td class="text-right">{{ taka_format("", DB::table('site_expenses')->where('purpose_id', $expense->purpose_id)->whereMonth('payment_date', '05')->whereYear('payment_date', $year)->SUM('payment_amount')) }}</td>--}}
                    {{--                            <td class="text-right">{{ taka_format("", DB::table('site_expenses')->where('purpose_id', $expense->purpose_id)->whereMonth('payment_date', '06')->whereYear('payment_date', $year)->SUM('payment_amount')) }}</td>--}}
                    {{--                            <td class="text-right">{{ taka_format("", DB::table('site_expenses')->where('purpose_id', $expense->purpose_id)->whereMonth('payment_date', '07')->whereYear('payment_date', $year)->SUM('payment_amount')) }}</td>--}}
                    {{--                            <td class="text-right">{{ taka_format("", DB::table('site_expenses')->where('purpose_id', $expense->purpose_id)->whereMonth('payment_date', '08')->whereYear('payment_date', $year)->SUM('payment_amount')) }}</td>--}}
                    {{--                            <td class="text-right">{{ taka_format("", DB::table('site_expenses')->where('purpose_id', $expense->purpose_id)->whereMonth('payment_date', '09')->whereYear('payment_date', $year)->SUM('payment_amount')) }}</td>--}}
                    {{--                            <td class="text-right">{{ taka_format("", DB::table('site_expenses')->where('purpose_id', $expense->purpose_id)->whereMonth('payment_date', '10')->whereYear('payment_date', $year)->SUM('payment_amount')) }}</td>--}}
                    {{--                            <td class="text-right">{{ taka_format("", DB::table('site_expenses')->where('purpose_id', $expense->purpose_id)->whereMonth('payment_date', '11')->whereYear('payment_date', $year)->SUM('payment_amount')) }}</td>--}}
                    {{--                            <td class="text-right">{{ taka_format("", DB::table('site_expenses')->where('purpose_id', $expense->purpose_id)->whereMonth('payment_date', '12')->whereYear('payment_date', $year)->SUM('payment_amount')) }}</td>--}}
                    {{--                            <td class="text-right">{{ taka_format('', DB::table('site_expenses')->where('purpose_id', $expense->purpose_id)->whereYear('payment_date', $year)->SUM('payment_amount')) }}</td>--}}
                    {{--                            <td class="text-right">{{ taka_format('', DB::table('site_expenses')->where('purpose_id', $expense->purpose_id)->whereYear('payment_date', $year)->SUM('payment_amount') / 12) }}</td>--}}
                    {{--                        </tr>--}}
                    {{--                    @endforeach--}}
                    </tbody>
                    <tfoot class="total_row">
                    <tr>
                        {{--                        <th class="total_text">Grand Total</th>--}}
                        {{--                        <th>{{ taka_format("", DB::table('site_expenses')->whereBetween('payment_date', [(date('Y').'-01-01'), (date('Y').'-01-31')])->SUM('payment_amount')) }}</th>--}}
                        {{--                        <th>{{ taka_format("", DB::table('site_expenses')->whereBetween('payment_date', [(date('Y').'-02-01'), (date('Y').'-02-29')])->SUM('payment_amount')) }}</th>--}}
                        {{--                        <th>{{ taka_format("", DB::table('site_expenses')->whereBetween('payment_date', [(date('Y').'-03-01'), (date('Y').'-03-31')])->SUM('payment_amount')) }}</th>--}}
                        {{--                        <th>{{ taka_format("", DB::table('site_expenses')->whereBetween('payment_date', [(date('Y').'-04-01'), (date('Y').'-04-30')])->SUM('payment_amount')) }}</th>--}}
                        {{--                        <th>{{ taka_format("", DB::table('site_expenses')->whereBetween('payment_date', [(date('Y').'-05-01'), (date('Y').'-05-31')])->SUM('payment_amount')) }}</th>--}}
                        {{--                        <th>{{ taka_format("", DB::table('site_expenses')->whereBetween('payment_date', [(date('Y').'-06-01'), (date('Y').'-06-30')])->SUM('payment_amount')) }}</th>--}}
                        {{--                        <th>{{ taka_format("", DB::table('site_expenses')->whereBetween('payment_date', [(date('Y').'-07-01'), (date('Y').'-07-31')])->SUM('payment_amount')) }}</th>--}}
                        {{--                        <th>{{ taka_format("", DB::table('site_expenses')->whereBetween('payment_date', [(date('Y').'-08-01'), (date('Y').'-08-31')])->SUM('payment_amount')) }}</th>--}}
                        {{--                        <th>{{ taka_format("", DB::table('site_expenses')->whereBetween('payment_date', [(date('Y').'-09-01'), (date('Y').'-09-30')])->SUM('payment_amount')) }}</th>--}}
                        {{--                        <th>{{ taka_format("", DB::table('site_expenses')->whereBetween('payment_date', [(date('Y').'-10-01'), (date('Y').'-10-31')])->SUM('payment_amount')) }}</th>--}}
                        {{--                        <th>{{ taka_format("", DB::table('site_expenses')->whereBetween('payment_date', [(date('Y').'-11-01'), (date('Y').'-11-30')])->SUM('payment_amount')) }}</th>--}}
                        {{--                        <th>{{ taka_format("", DB::table('site_expenses')->whereBetween('payment_date', [(date('Y').'-12-01'), (date('Y').'-12-31')])->SUM('payment_amount')) }}</th>--}}
                        {{--                        <th>{{ taka_format("", DB::table('site_expenses')->whereBetween('payment_date', [(date('Y').'-01-01'), (date('Y').'-12-31')])->SUM('payment_amount')) }}</th>--}}
                        {{--                        <th>-</th>--}}
                    </tr>
                    </tfoot>
                </table>
            </div>
        </div>
    </div>
</div>
