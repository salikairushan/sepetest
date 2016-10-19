/**
 * Created by HP-PC on 9/25/2016.
 */

// notifications layout

/**
 * Notifications General types
 * @type {string}
 */
var USER_PROFILE = "user_profile";
var USER_UPDATE = "user_update";
var GENERAL = "general";
var ACCOUNT_SETTINGS = "account_settings";


/**
 * User notifications binder, allows users to push notifications to logged user to view
 * and interact with custom links
 *
 * @param type
 * @param url
 * @param header_text
 * @param detail_text
 * @returns {string}
 */
function notificationBinder(id, user_id, type, url, header_text, detail_text) {
    // base url
    var base_URL = $('#base_URL').val();
    var NOTIFICATION_LAYOUT = '<li><a onclick="checkNotification(' + id + ',' + user_id + ',\'' + url + '\')" class="waves-effect waves-block">';

    switch (type) {
        case USER_PROFILE:
            // -> user profile notification implementation
            NOTIFICATION_LAYOUT += '<div class="icon-circle bg-light-green"><i class="material-icons">account_circle</i>';
            break;
        case USER_UPDATE:
            // -> user update notification implementation
            NOTIFICATION_LAYOUT += '<div class="icon-circle bg-orange"><i class="material-icons">update</i>';
            break;
        case GENERAL:
            // -> general notification implementation
            NOTIFICATION_LAYOUT += '<div class="icon-circle bg-cyan"><i class="material-icons">notifications_active</i>';
            break;
        case ACCOUNT_SETTINGS:
            // -> account settings notification implementation
            NOTIFICATION_LAYOUT += '<div class="icon-circle bg-red"><i class="material-icons">settings</i>';
            break;
    }
    NOTIFICATION_LAYOUT += '</div>&nbsp;<div class="menu-info"><h4>' + header_text + '</h4><p>' + detail_text + '</p></div></a></li>';

    return NOTIFICATION_LAYOUT;
};

/**
 * notifications liner which get notification from WebSocket and display
 * those on notifications are as per the given details and types.
 */
function loadDetails(notifications) {
    var MAIN_STACK = ''; // appends notifications
    for (var i = 0; i < notifications.length; i++) {
        MAIN_STACK += notificationBinder(
            notifications[i]['id'],
            notifications[i]['user_id'],
            notifications[i]['type'],
            notifications[i]['url'],
            notifications[i]['header_text'],
            notifications[i]['detail_text']
        );
    }

    // binds notifications with master page notifications panel
    $("#notifications_count").html(i);
    $('#notifications_panel').html(MAIN_STACK);
};


/**
 * update notifications status as read
 *
 * @param id
 * @param url
 */
function checkNotification(id, user_id, url) {
    // ignore view status update for common notifications
    if (user_id != 0) {
        var dataString = "notification_id=" + id;
        var url = $('#base_URL').val() + "/notifications/markAsReadNotification";

        $.ajax({
            type: 'POST',
            dataType: 'json',
            url: url,
            data: dataString,
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            cache: false,
            success: function (data) {
                //console.log(data);
                notificationLinker();
            },
            error: function (data) {
                console.log('Error:', data);
            }
        });
    }
};

/**
 * Get notifications from notifications end point
 */
function notificationLinker() {
    var user_id = $('#user_id').val();
    var dataString = "user_id=" + user_id;
    var url = $('#base_URL').val() + "/notifications/browseNotification";

    $.ajax({
        type: 'POST',
        dataType: 'json',
        url: url,
        data: dataString,
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        cache: false,
        success: function (data) {
            //console.log(data);
            loadDetails(data);
        },
        error: function (data) {
            console.log('Error:', data);
        }
    });
};

// for testing
setInterval(notificationLinker, 15000);