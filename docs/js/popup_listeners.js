'use strict';

(function() {
    const main = document.querySelector('main');

    const add_popup = function(popup_template, wrapper, func) {
        const template = popup_template.cloneNode(true);
        main.appendChild(template);
        const popup = document.querySelector(wrapper);
        const button_close = popup.querySelector(".popup__close");
        button_close.addEventListener("click", function (evt) {
            evt.preventDefault();
                main.removeChild(popup);
        });
        waiterForPopupsHandler();
    };

    const forgotClickHandler = function() {
        const value = document.getElementById('forgot_password').content;
        add_popup(value, ".popup_wrapper--forgot", forgotClickHandler);
    };

    const changeUsernameClickHandler = function() {
        const value = document.getElementById('change_username').content;
        add_popup(value, ".popup__wrapper-username", changeUsernameClickHandler);
    };
    const changeEmailClickHandler = function() {
        const value = document.getElementById('change_email').content;
        add_popup(value, ".popup__wrapper-email", changeEmailClickHandler);
    };
    const changePasswordClickHandler = function() {
        const value = document.getElementById('change_password').content;
        add_popup(value, ".popup__wrapper-password", changePasswordClickHandler);
    };

    function add_listener_to_popup(what_search, handlerFunc) {
        const link = document.querySelector(what_search);
        if (link)
            link.addEventListener("click", handlerFunc);
    }

    let array_links = [];
    array_links = [{
        class: ".sign-in-form__forgot",
        func: forgotClickHandler
    },
        {
            class: ".profile__change--username",
            func: changeUsernameClickHandler
        },
        {
            class: ".profile__change--email",
            func: changeEmailClickHandler
        },
        {
            class: ".profile__change--password",
            func: changePasswordClickHandler
        },
    ];

    for (let item of array_links) {
        add_listener_to_popup(item.class, item.func);
    }
})();