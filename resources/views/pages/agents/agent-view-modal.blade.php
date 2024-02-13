<div class="modal fade" id="view_agent_modal" tabindex="-1" role="dialog" aria-hidden="true">
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
                        <th style="width: 15%;">Agent Name</th>
                        <td style="width: 1%;">:</td>
                        <td class="agent_name text-capitalize"></td>
                        <td style="width: 1%; border: none; background: #F0F0F0;"></td>

                        <th style="width: 14%;">Agent Status</th>
                        <td style="width: 1%;">:</td>
                        <td style="width: 34%;" class="agent_status text-capitalize"></td>
                    </tr>
                    <tr>
                        <th style="width: 14%;">Father's Name</th>
                        <td style="width: 1%;">:</td>
                        <td style="width: 34%;" class="fathers_name text-capitalize"></td>
                        <td style="width: 1%; border: none; background: #F0F0F0;"></td>

                        <th style="width: 15%;">Mother's Name</th>
                        <td style="width: 1%;">:</td>
                        <td style="width: 34%;" class="mothers_name"></td>
                    </tr>
                    <tr>
                        <th>Division Name</th>
                        <td>:</td>
                        <td class="division_name text-capitalize"></td>
                        <td style="width: 1%; border: none; background: #F0F0F0;"></td>

                        <th>District Name</th>
                        <td>:</td>
                        <td class="district_name text-capitalize"></td>
                    </tr>
                    <tr>
                        <th>Branch Name</th>
                        <td>:</td>
                        <td class="branch_name"></td>
                        <td style="width: 1%; border: none; background: #F0F0F0;"></td>

                        <th>Branch Address</th>
                        <td>:</td>
                        <td class="branch_address"></td>
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
                        <th>Latitude/Longitude</th>
                        <td>:</td>
                        <td class="latlng"><var></var><div class="float-right attachment-btn"><a href="" class="btn btn-sm" target="_blank"> <i class="fa fa-map-marker-alt"></i> View in Map</a></div></td>
                        <td style="border: none; background: #F0F0F0;"></td>

                        <th>Trade Licence</th>
                        <td>:</td>
                        <td class="trade_licence"><var></var><div class="float-right attachment-btn"><a href="" class="btn btn-sm" download> <i class="fa fa-cloud-download-alt"></i> Trade Licence</a></div></td>
                    </tr>
                    <tr>
                        <th>Tin Certificate</th>
                        <td>:</td>
                        <td class="tin_certificate"><var></var><div class="float-right attachment-btn"><a href="" class="btn btn-sm" download> <i class="fa fa-cloud-download-alt"></i> Tin Certificate</a></div></td>
                        <td style="border: none; background: #F0F0F0;"></td>

                        <th>VAT Certificate</th>
                        <td>:</td>
                        <td colspan="5" class="vat_certificate"><var></var><div class="float-right attachment-btn"><a href="" class="btn btn-sm" download> <i class="fa fa-cloud-download-alt"></i> VAT Certificate</a></div></td>
                    </tr>
                    <tr>
                        <th>Total Drivers</th>
                        <td>:</td>
                        <td class="total_drivers"></td>
                        <td style="width: 1%; border: none; background: #F0F0F0;"></td>

                        <th>Total Trips</th>
                        <td>:</td>
                        <td class="total_trips"></td>
                    </tr>
                    <tr>
                        <th>Commission Rate</th>
                        <td>:</td>
                        <td class="commission_rate"></td>
                        <td style="width: 1%; border: none; background: #F0F0F0;"></td>

                        <th>Wallet Balance</th>
                        <td>:</td>
                        <td class="wallet_balance"></td>
                    </tr>
                    <tr>
                        <th>Date of Birth</th>
                        <td>:</td>
                        <td class="date_of_birth"></td>
                        <td style="width: 1%; border: none; background: #F0F0F0;"></td>

                        <th>Blood Group</th>
                        <td>:</td>
                        <td class="blood_group"></td>
                    </tr>
                    <tr>
                        <th>Gender</th>
                        <td>:</td>
                        <td class="gender"></td>
                        <td style="border: none; background: #F0F0F0;"></td>

                        <th>Registration Date</th>
                        <td>:</td>
                        <td class="reg_date"></td>
                    </tr>
                    <tr>
                        <th>Note</th>
                        <td>:</td>
                        <td colspan="5" class="note"></td>
                    </tr>
                </table>

                <table class="table table-bordered table-sm earning_view_table text-center">
                    <caption class="view-modal-table-caption">Earnings in 5 Years</caption>
                    <thead class="thead-light">
                        <tr>
                            <th>Source</th>
                            <?php foreach( range(date('Y')-4, date('Y')) as $year){ echo '<th>'.$year.'</th>'; } ?>
                            <th>Total Earnings</th>
                        </tr>
                    </thead>
                    <tbody class="earning_view_wrapper">
                    <!-- Expense View Wrapper -->
                    </tbody>
                    <tfoot>
                        <tr class="text-bold text-right">
                            <th>Total Amount</th>
                            <th></th>
                            <th></th>
                            <th></th>
                            <th></th>
                            <th></th>
                            <th></th>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>
    </div>
</div>
