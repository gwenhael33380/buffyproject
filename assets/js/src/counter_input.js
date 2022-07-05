// Counter add article
//
let counter_input_add_article_1 = document.getElementById('input_title_add_article');
let counter_input_add_article_2 = document.getElementById('input_textarea_add_article');
let counter_input_add_article_3 = document.getElementById('input_alt_add_article');



if (counter_input_add_article_1){
    counter_input_add_article_1.addEventListener('keyup', function() {
        document.getElementById('counter_title_add_article').innerHTML = input_title_add_article.value.length;
    });
}

if (counter_input_add_article_2){
    counter_input_add_article_2.addEventListener('keyup', function() {
        document.getElementById('counter_content_add_article').innerHTML = input_textarea_add_article.value.length;
    });
}

if (counter_input_add_article_3){
    counter_input_add_article_3.addEventListener('keyup', function() {
        document.getElementById('counter_alt_add_article').innerHTML = input_alt_add_article.value.length;
    });
}


// // Counter update article

let counter_input_update_article_1 = document.getElementById('input_title_update_article');
let counter_input_update_article_2 = document.getElementById('input_textarea_update_article');
let counter_input_update_article_3 = document.getElementById('input_alt_update_article');

if (counter_input_update_article_1)
    counter_input_update_article_1.addEventListener('keyup', function() {
    document.getElementById('counter_title_update_article').innerHTML = input_title_update_article.value.length;
});

if (counter_input_update_article_2){
    counter_input_update_article_2.addEventListener('keyup', function() {
        document.getElementById('counter_content_update_article').innerHTML = input_textarea_update_article.value.length;
    });
}

if (counter_input_update_article_3){
    counter_input_update_article_3.addEventListener('keyup', function() {
        document.getElementById('counter_alt_update_article').innerHTML = input_alt_update_article.value.length;
    });

}
