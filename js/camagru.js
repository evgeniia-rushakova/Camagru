'use_strict';

(function () {
    navigator.getUserMedia = navigator.getUserMedia || navigator.webkitGetUserMedia || navigator.mozGetUserMedia;
    if (navigator.getUserMedia) {
        navigator.getUserMedia({
                audio: true,
                video: {
                    width: 400,
                    height: 400
                }
            },
            function (stream) {
                var video = document.querySelector('video');
                video.srcObject = stream;
                video.onloadedmetadata = function (e) {
                    video.play();
                };
            },
            function (err) {
                console.log("The following error occurred: " + err.name);
            }
        );
    } else {
        console.log("getUserMedia not supported");
    }


    var cameraButton = document.querySelector(".buttons__camera-radio");
    var info = window.location.href;

    if (info.indexOf("success") != -1 && info.indexOf("result=") != -1) {
        const main = document.querySelector('main');
        const template = document.getElementById("photo_result").content;
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
            document.location.href = "../inner_camagru.php";
        });
    }


    var mainCamagruButton = document.querySelector(".main-camagru__submit");
    var hiddenInput = document.querySelector(".canvas--photo");
    var form = document.querySelector(".main-camagru__form");
    var video = document.querySelector(".view--video__video");
    var canvas = document.querySelector(".canvas");
    var width = 640;
    var height = 480;


    var take_photo = function () {
        if (cameraButton.checked == true) {
            canvas.setAttribute('width', width);
            canvas.setAttribute('height', height);
            canvas.getContext("2d").drawImage(video, 0, 0, width, height);
            var data = canvas.toDataURL("image/png");
            hiddenInput.value = data;
        }

    };

    mainCamagruButton.addEventListener("click", function () {
        take_photo();
    });

})();