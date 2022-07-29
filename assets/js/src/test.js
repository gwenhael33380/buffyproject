(function($) {
    let spanLabel = $('.delete_label');
    $(".delete_user").on('click', function(e) {
        e.preventDefault();
        let thisLink = $(this);
        let url = thisLink.attr('href');
        console.log(url);
        if(url.indexOf('dashboard') >= 0) {
            spanLabel.html('cet utilisateur ?');
        }
        thisLink.parents('main').addClass('delete_open').next().fadeIn();
        $(".delete_link").on('click', function(e) {
            e.preventDefault();
            window.location.href = url;
        })
    });

    // pour refermer la popup avec le bouton return
    $(".close_popup").on('click', function() {
        $(".pop_delete").fadeOut();
    });
})(jQuery);


// -----------------------------------------------------
