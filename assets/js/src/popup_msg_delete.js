
// delete message connect 5 sec
setTimeout(fade_out, 3000);

function fade_out() {
    $("#connect_user").fadeOut().empty();
}

// delete message erreur connect 5 sec

// missing fields
setTimeout(fade_out_falure, 5000);

function fade_out_falure() {
    $("#connect_user_falure").fadeOut().empty();
}

setTimeout(fade_out_falure2, 5000);

function fade_out_falure2() {
    $("#connect_user_falure2").fadeOut().empty();
}

setTimeout(fade_out_falure3, 5000);

function fade_out_falure3() {
    $("#connect_user_falure3").fadeOut().empty();
}

setTimeout(fade_out_falure4, 5000);

function fade_out_falure4() {
    $("#connect_user_falure4").fadeOut().empty();
}

// disconnect message 5 sec

setTimeout(disconnect_user, 3000);

function disconnect_user() {
    $("#disconnect_user").fadeOut().empty();
}
