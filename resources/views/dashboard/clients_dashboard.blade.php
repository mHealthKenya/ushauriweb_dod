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
    <div class="col-12">
        <div class="card">
            <div class="card-body row">

                <div class="row">
                    <div class="col-6">

                        <div class="card-body row">
                            <div id="container" class="col" style="height:  600px;margin-top:20px;width: 900px"></div> <br />
                        </div>

                    </div>
                    <div class="col-6">

                        <div class="card-body row">
                            <div id="marital" class="col" style="height:  600px;margin-top:20px;width: 900px"></div> <br />
                        </div>

                    </div>
                </div>


            </div>
        </div>
    </div>

    <script type="text/javascript">
        var ToNine_consented = <?php echo json_encode($consented_nine) ?>;
        var ToFourteen_consented = <?php echo json_encode($consented_forteen) ?>;
        var ToNineteen_consented = <?php echo json_encode($consented_nineteen) ?>;
        var ToTwentyFour_consented = <?php echo json_encode($consented_twenty_four) ?>;
        var ToTwentyFive_consented = <?php echo json_encode($consented_over_twenty_five) ?>;

        var ToNine_registered = <?php echo json_encode($registered_nine) ?>;
        var ToFourteen_registered = <?php echo json_encode($registered_forteen) ?>;
        var ToNineteen_registered = <?php echo json_encode($registered_nineteen) ?>;
        var ToTwentyFour_registered = <?php echo json_encode($registered_twenty_four) ?>;
        var ToTwentyFive_registered = <?php echo json_encode($registered_over_twenty_five) ?>;

        var Single_consented = <?php echo json_encode($single_consented) ?>;
        var Mono_consented = <?php echo json_encode($monogamous_consented) ?>;
        var Divorced_consented = <?php echo json_encode($divorced_consented) ?>;
        var Widowed_consented = <?php echo json_encode($widowed_consented) ?>;
        var Cohabating_consented = <?php echo json_encode($cohabating_consented) ?>;
        var Unavailable_consented = <?php echo json_encode($unavailable_consented) ?>;
        var Notapplicable_consented = <?php echo json_encode($notapplicable_consented) ?>;
        var Poly_consented = <?php echo json_encode($polygamous_consented) ?>;

        var Single_registered = <?php echo json_encode($single_registered) ?>;
        var Mono_registered = <?php echo json_encode($monogamous_registered) ?>;
        var Divorced_registered = <?php echo json_encode($divorced_registered) ?>;
        var Widowed_registered = <?php echo json_encode($widowed_registered) ?>;
        var Cohabating_registered = <?php echo json_encode($cohabating_registered) ?>;
        var Unavailable_registered = <?php echo json_encode($unavailable_registered) ?>;
        var Notapplicable_registered = <?php echo json_encode($notapplicable_registered) ?>;
        var Poly_registered = <?php echo json_encode($polygamous_registered) ?>;



        Highcharts.drawTable = function() {


            // user options
            var tableTop = 55,
                colWidth = 95,
                tableLeft = 60,
                rowHeight = 40,
                cellPadding = 6,
                valueDecimals = 0;

            var chart = this,
                series = chart.series,
                renderer = chart.renderer,
                cellLeft = tableLeft;

            // draw category labels
            $.each(chart.xAxis[0].categories, function(i, name) {
                renderer.text(
                        name,
                        cellLeft + cellPadding,
                        tableTop + (i + 2) * rowHeight - cellPadding
                    )
                    .css({
                        fontWeight: 'bold'
                    })
                    .add();
            });

            $.each(series, function(i, serie) {
                cellLeft += colWidth;

                // Apply the cell text
                renderer.text(
                        serie.name,
                        cellLeft - cellPadding + colWidth,
                        tableTop + rowHeight - cellPadding
                    )
                    .attr({
                        align: 'right'
                    })
                    .css({
                        fontWeight: 'bold'
                    })
                    .add();

                $.each(serie.data, function(row, point) {

                    // Apply the cell text
                    renderer.text(
                            Highcharts.numberFormat(point.y, valueDecimals),
                            cellLeft + colWidth - cellPadding,
                            tableTop + (row + 2) * rowHeight - cellPadding
                        )
                        .attr({
                            align: 'right'
                        })
                        .add();

                    // horizontal lines
                    if (row == 0) {
                        Highcharts.tableLine( // top
                            renderer,
                            tableLeft,
                            tableTop + cellPadding,
                            cellLeft + colWidth,
                            tableTop + cellPadding
                        );
                        Highcharts.tableLine( // bottom
                            renderer,
                            tableLeft,
                            tableTop + (serie.data.length + 1) * rowHeight + cellPadding,
                            cellLeft + colWidth,
                            tableTop + (serie.data.length + 1) * rowHeight + cellPadding
                        );
                    }
                    // horizontal line
                    Highcharts.tableLine(
                        renderer,
                        tableLeft,
                        tableTop + row * rowHeight + rowHeight + cellPadding,
                        cellLeft + colWidth,
                        tableTop + row * rowHeight + rowHeight + cellPadding
                    );

                });

                // vertical lines
                if (i == 0) { // left table border
                    Highcharts.tableLine(
                        renderer,
                        tableLeft,
                        tableTop + cellPadding,
                        tableLeft,
                        tableTop + (serie.data.length + 1) * rowHeight + cellPadding
                    );
                }

                Highcharts.tableLine(
                    renderer,
                    cellLeft,
                    tableTop + cellPadding,
                    cellLeft,
                    tableTop + (serie.data.length + 1) * rowHeight + cellPadding
                );

                if (i == series.length - 1) { // right table border

                    Highcharts.tableLine(
                        renderer,
                        cellLeft + colWidth,
                        tableTop + cellPadding,
                        cellLeft + colWidth,
                        tableTop + (serie.data.length + 1) * rowHeight + cellPadding
                    );
                }

            });


        };
        Highcharts.tableLine = function(renderer, x1, y1, x2, y2) {
            renderer.path(['M', x1, y1, 'L', x2, y2])
                .attr({
                    'stroke': 'silver',
                    'stroke-width': 1
                })
                .add();
        }
        window.chart = new Highcharts.Chart({

            chart: {
                renderTo: 'container',
                events: {
                    load: Highcharts.drawTable
                },
                borderWidth: 2
            },

            title: {
                text: 'Client Registration by Age Group'
            },

            xAxis: {
                visible: false,
                categories: ['10-14', '15-19', '20-24', '25+']
            },

            yAxis: {
                visible: false
            },

            legend: {
                enabled: false
            },
            plotOptions: {
                series: {
                    visible: false
                }
            },

            series: [{
                name: 'Registered',
                data: [ToFourteen_registered, ToNineteen_registered, ToTwentyFour_registered, ToTwentyFive_registered]
            }, {
                name: 'Consented',
                data: [ToFourteen_consented, ToNineteen_consented, ToTwentyFour_consented, ToTwentyFive_consented]

            }]
        });

        window.chart = new Highcharts.Chart({

            chart: {
                renderTo: 'marital',
                events: {
                    load: Highcharts.drawTable
                },
                borderWidth: 2
            },

            title: {
                text: 'Client Registration by Marital Status'
            },

            xAxis: {
                visible: false,
                categories: ['Single', 'Married Monogamous', 'Divorced', 'Widowed', 'Cohabating', 'Married Polygamous', 'Not Applicable', 'Unavailable']
            },

            yAxis: {
                visible: false
            },

            legend: {
                enabled: false
            },
            plotOptions: {
                series: {
                    visible: false
                }
            },

            series: [{
                name: 'Registered',
                data: [Single_registered, Mono_registered, Divorced_registered, Widowed_registered, Cohabating_registered, Poly_registered, Notapplicable_registered, Unavailable_registered]
            }, {
                name: 'Consented',
                data: [Single_consented, Mono_consented, Divorced_consented, Widowed_consented, Cohabating_consented, Poly_consented, Notapplicable_consented, Unavailable_consented]

            }]
        });

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
            let subcounties = $('#subcounties').val();
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
                    "subcounties": subcounties,
                    "facilities": facilities
                },
                url: "{{ route('filter_client_dashboard') }}",
                success: function(data) {

                    $("#container").html(data.consented_nine);
                    $("#container").html(data.consented_forteen);
                    $("#container").html(data.consented_nineteen);
                    $("#container").html(data.consented_twenty_four);
                    $("#container").html(data.consented_over_twenty_five);
                    $("#container").html(data.registered_nine);
                    $("#container").html(data.registered_forteen);
                    $("#container").html(data.registered_nineteen);
                    $("#container").html(data.registered_twenty_four);
                    $("#container").html(data.registered_over_twenty_five);
                    $("#container").html(data.registered_over_twenty_five);

                    $("#marital").html(data.single_consented);
                    $("#marital").html(data.monogamous_consented);
                    $("#marital").html(data.divorced_consented);
                    $("#marital").html(data.widowed_consented);
                    $("#marital").html(data.cohabating_consented);
                    $("#marital").html(data.unavailable_consented);
                    $("#marital").html(data.notapplicable_consented);
                    $("#marital").html(data.polygamous_consented);
                    $("#marital").html(data.single_registered);
                    $("#marital").html(data.monogamous_registered);
                    $("#marital").html(data.divorced_registered);
                    $("#marital").html(data.widowed_registered);
                    $("#marital").html(data.cohabating_registered);
                    $("#marital").html(data.unavailable_registered);
                    $("#marital").html(data.notapplicable_registered);
                    $("#marital").html(data.polygamous_registered);


                }
            });
        });
    </script>




</div>
</div>
<!-- end of col -->

@endsection