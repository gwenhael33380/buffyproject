// Home page

// delete message connect 3 sec and 3000ms
setTimeout(fade_out, 3000);

function fade_out() {
    $("#connect_user, .update_user_success").fadeOut().empty();
}

// delete message erreur connect 5 sec and 5000ms

// missing fields
setTimeout(msg_connect_failure, 5000);

function msg_connect_failure() {
    $("#connect_user_falure, #connect_user_falure2, #connect_user_falure3, #connect_user_falure4").fadeOut().empty();
}

// Disconnect user
setTimeout(disconnect_user, 3000);

function disconnect_user() {
    $("#disconnect_user").fadeOut().empty();
}




// User update

// delete message update 3 sec and 3000ms
setTimeout(msg_update_succes, 3000);

function msg_update_succes() {
    $(".update_user_success").fadeOut().empty();
}

// delete message erreur update 5 sec and 5000ms
setTimeout(error_msg_update_user, 5000);

function error_msg_update_user() {
    $(".error_update_user").fadeOut().empty();
}


// Article

// delete message update 3 sec and 3000ms
setTimeout(msg_delete_comment_succes, 3000);

function msg_delete_comment_succes() {
    $("#delete_comment_success").fadeOut().empty();
}

// delete message erreur update 5 sec and 5000ms
setTimeout(msg_error_delete_comment, 5000);

function msg_error_delete_comment() {
    $("#connect_user_failure").fadeOut().empty();
}