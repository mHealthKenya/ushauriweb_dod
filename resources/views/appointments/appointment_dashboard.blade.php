@extends('layouts.master')
@section('page-css')

@endsection

@section('main-content')
@if (Auth::user()->access_level == 'Admin' || Auth::user()->access_level == 'Partner' || Auth::user()->access_level == 'Donor')
<div class="separator-breadcrumb border-top"></div>

<div class="col-md-12">

    <form role="form" method="post" action="#" id="dataFilter">
        {{ csrf_field() }}
        <div class="row">
            <div class="col">
                <div class="form-group">

                    <select class="form-control filter_partner  input-rounded input-sm select2" id="partners" name="partner">
                        <option value="">Please select Service</option>
                        @foreach ($all_partners as $partner => $value)
                        <option value="{{ $partner }}"> {{ $value }}</option>
                        @endforeach
                        <option></option>
                    </select>
                </div>
            </div>
            <div class="col">
                <div class="form-group">
                    <select class="form-control county  input-rounded input-sm select2" id="counties" name="county">
                        <option value="">Please select Unit:</option>
                        <option value=""></option>
                    </select>
                </div>
            </div>

            <div class="col">
                <div class="form-group">
                    <span class="filter_facility_wait" style="display: none;">Loading , Please Wait ...</span>

                    <select class="form-control filter_facility input-rounded input-sm select2" id="facilities" name="facility">
                        <option value="">Please select CCC Clinic : </option>
                        <option value=""></option>
                    </select>
                </div>
            </div>
            <div class="col">
                <div class="form-group">

                    <button class="btn btn-default filter btn-round  btn-small btn-primary  " type="submit" name="filter" id="filter"> <i class="fa fa-filter"></i>
                        Filter</button>
                </div>
            </div>
        </div>

    </form>

</div>
@endif





<div id="highchart"></div>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    <script src="https://code.highcharts.com/highcharts.js"></script>
    <script src="https://code.highcharts.com/modules/series-label.js"></script>
    <script src="https://code.highcharts.com/modules/exporting.js"></script>
    <script src="https://code.highcharts.com/modules/export-data.js"></script>
    <script src="https://code.highcharts.com/modules/accessibility.js"></script>
    <script src="https://code.highcharts.com/themes/high-contrast-light.js"></script>

                    <div class="row">
                    <div class="col-lg-3 col-md-6 col-sm-6">
                         <div class="card card-icon-bg card-icon-bg-primary o-hidden mb-4">
                          <div class="card-body text-center">
                           <div class="content">
                            <p class="text-muted mt-2 mb-0">Created Appointments</p>

                             <p id="allApps" class="text-primary text-20 line-height-1 mb-2">{{$created_appointmnent_count}}</p>
                           </div>
                          </div>
                         </div>
                        </div>

                        <div class="col-lg-3 col-md-6 col-sm-6">
                         <div class="card card-icon-bg card-icon-bg-primary o-hidden mb-4">
                          <div class="card-body text-center">
                           <div class="content">
                            <p class="text-muted mt-2 mb-0">Honoured Appointments</p>

                             <p id="keptApps" class="text-primary text-20 line-height-1 mb-2">{{$kept_appointmnent_count}}</p>
                           </div>
                          </div>
                         </div>
                        </div>

                        <div class="col-lg-2 col-md-6 col-sm-6">
                         <div class="card card-icon-bg card-icon-bg-primary o-hidden mb-4">
                          <div class="card-body text-center">
                           <div class="content">
                            <p class="text-muted mt-2 mb-0">Active Defaulted Appointments</p>

                             <p id="defaultedApps" class="text-primary text-20 line-height-1 mb-2">{{$defaulted_appointmnent_count}}</p>
                           </div>
                          </div>
                         </div>
                        </div>

                        <div class="col-lg-2 col-md-6 col-sm-6">
                         <div class="card card-icon-bg card-icon-bg-primary o-hidden mb-4">
                          <div class="card-body text-center">
                           <div class="content">
                            <p class="text-muted mt-2 mb-0">Active Missed Appointments</p>

                             <p id="missedApps" class="text-primary text-20 line-height-1 mb-2">{{$missed_appointmnent_count}}</p>
                           </div>
                          </div>
                         </div>
                        </div>

                        <div class="col-lg-2 col-md-6 col-sm-6">
                         <div class="card card-icon-bg card-icon-bg-primary o-hidden mb-4">
                          <div class="card-body text-center">
                           <div class="content">
                            <p class="text-muted mt-2 mb-0">Active LTFU Appointments</p>

                             <p id="ltfuApps" class="text-primary text-20 line-height-1 mb-2">{{$ltfu_appointmnent_count}}</p>
                           </div>
                          </div>
                         </div>
                        </div>

                    </div>

                    <div class="row">
                        <div class="col-12">

                            <div class="card-body row">
                                <div id="container" class="col" style="height: 450px;margin-top:40px;"></div> <br />
                            </div>
                            <div class="card-body row">
                                <div id="trend" class="col" style="height: 450px;margin-top:40px;"></div>
                            </div>
                        </div>
                    </div>




    <script type="text/javascript">

