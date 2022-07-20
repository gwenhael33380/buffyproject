(function($){

    $('#categoryFilter').focus().keyup(function(event){
        let input = $(this);
        let val  = input.val();

        // Si rien est tapé, on affiche tout
        if(val == ''){
            $('#filter div div p span').show();
            $('#filter').removeClass('highlighted');
            return true;
        }

        // On construit l'expression à partir de ce qui est tapé (.*)e(.*)x(.*)e(.*)m(.*)p(.*)l(.*)e(.*)
        let regexp = '\\b(.*)';
        for(let i in val){
            regexp += '('+val[i]+')(.*)';
        }
        regexp += '\\b';
        $('#filter div div p span').show();

        // On parcourt chaque élément de la liste
        $('#filter div div p span').each(function(){
            let span = $(this);
            let results = span.text().match(new RegExp(regexp,'i'));

            // le text match
            if(results){
                let string = '';
                for(let i in results){
                    if(i > 0){
                        if(i%2 == 0){
                            string += '<span class="highlighted">'+results[i]+'</span>';
                        }else{
                            string += results[i];
                        }
                    }
                }
                span.empty().append(string);
            }else{
                span.parent().parent().toggle();
            }
        })
    });

})(jQuery);

