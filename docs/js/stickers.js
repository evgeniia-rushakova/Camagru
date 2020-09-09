'use_strict';

(function() {
    var cameraButton = document.querySelector(".buttons__camera-radio");
    var uploadButton = document.querySelector(".buttons__upload-radio");
    var videoWindow = document.querySelector(".view--video__video");
    var uploadedImgWindow = document.querySelector(".main-camagru__loaded-img");
    let Filters = Array.prototype.slice.call(document.querySelectorAll(".filter__radio"))
    let scaleRangeValue = document.getElementById("scale");
    let vertRangeValue = document.getElementById("vert");
    let horRangeValue = document.getElementById("hor");
    let uploadImg = document.getElementById("img");

    let createConture = function(size, parent, parentWidth, parentHeight) {

        let Contures = document.querySelectorAll(".conture");
        Contures.forEach(function(elem) {
            elem.parentNode.removeChild(elem);
        })
        let cont = document.createElement("div");
        cont.style.content = "";
        cont.style.width = Math.floor(size * scaleRangeValue.value / 100) + "px";
        cont.style.height = Math.floor(size * scaleRangeValue.value / 100) + "px";
        cont.style.position = "absolute";
        cont.style.border = "2px dashed white";
        cont.style.fontSize = Math.floor((size * scaleRangeValue.value / 100) / 10) + "px";
        cont.style.left = Math.floor((parentWidth - parseInt(cont.style.width)) * horRangeValue.value / 100 + (640 - parentWidth) / 2) + "px";
        cont.style.top = Math.floor((parentHeight - parseInt(cont.style.height)) * vertRangeValue.value / 100) + "px";
        cont.style.borderRadius = "8px";
        cont.style.display = "flex";
        cont.style.justifyContent = "center";
        cont.style.alignItems = "center";
        cont.innerHTML = '<p class="sticker-text">Your Sticker</p>';
        cont.classList.add("conture");
        parent.after(cont);
    }

    let addListenersOnFilters = function() {
        let checkedFilters = Filters.filter(function(element) {
            if (element.checked)
                return true;
        })
        let conture = document.querySelector(".conture");
        if (checkedFilters.length === 0 && conture)
            conture.parentNode.removeChild(conture);
        Filters.forEach(function(element) {
            element.addEventListener("click", function(evt) {
                let size;
                if (cameraButton.checked) {
                    size = 480;
                    createConture(size, videoWindow, 640, 480);
                } else if (uploadButton.checked && uploadImg.src !== "upl.png") {
                    size = Math.min(uploadedImgWindow.offsetWidth, uploadedImgWindow.offsetHeight) * (480 / uploadImg.naturalWidth);
                    createConture(size, uploadedImgWindow, uploadedImgWindow.offsetWidth, uploadedImgWindow.offsetHeight);
                }
                addListenersOnFilters(evt);
            })
        })
    }

    let changeFilter = function(evt) {
        let conture = document.querySelector(".conture");
        let size;
        let width;
        let height;
        if (conture) {
            if (cameraButton.checked) {
                size = 480;
                width = 640;
                height = 480;
            } else if (uploadButton.checked && uploadImg.src !== "upl.png") {
                size = Math.min(uploadedImgWindow.offsetWidth, uploadedImgWindow.offsetHeight) * (480 / uploadImg.naturalWidth);
                width = uploadedImgWindow.offsetWidth;
                height = uploadedImgWindow.offsetHeight;
            }
            conture.style.width = size * scaleRangeValue.value / 100 + "px";
            conture.style.height = size * scaleRangeValue.value / 100 + "px";
            conture.style.left = Math.floor((width - parseInt(conture.style.width)) * horRangeValue.value / 100 + (640 - width) / 2) + "px";
            conture.style.top = Math.floor((height - parseInt(conture.style.height)) * vertRangeValue.value / 100) + "px";
            conture.style.fontSize = Math.floor((size * scaleRangeValue.value / 100) / 10) + "px";
        }
    }

    scaleRangeValue.addEventListener("change", function(evt) {
        changeFilter(evt);
    })
    horRangeValue.addEventListener("change", function(evt) {
        changeFilter(evt);
    })
    vertRangeValue.addEventListener("change", function(evt) {
        changeFilter(evt);
    })

    let startListen = function() {
        let Contures = document.querySelectorAll(".conture");
        Contures.forEach(function(elem) {
            elem.parentNode.removeChild(elem);
        })
        Filters.forEach(function(filter) {
            filter.checked = false;
        })
        addListenersOnFilters();
    }

    cameraButton.addEventListener("change", startListen);
    uploadButton.addEventListener("change", startListen);
    uploadImg.addEventListener("change", startListen);
    window.addEventListener("load", addListenersOnFilters);
})();