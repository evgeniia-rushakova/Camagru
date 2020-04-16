<?php


$change_username = '
<template id="change_username">
    <div class="popup__wrapper-username">
        <div class="overlay"></div>
        <div class="popup popup__change-username">
            <form class="popup__form" action="../php/settings.php">
                <button class="popup__close"></button>
                <input type="hidden" name="act" value="change_username">
                <label class="sign-in-form__label" for="password">Your password: </label>
                <input class="sign-in-form__field" type="password" name="password" id="password">
                <label class="sign-in-form__label" for="newusername">New username: </label>
                <input class="sign-in-form__field" type="text" name="newusername" id="newusername">
                <label class="sign-in-form__label" for="newusername2">Please, repeat: </label>
                <input class="sign-in-form__field" type="text" name="newusername2" id="newusername2">
                <button class="popup__submit sign-in-form__submit" type="submit">Send</button>
            </form>
        </div>
    </div>
</template>
';

$forgot_password = '
    <template id="forgot_password">
        <div class="popup_wrapper--forgot">
            <div class="overlay"></div>
            <div class="popup popup__change-password">
                <form class="popup__form" action="../php/settings.php">
                    <button class="popup__close"></button>
                    <input class="sign-in-form__field" type="hidden" name="act" value="forgot_password">
                    <label class="sign-in-form__label" for="email">Your e-mail: </label>
                    <input class="sign-in-form__field" type="email" name="email" id="email" required>
                    <label class="sign-in-form__label" for="email2">Please, repeat: </label>
                    <input class="sign-in-form__field" type="email" name="email2" id="email2" required>
                    <button class="popup__submit sign-in-form__submit" type="submit">Send</button>
                </form>
            </div>
        </div>
    </template>
   ';

$change_password = '
    <template id="change_password">
        <div class="popup__wrapper-password">
        <div class="overlay"></div>
        <div class="popup popup__change-password">
            <form class="popup__form" action="../php/settings.php">
                <button class="popup__close"></button>
                <input class="sign-in-form__field" type="hidden" name="act" value="change_password">
                <label class="sign-in-form__label" for="oldpassword">Your old password: </label>
                <input class="sign-in-form__field" type="password" name="password">
                <label class="sign-in-form__label" for="newpassword">New password: </label>
                <input class="sign-in-form__field" type="text" name="newpassword" id="">
                <label class="sign-in-form__label" for="newpassword2">Please, repeat: </label>
                <input class="sign-in-form__field" type="text" name="newrpassword2" id="">
                <button class="popup__submit sign-in-form__submit" type="submit">Send</button>
            </form>
        </div>
        </div>
    </template>
    ';

$change_email = '
    <template id="change_email">
        <div class="popup__wrapper-email">
            <div class="overlay"></div>
            <div class="popup popup__change-email">
                <form class="popup__form" action="../php/settings.php">
                    <button class="popup__close"></button>
                    <input type="hidden" name="act" value="change_email">
                    <label class="sign-in-form__label" for="password">Your password: </label>
                    <input class="sign-in-form__field" type="password" name="password" id="password">
                    <label class="sign-in-form__label" for="newusername">New e-mail: </label>
                    <input class="sign-in-form__field" type="text" name="email" id="newusername">
                    <label class="sign-in-form__label" for="newusername2">Please, repeat: </label>
                    <input class="sign-in-form__field" type="text" name="email2" id="newusername2">
                    <button class="popup__submit sign-in-form__submit" type="submit">Send</button>
                </form>
            </div>
        </div>
    </template>
    ';

$answer = '
    <template id="answer">
        <div class="popup__wrapper">
            <div class="overlay"></div>
            <div class="popup popup__result">
                <p class="popup__answer">{answer}</p>
                <button class="popup__close"></button>
                <button class="popup__submit sign-in-form__submit" type="submit">ok</button>
            </div>
        </div>
    </template>
    ';

$photo = '
    <template id="photo_result">
     <div class="popup__wrapper-photo">
         <div class="overlay"></div>
         <div class="popup popup__photo">
             <div class="popup__photo-wrapper">
                 <button class="popup__close"></button>
                 <div class="popup__photo-result">
                     <img src="{img_src}" alt="" class="popup__photo--src">
                 </div>
                 <form class="popup__form" action="#">
                     <input type="hidden" name="main-photo" value=happy-pepe-feelsgoodman.jpg>
                     <input type="hidden" name="author_photo" value=cat>
                     <label for="comment">
                         <input type="text" required id="comment" maxlength="300" name="comment" placeholder="Your comment..." class="photo__comment-form--new">
                     </label>
                     <button class="popup__submit sign-in-form__submit" type="submit">Save to gallery</button>
                 </form>
                 <form class="popup__form" action="#">
                     <button class="popup__submit popup__submit--dowload sign-in-form__submit" type="submit">Download</button>
                 </form>
             </div>
         </div>
     </div>
 </template>
';