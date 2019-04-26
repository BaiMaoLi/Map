
@extends('admin.layouts.app')
@section('main-content')
    <style>
        #all-users,#driver-menu{
            color:white;
        }
        td{
            text-align: center;
        }
    </style>
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <h1>
                All Drivers
            </h1>
        </section>

        <section class="content">
            <div class="box">
                <div class="box-header with-border">
                    <h3 class="box-title">Drivers</h3>
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
                                <table id="driver-table" class="table table-bordered table-striped">
                                    <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Name</th>
                                        <th>Email</th>
                                        <th>Phone Number</th>
                                        <th>Profile Url</th>
                                        <th>Current Location</th>
                                        <th>Edit</th>
                                        <th>Suspend</th>
                                        <th>Terminate</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach ($drivers as $driver)
                                        <tr>
                                            <td>{{ $loop->index + 1 }}</td>
                                            <td>{{ $driver->name}}</td>
                                            <td>{{ $driver->email}}</td>
                                            <td>{{ $driver->phone_number}}</td>
                                            <td>{{ $driver->profile_url}}</td>
                                            <td><a target="_blank" href="https://www.google.com/maps/search/?api=1&query={{$locations[$loop->index]['lat']}},{{$locations[$loop->index]['lan']}}">Show on Map</a></td>
                                            <td><a href="driver/edit/{{$driver->id}}"><button type="button" class="btn btn-block btn-primary">&nbsp&nbspEdit&nbsp&nbsp</button></a></td>
                                            <td>
                                                <form id="driver-suspect-{{ $driver->id }}" method="post" action="{{route('driver.suspect',$driver->id)}}" style="display: none">
                                                    {{ csrf_field() }}
                                                </form>
                                                <a href="" onclick="
                                                    event.preventDefault();
                                                    document.getElementById('driver-suspect-{{ $driver->id }}').submit();
                                                    " ><button type="button" class="btn btn-block btn-warning">Suspect</button></a>
                                            </td>
                                            <td>
                                                <form id="driver-terminate-{{ $driver->id }}" method="post" action="{{route('driver.terminate',$driver->id)}}" style="display: none">
                                                    {{ csrf_field() }}
                                                </form>
                                                <a href="" onclick="
                                                        event.preventDefault();
                                                        document.getElementById('driver-terminate-{{ $driver->id }}').submit();
                                                        " ><button type="button" class="btn btn-block btn-danger">Terminate</button></a>
                                            </td>
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

            </div>

        </section>
    </div>
@endsection

@section('footerSection')
    <script>
        // $(function () {
        //     // $('#driver-table').DataTable();
        // });
    </script>
@endsection