$(document).ready(function() {
            $('select[name="partner"]').on('change', function() {
                var partnerID = $(this).val();
                if (partnerID) {
                    $.ajax({
                        url: '/get_dashboard_counties/' + partnerID,
                        type: "GET",
                        dataType: "json",
                        success: function(data) {


                            $('select[name="county"]').empty();
                            $.each(data, function(key, value) {
                                $('select[name="county"]').append('<option value="' + key + '">' + value + '</option>');
                            });


                        }
                    });
                } else {
                    $('select[name="county"]').empty();
                }
            });
        });

        $(document).ready(function() {
            $('select[name="county"]').on('change', function() {
                var countyID = $(this).val();
                if (countyID) {
                    $.ajax({
                        url: '/get_dashboard_sub_counties/' + countyID,
                        type: "GET",
                        dataType: "json",
                        success: function(data) {


                            $('select[name="subcounty"]').empty();
                            $.each(data, function(key, value) {
                                $('select[name="subcounty"]').append('<option value="' + key + '">' + value + '</option>');
                            });


                        }
                    });
                } else {
                    $('select[name="subcounty"]').empty();
                }
            });
        });

        $(document).ready(function() {
            $('select[name="county"]').on('change', function() {
                var countyID = $(this).val();
                if (countyID) {
                    $.ajax({
                        url: '/get_dashboard_facilities/' + countyID,
                        type: "GET",
                        dataType: "json",
                        success: function(data) {


                            $('select[name="facility"]').empty();
                            $.each(data, function(key, value) {
                                $('select[name="facility"]').append('<option value="' + key + '">' + value + '</option>');
                            });


                        }
                    });
                } else {
                    $('select[name="facility"]').empty();
                }
            });
        });

        $('#dataFilter').on('submit', function(e) {
        e.preventDefault();
        let partners = $('#partners').val();
        let counties = $('#counties').val();
        let facilities = $('#facilities').val();
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        $.ajax({
            type: 'GET',
            data: {
                "partners": partners,
                "counties": counties,
                "facilities": facilities
            },
            url: "{{ route('filter_appointment_dashboard') }}",
            success: function(data) {
                $("#allApps").html(data.created_appointmnent_count);
                $("#keptApps").html(data.kept_appointmnent_count);
                $("#defaultedApps").html(data.defaulted_appointmnent_count);
                $("#missedApps").html(data.missed_appointmnent_count);
                $("#ltfuApps").html(data.ltfu_appointmnent_count);

                $("#container").html(data.all_appointment_by_marital_single_missed);
                $("#container").html(data.all_appointment_by_marital_single_defaulted);
                $("#container").html(data.all_appointment_by_marital_single_ltfu);
                $("#container").html(data.all_appointment_by_marital_monogomous_missed);
                $("#container").html(data.all_appointment_by_marital_monogomous_defaulted);
                $("#container").html(data.all_appointment_by_marital_monogomous_lftu);
                $("#container").html(data.all_appointment_by_marital_divorced_missed);
                $("#container").html(data.all_appointment_by_marital_divorced_defaulted);
                $("#container").html(data.all_appointment_by_marital_divorced_lftu);
                $("#container").html(data.all_appointment_by_marital_widowed_missed);
                $("#container").html(data.all_appointment_by_marital_widowed_defaulted);

                $("#container").html(data.all_appointment_by_marital_widowed_lftu);
                $("#container").html(data.all_appointment_by_marital_cohabiting_missed);
                $("#container").html(data.all_appointment_by_marital_cohabiting_defaulted);
                $("#container").html(data.all_appointment_by_marital_cohabiting_lftu);
                $("#container").html(data.all_appointment_by_marital_unavailable_missed);
                $("#container").html(data.all_appointment_by_marital_unavailable_defaulted);
                $("#container").html(data.all_appointment_by_marital_unavailable_lftu);
                $("#container").html(data.all_appointment_by_marital_polygamous_missed);
                $("#container").html(data.all_appointment_by_marital_polygamous_defaulted);
                $("#container").html(data.all_appointment_by_marital_polygamous_lftu);
                $("#container").html(data.all_appointment_by_marital_notapplicable_missed);
                $("#container").html(data.all_appointment_by_marital_notapplicable_defaulted);
                $("#container").html(data.all_appointment_by_marital_notapplicable_lftu);



            }
        });
    });
        var singleMissed =  <?php echo json_encode($all_appointment_by_marital_single_missed) ?>;
        var singleDefaulted =  <?php echo json_encode($all_appointment_by_marital_single_defaulted) ?>;
        var singleLTFU =  <?php echo json_encode($all_appointment_by_marital_single_ltfu) ?>;

        var monogamousMissed =  <?php echo json_encode($all_appointment_by_marital_monogomous_missed) ?>;
        var monogamousDefaulted =  <?php echo json_encode($all_appointment_by_marital_monogomous_defaulted) ?>;
        var monogamousLTFU =  <?php echo json_encode($all_appointment_by_marital_monogomous_lftu) ?>;

        var divorcedMissed =  <?php echo json_encode($all_appointment_by_marital_divorced_missed) ?>;
        var divorcedDefaulted =  <?php echo json_encode($all_appointment_by_marital_divorced_defaulted) ?>;
        var divorcedLTFU =  <?php echo json_encode($all_appointment_by_marital_divorced_lftu) ?>;

        var widowedMissed =  <?php echo json_encode($all_appointment_by_marital_widowed_missed) ?>;
        var widowedDefaulted =  <?php echo json_encode($all_appointment_by_marital_widowed_defaulted) ?>;
        var widowedLTFU =  <?php echo json_encode($all_appointment_by_marital_widowed_lftu) ?>;

        var cohabitingMissed =  <?php echo json_encode($all_appointment_by_marital_cohabiting_missed) ?>;
        var cohabitingDefaulted =  <?php echo json_encode($all_appointment_by_marital_cohabiting_defaulted) ?>;
        var cohabitingLTFU =  <?php echo json_encode($all_appointment_by_marital_cohabiting_lftu) ?>;

        var unavailableMissed =  <?php echo json_encode($all_appointment_by_marital_unavailable_missed) ?>;
        var unavailableDefaulted =  <?php echo json_encode($all_appointment_by_marital_unavailable_defaulted) ?>;
        var unavailableLTFU =  <?php echo json_encode($all_appointment_by_marital_unavailable_lftu) ?>;

        var polygamousMissed =  <?php echo json_encode($all_appointment_by_marital_polygamous_missed) ?>;
        var polygamousDefaulted =  <?php echo json_encode($all_appointment_by_marital_polygamous_defaulted) ?>;
        var polygamousLTFU =  <?php echo json_encode($all_appointment_by_marital_polygamous_lftu) ?>;

        var notapplicableMissed =  <?php echo json_encode($all_appointment_by_marital_notapplicable_missed) ?>;
        var notapplicableDefaulted =  <?php echo json_encode($all_appointment_by_marital_notapplicable_defaulted) ?>;
        var notapplicableLTFU =  <?php echo json_encode($all_appointment_by_marital_notapplicable_lftu) ?>;

        Highcharts.chart('container', {
        chart: {
            type: 'column'
        },
        title: {
            text: 'Appointments by Marital Status'
        },
        xAxis: {
            categories: ['Single', 'Married Monogamous', 'Divorced', 'Widowed', 'Cohabiting', 'Unavailable', 'Married Polygamous', 'Not Applicable']
        },
        yAxis: {
            min: 0,
            title: {
                text: 'Appointments Count'
            },
            stackLabels: {
                enabled: true,
                style: {
                    fontWeight: 'bold',
                    color: ( // theme
                        Highcharts.defaultOptions.title.style &&
                        Highcharts.defaultOptions.title.style.color
                    ) || 'gray'
                }
            }
        },
        tooltip: {
            formatter: function() {
                return '<b>' + this.x + '</b><br/>' +
                    this.series.name + ': ' + this.y + '<br/>' +
                    'Sum of all appointment categories: ' + this.point.stackTotal;
            }
        },
        plotOptions: {
            column: {
                stacking: 'normal',
            }
        },
        series: [{
                name: 'Honoured Appointments',
                data: singleMissed
            }, {
                name: 'Active Defaulters',
                data: [singleDefaulted, monogamousDefaulted, divorcedDefaulted, widowedDefaulted, cohabitingDefaulted, unavailableDefaulted, polygamousDefaulted, notapplicableDefaulted]
            }, {
                name: 'Active Missed',
                data: [singleMissed, monogamousMissed, divorcedMissed, widowedMissed, cohabitingMissed, unavailableMissed, polygamousMissed, notapplicableMissed]
            },
            {
                name: 'Active LTFUs',
                data: [singleLTFU, monogamousLTFU, divorcedLTFU, widowedLTFU, cohabitingLTFU, unavailableLTFU, polygamousLTFU, notapplicableLTFU]
            }
        ],

    });

    var colors = Highcharts.getOptions().colors;
    </script>





                <!-- end of col -->

@endsection
