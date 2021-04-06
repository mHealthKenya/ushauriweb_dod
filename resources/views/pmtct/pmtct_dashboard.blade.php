@extends('layouts.master')
@section('page-css')

@endsection

@section('main-content')

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
                                <div id="container" class="col" style="height:  600px;margin-top:20px;width: 900px"></div> <br />
                            </div>

                        </div>
                    </div>


                </div>
            </div>
    </div>

    <script type="text/javascript">
    var ToNine_scheduled =  <?php echo json_encode($tonine_scheduled) ?>;
    var ToFourteen_scheduled =  <?php echo json_encode($tofourteen_scheduled) ?>;
    var ToNineteen_scheduled =  <?php echo json_encode($tonineteen_scheduled) ?>;
    var ToTwentyFour_scheduled =  <?php echo json_encode($totwentyfour_scheduled) ?>;
    var ToTwentyNine_scheduled =  <?php echo json_encode($totwentynine_scheduled) ?>;
    var ToThirtyFour_scheduled =  <?php echo json_encode($tothirtyfour_scheduled) ?>;
    var ToThirtyNine_scheduled =  <?php echo json_encode($tothirtynine_scheduled) ?>;
    var ToFortyFour_scheduled =  <?php echo json_encode($tofortyfour_scheduled) ?>;
    var ToFortyNine_scheduled =  <?php echo json_encode($tofortynine_scheduled) ?>;
    var ToFirtyPlus_scheduled =  <?php echo json_encode($tofiftyplus_scheduled) ?>;
    var Total_Scheduled =  <?php echo json_encode($tototal_scheduled) ?>;

    var ToNine_unscheduled =  <?php echo json_encode($tonine_unscheduled) ?>;
    var ToFourteen_unscheduled =  <?php echo json_encode($tofourteen_unscheduled) ?>;
    var ToNineteen_unscheduled =  <?php echo json_encode($tonineteen_unscheduled) ?>;
    var ToTwentyFour_unscheduled =  <?php echo json_encode($totwentyfour_unscheduled) ?>;
    var ToTwentyNine_unscheduled =  <?php echo json_encode($totwentynine_unscheduled) ?>;
    var ToThirtyFour_unscheduled =  <?php echo json_encode($tothirtyfour_unscheduled) ?>;
    var ToThirtyNine_unscheduled =  <?php echo json_encode($tothirtynine_unscheduled) ?>;
    var ToFortyFour_unscheduled =  <?php echo json_encode($tofortyfour_unscheduled) ?>;
    var ToFortyNine_unscheduled =  <?php echo json_encode($tofortynine_unscheduled) ?>;
    var ToFirtyPlus_unscheduled =  <?php echo json_encode($tofifty_unscheduled) ?>;
    var Total_unscheduled =  <?php echo json_encode($tototal_unscheduled) ?>;

    var ToNine_booked =  <?php echo json_encode($tonine_booked) ?>;
    var ToFourteen_booked =  <?php echo json_encode($tofourteen_booked) ?>;
    var ToNineteen_booked =  <?php echo json_encode($tonineteen_booked) ?>;
    var ToTwentyFour_booked =  <?php echo json_encode($totwentyfour_booked) ?>;
    var ToTwentyNine_booked =  <?php echo json_encode($totwentynine_booked) ?>;
    var ToThirtyFour_booked =  <?php echo json_encode($tothirtyfour_booked) ?>;
    var ToThirtyNine_booked =  <?php echo json_encode($tothirtynine_booked) ?>;
    var ToFortyFour_booked =  <?php echo json_encode($tofortyfour_booked) ?>;
    var ToFortyNine_booked =  <?php echo json_encode($tofortynine_booked) ?>;
    var ToFirtyPlus_booked =  <?php echo json_encode($tofifty_booked) ?>;
    var Total_booked =  <?php echo json_encode($tototal_booked) ?>;

    var ToNine_defaulted =  <?php echo json_encode($tonine_defaulted) ?>;
    var ToFourteen_defaulted =  <?php echo json_encode($tofourteen_defaulted) ?>;
    var ToNineteen_defaulted =  <?php echo json_encode($tonineteen_defaulted) ?>;
    var ToTwentyFour_defaulted =  <?php echo json_encode($totwentyfour_defaulted) ?>;
    var ToTwentyNine_defaulted =  <?php echo json_encode($totwentynine_defaulted) ?>;
    var ToThirtyFour_defaulted =  <?php echo json_encode($tothirtyfour_defaulted) ?>;
    var ToThirtyNine_defaulted =  <?php echo json_encode($tothirtynine_defaulted) ?>;
    var ToFortyFour_defaulted =  <?php echo json_encode($tofortyfour_defaulted) ?>;
    var ToFortyNine_defaulted =  <?php echo json_encode($tofortynine_defaulted) ?>;
    var ToFirtyPlus_defaulted =  <?php echo json_encode($tofifty_defaulted) ?>;
    var Total_defaulted =  <?php echo json_encode($tototal_defaulted) ?>;

    var ToNine_missed =  <?php echo json_encode($tonine_missed) ?>;
    var ToFourteen_missed =  <?php echo json_encode($tofourteen_missed) ?>;
    var ToNineteen_missed =  <?php echo json_encode($tonineteen_missed) ?>;
    var ToTwentyFour_missed =  <?php echo json_encode($totwentyfour_missed) ?>;
    var ToTwentyNine_missed =  <?php echo json_encode($totwentynine_missed) ?>;
    var ToThirtyFour_missed =  <?php echo json_encode($tothirtyfour_missed) ?>;
    var ToThirtyNine_missed =  <?php echo json_encode($tothirtynine_missed) ?>;
    var ToFortyFour_missed =  <?php echo json_encode($tofortyfour_missed) ?>;
    var ToFortyNine_missed =  <?php echo json_encode($tofortynine_missed) ?>;
    var ToFirtyPlus_missed =  <?php echo json_encode($tofifty_missed) ?>;
    var Total_missed =  <?php echo json_encode($tototal_missed) ?>;



  Highcharts.drawTable = function() {


// user options
var tableTop = 55,
    colWidth = 95,
    tableLeft = 10,
    rowHeight = 40,
    cellPadding = 4,
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
    text: 'Evaluation of Retention/Attendance Summary'
},

