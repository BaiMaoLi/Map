<!DOCTYPE html>
<html>
<head>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <link href="{{ asset('css/map.css') }}" rel="stylesheet">
    <title>GrandExpress</title>
    <meta name="viewport" content="initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta charset="utf-8">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.2.0/css/all.css" integrity="sha384-hWVjflwFxL6sNzntih27bfxkr27PmbbK/iSvJ+a4+0owXq79v+lsFkW54bOGbiDQ" crossorigin="anonymous">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js"></script>
</head>
<body>
<script src="{{asset('/js/NoSleep.min.js')}}"></script>
    <h3 id="header_title">Kindly Stay online for easy location</h3>
    <div id="map" ></div>
<input type="button" id="toggle" value="Click here to activate Map" class="btn btn-dark"/>
<script>
    var noSleep = new NoSleep();
    var wakeLockEnabled = false;
    var toggleEl = document.querySelector("#toggle");
    toggleEl.addEventListener('click', function() {
        if (!wakeLockEnabled) {
            noSleep.enable(); // keep the screen on!
            toggleEl.value = "    Map is now activated    ";
        }
    });
</script>
   <a href="http://grandexpress.naifizzy.com/index.php/support/" target="_blank"> <button style="float:left" id="support" class="btn btn-dark">Support</button></a>
    <a href="http://grandexpress.naifizzy.com/index.php/feedback/" target="_blank"><button style="float:right" id="feedback" class="btn btn-dark">Feedback</button></a>


<script src="{{asset('js/geoUpdate.js')}}"></script>
<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDidJ4tXB7nwyQ8pTPKSoZWQVlOVF4xGmU&callback=initMap"
        async defer></script>

{{--//---------------------------------------Passenger Side Modal Dialogue-----------------------------------------------//--}}

        {{--//------------------------------Passenger Booking Modal Dailogu-------------------------------//--}}
                    <div class="modal fade" id="BookingModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                        <div class="modal-dialog" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="exampleModalLabel">Booking Driver</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <div class="modal-body">
                                    <a id="call_driver" href="#" style="margin:auto;width:100px;">Call Driver</a>
                                    <a id="send_location" href="#" target="_blank" style="display:block">Send Driver location on whatsapp</a>
                                    {{--<p id="arriving_time">Driver 2 mins from here</p>--}}
                                    <a id="view_driver_profile" href="#" target="_blank" style="display:block">View Driver's Profile</a>
                                </div>
                                <div class="modal-footer">
                                    <button class="btn btn-primary" type="submit" id="book" style="width:90px;">Connect</button>
                                    <button class="btn btn-primary" type="submit" id="no_book" style="width:90px;">Reject</button>
                                    <button type="submit" class="btn btn-secondary" id="cancel" data-dismiss="modal" style="width:90px;"> Cancel</button>
                                </div>
                            </div>
                        </div>
                    </div>
        {{--//------------------------------ENd User Booking-----------------------------------------//--}}

        {{--//------------------------------Notification Dialogue of showing cancell state by driver--------------------------//--}}
                    <div class="modal fade" id="Cancell_by_driver_modal" tabindex="-1" role="dialog" aria-labelledby="Cancell_by_passenger_modal" aria-hidden="true">
                        <div class="modal-dialog" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="driver_side_cancell_modal_title">Driver has rejected the booking</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <div class="modal-footer">
                                    <button class="btn btn-primary" type="submit" id="passenger_confirm" style="width:90px;">OK</button>
                                </div>
                            </div>
                        </div>
                    </div>
        {{--//--------------------------------End User Notification-----------------------------------------------------------//--}}

{{--//--------------------------------------End User Side-----------------------------------------------------------------------------------------------------//--}}





{{--//-------------------------------------------------Driver Side Modal----------------------------------------------------------------------//--}}

        {{--//----------------------------------------Accepting Modal Dialogue----------------------------------------------//--}}
                    <div class="modal fade" id="AcceptingModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                        <div class="modal-dialog" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="exampleModalLabel">Accepting Booking</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <div class="modal-footer">
                                    <a id="call_passenger" href="#" ><i class="fas fa-phone" style="font-size:35px;margin-right:10px;"></i></a>
                                    <a id="message_passenger" href="#" target="_blank" >  <i class="fas fa-envelope" style="font-size:45px;margin-right:50px;"></i></a>
                                    <button class="btn btn-primary" type="submit" id="accept" style="width:90px;">Accept</button>
                                    <button type="submit" class="btn btn-secondary" id="reject" style="width:90px;"> Reject</button>
                                    <button type="submit" class="btn btn-secondary" id="driver_cancel" style="width:90px;display:none"> Cancel</button>
                                </div>
                            </div>
                        </div>
                    </div>
        {{--//-------------------------------------End Accepting------------------------------------------------------------//--}}

        {{--//------------------------------Notification Dialogue of showing cancell state by passenger--------------------------//--}}
                    <div class="modal fade" id="Cancell_by_passenger_modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                        <div class="modal-dialog" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="passenger_side_cancell_modal_title">Booking cancelled by Passenger</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <div class="modal-footer">
                                    <button class="btn btn-primary" type="submit" id="driver_confirm" style="width:90px;">OK</button>
                                </div>
                            </div>
                        </div>
                    </div>
        {{--//--------------------------------End Driver Notification-----------------------------------------------------------//--}}

{{--//----------------------------------------End Driver Side-------------------------------------------------------------------------------//--}}
</body>
</html>






























