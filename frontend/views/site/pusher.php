<!DOCTYPE html>
<head>
    <title>Pusher Test</title>
    <script src="//js.pusher.com/2.2/pusher.min.js"></script>
    <script>
        // Enable pusher logging - don't include this in production
        Pusher.log = function(message) {
            if (window.console && window.console.log) {
                window.console.log(message);
            }
        };

        var pusher = new Pusher('f18c18ce9c6738d06077');
        var channel = pusher.subscribe('test_channel');
        channel.bind('my_event', function(data) {
            alert(data.message);
        });
    </script>
</head>

<?php
//    $pusher = new Pusher('f18c18ce9c6738d06077', '9a7474a98a83b88a05d6', '274019');
//
//    $data['message'] = 'Hello';
//
//    $pusher->trigger('notifications', 'new_notification', $data);
?>