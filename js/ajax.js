function CreateRequest() {
    let Request = false;
    if (window.XMLHttpRequest)
        Request = new XMLHttpRequest(); //Internet explorer
    else if (window.ActiveXObject) {
        try {
            Request = new ActiveXObject("Microsoft.XMLHTTP");
        } catch (CatchException) {
            Request = new ActiveXObject("Msxml2.XMLHTTP");
        }
    }
    if (!Request)
        alert("Невозможно создать XMLHttpRequest");
    return Request;
}

function addListenersOnComments() {
    let deleteCommentButtonsForms = document.querySelectorAll(".delete-comment");
    deleteCommentButtonsForms.forEach(function (currentValue, currentIndex, listObj) {
        currentValue.removeEventListener("submit", function (evt) {
            callback(deleteComment, 'http://localhost/php/ajax_comments.php', evt)
        })
    });
    deleteCommentButtonsForms.forEach(function (currentValue, currentIndex, listObj) {
        currentValue.addEventListener("submit", function (evt) {
            callback(deleteComment, 'http://localhost/php/ajax_comments.php', evt)
        })
    });
}

function likesLoad(link, evt) {
    if (evt)
        evt.preventDefault();
    let request = CreateRequest();
    let href = link;
    request.open('GET', href, true);
    request.addEventListener('readystatechange', function () {
        if ((request.readyState == 4) && (request.status == 200)) {
            const req = request.responseText;
            const response = JSON.parse(request.responseText);
            let like = document.querySelector('.ajaxlike');
            let dislike = document.querySelector('.ajaxdislike');
            like.innerHTML = response.likes;
            dislike.innerHTML = response.dislikes;
        }
    });
    request.send();
}

function deleteComment(link, evt) {
    if (evt)
        evt.preventDefault();

    const formData = new FormData(evt.target);
    let request = CreateRequest();
    let href = link;
    request.open('POST', href, true);
    request.send(formData);
    request.addEventListener('readystatechange', function () {
        if ((request.readyState == 4) && (request.status == 200)) {
            const req = request.responseText;
            let comments = document.getElementById("ajaxcomments");
            comments.innerHTML = req;
            addListenersOnComments();
        }
    });
}

function commentsLoad(link, evt) {
    if (evt)
        evt.preventDefault();
    let request = CreateRequest();
    let href = link;
    request.open('GET', href, true);
    request.addEventListener('readystatechange', function () {
        if ((request.readyState == 4) && (request.status == 200)) {
            const req = request.responseText;
            let comments = document.getElementById("ajaxcomments");
            comments.innerHTML = req;
            addListenersOnComments();
        }
    });
    request.send();
}

function addNewComment(link, evt) {
    if (evt)
        evt.preventDefault();

    const formData = new FormData(document.querySelector(".photo__comment-form--form"));
    let request = CreateRequest();
    let href = link;
    request.open('POST', href, true);
    request.send(formData);
    request.addEventListener('readystatechange', function () {

        if ((request.readyState == 4) && (request.status == 200)) {
            const req = request.responseText;
            let comments = document.getElementById("ajaxcomments");
            comments.innerHTML = req;
            addListenersOnComments()
        }
    });
}

function callback(otherFunc, link, evt) {
    otherFunc(link, evt);
}

let likelink = document.querySelector(".likelink");
let dislikelink = document.querySelector(".dislikelink");
let form = document.querySelector(".photo__comment-form--form");

form.addEventListener("submit", function (evt) {
    callback(addNewComment, 'http://localhost/php/ajax_comments.php', evt)
});

likelink.addEventListener("click", function (evt) {
    callback(likesLoad, likelink.href, evt)
}, false);
dislikelink.addEventListener("click", function (evt) {
    callback(likesLoad, dislikelink.href, evt)
}, false);

window.addEventListener("load", function (evt) {
    callback(likesLoad, 'http://localhost/php/ajax_like.php', null)
})

window.addEventListener("load", function (evt) {
    callback(commentsLoad, 'http://localhost/php/ajax_comments.php', null) //load comments
})