(function($){

// delete message erreur update 5 sec and 3000ms
    setTimeout(msg_success, 3000);

    function msg_success() {
        $(".msg_success").fadeOut().empty();
    }

// delete message erreur update 5 sec and 5000ms
    setTimeout(msg_error_delete_comment, 5000);

    function msg_error_delete_comment() {
        $(".msg_error").fadeOut().empty();
    }

})(jQuery);