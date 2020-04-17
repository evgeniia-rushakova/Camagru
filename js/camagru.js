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
            console.log("upload checked");
            if (uploadForm.classList.contains("visually-hidden"))
                uploadForm.classList.remove("visually-hidden");
            if (uploadedImgWindow.classList.contains("visually-hidden"))
                uploadedImgWindow.classList.remove("visually-hidden");
            videoWindow.classList.add("visually-hidden");
        }
        if (cameraButton.checked == true)
        {
            console.log("camera checked");
            uploadForm.classList.add("visually-hidden");
            if (videoWindow.classList.contains("visually-hidden"))
                videoWindow.classList.remove("visually-hidden");
            uploadedImgWindow.classList.add("visually-hidden");
        }
    };
    if (cameraButton.checked == true) {
        uploadedImgWindow.classList.add("visually-hidden");
        uploadForm.classList.add("visually-hidden");
    }


    cameraButton.addEventListener("change",checkCheckboxChanging);
    uploadButton.addEventListener("change",checkCheckboxChanging);
    var info = window.location.href;
    var first = info.indexOf("success");
    if (info.indexOf("success")!= -1 && info.indexOf("result=") != -1)
    {
        const main = document.querySelector('main');
        const template= document.getElementById("photo_result").content;
        var popup = template.cloneNode(true);
        var imSrcPlace = popup.querySelector(".popup__photo--src");

       var result = info.split("result=")[1];
        imSrcPlace.src = result;
        imSrcPlace.maxWidth = "50%";
        imSrcPlace.maxHeight = "30%";
        main.appendChild(popup);
        const button_close = document.querySelector(".popup__close");
        button_close.addEventListener("click", function () {
            var win = document.querySelector(".popup__wrapper-photo");
            main.removeChild(win);
        });

    }

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


    if (cameraButton.checked == true)
    {
        var mainCamagruForm=document.querySelector(".main-camagru__form");
        var mainCamagruButton = document.querySelector(".main-camagru__submit")
        var hiddenInput = document.querySelector(".canvas--photo");
        var take_photo = function (evt)
        {
            var video = document.querySelector(".view--video__video");
            var canvas = document.querySelector(".canvas");
            var width = 640;
            var height = 480;
            canvas.setAttribute('width', width);
            canvas.setAttribute('height', height);
            canvas.getContext("2d").drawImage(video, 0, 0, width,height);
            var data= canvas.toDataURL("image/png");
            hiddenInput.value = data;


        };

        mainCamagruButton.addEventListener("click", function (evt) {
                take_photo();
          //  evt.preventDefault();
        });

    }
})();