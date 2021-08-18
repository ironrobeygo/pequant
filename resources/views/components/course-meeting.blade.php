<!DOCTYPE html>

<head>
    <title>{{ $header }}</title>
    <meta charset="utf-8" />
    <link type="text/css" rel="stylesheet" href="https://source.zoom.us/1.9.7/css/bootstrap.css" />
    <link type="text/css" rel="stylesheet" href="https://source.zoom.us/1.9.7/css/react-select.css" />
    <meta name="format-detection" content="telephone=no">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
    <meta http-equiv="origin-trial" content="">
</head>

<body>

    <script src="https://source.zoom.us/1.9.7/lib/vendor/react.min.js"></script>
    <script src="https://source.zoom.us/1.9.7/lib/vendor/react-dom.min.js"></script>
    <script src="https://source.zoom.us/1.9.7/lib/vendor/redux.min.js"></script>
    <script src="https://source.zoom.us/1.9.7/lib/vendor/redux-thunk.min.js"></script>
    <script src="https://source.zoom.us/1.9.7/lib/vendor/lodash.min.js"></script>
    <script src="https://source.zoom.us/zoom-meeting-1.9.7.min.js"></script>
    <script src="{{ asset('js/admin/tool.js') }}"></script>
    <script src="{{ asset('js/admin/vconsole.min.js') }}"></script>

    <script type="text/javascript">

    var testTool = window.testTool;
    var tmpArgs = testTool.parseQuery();

    console.log();
        
    var meetingConfig = {
        apiKey: tmpArgs.api,
        apiSecret: tmpArgs.secret,
        meetingNumber: tmpArgs.meeting_number,
        userName: tmpArgs.user,
        passWord: tmpArgs.password,
        leaveUrl: "/dashboard",
        role: 1,
        userEmail: "",
        lang: "en-US", 
        signature: tmpArgs.signature || "",
        china: tmpArgs.china === "1"
    };

    window.addEventListener('DOMContentLoaded', function(event) {
        console.log('DOM fully loaded and parsed');
        websdkready(meetingConfig);
    });

    </script>
    
    <script src="{{ asset('js/admin/meeting.js') }}"></script>
</body>

</html>