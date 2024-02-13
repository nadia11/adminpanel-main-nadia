<div class="row">
    <div class="col-md-9">
        <div class="box box-info" style="max-height: 475px;">
            <div class="box-header with-border">
                <h3 class="box-title">Weekly Earnings Report</h3>
                <div class="box-tools float-right">
                    <button type="button" class="btn btn-box-tool" id="refresh" data-widget="Refresh" data-toggle="tooltip" title="Refresh"><i class="fa fa-sync-alt"></i></button>
                </div><!-- /.box-tools -->
            </div><!-- /.box-header -->
            <div class="box-body">
                <table class="table table-bordered table-summery" style="height: 415px;">
                    <thead class="table-blue">
                        <tr>
                            <th class="p-0" style="width: 15%;">Earnings Source</th>
                            <th class="p-0" style="width: 10%;">{{ Carbon\Carbon::today()->subDay(6)->dayName }} <p class="p-0 m-0">{{ Carbon\Carbon::today()->subDay(6)->format('d/m/Y') }}</p></th>
                            <th class="p-0" style="width: 10%;">{{ Carbon\Carbon::today()->subDay(5)->dayName }} <p class="p-0 m-0">{{ Carbon\Carbon::today()->subDay(5)->format('d/m/Y') }}</p></th>
                            <th class="p-0" style="width: 10%;">{{ Carbon\Carbon::today()->subDay(4)->dayName }} <p class="p-0 m-0">{{ Carbon\Carbon::today()->subDay(4)->format('d/m/Y') }}</p></th>
                            <th class="p-0" style="width: 10%;">{{ Carbon\Carbon::today()->subDay(3)->dayName }} <p class="p-0 m-0">{{ Carbon\Carbon::today()->subDay(3)->format('d/m/Y') }}</p></th>
                            <th class="p-0" style="width: 10%;">{{ Carbon\Carbon::today()->subDay(2)->dayName }} <p class="p-0 m-0">{{ Carbon\Carbon::today()->subDay(2)->format('d/m/Y') }}</p></th>
                            <th class="p-0" style="width: 10%;">{{ Carbon\Carbon::yesterday()->dayName }} <p class="p-0 m-0">{{ Carbon\Carbon::yesterday()->format('d/m/Y') }}</p></th>
                            <th class="p-0" style="width: 10%;">{{ Carbon\Carbon::today()->dayName }} <p class="p-0 m-0">{{ Carbon\Carbon::today()->format('d/m/Y') }}</p></th>
                            <th class="p-0" style="width: 10%;">Total Amount <p class="p-0 m-0">{{ Carbon\Carbon::today()->subDay(6)->format('d/m/Y') }} - {{ Carbon\Carbon::today()->format('d/m/Y') }}</p></th>
                            <th class="p-0" style="width: 10%;">Average</th>
                        </tr>
                    </thead>
                    <tbody>
						<?php $earning_info = DB::table('drivers')->select('driver_id', 'driver_name', 'created_at')->groupBy('driver_id', 'driver_name', 'created_at')->get(); ?>

                        @foreach( $earning_info as $earning )
                        <tr>
                            <td class="text-left">{{ str_snack($earning->driver_name) }}</td>
                            <td class="text-right">{{ taka_format("", DB::table('drivers')->where('driver_id', $earning->driver_id)->whereDate('created_at', Carbon\Carbon::today()->subDay(6))->SUM('trip_count')) }}</td>
                            <td class="text-right">{{ taka_format("", DB::table('drivers')->where('driver_id', $earning->driver_id)->whereDate('created_at', Carbon\Carbon::today()->subDay(5))->SUM('trip_count')) }}</td>
                            <td class="text-right">{{ taka_format("", DB::table('drivers')->where('driver_id', $earning->driver_id)->whereDate('created_at', Carbon\Carbon::today()->subDay(4))->SUM('trip_count')) }}</td>
                            <td class="text-right">{{ taka_format("", DB::table('drivers')->where('driver_id', $earning->driver_id)->whereDate('created_at', Carbon\Carbon::today()->subDay(3))->SUM('trip_count')) }}</td>
                            <td class="text-right">{{ taka_format("", DB::table('drivers')->where('driver_id', $earning->driver_id)->whereDate('created_at', Carbon\Carbon::today()->subDay(2))->SUM('trip_count')) }}</td>
                            <td class="text-right">{{ taka_format("", DB::table('drivers')->where('driver_id', $earning->driver_id)->whereDate('created_at', Carbon\Carbon::today()->subDay(1))->SUM('trip_count')) }}</td>
                            <td class="text-right">{{ taka_format("", DB::table('drivers')->where('driver_id', $earning->driver_id)->whereDate('created_at', date('Y-m-d'))->SUM('trip_count')) }}</td>
                            <td class="text-right">{{ taka_format("", DB::table('drivers')->where('driver_id', $earning->driver_id)->whereBetween('created_at', [Carbon\Carbon::today()->subDay(6), date('Y-m-d')])->SUM('trip_count')) }}</td>
                            <td class="text-right">{{ taka_format("", DB::table('drivers')->where('driver_id', $earning->driver_id)->whereBetween('created_at', [Carbon\Carbon::today()->subDay(6), date('Y-m-d')])->SUM('trip_count') / 7) }}</td>
                        </tr>
						@endforeach
                    </tbody>
                    <tfoot class="total_row">
						<tr>
							<th colspan="1" class="total_text">Total </th>
							<th>{{ taka_format("", DB::table('drivers')->whereDate('created_at', Carbon\Carbon::today()->subDay(6))->SUM('trip_count')) }}</th>
							<th>{{ taka_format("", DB::table('drivers')->whereDate('created_at', Carbon\Carbon::today()->subDay(5))->SUM('trip_count')) }}</th>
							<th>{{ taka_format("", DB::table('drivers')->whereDate('created_at', Carbon\Carbon::today()->subDay(4))->SUM('trip_count')) }}</th>
							<th>{{ taka_format("", DB::table('drivers')->whereDate('created_at', Carbon\Carbon::today()->subDay(3))->SUM('trip_count')) }}</th>
							<th>{{ taka_format("", DB::table('drivers')->whereDate('created_at', Carbon\Carbon::today()->subDay(2))->SUM('trip_count')) }}</th>
							<th>{{ taka_format("", DB::table('drivers')->whereDate('created_at', Carbon\Carbon::today()->subDay(1))->SUM('trip_count')) }}</th>
							<th>{{ taka_format("", DB::table('drivers')->whereDate('created_at', Carbon\Carbon::today())->SUM('trip_count')) }}</th>
							<th>{{ taka_format("", DB::table('drivers')->whereBetween('created_at', [Carbon\Carbon::today()->subDay(6), date('Y-m-d')])->SUM('trip_count')) }}</th>
							<th>-</th>
						</tr>
                    </tfoot>
                </table>
            </div>
        </div><!-- /.box -->
    </div>
    <div class="col-md-3">
        <div class="box box-info" style="max-height: 475px;">
            <div class="box-header with-border">
                <h3 class="box-title">Division wise Agent Map</h3>
                <div class="box-tools float-right">
                    <button type="button" class="btn btn-box-tool" id="refresh" data-widget="Refresh" data-toggle="tooltip" title="Refresh"><i class="fa fa-sync-alt"></i></button>
                </div><!-- /.box-tools -->
            </div><!-- /.box-header -->

            <div class="box-body">
                <div class="floatright">
                    <div class="noresize" style="height: 415px;width: 300px; margin: 0 auto;">
                        <map name="ImageMap_7e2ae818281c9310">
                            <area href="{{ url('agent/agent-management?division_id=7') }}" shape="poly" coords="107,110,97,112,82,107,77,101,66,95,56,89,52,76,46,81,36,81,30,70,19,59,12,60,8,50,13,45,16,34,31,21,33,14,23,14,25,4,33,11,56,31,68,30,58,19,61,15,69,19,75,33,90,44,104,46,105,41,103,36,109,33,115,42,119,58,119,80,113,90,104,110" alt="Rangpur Division" title="Rangpur Division" target="_blank">
                            <area href="{{ url('agent/agent-management?division_id=6') }}" shape="poly" coords="111,193,98,196,85,188,74,184,48,171,45,159,37,162,14,151,5,135,12,126,11,119,14,117,19,122,29,114,32,101,42,101,53,101,66,97,83,108,88,111,105,110,109,125,115,133,113,145,113,159,117,176,109,183,109,193" alt="Rajshahi Division" title="Rajshahi Division" target="_blank">
                            <area href="{{ url('agent/agent-management?division_id=4') }}" shape="poly" coords="78,344,71,320,65,299,62,272,59,248,65,238,45,230,52,222,41,206,42,191,49,189,45,171,62,175,76,188,85,199,100,216,110,245,122,269,123,289,120,327,80,344" alt="Khulna Division" title="Khulna Division" target="_blank">
                            <area href="{{ url('agent/agent-management?division_id=5') }}" shape="poly" coords="117,86,112,92,116,98,108,110,112,128,115,145,122,141,121,133,124,131,126,133,135,131,137,134,143,150,147,164,159,159,171,164,171,158,165,150,174,147,194,142,208,139,206,131,194,120,192,105,177,104,163,104,144,100,128,94,124,94,116,90,113,92" alt="Mymensingh Division" title="Mymensingh Division" target="_blank">
                            <area href="{{ url('agent/agent-management?division_id=3') }}" shape="poly" coords="135,127,122,136,113,146,111,154,116,167,116,178,109,183,111,194,99,196,90,191,85,199,92,203,105,230,120,259,142,246,146,250,154,250,163,244,164,226,165,211,171,204,177,193,186,189,194,176,193,170,201,164,208,160,207,139,183,146,167,149,172,153,172,160,164,164,160,159,153,164,143,160,144,150,136,141,135,126,116,143" alt="Dhaka Division" title="Dhaka Division" target="_blank">
                            <area href="{{ url('agent/agent-management?division_id=1') }}" shape="poly" coords="153,251,174,260,188,287,190,309,177,326,144,333,126,331,121,304,124,279,124,260,140,247,169,253" alt="Barisal Division" title="Barisal Division" target="_blank">
                            <area href="{{ url('agent/agent-management?division_id=8') }}" shape="poly" coords="192,100,217,104,244,101,263,101,283,112,289,122,274,125,266,148,256,158,251,169,250,171,240,166,240,172,233,169,233,174,218,175,217,184,212,183,213,165,206,164,209,160,209,145,209,135,206,124,197,119,194,103,210,99" alt="Sylhet Division" title="Sylhet Division" target="_blank">
                            <area href="{{ url('agent/agent-management?division_id=2') }}" shape="poly" coords="212,167,214,184,205,194,203,210,210,230,216,247,219,246,218,235,223,235,228,253,238,253,243,244,242,231,251,223,255,218,253,203,260,208,268,203,274,208,280,235,281,254,285,265,296,309,294,310,296,329,294,344,299,369,294,372,289,365,286,364,278,357,274,365,270,369,270,379,278,403,277,405,262,379,256,360,251,354,248,355,247,337,247,326,247,316,239,292,228,293,222,300,204,308,179,311,185,287,175,262,164,247,163,226,171,216,171,203,179,194,188,189,194,180,194,171,212,168" alt="Chittagong Division" title="Chittagong Division" target="_blank">
                        </map>
                        <img alt="A clickable map of Bangladesh exhibiting its divisions." src="{{ image_url('Bangladesh_divisions_english.svg.png') }}" decoding="async" width="300" height="415" data-file-width="1550" data-file-height="2150" usemap="#ImageMap_7e2ae818281c9310">
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
