//jQUERY code for search function

(function($){

    $('#categoryFilter').keyup(function(event){ // keyup, when you release the | function -> takes the event into account
        let input = $(this); // definition of the input variable which takes the value of this.
        let val  = input.val(); //val takes the value of input.val

        // If nothing is typed in the search field, everything is displayed
        if(val == ''){ // if val the value of an empty field
            $('#categoryFilter').val(null); // if nothing is type alros we attribute the value null to the input having the id #categoryFilter
            $('.content_user_dashboard').show(); // if there is no search, I display all the content
            $('.result_pseudo span').removeClass('highlighted'); //remove the span highlighted class
            return true; // return true prevents the function from going further
        }

        // We build the expression from what is typed (.*)e(.*)x(.*)e(.*)m(.*)p(.*)l(.*)e(.*) he is asked to break down each letter typed in the field
        let regexp = '\\b(.*)';
        for(let i in val){ // for loop allows to go through all the letters of the regex
            regexp += '('+val[i]+')(.*)'; // vali['i'] is equal to the typed letter (.*) includes all typed characters, now the regex is dynamic.
        }
        regexp += '\\b'; // regex closing therm
        $('.content_user_dashboard').show();

        // We go through each element of the list
        $('.content_user_dashboard').find('.result_pseudo').each(function(){
            let span = $(this);
            let resultats = span.text().match(new RegExp(regexp,'i')); // in the span does the text match the regular expression

            // le text match
            if(resultats){
                let string = '';
                for(let i in resultats){ // I browse the results with the for loop the index of the results that interests us is the even index
                    if(i > 0){ //if i is greater than 0
                        if(i%2 == 0){ // if the index is even then modulo 2, I surround it with the span with the class highlighted
                            string += '<span class="highlighted">'+resultats[i]+'</span>'; //  results['i'] inside the <span> tag are the arguments that match
                        }else{
                            string += resultats[i]; // otherwise I just added the string
                        }
                    }
                }
                span.empty().append(string); // // I empty the span with empty() and I add the content of the string variable with the append() function
            }else{
                span.parent().parent().parent().parent().hide(); // hider() will hide the content of the 4th parent from the span variable
            }
        })
    });

})(jQuery);