@extends('layouts.master')
@section('page-css')
<link rel="stylesheet" href="{{asset('assets/styles/vendor/datatables.min.css')}}">

@endsection
@section('main-content')

<div class="separator-breadcrumb border-top"></div>


<div class="row">
    <div class="col-lg-6 col-md-12">
        <div class="card mb-4">
            <div class="panel-heading">
                <i class="icon-table">Missed HEIs List</i>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table id="hei_missed_table" class="display table table-striped table-bordered" style="width:50%">
                        <thead>
                            <tr>
                                <th>No.</th>
                                <th>KDOD Number</th>
                                <th>HEI Number</th>
                                <th>First Name</th>
                                <th>Middle Name</th>
                                <th>Last Name</th>
                                <th>Phone No</th>
                                <th>Appointment Status</th>
                                <th>Appointment Date</th>
                                <th>Appoitment Type</th>
                            </tr>
                        </thead>
                        <tbody>
                            @if (count($all_missed_heis) > 0)
                            @foreach($all_missed_heis as $result)
                            <tr>
                                <td> {{ $loop->iteration }}</td>
                                <td> {{$result->clinic_number}}</td>
                                <td> {{$result->hei_no}}</td>
                                <td> {{$result->f_name}}</td>
                                <td> {{$result->m_name}}</td>
                                <td> {{$result->l_name}}</td>
                                <td> {{$result->phone_no}}</td>
                                <td> {{$result->app_status}}</td>
                                <td> {{$result->appntmnt_date}}</td>
                                <td> {{$result->app_type_1}}</td>
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
                <i class="icon-table">Defaulted HEIs List</i>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table id="hei_defaulted_table" class="display table table-striped table-bordered" style="width:50%">
                        <thead>
                            <tr>
                                <th>No.</th>
                                <th>KDOD Number</th>
                                <th>Hei Number</th>
                                <th>First Name</th>
                                <th>Middle Name</th>
                                <th>Last Name</th>
                                <th>Phone No</th>
                                <th>Appointment Status</th>
                                <th>Appointment Date</th>
                                <th>Appoitment Type</th>
                            </tr>
                        </thead>
                        <tbody>
                            @if (count($all_defaulted_heis) > 0)
                            @foreach($all_defaulted_heis as $result)
                            <tr>
                                <td> {{ $loop->iteration }}</td>
                                <td> {{$result->clinic_number}}</td>
                                <td> {{$result->hei_no}}</td>
                                <td> {{$result->f_name}}</td>
                                <td> {{$result->m_name}}</td>
                                <td> {{$result->l_name}}</td>
                                <td> {{$result->phone_no}}</td>
                                <td> {{$result->app_status}}</td>
                                <td> {{$result->appntmnt_date}}</td>
                                <td> {{$result->app_type_1}}</td>
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
    <div class="col-lg-12 col-md-12">
        <div class="card mb-4">
            <div class="panel-heading">
                <i class="icon-table">Lost To Follow Up HEIs List</i>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table id="hei_ltfu_table" class="display table table-striped table-bordered" style="width:50%">
                        <thead>
                            <tr>
                                <th>No.</th>
                                <th>KDOD Number</th>
                                <th>Hei Number</th>
                                <th>First Name</th>
                                <th>Middle Name</th>
                                <th>Last Name</th>
                                <th>Phone No</th>
                                <th>Appointment Status</th>
                                <th>Appointment Date</th>
                                <th>Appoitment Type</th>
                            </tr>
                        </thead>
                        <tbody>
                            @if (count($all_ltfu_heis) > 0)
                            @foreach($all_ltfu_heis as $result)
                            <tr>
                                <td> {{ $loop->iteration }}</td>
                                <td> {{$result->clinic_number}}</td>
                                <td> {{$result->hei_no}}</td>
                                <td> {{$result->f_name}}</td>
                                <td> {{$result->m_name}}</td>
                                <td> {{$result->l_name}}</td>
                                <td> {{$result->phone_no}}</td>
                                <td> {{$result->app_status}}</td>
                                <td> {{$result->appntmnt_date}}</td>
                                <td> {{$result->app_type_1}}</td>
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
    $('#hei_missed_table').DataTable({
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
        "responsive": true,
        "ordering": true,
        "info": true,
        dom: 'Bfrtip',
        buttons: [
            'copy', 'csv', 'excel', 'pdf', 'print'
        ]
    });
    $('#hei_defaulted_table').DataTable({
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
        "responsive": true,
        "ordering": true,
        "info": true,
        dom: 'Bfrtip',
        buttons: [
            'copy', 'csv', 'excel', 'pdf', 'print'
        ]
    });
    $('#hei_ltfu_table').DataTable({
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
        "responsive": true,
        "ordering": true,
        "info": true,
        dom: 'Bfrtip',
        buttons: [
            'copy', 'csv', 'excel', 'pdf', 'print'
        ]
    });
    // multi column ordering
</script>

@endsection