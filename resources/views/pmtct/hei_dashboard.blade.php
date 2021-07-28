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

<div class="col-md-12 mb-4">
<div class="row">



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
                        <div class="col-12">

                            <div class="card-body row">
                                <div id="hei_graph" class="col" style="height:  400px;margin-top:20px;width: 900px"></div> <br />
                            </div>

                        </div>
                    </div>
                    <div class="row">
                        <div class="col-12">

                            <div class="card-body row">
                                <div id="container" class="col" style="height:  350px;margin-top:20px;width: 900px"></div> <br />
                            </div>

                        </div>
                    </div>


                </div>
            </div>
    </div>

    <script type="text/javascript">
    var Toone_scheduled =  <?php echo json_encode($toone_scheduled_heis) ?>;
    var ToFour_scheduled =  <?php echo json_encode($tofour_scheduled_heis) ?>;
    var ToNine_scheduled =  <?php echo json_encode($tonine_scheduled_heis) ?>;
    var ToFourteen_scheduled =  <?php echo json_encode($tofourteen_scheduled_heis) ?>;
    var ToTotal_scheduled =  <?php echo json_encode($tototal_scheduled_heis) ?>;


    var Toone_unscheduled =  <?php echo json_encode($toone_unscheduled_heis) ?>;
    var ToFour_unscheduled =  <?php echo json_encode($tofour_unscheduled_heis) ?>;
    var ToNine_unscheduled =  <?php echo json_encode($tonine_unscheduled_heis) ?>;
    var ToFourteen_unscheduled =  <?php echo json_encode($tofourteen_unscheduled_heis) ?>;
    var ToTotal_unscheduled =  <?php echo json_encode($tototal_unscheduled_heis) ?>;

    var Toone_booked =  <?php echo json_encode($toone_booked_heis) ?>;
    var ToFour_booked =  <?php echo json_encode($tofour_booked_heis) ?>;
    var ToNine_booked =  <?php echo json_encode($tonine_booked_heis) ?>;
    var ToFourteen_booked =  <?php echo json_encode($tofourteen_booked_heis) ?>;
    var ToTotal_booked =  <?php echo json_encode($tototal_booked_heis) ?>;

    var Toone_defaulted =  <?php echo json_encode($toone_defaulted_heis) ?>;
    var ToFour_defaulted =  <?php echo json_encode($tofour_defaulted_heis) ?>;
    var ToNine_defaulted =  <?php echo json_encode($tonine_defaulted_heis) ?>;
    var ToFourteen_defaulted =  <?php echo json_encode($tofourteen_defaulted_heis) ?>;
    var ToTotal_defaulted =  <?php echo json_encode($tototal_defaulted_heis) ?>;


    var Toone_missed =  <?php echo json_encode($toone_missed_heis) ?>;
    var ToFour_missed =  <?php echo json_encode($tofour_missed_heis) ?>;
    var ToNine_missed =  <?php echo json_encode($tonine_missed_heis) ?>;
    var ToFourteen_missed =  <?php echo json_encode($tofourteen_missed_heis) ?>;
    var ToTotal_missed =  <?php echo json_encode($tototal_missed_heis) ?>;


    var Toone_ltfu =  <?php echo json_encode($toone_ltfu_heis) ?>;
    var ToFour_ltfu =  <?php echo json_encode($tofour_ltfu_heis) ?>;
    var ToNine_ltfu =  <?php echo json_encode($tonine_ltfu_heis) ?>;
    var ToFourteen_ltfu =  <?php echo json_encode($tofourteen_ltfu_heis) ?>;
    var ToTotal_ltfu =  <?php echo json_encode($tototal_ltfu_heis) ?>;

    var Booked_count =  <?php echo json_encode($count_booked_heis) ?>;
    var Scheduled_count =  <?php echo json_encode($count_scheduled_heis) ?>;
    var Unscheduled_count =  <?php echo json_encode($count_unscheduled_heis) ?>;
    var Deceased_count =  <?php echo json_encode($count_deceased_heis) ?>;
    var Transfer_count =  <?php echo json_encode($count_transfer_heis) ?>;
    var Discharged_count =  <?php echo json_encode($count_discharged_heis) ?>;
    var Missed_count =  <?php echo json_encode($count_missed_heis) ?>;
    var Defaulted_count =  <?php echo json_encode($count_defaulted_heis) ?>;
    var LTFU_count =  <?php echo json_encode($count_ltfu_heis) ?>;
    var PCR_count =  <?php echo json_encode($count_pcr_heis) ?>;




    Highcharts.chart('hei_graph', {
        chart: {
            type: 'column'
        },
        title: {
            text: 'HEI Evaluation Report Summary'
        },
        xAxis: {
            categories: ['Scheduled', 'Un-Scheduled', 'Missed', 'Defaulter', 'LTFU', 'Deceased', 'Transfer Out', 'Discharged', 'PCR Positive']
        },
        yAxis: {
            min: 0,
            title: {
                text: 'HEIs Count'
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
                    this.series.name + ': ' + this.y + '<br/>';
            }
        },
        plotOptions: {
            column: {
                stacking: 'normal',
            }
        },
        series: [{
                name: 'Total HEI',
                data: [Scheduled_count, Unscheduled_count, Missed_count, Defaulted_count, LTFU_count, Deceased_count, Transfer_count, Discharged_count, PCR_count]
            }
        ],

    });

    var colors = Highcharts.getOptions().colors;

  Highcharts.drawTable = function() {


// user options
var tableTop = 55,
    colWidth = 95,
    tableLeft = 100,
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
    text: 'HIV Infected Children Report Summary'
},

xAxis: {
    visible: false,
    categories: ['less 1', '1-4', '5-9', '10-14', 'Total']
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
    name: 'Scheduled',
    data: [Toone_scheduled, ToFour_scheduled, ToNine_scheduled, ToFourteen_scheduled, ToTotal_scheduled]
}, {
    name: 'Un-Scheduled',
    data: [Toone_unscheduled, ToFour_unscheduled, ToNine_unscheduled, ToFourteen_unscheduled, ToTotal_unscheduled]

}, {
    name: 'Defaulter',
    data: [Toone_defaulted, ToFour_defaulted, ToNine_defaulted, ToFourteen_defaulted, ToTotal_defaulted]

}, {
    name: 'Missed',
    data: [Toone_missed, ToFour_missed, ToNine_missed, ToFourteen_missed, ToTotal_missed]

}, {
    name: 'LTFU',
    data: [Toone_ltfu, ToFour_ltfu, ToNine_ltfu, ToFourteen_ltfu, ToTotal_ltfu]

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

    </script>




</div>
</div>
                <!-- end of col -->

@endsection
