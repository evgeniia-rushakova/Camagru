
    <div class="cabinet-container">
        <div class="cabinet__avatar">
            <h3 class="profile__title">Avatar</h3>
            <div class="cabinet__avatar__upload--wrapper">
                <img class="cabinet__avatar-photo" src="img/avatars/{user_avatar}" alt="avatar of user">
                <form enctype="multipart/form-data" action="../php/avatar_upload.php" class="cabinet__avatar-form" method="post">
                    <label for="file" class="cabinet__avatar__upload-label">Choose file...</label>
                    <input class="cabinet__avatar__upload" type="file" required id="file" name="userfile">
                    <input type="hidden" name="MAX_FILE_SIZE" value="300000">
                    <button class="cabinet__avatar-button" type="submit">change</button>
                </form>
            </div>
        </div>
        <div class="cabinet__profile profile">
            <h3 class="profile__title">Settings</h3>
            <table class="profile__info">
                <tr class="profile__table-row">
                    <th class="profile__item">Username:</th>
                    <th class="profile__value"> {username}</th>
                    <th class="profile__change">change</th>
                </tr>
                <tr class="profile__table-row">
                    <th class="profile__item">E-mail:</th>
                    <th class="profile__value"> {useremail} </th>
                    <th class="profile__change">change</th>
                </tr>
                <tr class="profile__table-row">
                    <th class="profile__item">Password:</th>
                    <th class="profile__value">&#8226 &#8226 &#8226 &#8226 &#8226 &#8226 </th>
                    <th class="profile__change">change</th>
                </tr>
                <tr class="profile__table-row">
                    <th class="profile__item">E-mail notifications:</th>
                    <th class="profile__value">{notif}</th>
                    <th class="profile__change">change</th>
                </tr>
            </table>
            <div class="profile__photos">
                <h3 class="profile__title">Yor photos:</h3>
                <div class="profile__photos-container">
                    {gallery}
                </div>
            </div>
            <div class="profile__comments">
                <h3 class="profile__title"> Your comments:</h3>
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