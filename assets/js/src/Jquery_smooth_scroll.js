$(function() {
    /**
     * Smooth scrolling to page anchor on click
     **/
    $("a[href='#scroll_section_2']:not([href='#'])").click(function(e) {
        e.preventDefault();
        if (
            location.hostname == this.hostname
            && this.pathname.replace(/^\//,"") == location.pathname.replace(/^\//,"")
        ) {
            var anchor = $(this.hash);
            anchor = anchor.length ? anchor : $("[#scroll_section_2=" + this.hash.slice(1) +"]");
            if ( anchor.length ) {
                $("html, body").animate( { scrollTop: anchor.offset().top }, 1500);
            }
        }
    });
});