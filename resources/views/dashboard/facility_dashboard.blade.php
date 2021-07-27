@extends('layouts.master')
@section('page-css')
<link rel="stylesheet" href="{{asset('assets/styles/vendor/datatables.min.css')}}">

@endsection
@section('main-content')

    <div class="separator-breadcrumb border-top"></div>
    <div style="margin-bottom:10px; ">
                <a type="button" href="{{route('new_client')}}" class="btn btn-primary btn-md pull-right">Add Client</a>
            </div>

            <div class="row">
                <!-- ICON BG -->
                <div class="col-lg-3 col-md-6 col-sm-6">
                    <div class="card card-icon-bg card-icon-bg-primary o-hidden mb-4">
                        <div class="card-body text-center">
                            <div class="content">
                            <a class="has-arrow" href="{{route('Reports-clients-distribution')}}">
                                    <b><?php echo $clients_count; ?><br></b>
                                    Clients
                                 </a>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-lg-3 col-md-6 col-sm-6">
                    <div class="card card-icon-bg card-icon-bg-primary o-hidden mb-4">
                        <div class="card-body text-center">
                            <div class="content">
                            <b>{{$consented_count}}<br></b>
                                    Consented Clients
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-lg-3 col-md-6 col-sm-6">
                    <div class="card card-icon-bg card-icon-bg-primary o-hidden mb-4">
                        <div class="card-body text-center">
                            <div class="content">
                            <b>{{$appointment_count}}<br></b>
                                    Appointments
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-lg-3 col-md-6 col-sm-6">
                    <div class="card card-icon-bg card-icon-bg-primary o-hidden mb-4">
                        <div class="card-body text-center">
                            <div class="content">
                            <b>{{$messages_count}}<br></b>
                                    Messages Sent
                            </div>
                        </div>
                    </div>
                </div>

            </div>

            <div class="row">
                <div class="col-lg-6 col-md-12">
                    <div class="card mb-4">
                    <div class="panel-heading">
                      <i class="icon-table"></i>Today Appointments
                     </div>
                        <div class="card-body">
                        <div class="table-responsive">
                                                <table id="today_appointment_table" class="display table table-striped table-bordered" style="width:50%">
                                                    <thead>
                                                        <tr>
                                                            <th>No.</th>
                                                            <th>KDOD Number</th>
                                                            <th>Service No</th>
                                                            <th>Client Name</th>
                                                            <th>Phone No</th>
                                                            <th>Appointment Date</th>
                                                            <th>Appointment Type</th>


                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                            @if (count($today_appointment) > 0)
                                                @foreach($today_appointment as $result)
                                                    <tr>
                                                        <td> {{ $loop->iteration }}</td>
                                                        <td>  {{$result->clinic_no}}</td>
                                                        <td>  {{$result->file_no}}</td>
                                                        <td>  {{$result->client_name}}</td>
                                                        <td>  {{$result->client_phone_no}}</td>
                                                        <td>  {{$result->appntmnt_date}}</td>
                                                        <td>  {{$result->appointment_type}}</td>
                                                    </tr>
                                                @endforeach
                                            @endif
                                        </tbody>
                                      </table>
                                    </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6 col-sm-12">
                    <div class="card mb-4">
                    <div class="panel-heading">
                         <i class="icon-table"></i>Missed Appointments
                          </div>
                        <div class="card-body">
                        <div class="table-responsive">
                                                <table id="missed_table" class="display table table-striped table-bordered" style="width:50%">
                                                    <thead>
                                                        <tr>
                                                            <th>No.</th>
                                                            <th>KDOD Number</th>
                                                            <th>Service No</th>
                                                            <th>Client Name</th>
                                                            <th>Phone No</th>
                                                            <th>Appointment Date</th>
                                                            <th>Appointment Type</th>

                                                        </tr>
                                                    </thead>
                                                    <tbody>

                                                    @if (count($missed_appoitment) > 0)
                                                @foreach($missed_appoitment as $result)
                                                    <tr>
                                                        <td> {{ $loop->iteration }}</td>
                                                        <td>  {{$result->clinic_number}}</td>
                                                        <td>  {{$result->file_no}}</td>
                                                        <td>  {{$result->full_name}}</td>
                                                        <td>  {{$result->phone_no}}</td>
                                                        <td>  {{$result->appntmnt_date}}</td>
                                                        <td>  {{$result->name}}</td>
                                                    </tr>
                                                @endforeach
                                            @endif

                                                    </tbody>
                                                </table>
                                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-lg-6 col-md-12">
                    <div class="card mb-4">
                    <div class="panel-heading">
                      <i class="icon-table"></i>Defaulted Appointments
                     </div>
                        <div class="card-body">
                        <div class="table-responsive">
                                                <table id="defaulted_table" class="display table table-striped table-bordered" style="width:50%">
                                                    <thead>
                                                        <tr>
                                                            <th>No.</th>
                                                            <th>KDOD Number</th>
                                                            <th>Service Number</th>
                                                            <th>Client Name</th>
                                                            <th>Phone No</th>
                                                            <th>Appointment Date</th>
                                                            <th>Appointment Type</th>

                                                        </tr>
                                                    </thead>
                                                    <tbody>

                                                    @if (count($defaulted_appoitment) > 0)
                                                @foreach($defaulted_appoitment as $result)
                                                    <tr>
                                                        <td> {{ $loop->iteration }}</td>
                                                        <td>  {{$result->clinic_number}}</td>
                                                        <td>  {{$result->file_no}}</td>
                                                        <td>  {{$result->full_name}}</td>
                                                        <td>  {{$result->phone_no}}</td>
                                                        <td>  {{$result->appntmnt_date}}</td>
                                                        <td>  {{$result->name}}</td>
                                                    </tr>
                                                @endforeach
                                            @endif
                                                    </tbody>
                                                </table>
                                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6 col-sm-12">
                    <div class="card mb-4">
                    <div class="panel-heading">
                         <i class="icon-table"></i>LTFU Appointments
                         </div>
                        <div class="card-body">
                        <div class="table-responsive">
                                                <table id="ltfu_table" class="display table table-striped table-bordered" style="width:50%">
                                                    <thead>
                                                        <tr>
                                                            <th>No.</th>
                                                            <th>KDOD Number</th>
                                                            <th>Service No</th>
                                                            <th>Client Name</th>
                                                            <th>Phone No</th>
                                                            <th>Appointment Date</th>
                                                            <th>Appointment Type</th>

                                                        </tr>
                                                    </thead>
                                                    <tbody>

                                                    @if (count($ltfu_appoitment) > 0)
                                                @foreach($ltfu_appoitment as $result)
                                                    <tr>
                                                        <td> {{ $loop->iteration }}</td>
                                                        <td>  {{$result->clinic_number}}</td>
                                                        <td>  {{$result->file_no}}</td>
                                                        <td>  {{$result->full_name}}</td>
                                                        <td>  {{$result->phone_no}}</td>
                                                        <td>  {{$result->appntmnt_date}}</td>
                                                        <td>  {{$result->name}}</td>
                                                    </tr>
                                                @endforeach
                                            @endif

                                                    </tbody>
                                                </table>
                                            </div>
                        </div>
                    </div>
                </div>
            </div>
     </div>



