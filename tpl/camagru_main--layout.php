<div class="main-camagru-container" style="display: flex;
flex-direction: row;
justify-content: space-around;">
	<div class="main-camagru__upload file_upload-container">
		<div class="sign-in-form-container" style="height: 400px;width: 400px;">
			<video id="videoTag" src="" autoplay muted class="view--video__video"></video>
		</div>
		<form enctype="multipart/form-data" action="../php/file_upload.php" method="post"
			  style="border-radius: 10px;
		  width: 300px;
		  margin: auto;
		  height: 100px;
		  border: 2px solid purple;">
			<input type="hidden" name="MAX_FILE_SIZE" value="300000">
			<input type="text" name = "description" placeholder="Add description" class="sign-in-form__email">
			<input type="file" class="sign-in-form__label" name="userfile">
			<button type="submit" class="sign-in-form__submit"> upload</button>
		</form>
		<div class="sign-in-form-container">
			<img src="../img/images.jfif" alt="pepe">
		</div>
	</div>
	<aside class="main-camagru__gallery">
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