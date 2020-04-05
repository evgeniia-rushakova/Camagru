<div class ="cabinet-container">
    <div class="profile">
        <h3 class="profile__title">Settings</h3>
        <ul class="profile__info">
            <li class="profile__item">Username: {username} <a href="../php/settings.php?act=change_username">change</a></li>
            <li class="profile__item">E-mail: {useremail} <a href="../php/settings.php?act=change_email">change</a></li>
            <li class="profile__item">Password:  <a href="../php/settings.php?act=change_password">change</a></li>
            <li class="profile__item">Send me notifications about new comments : {notif}<a href="../php/settings.php?act=notifications">change</a></li>
            <li class="profile__item"> <a href="../php/settings.php?act=delete_profile">Delete my profile </a></li>
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