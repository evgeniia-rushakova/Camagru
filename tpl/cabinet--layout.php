
    <div class="cabinet-container">
        <div class="cabinet__avatar">
            <h3 class="profile__title">Avatar</h3>
            <div class="cabinet__avatar__upload--wrapper">
                <img class="cabinet__avatar-photo" src="img/avatars/{user_avatar}" alt="avatar of user">
                <form  action="../php/avatar_upload.php" class="cabinet__avatar-form" method="post" enctype="multipart/form-data" >
                    <input type="hidden" name="type_upload" value="avatar">
                    <label for="file" class="cabinet__avatar__upload-label">Choose file...</label>
                    <input class="cabinet__avatar__upload" type="file" required id="file" name="userfile"  accept=".jpg, .jpeg, .png .bmp .gif">
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
                    <th class="profile__change profile__change--username">change</th>
                </tr>
                <tr class="profile__table-row">
                    <th class="profile__item">E-mail:</th>
                    <th class="profile__value"> {useremail} </th>
                    <th class="profile__change profile__change--email">change</th>
                </tr>
                <tr class="profile__table-row">
                    <th class="profile__item">Password:</th>
                    <th class="profile__value">&#8226 &#8226 &#8226 &#8226 &#8226 &#8226 </th>
                    <th class="profile__change profile__change--password">change</th>
                </tr>
                <tr class="profile__table-row">
                    <th class="profile__item">E-mail notifications:</th>
                    <th class="profile__value">{notif}</th>
                    <th class="profile__change"><a href="../php/settings.php?act=notifications&val={notif}" style="
    color: #f06546;
    text-decoration: none;
">change</a></th>
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