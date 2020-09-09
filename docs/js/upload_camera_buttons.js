'use_strict';

(function () {
    var cameraButton = document.querySelector(".buttons__camera-radio");
    var uploadButton = document.querySelector(".buttons__upload-radio");
    var uploadForm = document.querySelector(".main-camagru__upload-file");
    var videoWindow = document.querySelector(".view--video__video");
    var uploadedImgWindow = document.querySelector(".main-camagru__loaded-img");
    var uploaded_img = document.getElementById("img");

    var checkCheckboxChanging = function () {
        if (uploadButton.checked == true) {
            if (uploadForm.classList.contains("visually-hidden"))
                uploadForm.classList.remove("visually-hidden");
            if (uploadedImgWindow.classList.contains("visually-hidden"))
                uploadedImgWindow.classList.remove("visually-hidden");
            videoWindow.classList.add("visually-hidden");
        }
        if (cameraButton.checked == true) {
            uploadForm.classList.add("visually-hidden");
            if (videoWindow.classList.contains("visually-hidden"))
                videoWindow.classList.remove("visually-hidden");
            uploadedImgWindow.classList.add("visually-hidden");
        }
    };

    if (uploaded_img.src.indexOf("{uploaded_img}") === -1)
    {
        uploadButton.checked = true;
        cameraButton.checked = false;
        if (uploadForm.classList.contains("visually-hidden"))
            uploadForm.classList.remove("visually-hidden");
        if (uploadedImgWindow.classList.contains("visually-hidden"))
            uploadedImgWindow.classList.remove("visually-hidden");
        videoWindow.classList.add("visually-hidden");
    }

    if (cameraButton.checked == true) {
        uploadedImgWindow.classList.add("visually-hidden");
        uploadForm.classList.add("visually-hidden");
    }

    cameraButton.addEventListener("change", checkCheckboxChanging);
    uploadButton.addEventListener("change", checkCheckboxChanging);

})();