@extends('layouts.master')
@section('page-css')

<link rel="stylesheet" href="{{asset('assets/styles/vendor/datatables.min.css')}}">
@endsection

@section('main-content')

<div class="col-md-12 mb-4">
    <div class="card text-left">

        <div class="card-body">
            @if (Auth::user()->access_level == 'Admin' || Auth::user()->access_level == 'Partner' || Auth::user()->access_level == 'Donor')
            <h4 class="card-title mb-3">My CCC Clinics Lists</h4>
            @endif
            @if (Auth::user()->access_level == 'Facility')
            <h4 class="card-title mb-3">My CCC Clinic</h4>
            @endif
            <div class="col-md-12" style="margin-top:10px; ">


                <div class="table-responsive">
                    <table id="multicolumn_ordering_table" class="display table table-striped table-bordered" style="width:100%">
                        <thead>
                            <tr>
                                <th>No.</th>
                                <th>CCC Clinic Name</th>
                                <th>MFL Code</th>
                                <th>CCC Clinic Type</th>
                                <th>Service</th>
                                <th>Owner</th>
                                <th>Action</th>

                            </tr>
                        </thead>
                        <tbody>
                            @if (count($facilities) > 0)
                            @foreach($facilities as $result)
                            <tr>
                                <td> {{ $loop->iteration }}</td>
                                <td> {{$result->facility_name}}</td>
                                <td> {{$result->code}}</td>
                                <td> {{$result->facility_type}}</td>
                                <td> {{$result->county_name}}</td>
                                <td> {{$result->owner}}</td>


                                @if (Auth::user()->access_level == 'Admin' || Auth::user()->access_level == 'Partner')
                                <td>
                                    <button onclick="editfacility({{$result}});" data-toggle="modal" data-target="#editfacility" type="button" class="btn btn-primary btn-sm">Edit</button>
                                    <button onclick="" data-toggle="modal" data-target="#" type="button" class="btn btn-primary btn-sm">Delete</button>
                                </td>
                                @endif

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
<!-- end of col -->

<div id="editfacility" class="modal fade" role="dialog">
    <div class="modal-dialog modal-lg">

        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">

                <div class="card-title mb-3">Edit CCC Clinic</div>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body">
                <div class="col-md-12">
                    <div class="card mb-4">
                        <div class="card-body">
                            <form role="form" method="post" action="{{route('edit_facility')}}">
                                {{ csrf_field() }}

                                <input type="hidden" name="mflcode" id="mflcode">
                                <div class="row">
                                    <div class="col-md-6 form-group mb-3">
                                        <label for="firstName1">CCC Clinic Name</label>
                                        <input type="text" class="form-control" id="facility_name" name="facility_name" placeholder="Facility Name" readonly />

                                    </div>
                                    <div class="col-md-6 form-group mb-3">
                                        <label for="firstName1">MFL Code</label>
                                        <input type="text" class="form-control" id="code" name="code" placeholder="MFL Code" readonly />

                                    </div>
                                    <div class="col-md-6 form-group mb-3">
                                        <label for="firstName1">No of Clients on ART</label>
                                        <input type="text" class="form-control" id="average_clients" name="average_clients" placeholder="No of Clients on ART" />
                                    </div>
                                    <div class="col-md-6 form-group mb-3">
                                        <label for="picker1">Service Name</label>
                                        <select id="partner" name="partner" class="form-control" required="">
                                            <option>Select Partner</option>
                                            @if (count($all_partners) > 0)
                                            @foreach($all_partners as $partner)
                                            <option value="{{$partner->id }}">{{ ucwords($partner->name) }}</option>
                                            @endforeach
                                            @endif

                                            <option></option>
                                        </select>
                                    </div>
                                </div>
                                <button type="submit" class="btn btn-block btn-primary">Update CCC Clinic</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            </div>
        </div>

    </div>
</div>


@endsection

@section('page-js')

<script src="{{asset('assets/js/vendor/datatables.min.js')}}"></script>
<script type="text/javascript">
    function editfacility(result) {
        $('#code').val(result.code);
        $('#facility_name').val(result.facility_name);
        $('#average_clients').val(result.average_clients);
        $('#partner').val(result.partner_name);
    }
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