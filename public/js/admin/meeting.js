function websdkready(meetingConfig) {
    var testTool = window.testTool;
    // get meeting args from url
    var tmpArgs = testTool.parseQuery();

    meetingConfig.signature = tmpArgs.signature || "";
    meetingConfig.china = tmpArgs.china === "1";

    // a tool use debug mobile device
    if (testTool.isMobileDevice()) {
        vConsole = new VConsole();
    }
    console.log(JSON.stringify(ZoomMtg.checkSystemRequirements()));

    // it's option if you want to change the WebSDK dependency link resources. setZoomJSLib must be run at first
    // ZoomMtg.setZoomJSLib("https://source.zoom.us/1.9.7/lib", "/av"); // CDN version defaul
    if (meetingConfig.china)
        ZoomMtg.setZoomJSLib("https://jssdk.zoomus.us/1.9.7/lib", "/av"); // china cdn option

    ZoomMtg.preLoadWasm();
    ZoomMtg.prepareJssdk();

    var signature = ZoomMtg.generateSignature({
        meetingNumber: meetingConfig.meetingNumber,
        apiKey: meetingConfig.apiKey,
        apiSecret: meetingConfig.apiSecret,
        role: meetingConfig.role,
        success: function(res) {
            meetingConfig.signature = res.result;
            var joinUrl = testTool.serialize(meetingConfig);
            console.log(joinUrl);
        },
    });

    function beginJoin(signature) {
        ZoomMtg.init({
            leaveUrl: meetingConfig.leaveUrl,
            webEndpoint: meetingConfig.webEndpoint,
            disableCORP: !window.crossOriginIsolated, // default true
            // disablePreview: false, // default false
            success: function() {
                console.log(meetingConfig);
                console.log("signature", signature);
                ZoomMtg.i18n.load(meetingConfig.lang);
                ZoomMtg.i18n.reload(meetingConfig.lang);
                ZoomMtg.join({
                    meetingNumber: meetingConfig.meetingNumber,
                    userName: meetingConfig.userName,
                    signature: signature,
                    apiKey: meetingConfig.apiKey,
                    userEmail: meetingConfig.userEmail,
                    passWord: meetingConfig.passWord,
                    success: function(res) {
                        console.log("join meeting success");
                        console.log("get attendeelist");
                        ZoomMtg.getAttendeeslist({});
                        ZoomMtg.getCurrentUser({
                            success: function(res) {
                                console.log("success getCurrentUser", res.result.currentUser);
                            },
                        });
                    },
                    error: function(res) {
                        console.log(res);
                    },
                });
            },
            error: function(res) {
                console.log(res);
            },
        });

        ZoomMtg.inMeetingServiceListener('onUserJoin', function(data) {
            console.log('inMeetingServiceListener onUserJoin', data);
        });

        ZoomMtg.inMeetingServiceListener('onUserLeave', function(data) {
            console.log('inMeetingServiceListener onUserLeave', data);
        });

        ZoomMtg.inMeetingServiceListener('onUserIsInWaitingRoom', function(data) {
            console.log('inMeetingServiceListener onUserIsInWaitingRoom', data);
        });

        ZoomMtg.inMeetingServiceListener('onMeetingStatus', function(data) {
            console.log('inMeetingServiceListener onMeetingStatus', data);
        });
    }

    beginJoin(meetingConfig.signature);
};