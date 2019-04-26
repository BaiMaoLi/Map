var map;
var markers=[];
var renderObjects = [];
var my_lat, my_lng;
var my_marker;
var cancelled_driver_id=[];
var booked_driver_id=0;
var current_id=0;
var k=1;
var passenger_marker;
var passenger_id=0;
var unaccept_passenger=0;


function initMap() {
    var lat, lng;

    if (navigator.geolocation) {
        var options = {
            enableHighAccuracy: false,
            timeout: 105000,
            maximumAge: 100000
        };
        navigator.geolocation.getCurrentPosition(function (position) {
                my_lat = position.coords.latitude;
                my_lng = position.coords.longitude;
                var uluru = {lat: my_lat, lng: my_lng};
                map= new google.maps.Map(document.getElementById('map'), {
                    center: {lat: my_lng, lng: my_lng},
                    mapTypeId: 'roadmap'
                });
                var southWest = new google.maps.LatLng(my_lat+2/111,my_lng-2/111);
                var northEast = new google.maps.LatLng(my_lat-2/111,my_lng+2/111);
                var bounds = new google.maps.LatLngBounds(southWest,northEast);
                map.fitBounds(bounds);
            },function error(err) {
                alert(`ERROR(${err.code}): ${err.message}`);
//                alert(err);
            },options
        )}
    geoUpdate();
    setInterval(geoUpdate,5000);
    function geoUpdate() {
        if (navigator.geolocation) {
            navigator.geolocation.getCurrentPosition(function (position) {
                my_lat = position.coords.latitude;
                my_lng = position.coords.longitude;
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
                    }
                });
                $.ajax({
                    url: "geoUpdate",
                    method: 'post',
                    data: {
                        _token: $('meta[name="csrf-token"]').attr('content'),
                        lat: my_lat,
                        lng: my_lng
                    },
                    success: function (result) {
                        //console.log(result);

                        //-------------------------IF user is passenger----------------------------------//

                        if (result['kind']=='passanger'){    //If passanger
                            my_lat = parseFloat(result['lat']);
                            my_lng = parseFloat(result['lng']);
                            if (my_marker!=null)
                                my_marker.setMap(null);
                            addMyMarker(my_lat,my_lng,result['kind']);
                            setMapOnAll(null);
                            clearMarkers();
                            if (result['booked_driver_id']!=0){      //If there is booked driver.
                                //console.log(result['booked_driver_id']);
                                booked_driver_id=result['booked_driver_id'];
                                if (result['cancell_by_driver']==0){    //do not cancelled by driver
                                    booked_driver_id=result['booked_driver_id'];
                                    cancelled_driver_id=[];
                                }     //If book is not cancelled by driver
                                else{                           //Cancelled By driver
                                    $('#Cancell_by_driver_modal').modal('show');
                                    cancelled_driver_id.push(result['booked_driver_id']);
                                    booked_driver_id=0;
                                }
                            }
                            else
                                booked_driver_id=0;
                            if(booked_driver_id!=0){  //If there is booked driver
                                //console.log("Booked Driver ID"+booked_driver_id.toString());
                                $('#book').hide();
                                console.log(result['driver_ids']);
                                console.log(result);
                                for (i=0;i<result['driver_lats'].length;i++){
                                    if(booked_driver_id==result['driver_ids'][i]){
                                        console.log("matched"+result['driver_ids'][i].toString());
                                        addDriverMarker(lat,lng,k*parseFloat(result['driver_lats'][i]),parseFloat(result['driver_lans'][i]),map,result['phone_number'][i],parseInt(result['driver_ids'][i]),result['profile_url'][i]);
                                    }
                                }
                            }
                            else{  //If there is no booked driver
                                $('#book').show();
                                for (i=0;i<result['driver_lats'].length;i++){
                                    var display=true;
                                    for(j=1;j<=cancelled_driver_id.length;j++)
                                    {
                                        if (
                                            cancelled_driver_id[j-1]==result['driver_ids'][i]){
                                            display=false;
                                        }
                                    }
                                    if (display==true)
                                        addDriverMarker(lat,lng,parseFloat(result['driver_lats'][i])*k,parseFloat(result['driver_lans'][i]),map,result['phone_number'][i],parseInt(result['driver_ids'][i]),result['profile_url'][i]);
                                }
                            }
                        }

                        //-------------------------------------------End passenger------------------------------------------------//



                        //----------------------------------------------------IF user is driver-----------------------------------------//

                        else{
                            // console.log(result);
                            my_lat = parseFloat(result['lat']);
                            my_lng = parseFloat(result['lng']);
                            if(my_marker!=null)
                                my_marker.setMap(null);
                            addMyMarker(my_lat,my_lng,result['kind']);
                            if (passenger_marker!=null)
                                passenger_marker.setMap(null);
                            if(result['passenger_id']!=0)   //That is, if there is booked user
                            {        //First of all, must show passenger's location
                                phone_number=result['phone_number'];
                                addPassengerMarker(parseFloat(result['passenger_lat']),parseFloat(result['passenger_lng']),map,phone_number,result['passenger_id']);
                                if (result['driver_confirm_state']==0){  //That is, if driver doesn't still accept booking, show only accepting modal
                                    $('#accept').show();   //Hide accept button
                                    $('#driver_cancel').hide();
                                    $('#AcceptingModal').modal('show');
                                    unaccept_passenger=result['passenger_id'];
                                }
                                else{   //That is, if driver accept booking already. Show mark and, if cancelled by user, then show confirm dialogue
                                    $('#accept').hide();   //Hide accept button
                                    $('#driver_cancel').show();
                                    phone_number=result['phone_number'];
                                    unaccept_passenger=0;
                                    if (result['cancell_by_passenger']!=0){  //If passenger cancell booking
                                        $('#Cancell_by_passenger_modal').modal('show');
                                    }
                                }
                            }
                        }

                        //----------------------------------------------------------End Driver---------------------------------------------//
                    },
                    error:function (evt) {
                        console.log(evt);
                    }
                })
            })
        }
    }
}