xAxis: {
    visible: false,
    categories: ['0-9', '10-14', '15-19', '20-24', '25-29', '30-34', '35-39', '40-44', '45-49', '50+', 'Total']
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
    name: 'Booked',
    data: [ToNine_booked, ToFourteen_booked, ToNineteen_booked, ToTwentyFour_booked, ToTwentyNine_booked, ToThirtyFour_booked, ToThirtyNine_booked, ToFortyFour_booked, ToFortyNine_booked, ToFirtyPlus_booked, Total_booked]
},{
    name: 'App Kept',
},{
    name: 'Scheduled',
    data: [ToNine_scheduled, ToFourteen_scheduled, ToNineteen_scheduled, ToTwentyFour_scheduled, ToTwentyNine_scheduled, ToThirtyFour_scheduled, ToThirtyNine_scheduled, ToFortyFour_scheduled, ToFortyNine_scheduled, ToFirtyPlus_scheduled, Total_Scheduled]
}, {
    name: 'Un-Scheduled',
    data: [ToNine_unscheduled, ToFourteen_unscheduled, ToNineteen_unscheduled, ToTwentyFour_unscheduled, ToTwentyNine_unscheduled, ToThirtyFour_unscheduled, ToThirtyNine_unscheduled, ToFortyFour_unscheduled, ToFortyNine_unscheduled, ToFirtyPlus_unscheduled, Total_unscheduled]

}, {
    name: 'Defaulter',
    data: [ToNine_defaulted, ToFourteen_defaulted, ToNineteen_defaulted, ToTwentyFour_defaulted, ToTwentyNine_defaulted, ToThirtyFour_defaulted, ToThirtyNine_defaulted, ToFortyFour_defaulted, ToFortyNine_defaulted, ToFirtyPlus_defaulted, Total_defaulted]

}, {
    name: 'Missed',
    data: [ToNine_missed, ToFourteen_missed, ToNineteen_missed, ToTwentyFour_missed, ToTwentyNine_missed, ToThirtyFour_missed, ToThirtyNine_missed, ToFortyFour_missed, ToFortyNine_missed, ToFirtyPlus_missed, Total_missed]

}, {
    name: 'LTFU',

}, {
    name: 'TO',

}]
});
    </script>




</div>
</div>
                <!-- end of col -->

@endsection
