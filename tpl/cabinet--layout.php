<div class ="cabinet-container" style="position: relative;">
    <div class="profile">
        <h3 class="profile__title">Settings</h3>
        <ul class="profile__info">
            <li class="profile__item">Username: {username} <a href="#">change</a></li>
            <li class="profile__item">E-mail: {useremail} <a href="#">change</a></li>
            <li class="profile__item">Password:  <a href="#">change</a></li>
            <li class="profile__item">Send me notifications about new comments : {notif}<a href="../php/settings.php?act=notifications&val={notif}">change</a></li>
        </ul>
        <div class="profile__photos">
            <h4 class="profile__photos__title">Yor photos:</h4>
            {gallery}
        </div>
        <div class="profile__comments">
            <h4 class="profile__comments__title"> Your comments:</h4>
            {comments}
        </div>
    </div>
</div>
<template id="change_username">
    <div class="popup popup__change-username" style="border: 2px solid purple;">
        <form action="../php/settings.php">
            <button>close</button>
            <input type="hidden" name="act" value="change_username">
            <label for="password">Your password: <input type="password" name="password"></label>
            <label for="newusername">New username: <input type="text" name="newusername" id=""></label>
            <label for="newusername2">Please, repeat: <input type="text" name="newusername2" id=""></label>
            <input type="submit">
        </form>
    </div>
</template>
<template id="change_password">
    <div class="popup popup__change-password" style="border: 2px solid purple;">
        <form action="../php/settings.php">
            <button>close</button>
            <input type="hidden" name="act" value="change_password">
            <label for="oldpassword">Your old password:<input type="password" name="password"></label>
            <label for="newpassword">New password: <input type="text" name="newpassword" id=""></label>
            <label for="newpassword2">Please, repeat: <input type="text" name="newrpassword2" id=""></label>
            <input type="submit">
        </form>
    </div>
</template>
<template id="change_email">
    <div class="popup popup__change-email" style="border: 2px solid purple;">
        <form action="../php/settings.php">
            <button>close</button>
            <input type="hidden" name="act" value="change_email">
            <label for="password">Your password: <input type="password" name="password"></label>
            <label for="newusername">New email: <input type="text" name="email" id="newusername"></label>
            <label for="newusername2">Please, repeat: <input type="text" name="email2" id="newusername2"></label>
            <input type="submit">
        </form>
    </div>
</template>
<template id="popup popup__result">
    <div><p>answer</p>
    <button>ok</button></div>
</template>