//---------------------------------------------------Marker Displaying Part-------------------------------------------------------------//
function addMyMarker(lat,lng,kind){
    // console.log(kind);
    if (kind!='driver'){
        my_marker = new google.maps.Marker({position: {lat:lat,lng:lng},
            // icon:{
            //     // url:'http://icons.iconarchive.com/icons/icons-land/vista-map-markers/256/Map-Marker-Marker-Outside-Pink-icon.png',
            //     scaledSize: new google.maps.Size(50, 40),
            //     origin: new google.maps.Point(0,0),
            //     anchor: new google.maps.Point(0, 0)
            // },
            map: map});
    }
    else{
        my_marker = new google.maps.Marker({position: {lat:lat,lng:lng},
            icon:{
                url:'public/images/car.png',
                scaledSize: new google.maps.Size(80, 60),
                origin: new google.maps.Point(0,0),
                anchor: new google.maps.Point(0, 0)
            },
            map: map});
    }
}

function addDriverMarker(lat_origin,lng_origin,lat,lng,map,phone_number,driver_id,profile_url) {
    // alert("driver marker");
    var marker = new google.maps.Marker({
        position: {lat:lat,lng:lng},
        // icon: "http://icons.iconarchive.com/icons/icons-land/vista-map-markers/48/Map-Marker-Bubble-Pink-icon.png",
        icon:{
            url:'public/images/car.png',
            scaledSize: new google.maps.Size(80, 60),
            // origin: new google.maps.Point(0,0),
            // anchor: new google.maps.Point(0, 0)
        },
        map: map
    });
    markers.push(marker);

    marker.addListener('click', function() {
        current_id=driver_id;
        clearRenderObjects();
        var directionDisplay=new google.maps.DirectionsRenderer;
        var directionService=new google.maps.DirectionsService;
        directionDisplay.setMap(map);
        renderObjects.push(directionDisplay);
        directionService.route({
            origin:new google.maps.LatLng(lat_origin,lng_origin),
            destination:new google.maps.LatLng(lat,lng),
            travelMode:'DRIVING'
        },function(response,status){
            if(status==='OK')
            {
                directionDisplay.setDirections(response);
                // console.log(response);
            }
            else console.log(response);
            $('#BookingModal').modal('show');
            document.getElementById("send_location").href=("https://wa.me/"+phone_number+'?text=')+encodeURI('Hi, I need your services, can you come here?');
            document.getElementById("call_driver").href="tel:+"+phone_number;
            //document.getElementById("arriving_time").innerHTML="Driver " + response.routes[0].legs[0].duration.text +" from you";
            document.getElementById("view_driver_profile").href=profile_url;
        });
    });
}

function setMapOnAll(map) {
    for (var i = 0; i < markers.length; i++) {
        markers[i].setMap(map);
    }
}

function clearMarkers() {
    setMapOnAll(null);
}

