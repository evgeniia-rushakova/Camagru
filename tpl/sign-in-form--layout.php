
<div class="sign-in-form-container">
        <h3 class="sign-in-form__header">Please, sign in:</h3>
        <form action="../php/login.php" class="sign-in-form">
            <label class="sign-in-form__label" for="sign-in-form__email">Your login</label>
            <input class="sign-in-form__email" id="sign-in-form__email" type="text" name="user">
            <label class="sign-in-form__label" for="sign-in-form__password">Your password</label>
            <input class="sign-in-form__pass" id="sign-in-form__password" type="password" name="password">
            <div class="sign-in-form__help-container">
                <a href="../forgot_password.php" class="sign-in-form__forgot-reg">Forgot Password?</a>
                <a href="../inner_reg.php" class="sign-in-form__forgot-reg">Register</a>
            </div>
            <button class="sign-in-form__submit" type="submit">Enter</button>
        </form>
    </div>