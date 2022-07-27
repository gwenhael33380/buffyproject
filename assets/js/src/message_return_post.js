// Home page

// delete message connect 3 sec and 3000ms
// setTimeout(fade_out, 3000);
//
// function fade_out() {
//     $("#connect_user, .update_user_success").fadeOut().empty();
// }
//
// // delete message erreur connect 5 sec and 5000ms
//
// // missing fields
// setTimeout(msg_connect_failure, 5000);
//
// function msg_connect_failure() {
//     $("#connect_user_falure, #connect_user_falure2, #connect_user_falure3, #connect_user_falure4").fadeOut().empty();
// }

//
//
//
//
//                                                             // Disconnect user
// setTimeout(disconnect_user, 3000);
//
// function disconnect_user() {
//     $("#disconnect_user").fadeOut().empty();
// }
//
//
//                                                             // User update
//
// // delete message update 3 sec and 3000ms
// setTimeout(msg_update_success, 3000);
//
// function msg_update_success() {
//     $(".update_user_success").fadeOut().empty();
// }
//
// // delete message erreur update 5 sec and 5000ms
// setTimeout(error_msg_update_user, 5000);
//
// function error_msg_update_user() {
//     $(".error_update_user").fadeOut().empty();
// }
//
//
//
//
//
//                                                             // message create article and delete article
// setTimeout(msg_create_article_success, 3000);
//
//
// // delete message update 3 sec and 3000ms
// function msg_create_article_success() {
//     $(".create_article_success, #delete_article_success").fadeOut().empty();
// }
//
// setTimeout(msg_create_article_error, 5000);
//
// // delete message erreur update 5 sec and 5000ms
// function msg_create_article_error() {
//     $(".create_article_error,#delete_article_error").fadeOut().empty();
// }
//
//
//
//                                                             // comments
//
// // delete message update 3 sec and 3000ms
// setTimeout(msg_delete_comment_success, 3000);
//
// function msg_delete_comment_success() {
//     $("#add_comment_success, #update_comment_success, #delete_comment_success").fadeOut().empty();
// }
//
// // delete message erreur update 5 sec and 5000ms
// setTimeout(msg_error_delete_comment, 5000);
//
// function msg_error_delete_comment() {
//     $("#add_comment_error, #update_comment_error, #error_delete_comment, #comment_empty").fadeOut().empty();
// }

setTimeout(msg_success, 3000);

function msg_success() {
    $(".msg_success").fadeOut().empty();
}

// delete message erreur update 5 sec and 5000ms
setTimeout(msg_error_delete_comment, 5000);

function msg_error_delete_comment() {
    $(".msg_error").fadeOut().empty();
}