function clearRenderObjects() {
    for(var i in renderObjects) {
        renderObjects[i].setMap(null);
    }
}

function addPassengerMarker(lat,lng,map,phone_number,passenger_id1){   //Add Passenger Marker on the map
    passenger_marker = new google.maps.Marker({
        position: {lat:lat,lng:lng},
        // icon:{
        //     // url:'http://icons.iconarchive.com/icons/icons-land/vista-map-markers/256/Map-Marker-Marker-Outside-Pink-icon.png',
        //     scaledSize: new google.maps.Size(50, 40),
        //     origin: new google.maps.Point(0,0),
        //     anchor: new google.maps.Point(0, 0)
        // },
        map: map
    });
    passenger_marker.addListener('click',function(){
        passenger_id=passenger_id1;
        $('#AcceptingModal').modal('show');
        document.getElementById('message_passenger').href=("https://wa.me/"+phone_number+'?text=')+encodeURI('Hello');
        document.getElementById("call_passenger").href="tel:+"+phone_number;
    });
}
//------------------------------------------------End Marker Displaying---------------------------------------------------------------------//


//-----------------------------------------Passenger Dialogue Operation Part----------------------------------------------------------------//
//Booking Driver
$(document).on( "click", "#book", function() {
    booked_driver_id=current_id;
    // console.log(booked_driver_id);
    // console.log(current_id);
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
        }
    });
    $.ajax({
        url: "bookRegister",
        method: 'post',
        data: {
            _token: $('meta[name="csrf-token"]').attr('content'),
            driver_id:booked_driver_id
        },
        success: function (result) {
            // console.log(result);
        },
        error: function (evt) {
            // console.log(evt);
        }

    });
    // $('#book').css({display:none});

    $('#BookingModal').modal('hide');
    $('#book').hide();
    // $('#book').css({display:none});

});
//End Booking


//Cancelling Book
$(document).on( "click", "#no_book", function() {
    // clearRenderObjects();
    cancelled_driver_id.push(current_id);
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
        }
    });
    $.ajax({
        url: "bookCancell",
        method: 'post',
        data: {
            _token: $('meta[name="csrf-token"]').attr('content'),
            driver_id:booked_driver_id
        },
        success: function (result) {
            // console.log(result);
        },
        error: function (evt) {
            // console.log(evt);
        }
    });
    $('#BookingModal').modal('hide');
});
//End Cancelling

//Passenger confirm driver's reject, remove booktable
$(document).on( "click", "#passenger_confirm", function() {
    cancelled_driver_id.push(booked_driver_id);
    // console.log('here');
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
        }
    });
    $.ajax({
        url: "passengerConfirmCancell",
        method: 'post',
        data: {
            _token: $('meta[name="csrf-token"]').attr('content'),
        },

        success: function (result) {
            // console.log(result);
        },
        error: function (evt) {
            // console.log(evt);
        }
    });
    $('#Cancell_by_driver_modal').modal('hide');
});
//End Booking
//------------------------------------------------End Passenger Dialogue Part----------------------------------------------------------------//


//-----------------------------------------------Driver Dialogue Part------------------------------------------------------------------------//
//Accepting Booking
$(document).on( "click", "#accept", function() {
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
        }
    });
    $.ajax({
        url: "bookAccept",
        method: 'post',
        data: {
            _token: $('meta[name="csrf-token"]').attr('content'),
        },
        success: function (result) {
            // console.log(result);
        },
        error: function (evt) {
            // console.log(evt);
        }
    });
    $('#AcceptingModal').modal('hide');

});
//End Accepting

//Rejecting Book
$(document).on( "click", "#reject", function() {
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
        }
    });
    $.ajax({
        url: "bookReject",
        method: 'post',
        data: {
            _token: $('meta[name="csrf-token"]').attr('content'),
            passenger_id:passenger_id
        },
        success: function (result) {
            //console.log(result);
        },
        error: function (evt) {
            console.log(evt);
        }
    });
    $('#AcceptingModal').modal('hide');
});
//End Cancelling

//Driver Confirm
$(document).on( "click", "#driver_confirm", function() {
    cancelled_driver_id.push(booked_driver_id);
    // console.log('here');
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
        }
    });
    $.ajax({
        url: "driverConfirmCancell",
        method: 'post',
        data: {
            _token: $('meta[name="csrf-token"]').attr('content'),
        },

        success: function (result) {
            // console.log(result);
        },
        error: function (evt) {
            // console.log(evt);
        }
    });
    $('#Cancell_by_passenger_modal').modal('hide');
});



