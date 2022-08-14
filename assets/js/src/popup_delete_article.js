const btn = document.querySelector(".btnDeleteArticle");
const popupDeleteArticle = document.querySelector(".popupDeleteArticle");
const popupBtnDeleteArticle = document.getElementById("popupBtnDeleteArticle");
// toggle_modal_delete_article

if(btn){
    btn.addEventListener("click", () => {
        popupDeleteArticle.classList.toggle('toggle_modal_delete_article');
    });
}

if(popupBtnDeleteArticle){
    popupBtnDeleteArticle.addEventListener("click", () => {
        popupDeleteArticle.classList.remove('toggle_modal_delete_article');

    });
}