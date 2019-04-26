var notifications;
var n;
var myvar;


$(document).ready(function() {
    readMessage();
    myvar=setInterval(readMessage, 5000);

    function readMessage() {
        $.get("readNotification", function (data) {
            if (data['notifications'].length) {
                notifications=data['notifications'];
                n=notifications.length;
                document.getElementById('notification-number').innerText =n;
                display_notifications(notifications,'#new-notifications');
            }
            else
                display_empty('#new-notifications');
        });
    }
});

function display_notifications(notifications, target) {
    str='';
    str+='<li class="header" id="notification-header">You have '+n+' new notifications</li>\
    <li><ul class="menu">';
    for(i=0;i<n;i++)
    {
        str+=' <li> <a><i class="fa fa-warning text-yellow"></i><b>'+notifications[i]['data']['driver_name']+'</b>  '+notifications[i]['data']['rejectMessage']+'</a></li>';
    }
    str+='</ul></li><li class="footer"><a href="'+APP_URL+'/admin/notification" onclick="markAsRead()">'+'View all</a></li></ul></li>';
    $(target).html(str);
}

function display_empty(target) {
    str='<li class="header" id="notification-header">You have no new notifications</li>';
    $(target).html(str);
}

function markAsRead() {
}

$('.dropdown').on('show.bs.dropdown', function () {
    window.clearInterval(myvar);
    document.getElementById('notification-number').innerText ='';
    $.get("markAsRead");

});




//
// var i=0;
// var myvar;
// var notification_number;
// var click_number=0;
// var prev_id='';
// var current_id='';
// var unread_messages=[];
//
// $(document).ready(function(){
//     readMessage();
//     function readMessage() {
//         $.get(APP_URL+"/notifications",function (data) {
//             if(data.length){
//                 notification_number=data.length;
//                 document.getElementById('badge1').innerText =data.length;
//                 if($('#AllAlerts').length)   /* If current page is All Alert Page */
//                     addNotifications(data, "#AllAlerts");
//                 if($('.MY-ALERTS').length)   /* If current page is All Alert Page */
//                     displaySingleAlert(data);
//             }
//             else
//                 $('#badge1').css("display", "none");
//         })
//     }
//     myvar=setInterval(readMessage, 5000);
// })
//
// const NOTIFICATION_TYPES = {
//     EventAlert: 'App\\Notifications\\EventAlert',
//     User_Alert: 'App\\Notifications\\UserAlert'
// };
//
//
// function addNotifications(notifications,target) {
//     showNotifications(notifications, target);
// }
//
// function showNotifications(notifications, target) {
//     if(notifications.length) {
//         $(target).empty();
//         var htmlElements = notifications.map(function (notification) {
//             $(target).append(makeNotificationText(notification));
//         });
//     } else {
//         $(target).html('<li class="dropdown-header">No notifications</li>');
//     }
// }
//
// function makeNotificationText(notification) {
//     if(notification.type === NOTIFICATION_TYPES.EventAlert) {
//         var all_alert_house=document.createElement('div');
//         all_alert_house.className="all-alert-house event-alert";
//         var alert_title=document.createElement('h4');
//         alert_title.className='alert-title';
//         text_node=document.createTextNode(notification.data.EventAlert_title);
//         alert_title.appendChild(text_node);
//         var event_time=document.createElement('h4');
//         event_time.className='event-time break';
//         text_node=document.createTextNode(notification.data.EventAlert_time);
//         event_time.appendChild(text_node);
//         event_time.id=notification['id'];
//         var event_location=document.createElement('h4');
//         event_location.className='event-location';
//         text_node=document.createTextNode(notification.data.EventAlert_location);
//         event_location.appendChild(text_node);
//         var line=document.createElement('div');
//         line.className='line';
//         all_alert_house.appendChild(alert_title);
//         all_alert_house.appendChild(event_time);
//         all_alert_house.appendChild(event_location);
//         all_alert_house.appendChild(line);
//
//         alert_title.onclick=notyRead(notification['id']);
//
//         return all_alert_house;
//     }
//     else if(notification.type === NOTIFICATION_TYPES.User_Alert) {
//         var all_alert_house=document.createElement('div');
//         all_alert_house.className="all-alert-house message-unread";
//         var alert_title=document.createElement('h4');
//         alert_title.className='alert-title';
//         text_node=document.createTextNode(notification.data.alert_title);
//         alert_title.appendChild(text_node);
//         var event_time=document.createElement('h4');
//         event_time.className='event-time break';
//         event_time.id=notification['id'];
//         text_node=document.createTextNode(notification.data.alert_body);
//         event_time.appendChild(text_node);
//         var line=document.createElement('div');
//         line.className='line';
//         all_alert_house.appendChild(alert_title);
//         all_alert_house.appendChild(event_time);
//         all_alert_house.appendChild(line);
//         alert_title.onclick=notyRead(notification['id']);
//         return all_alert_house;
//     }
// }
//
// function notyRead(id,event_time) {
//     return function () {
//         $.ajaxSetup({
//             headers: {
//                 'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
//             }
//         }),
//             $.ajax({
//                 url: APP_URL + "/notyRead",
//                 method: 'post',
//                 data: {
//                     _token: $('meta[name="csrf-token"]').attr('content'),
//                     id: id
//                 },
//                 success:function(result){
//                     window.clearInterval(myvar);
//                     var clickable=true;
//                     for (var i=0;i<unread_messages.length;i++){
//                         if (id==unread_messages[i])
//                             clickable=false;
//                     }
//                     if (clickable==true){
//                         notification_number=notification_number-1;
//                         document.getElementById('badge1').innerText =notification_number;
//                         unread_messages.push(id);
//                     }
//                     document.getElementById(id).classList.toggle('break');
//                 },
//                 error: function (evt) {
//                     console.log(evt);
//                 }
//             });
//     }
// }
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
// //Display Single Event in User HomePage
// function displaySingleAlert(data) {
//     if(i>=data.length){
//         i=0;
//     }
//
//     var notification=data[i];
//     var str='';
//     html='';
//     if(notification.type === NOTIFICATION_TYPES.EventAlert) {
//         str+='<h4 id="alert-title">'+notification.data.EventAlert_title+'</h4>\
//         <h6 id="alert-content">'+notification.data.EventAlert_time+'</h6>\
//         <h6 id="alert-place">'+notification.data.EventAlert_location+'</h6>\
//         </div>';
//     }
//     else{
//         str+='<h4 id="alert-title">'+notification.data.alert_title+'</h4>\
//         <h6 id="alert-place" >'+notification.data.alert_body+'</h6>\
//         </div>';
//     }
//     $('#My-alert').html(str);
//     i++;
// }
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
