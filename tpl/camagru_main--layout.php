<div class="main-camagru-container">
    <div class="main-camagru-wrapper" style="position: relative">
        <form action="../php/photo_to_gallery_upload.php" method="post" class=" main-camagru__upload-file cabinet__avatar-form" style="position: absolute;top: 0;
    left: 0;" enctype="multipart/form-data">
            <input type="hidden" name="MAX_FILE_SIZE" value="300000">
            <label for="file" class="cabinet__avatar__upload-label">Choose file...</label>
            <input class="cabinet__avatar__upload" type="file" required id="file" name="userfile">
            <button class="cabinet__avatar-button" type="submit">Load</button>
        </form>
        <form class="main-camagru__form" action="../php/camera.php" style="padding-top: 40px;" method="post">
            <div class="main-camagru__upload file_upload-container">
                <div class="main-camagru__preview">
                    <video id="videoTag"  autoplay muted class="view--video__video"></video>
                    <canvas class="canvas" style="display:none;"></canvas>
                    <input type="hidden" class="canvas--photo" name="photo">
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
                    <div class="filter__settings">
                        <div class="filter__radio-wrapper">
                            <p class="filter__settings--title">vertical position</p>
                            <input type="radio" class="filter__setting--radio" name="position_vert" id="position1">
                            <label class="filter__setting--label"  for="position1">top</label>
                            <input type="radio" class="filter__setting--radio" name="position_vert" id="position2" checked>
                            <label class="filter__setting--label"  for="position2">middle</label>
                            <input type="radio" class="filter__setting--radio" name="position_vert" id="position3">
                            <label class="filter__setting--label"  for="position3">bottom</label>
                        </div>
                        <div class="filter__radio-wrapper">
                            <p class="filter__settings--title">horizontal position</p>
                            <input type="radio" class="filter__setting--radio" name="scale" id="position4">
                            <label class="filter__setting--label"  for="position4">left</label>
                            <input type="radio" class="filter__setting--radio" name="scale" id="position5" checked>
                            <label class="filter__setting--label"  for="position5">center</label>
                            <input type="radio" class="filter__setting--radio" name="scale" id="position6">
                            <label class="filter__setting--label"  for="position6">right</label>
                        </div>
                        <div class="filter__radio-wrapper">
                            <p class="filter__settings--title">filter scale</p>
                            <input type="radio" class="filter__setting--radio" name="position_hor" id="position7" checked>
                            <label class="filter__setting--label"  for="position7">100%</label>
                            <input type="radio" class="filter__setting--radio" name="position_hor" id="position8">
                            <label class="filter__setting--label"  for="position8">75%</label>
                            <input type="radio" class="filter__setting--radio" name="position_hor" id="position9">
                            <label class="filter__setting--label"  for="position9">50%</label>
                        </div>
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
