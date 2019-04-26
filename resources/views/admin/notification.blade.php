@extends('admin.layouts.app')
@section('main-content')
    <style>
        #all-users,#passenger-menu,#driver-menu{
            color:#b8c7ce;
        }
        #notification{
            color:white;
        }
    </style>
    <div class="content-wrapper">
        <section class="content-header">
            <h1>
                {{--All Notifications--}}
            </h1>
        </section>
        <section class="content">
            <div class="row">
                {{--<div class="col-sm-offset-1 col-sm-9 col-md-offset-2 col-md-8">--}}
                <div class="col-sm-9 col-md-6">
                    <div class="box box-primary">
                        <div class="box-body no-padding">
                            <div class="table-responsive mailbox-messages">
                                <table id="notification-table" class="table table-hover table-striped">
                                    <thead>
                                    <tr>
                                        <th>Driver Name</th>
                                        <th>Notification Content</th>
                                    </tr>

                                    </thead>
                                    <tbody>
                                        @foreach($notifications as $notification)
                                            <tr>
                                                <td style="text-align: center;margin-right:10px;width:100px;padding-left:5px;padding-right:5px;" class="mailbox-name"><b>{{$notification['data']['driver_name']}}</b></td>
                                                <td style="text-align: center;" class="mailbox-name">{{$notification['data']['rejectMessage']}}&nbsp;at &nbsp;&nbsp;{{$notification['data']['rejectTime']}}</td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                 </div>
            </div>
        </section>
    </div>
@endsection
