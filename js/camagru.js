'use_strict';

(function() {

    var cameraButton = document.querySelector(".buttons__camera-radio");
    var uploadButton = document.querySelector(".buttons__upload-radio");
    var uploadForm = document.querySelector(".main-camagru__upload-file");
    var videoWindow = document.querySelector(".view--video__video");
    var uploadedImgWindow = document.querySelector(".main-camagru__loaded-img");


    var checkCheckboxChanging = function()
    {
        if(uploadButton.checked == true)
        {
            console.log("camera checked");
            if (uploadForm.classList.contains("visually-hidden"))
                uploadForm.classList.remove("visually-hidden");
            if (uploadedImgWindow.classList.contains("visually-hidden"))
                uploadedImgWindow.classList.remove("visually-hidden");
            videoWindow.classList.add("visually-hidden");
        }
        if (cameraButton.checked == true)
        {
            console.log("upload checked");
            uploadForm.classList.add("visually-hidden");
            if (videoWindow.classList.contains("visually-hidden"))
                videoWindow.classList.remove("visually-hidden");
            uploadedImgWindow.classList.add("visually-hidden");
        }
    };
    uploadedImgWindow.classList.add("visually-hidden");
    uploadForm.classList.add("visually-hidden");

    cameraButton.addEventListener("change",checkCheckboxChanging);
    uploadButton.addEventListener("change",checkCheckboxChanging);


    /*
    navigator.getUserMedia = navigator.getUserMedia || navigator.webkitGetUserMedia ||  navigator.mozGetUserMedia;
    if (navigator.getUserMedia) {
        navigator.getUserMedia({ audio: true, video: { width: 400, height: 400 } },
            function(stream) {
                var video = document.querySelector('video');
                video.srcObject = stream;
                video.onloadedmetadata = function(e) {
                    video.play();
                };
            },
            function(err) {
                console.log("The following error occurred: " + err.name);
            }
        );
    } else {
        console.log("getUserMedia not supported");
    }
    */

})();