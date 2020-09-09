'use strict';


var waiterForPopupsHandler = function () {

    var form = document.getElementById("form_check");
    var fieldOne = document.getElementById("field_1");
    var fieldTwo = document.getElementById("field_2");

    var checkIdentityHandler = function () {
        if (fieldOne.value === fieldTwo.value) {
            if (fieldTwo.classList.contains("sign-in-form__field--bad"))
                fieldTwo.classList.remove("sign-in-form__field--bad");
            fieldTwo.classList.add("sign-in-form__field--good");
        } else {
            if (fieldTwo.classList.contains("sign-in-form__field--good"))
                fieldTwo.classList.remove("sign-in-form__field--good");
            fieldTwo.classList.add("sign-in-form__field--bad");
        }
    };
    var formSubmitHandler = function (evt) {
        if (fieldTwo.classList.contains("sign-in-form__field--bad"))
            evt.preventDefault();
    };

    fieldOne.addEventListener("change", checkIdentityHandler);
    fieldTwo.addEventListener("change", checkIdentityHandler);
    form.addEventListener("submit", formSubmitHandler);
};