@extends('layouts.master')
@section('page-css')
<link rel="stylesheet" href="{{asset('assets/styles/vendor/datatables.min.css')}}">

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

<div class="separator-breadcrumb border-top"></div>



<div class="row">
    <div class="col-lg-6 col-md-12">
        <div class="card mb-4">
            <div class="panel-heading">
                <i class="icon-table">Advanced Clients</i>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table id="less_advanced_table" class="display table table-striped table-bordered" style="width:50%">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>KDOD Number</th>
                                <th>First Name</th>
                                <th>Middle Name</th>
                                <th>Last Name</th>
                                <th>Status</th>
                                <th>Appointment Date</th>
                            </tr>
                        </thead>
                        <tbody>
                            @if (count($all_clients_duration_less_advanced) > 0)
                            @foreach($all_clients_duration_less_advanced as $clients)
                            <tr>
                                <td> {{ $loop->iteration }}</td>
                                <td> {{ ucwords($clients->clinic_number)}}</td>
                                <td> {{$clients->f_name}}</td>
                                <td> {{$clients->m_name}}</td>
                                <td> {{$clients->l_name}}</td>
                                <td> {{$clients->duration_less}}</td>
                                <td> {{$clients->appntmnt_date}}</td>


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
                <i class="icon-table">Well Clients</i>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table id="less_well_table" class="display table table-striped table-bordered" style="width:50%">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>KDOD Number</th>
                                <th>First Name</th>
                                <th>Middle Name</th>
                                <th>Last Name</th>
                                <th>Status</th>
                                <th>Appointment Date</th>
                            </tr>
                        </thead>
                        <tbody>
                            @if (count($all_clients_duration_less_well) > 0)
                            @foreach($all_clients_duration_less_well as $clients)
                            <tr>
                                <td> {{ $loop->iteration }}</td>
                                <td> {{ ucwords($clients->clinic_number)}}</td>
                                <td> {{$clients->f_name}}</td>
                                <td> {{$clients->m_name}}</td>
                                <td> {{$clients->l_name}}</td>
                                <td> {{$clients->duration_less}}</td>
                                <td> {{$clients->appntmnt_date}}</td>

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
                <i class="icon-table">Stable Clients</i>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table id="more_stable_table" class="display table table-striped table-bordered" style="width:50%">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>KDOD Number</th>
                                <th>First Name</th>
                                <th>Middle Name</th>
                                <th>Last Name</th>
                                <th>Status</th>
                                <th>Stability Status</th>
                                <th>Facility Based</th>
                                <th>Community Based</th>
                                <th>Refill Date</th>
                                <th>Clinical Review Date</th>

                            </tr>
                        </thead>
                        <tbody>
                            @if (count($all_clients_duration_more_stable) > 0)
                            @foreach($all_clients_duration_more_stable as $clients)
                            <tr>
                                <td> {{ $loop->iteration }}</td>
                                <td> {{ ucwords($clients->clinic_number)}}</td>
                                <td> {{$clients->f_name}}</td>
                                <td> {{$clients->m_name}}</td>
                                <td> {{$clients->l_name}}</td>
                                <td> {{$clients->duration_more}}</td>
                                <td> {{$clients->stability_status}}</td>
                                <td> {{$clients->facility_based}}</td>
                                <td> {{$clients->community_based}}</td>
                                <td> {{$clients->refill_date}}</td>
                                <td> {{$clients->clinical_visit_date}}</td>
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
                <i class="icon-table">Unstable Clients</i>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table id="more_unstable_table" class="display table table-striped table-bordered" style="width:50%">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>KDOD Number</th>
                                <th>First Name</th>
                                <th>Middle Name</th>
                                <th>Last Name</th>
                                <th>Status</th>
                                <th>Appointment Date</th>

                            </tr>
                        </thead>
                        <tbody>
                            @if (count($all_clients_duration_more_unstable) > 0)
                            @foreach($all_clients_duration_more_unstable as $clients)
                            <tr>
                                <td> {{ $loop->iteration }}</td>
                                <td> {{ ucwords($clients->clinic_number)}}</td>
                                <td> {{$clients->f_name}}</td>
                                <td> {{$clients->m_name}}</td>
                                <td> {{$clients->l_name}}</td>
                                <td> {{$clients->duration_more}}</td>
                                <td> {{$clients->appntmnt_date}}</td>

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
    $('#less_advanced_table').DataTable({
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
    $('#less_well_table').DataTable({
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
    $('#more_unstable_table').DataTable({
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
    $('#more_stable_table').DataTable({
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
</script>

@endsection