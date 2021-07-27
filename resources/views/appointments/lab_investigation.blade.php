@extends('layouts.master')
@section('page-css')

<link rel="stylesheet" href="{{asset('assets/styles/vendor/datatables.min.css')}}">
@endsection

@section('main-content')

<div class="col-md-12 mb-4">
    <div class="card text-left">

        <div class="card-body">
            <! <h4 class="card-title mb-3">Lab Investigation List</h4>
                <div class="col-md-12" style="margin-top:10px; ">

                </div>
                <div class="table-responsive">
                    <table id="multicolumn_ordering_table" class="display table table-striped table-bordered" style="width:100%">
                        <thead>
                            <tr>
                                <th>No.</th>
                                <th>Service Name</th>
                                <th>Unit Name</th>
                                <th>Sub County</th>
                                <th>MFL Code</th>
                                <th>CCC Clinic Name</th>
                                <th>Age Group</th>
                                <th>Gender</th>
                                <th>No Of Lab Investigation</th>


                            </tr>
                        </thead>
                        <tbody>
                            @if (count($all_lab_app) > 0)
                            @foreach($all_lab_app as $result)
                            <tr>
                                <td> {{ $loop->iteration }}</td>
                                <td> {{$result->partner_name}}</td>
                                <td> {{$result->county_name}}</td>
                                <td> {{$result->sub_county_name}}</td>
                                <td> {{$result->mfl_code}}</td>
                                <td> {{$result->facility_name}}</td>
                                <td> {{$result->age_group}}</td>
                                <td> {{$result->gender}}</td>
                                <td> {{$result->total}}</td>
                            </tr>
                            @endforeach
                            @endif
                        </tbody>

                    </table>

                </div>

        </div>
    </div>
</div>
<!-- end of col -->

@endsection

@section('page-js')

<script src="{{asset('assets/js/vendor/datatables.min.js')}}"></script>
<script type="text/javascript">
    // multi column ordering
    $('#multicolumn_ordering_table').DataTable({
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