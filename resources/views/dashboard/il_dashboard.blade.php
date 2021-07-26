@extends('layouts.master')
@section('page-css')

@endsection

@section('main-content')


<div class="separator-breadcrumb border-top"></div>

<div class="col-md-12">

    <form role="form" method="post" action="#" id="dataFilter">
        {{ csrf_field() }}
        <div class="row">
            <div class="col">
                <div class="form-group">

                    <select class="form-control filter_partner  input-rounded input-sm select2" id="partners" name="partner">
                        <option value="">Please select Partner</option>
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
                        <option value="">Please select County:</option>
                        <option></option>
                        <option value=""></option>

                    </select>
                </div>
            </div>
            <div class="col">
                <div class="form-group">
                    <span class="filter_sub_county_wait" style="display: none;">Loading , Please Wait ...</span>
                    <select class="form-control subcounty input-rounded input-sm select2" id="subcounties" name="subcounty">
                        <option value="">Please Select Sub County : </option>
                        <option value=""></option>
                    </select>
                </div>
            </div>
            <div class="col">
                <div class="form-group">
                    <span class="filter_facility_wait" style="display: none;">Loading , Please Wait ...</span>

                    <select class="form-control filter_facility input-rounded input-sm select2" id="facilities" name="facility">
                        <option value="">Please select Facility : </option>
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
<div class="separator-breadcrumb border-top"></div>
<div class="row">
    <!-- ICON BG -->
    <div class="col-lg-3 col-md-6 col-sm-6">
        <div class="card card-icon-bg card-icon-bg-primary o-hidden mb-4">
            <div class="card-body text-center">
                <div class="content">
                    <p class="text-muted mt-2 mb-0">Total Appointments</p>

                    <p id="il_appointments" class="text-primary text-20 line-height-1 mb-2">{{$il_appointments}}</p>
                </div>
            </div>
        </div>
    </div>

    <div class="col-lg-3 col-md-6 col-sm-6">
        <div class="card card-icon-bg card-icon-bg-primary o-hidden mb-4">
            <div class="card-body text-center">
                <div class="content">
                    <p class="text-muted mt-2 mb-0">Future Appointments</p>
                    <p id="il_future_apps" class="text-primary text-20 line-height-1 mb-2">{{$il_future_apps}}</p>
                </div>
            </div>
        </div>
    </div>

    <div class="col-lg-2 col-md-6 col-sm-6">
        <div class="card card-icon-bg card-icon-bg-primary o-hidden mb-4">
            <div class="card-body text-center">
                <div class="content">
                    <p class="text-muted mt-2 mb-0">Messages Sent</p>
                    <p id="messages_count" class="text-primary text-20 line-height-1 mb-2">{{$messages_count}}</p>
                </div>
            </div>
        </div>
    </div>

    <div class="col-lg-2 col-md-6 col-sm-6">
        <div class="card card-icon-bg card-icon-bg-primary o-hidden mb-4">
            <div class="card-body text-center">
                <div class="content">
                    <a class="has-arrow" href="{{route('Reports-il-facilities')}}">
                        <p class="text-muted mt-2 mb-0">Facilities</p>
                        <p id="il_facilities" class="text-primary text-20 line-height-1 mb-2">{{count($il_facilities)}}</p>
                    </a>
                </div>
            </div>
        </div>
    </div>

    <div class="col-lg-2 col-md-6 col-sm-6">
        <div class="card card-icon-bg card-icon-bg-primary o-hidden mb-4">
            <div class="card-body text-center">
                <div class="content">
                    <a class="has-arrow" href="{{route('Reports-il-partners')}}">
                        <p class="text-muted mt-2 mb-0">Partners</p>
                        <p id="il_partners" class="text-primary text-20 line-height-1 mb-2">{{$il_partners}}</p>
                    </a>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-12">

            <div class="card-body row">
                <div id="container" class="col" style="height: 400px;margin-top:40px;"></div> <br />
            </div>
            <div class="card-body row">
                <div id="trend" class="col" style="height: 450px;margin-top:40px;"></div>
            </div>
        </div>
    </div>

    @endsection

    @section('page-js')


    <div id="highchart"></div>

    <script type="text/javascript" src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
    <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js">
    </script>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.13.12/js/bootstrap-select.min.js">
    </script>
    <script src="https://code.highcharts.com/maps/highmaps.js"></script>
    <script src="https://code.highcharts.com/maps/modules/data.js"></script>
    <script src="https://code.highcharts.com/maps/modules/exporting.js"></script>
    <script src="https://code.highcharts.com/maps/modules/offline-exporting.js"></script>
    <script src="https://code.highcharts.com/modules/bullet.js"></script>
    <script src="https://code.highcharts.com/modules/exporting.js"></script>
    <script src="https://code.highcharts.com/modules/export-data.js"></script>
    <script src="https://code.highcharts.com/modules/accessibility.js"></script>

    <script type="text/javascript">
        $(function() {
            $('#daterange').daterangepicker({
                "minYear": 2017,
                "autoApply": true,
                ranges: {
                    'Today': [moment(), moment()],
                    'Yesterday': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
                    'Last 7 Days': [moment().subtract(6, 'days'), moment()],
                    'Last 30 Days': [moment().subtract(29, 'days'), moment()],
                    'This Month': [moment().startOf('month'), moment().endOf('month')],
                    'Last Month': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1,
                        'month').endOf('month')]
                },
                "startDate": "04/10/2017",
                "endDate": moment().format('MM/DD/YYYY'),
                "opens": "left"
            }, function(start, end, label) {});
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
            $('select[name="subcounty"]').on('change', function() {
                var subcountyID = $(this).val();
                if (subcountyID) {
                    $.ajax({
                        url: '/get_dashboard_facilities/' + subcountyID,
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
                url: "{{ route('filter_ildashboard') }}",
                success: function(data) {


                    $("#il_appointments").html(data.il_appointments);
                    $("#il_future_apps").html(data.il_future_apps);
                    $("#messages_count").html(data.messages_count);
                    $("#il_facilities").html(data.il_facilities);
                    $("#il_partners").html(data.il_partners);
                    $("#il_kenyaemr").html(data.il_kenyaemr);
                    $("#il_adt").html(data.il_adt);
                    $("#il_registration").html(data.il_registration);
                }
            });
        });

        var Kenyaemr = <?php echo json_encode($il_kenyaemr) ?>;
        var ADT = <?php echo json_encode($il_adt) ?>;
        var Registration = <?php echo json_encode($il_registration) ?>;
        console.log(Kenyaemr);
        Highcharts.chart('container', {
            chart: {
                type: 'column'
            },
            title: {
                text: 'IL Appointments by Source'
            },
            xAxis: {
                categories: ['KENYAEMR Appointments', 'ADT Appointments', 'Client Registration']
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
                name: 'Appointments',
                data: [Kenyaemr, ADT, Registration]
            }],

        });

        var colors = Highcharts.getOptions().colors;
    </script>

    @endsection





    <!-- end of col -->