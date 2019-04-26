
@extends('admin.layouts.app')
@section('main-content')
    <style>
        #all-users,#passenger-menu{
            color:white;
        }
        #driver-menu{
            color:#b8c7ce;
        }
        td{
            text-align: center;
        }
    </style>
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <h1>
                All Passengers
            </h1>
        </section>

        <section class="content">
            <div class="box">
                <div class="box-header with-border">
                    <h3 class="box-title">Passengers</h3>
                    <div class="box-tools pull-right">
                        <button type="button" class="btn btn-box-tool" data-widget="collapse" data-toggle="tooltip" title="Collapse">
                            <i class="fa fa-minus"></i></button>
                        <button type="button" class="btn btn-box-tool" data-widget="remove" data-toggle="tooltip" title="Remove">
                            <i class="fa fa-times"></i></button>
                    </div>
                </div>
                <div class="box-body">
                    <div class="box">
                        <div class="box-header">

                        </div>
                        <!-- /.box-header -->
                        <div class="box-body">
                            <div class="table-responsive mailbox-messages">
                                <table id="passenger-table" class="table table-bordered table-striped">
                                    <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Name</th>
                                        <th>Email</th>
                                        <th>Phone Number</th>
                                        <th>Current Location</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach ($passengers as $passenger)
                                        <tr>
                                            <td>{{ $loop->index + 1 }}</td>
                                            <td>{{ $passenger->name}}</td>
                                            <td>{{ $passenger->email}}</td>
                                            <td>{{ $passenger->phone_number}}</td>

                                            <td><a target="_blank" href="https://www.google.com/maps/search/?api=1&query={{$locations[$loop->index]['lat']}},{{$locations[$loop->index]['lan']}}">Show on Map</a></td>
                                        </tr>
                                    @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <!-- /.box-body -->
                    </div>
                </div>
                <!-- /.box-body -->

                <!-- /.box-footer-->
            </div>

        </section>

    </div>


@endsection

@section('footerSection')
    <script>
        $(function () {
            // $('#passenger-table').DataTable();
        });
    </script>
@endsection
