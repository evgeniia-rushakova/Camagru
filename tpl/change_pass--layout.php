<div class="index__container">
	<div class="index__gallery">
		<img src="../img/isaac-quesada-w8--SP1DLEw-unsplashdesk.png" alt="gallery-photo" class="index__gallery-photo photo1" width="362" height="260">
		<img src="../img/jessica-felicio-_cvwXhGqG-o-unsplashdesk.png" alt="gallery-photo" class="index__gallery-photo photo2" width="261" height="189">
		<img src="../img/averie-woodard-4nulm-JUYFo-unsplashdsk.png" alt="gallery-photo" class="index__gallery-photo photo3" width="362" height="260">
		<img src="../img/anton-shakirov-fnylyZVS-x4-unsplashdsk.png" alt="gallery-photo" class="index__gallery-photo photo4" width="262" height="331">
		<img src="../img/aiony-haust-3TLl_97HNJo-unsplash.png" alt="gallery-photo" class="index__gallery-photo photo5" width="260" height="331">
		<img src="../img/blake-carpenter-qWiJBa6soE0-unsplash.png" alt="gallery-photo" class="index__gallery-photo photo6" width="361" height="346">
	</div>
	<div class="sign-in-form-container">
		<p class="index__header">Hello, {user}! Please, create new password to Camagru account.</p>
		<form action="../php/settings.php" class="sign-in-form">
			<input type="hidden" name="user" value={user}>
			<input type="hidden" name="act" value="change_password_outside">
			<p class="sign-in-form__label">Your new pass: <input type="password" name="password" class="sign-in-form__field" required="" minlength="6" maxlength="29"></p>
			<p class="sign-in-form__label">Please, repeat: <input type="password" name="password2" class="sign-in-form__field" required="" minlength="6" maxlength="29"></p>
			<button class="sign-in-form__submit" type="submit">create</button>
		</form>
	</div>
</div>