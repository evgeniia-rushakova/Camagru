'use strict';

(function() {
    const main = document.querySelector('main');

    const add_popup = function(popup_template, wrapper, func) {
        const template = popup_template.cloneNode(true);
        main.appendChild(template);
        const popup = document.querySelector(wrapper);
        const button_close = popup.querySelector(".popup__close");
    };

    const forgot_click_handler = function() {
        const value = document.getElementById('forgot_password').content;
        add_popup(value, ".popup_wrapper--forgot", forgot_click_handler);
    };

    const change_username_click_handler = function() {
        const value = document.getElementById('change_username').content;
        add_popup(value, ".popup__wrapper-username", change_username_click_handler);
    };
    const change_email_click_handler = function() {
        const value = document.getElementById('change_email').content;
        add_popup(value, ".popup__wrapper-email", change_email_click_handler);
    };
    const change_password_click_handler = function() {
        const value = document.getElementById('change_password').content;
        add_popup(value, ".popup__wrapper-password", change_password_click_handler);
    };
    /*    const camagru_submit_click_handler = function () {
            const value = document.getElementById('photo_result').content;
            add_popup(value, ".popup__wrapper-photo", camagru_submit_click_handler);
        };*/

    function add_listener_to_popup(what_search, handlerFunc) {
        const link = document.querySelector(what_search);
        if (link)
            link.addEventListener("click", handlerFunc);
    }

    let array_links = [];
    array_links = [{
        class: ".sign-in-form__forgot",
        func: forgot_click_handler
    },
        {
            class: ".profile__change--username",
            func: change_username_click_handler
        },
        {
            class: ".profile__change--email",
            func: change_email_click_handler
        },
        {
            class: ".profile__change--password",
            func: change_password_click_handler
        },
        // {class:".main-camagru__submit", func: camagru_submit_click_handler}
    ];

    for (let item of array_links) {
        add_listener_to_popup(item.class, item.func);
    }
})();