@endsection

@section('page-js')


     <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.13.12/js/bootstrap-select.min.js"> </script>
     <script src="{{asset('assets/js/vendor/datatables.min.js')}}"></script>

     <script type="text/javascript">
$('#today_appointment_table').DataTable({
        columnDefs: [{
            targets: [0],
            orderData: [0, 1]
        }, {
            targets: [1],
            orderData: [1, 0]
        }, {
            targets: [4],
            orderData: [4, 0]
        }],
        "paging": true,
        "responsive":true,
        "ordering": true,
        "info": true,
        dom: 'Bfrtip',
        buttons: [
            'copy', 'csv', 'excel', 'pdf', 'print'
        ]
    });
    $('#missed_table').DataTable({
        columnDefs: [{
            targets: [0],
            orderData: [0, 1]
        }, {
            targets: [1],
            orderData: [1, 0]
        }, {
            targets: [4],
            orderData: [4, 0]
        }],
        "paging": true,
        "responsive":true,
        "ordering": true,
        "info": true,
        dom: 'Bfrtip',
        buttons: [
            'copy', 'csv', 'excel', 'pdf', 'print'
        ]
    });
    $('#defaulted_table').DataTable({
        columnDefs: [{
            targets: [0],
            orderData: [0, 1]
        }, {
            targets: [1],
            orderData: [1, 0]
        }, {
            targets: [4],
            orderData: [4, 0]
        }],
        "paging": true,
        "responsive":true,
        "ordering": true,
        "info": true,
        dom: 'Bfrtip',
        buttons: [
            'copy', 'csv', 'excel', 'pdf', 'print'
        ]
    });
     // multi column ordering
   $('#ltfu_table').DataTable({
        columnDefs: [{
            targets: [0],
            orderData: [0, 1]
        }, {
            targets: [1],
            orderData: [1, 0]
        }, {
            targets: [4],
            orderData: [4, 0]
        }],
        "paging": true,
        "responsive":true,
        "ordering": true,
        "info": true,
        dom: 'Bfrtip',
        buttons: [
            'copy', 'csv', 'excel', 'pdf', 'print'
        ]
    });
        </script>

@endsection