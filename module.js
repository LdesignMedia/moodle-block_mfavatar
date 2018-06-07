/**
 * adding the flash container to view page also this will try to update img.profilepic
 * Added support for detecting webrtc most modern browser will support this
 *
 * @license http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 *
 * @package block_mfavatar
 * @copyright 2015 MoodleFreak.com
 * @author Luuk Verhoeven
 **/
M.block_mfavatar = {
    log                : function (val)
    {
        try{
            console.log(val);
        } catch (e) {

        }
    },
    init               : function (Y, applicationpath, expresspath, flashvars, supportwebrtc){

        supportwebrtc = (supportwebrtc == 1) ? true : false;

        if (this.webrtc_is_supported() && supportwebrtc){

            M.block_mfavatar.log('We have support for Webrtc');
            Y.one('#snapshotholder_webrtc').setStyle('display', 'block');

            this.webrtc_load(flashvars);
        }else{

            M.block_mfavatar.log('Default using flash for Webcam ');
            Y.one('#snapshotholder').setStyle('display', 'block');

            swfobject.embedSWF(
                applicationpath,
                "snapshot", "100%", "100%", "11.1.0",
                expresspath,
                flashvars, {
                    menu             : "false",
                    scale            : "noScale",
                    allowFullscreen  : "true",
                    allowScriptAccess: "always",
                    wmode            : "transparent",
                    bgcolor          : "#fff"
                },{
                    id: "snapshot"
                }, function (e){
                    //we are loaded?
                    // this.log(e);
                });
        }
    },
    webrtc_load        : function (flashvars)
    {
        var snapshotButton = document.querySelector('button#snapshot');
        var video = window.video = document.querySelector('video');
        var canvasrender = window.canvas = document.querySelector('canvas#render');
        var canvaspreview = window.canvas = document.querySelector('canvas#preview');

        snapshotButton.onclick = function ()
        {
            canvasrender.width = video.videoWidth;
            canvasrender.height = video.videoHeight;

            // video size
            canvasrender.getContext('2d').drawImage(video, 0, 0, canvasrender.width, canvasrender.height);

            // preview small
            canvaspreview.getContext('2d').drawImage(video, 0, 0,canvaspreview.width, canvaspreview.height);
            // set saved text
            canvaspreview.getContext('2d').font = "30px Comic Sans MS";
            canvaspreview.getContext('2d').fillStyle = "white";
            canvaspreview.getContext('2d').textAlign = "center";
            canvaspreview.getContext('2d').fillText("Saved!", canvas.width/2, canvas.height/2);

            var data = canvasrender.toDataURL('image/png');
            YUI().use('io-base', function (Y)
            {
                // saving the file
                var cfg = {
                    method   : 'POST',
                    data: {'sesskey': flashvars.sessionid, 'file': data}
                };
                var request = Y.io(flashvars.uploadPath, cfg);

                //on completed request
                Y.on('io:complete', onComplete, Y);
            });
        };

        navigator.getUserMedia = navigator.getUserMedia || navigator.webkitGetUserMedia || navigator.mozGetUserMedia;

        var constraints = {
            audio: false,
            "video": {
                "mandatory": {
                    "minWidth": "480",
                    "minHeight": "480",
                    "minFrameRate": "30",
                    "minAspectRatio": "1",
                    "maxWidth": "480",
                    "maxHeight": "480",
                    "maxFrameRate": "30",
                    "maxAspectRatio": "1"
                },
                "optional": []
            }
        };

        function successCallback(stream){

            window.stream = stream; // make stream available to browser console
            if (window.URL){
                video.src = window.URL.createObjectURL(stream);
            }else{
                video.src = stream;
            }
        }

        function onComplete(transactionid, response, arguments)
        {
            try{
                var json = JSON.parse(response.response);

                if(json.status == true) {
                    //reload profile picture
                    M.block_mfavatar.saved();
                }
                M.block_mfavatar.log(json);
            } catch (exc){
                console.log(exc);
            }
        }

        function errorCallback(error) {
            console.log('navigator.getUserMedia error: ', error);
        }

        navigator.getUserMedia(constraints, successCallback, errorCallback);
    },
    webrtc_is_supported: function () {
        return !!(navigator.getUserMedia || navigator.webkitGetUserMedia || navigator.mozGetUserMedia || navigator.msGetUserMedia);
    },
    saved              : function () {
        this.log('Saved!!!');
        var profilePicture = Y.one('img.profilepic');
        if (profilePicture)
        {
            var src = profilePicture.getAttribute('src');
            profilePicture.setAttribute('src', '');
            setTimeout(function ()
            {
                var now = new Date().getTime() / 1000;
                profilePicture.setAttribute('src', src + '&c=' + now);
            }, 500);

        }
    },
    error              : function (err){
        M.block_mfavatar.log('Error!');
        M.block_mfavatar.log(err);
    }
};