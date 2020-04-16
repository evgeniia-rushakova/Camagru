<div class="main-camagru-container">
    <div class="main-camagru-wrapper" style="position: relative">
        <form action="../php/photo_to_gallery_upload.php" method="post" class=" main-camagru__upload-file cabinet__avatar-form" style="position: absolute;top: 0;
    left: 0;" enctype="multipart/form-data">
            <input type="hidden" name="MAX_FILE_SIZE" value="300000">
            <label for="file" class="cabinet__avatar__upload-label">Choose file...</label>
            <input class="cabinet__avatar__upload" type="file" required id="file" name="userfile">
            <button class="cabinet__avatar-button" type="submit">Load</button>
        </form>
        <form class="main-camagru__form" action="../php/camera.php" style="padding-top: 40px;">
            <div class="main-camagru__upload file_upload-container">
                <div class="main-camagru__preview">
                    <video id="videoTag" src="" autoplay muted class="view--video__video"></video>
                    <div class="main-camagru__loaded-img">
                        <img src="{uploaded_img}" alt="uploaded_img" style="max-width: 80%;">
                    </div>
                    <div class="main-camagru__buttons buttons">
                        <input class="buttons__camera-radio" type="radio" name="file_type" value="camera" id="radio_camera" required checked>
                        <label class="buttons__camera-label" for="radio_camera"></label>
                        <input class="buttons__upload-radio" type="radio" name="file_type" value="upload" id="radio_upload" required>
                        <label class="buttons__upload-label" for="radio_upload"></label>
                    </div>
                </div>
                <button type="submit" class="main-camagru__submit">CamaGru</button>
                <div class="main-camagru-filters-container filters">
                    <h3 class="gallery-container--inner-title filters__title">Effects:</h3>
                    <div class="filters__list">
                        {filters}
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
