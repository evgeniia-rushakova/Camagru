<div class="additional_container">
    <div class="main-camagru-container">
        <div class="main-camagru-wrapper" style="position: relative">
            <form action="../php/photo_to_gallery_upload.php" method="post" class=" main-camagru__upload-file cabinet__avatar-form" style="position: absolute;top: 0;
         left: 0;" enctype="multipart/form-data">
                <input type="hidden" name="MAX_FILE_SIZE" value="500000000">
                <label for="file" class="cabinet__avatar__upload-label">Choose file...</label>
                <input class="cabinet__avatar__upload" type="file" required id="file" name="userfile" accept=".jpg, .jpeg, .png .bmp .gif">
                <button class="cabinet__avatar-button" type="submit">Load</button>
            </form>
            <form class="main-camagru__form" action="../php/camera.php" style="padding-top: 40px;" method="post"">
            <div class="main-camagru__upload file_upload-container">
                <div class="main-camagru__preview">
                    <video id="videoTag"  autoplay muted class="view--video__video"></video>
                    <canvas class="canvas" style="display:none;"></canvas>
                    <input type="hidden" class="canvas--photo" name="photo">
                    <div class="main-camagru__loaded-img">
                        <img  id="img" src="{uploaded_img}" alt="here will be your uploaded image">
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
                    <h3 class="gallery-container--inner-title filters__title">Stickers:</h3>
                    <div class="filters__list">
                        {filters}
                    </div>
                    <div class="filter__settings">
                        <div class="filter__radio-wrapper">
                            <p class="filter__settings--title">vertical position(%)</p>
                            <div class="range-wrap">
                                <input class="range" type="range" min="0" max="100" name="position_vert" value="50" id="vert">
                                <output class="bubble"></output>
                            </div>
                        </div>
                        <div class="filter__radio-wrapper">
                            <p class="filter__settings--title">horizontal position(%)</p>
                            <div class="range-wrap">
                                <input type="range" class="range" min="0" max="100" name="position_hor" value="50" id="hor">
                                <output class="bubble"></output>
                            </div>

                        </div>
                        <div class="filter__radio-wrapper">
                            <p class="filter__settings--title">filter scale(%)</p>
                            <div class="range-wrap">
                                <input type="range" class="range" min="1" max="100" name="scale" value="50" id="scale">
                                <output class="bubble"></output>
                            </div>

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
    <div class="filter__new-sticker">
        <h3 class="profile__title filter__new-sticker--title"> Add your own sticker:</h3>
        <form action="../php/add_new_sticker.php" method="post" enctype="multipart/form-data" class="filter__new-sticker-form" >
            <input type="hidden" name="MAX_FILE_SIZE" value="500000000">
            <label for="file2" class="cabinet__avatar__upload-label">Choose png</label>
            <input class="cabinet__avatar__upload2" type="file" required id="file2" name="userfile" accept=".png">
            <button class="cabinet__avatar-button" type="submit">Load</button>
        </form>
    </div>
</div>
