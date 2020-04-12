<div class="main-camagru-container">
    <div class="main-camagru-wrapper">
        <form enctype="multipart/form-data" action="../php/file_upload.php" method="post" class=" main-camagru__upload-file cabinet__avatar-form">
            <input type="hidden" name="MAX_FILE_SIZE" value="300000">
            <label for="file" class="cabinet__avatar__upload-label">Choose file...</label>
            <input class="cabinet__avatar__upload" type="file" required="" id="file">
            <button class="cabinet__avatar-button" type="submit">Load</button>
        </form>
        <form action="">
            <div class="main-camagru__upload file_upload-container">
                <div class="main-camagru__preview">
                    <video id="videoTag" src="" autoplay muted class="view--video__video"></video>
                    <div class="main-camagru__loaded-img">
                    </div>
                    <div class="main-camagru__buttons buttons">
                        <input class="buttons__camera-radio" type="radio" name="file_type" value="camera" id="radio_camera" required="">
                        <label class="buttons__camera-label" for="radio_camera"></label>
                        <input class="buttons__upload-radio" type="radio" name="file_type" value="upload" id="radio_upload" required="">
                        <label class="buttons__upload-label" for="radio_upload"></label>
                    </div>
                </div>
                <button type="submit" class="main-camagru__submit">CamaGru</button>
                <div class="main-camagru-filters-container filters">
                    <h3 class="gallery-container--inner-title filters__title">Effects:</h3>
                    <div class="filters__list">
                        <!--{filters}-->
                        <input type="checkbox" class="filter__radio" id="radio1" name="radio">
                        <label for="radio1" class="filters__item"><img class="filters__img" src="img/filters/filter%20(1).png" alt="filter"></label>
                        <input type="checkbox" class="filter__radio" id="radio2" name="radio">
                        <label for="radio2" class="filters__item"><img class="filters__img" src="img/filters/filter%20(7).png" alt="filter"></label>
                        <input type="checkbox" class="filter__radio" id="radio3" name="radio">
                        <label for="radio3" class="filters__item"><img class="filters__img" src="img/filters/filter%20(8).png" alt="filter"></label>
                        <input type="checkbox" class="filter__radio" id="radio4" name="radio">
                        <label for="radio4" class="filters__item"><img class="filters__img" src="img/filters/filter%20(9).png" alt="filter"></label>
                        <input type="checkbox" class="filter__radio" id="radio5" name="radio">
                        <label for="radio5" class="filters__item"><img class="filters__img" src="img/filters/filter%20(10).png" alt="filter"></label>
                        <input type="checkbox" class="filter__radio" id="radio6" name="radio">
                        <label for="radio6" class="filters__item"><img class="filters__img" src="img/filters/filter%20(11).png" alt="filter"></label>
                    </div>
                </div>
            </div>
        </form>
    </div>
    <aside class="gallery-container gallery-container--inner">
        <h3 class="gallery-container--inner-title">Your latest photos:</h3>
       {gallery}
    </aside>
</div>
<script>
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
</script>