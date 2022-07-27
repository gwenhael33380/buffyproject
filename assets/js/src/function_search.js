(function($){

    $('#categoryFilter').focus().keyup(function(event){
        let input = $(this);
        let val  = input.val();

        // Si rien est tapé, on affiche tout
        if(val == ''){
            $('#categoryFilter').val(null);
            $('.content_user_dashboard').show();
            $('.result_pseudo span').removeClass('highlighted');
            return true;
        }
        console.log(val);


        // On construit l'expression à partir de ce qui est tapé (.*)e(.*)x(.*)e(.*)m(.*)p(.*)l(.*)e(.*)
        let regexp = '\\b(.*)';
        for(let i in val){
            regexp += '('+val[i]+')(.*)';
        }
        regexp += '\\b';
        $('.content_user_dashboard').show();

        // On parcourt chaque élément de la liste
        $('.content_user_dashboard').find('.result_pseudo').each(function(){
            let span = $(this);
            let resultats = span.text().match(new RegExp(regexp,'i'));

            // le text match
            if(resultats){
                let string = '';
                for(let i in resultats){
                    if(i > 0){
                        if(i%2 == 0){
                            string += '<span class="highlighted">'+resultats[i]+'</span>';
                        }else{
                            string += resultats[i];
                        }
                    }
                }
                span.empty().append(string);
            }else{
                span.parent().parent().parent().parent().hide();
            }
        })
    });

})(jQuery);