const btn = document.querySelector(".btnDeleteArticle");
const popupDeleteArticle = document.querySelector(".popupDeleteArticle");
const popupBtnDeleteUser = document.getElementById("popupBtnDeleteArticle");


if(btn){
    btn.addEventListener("click", () => {
        popupDeleteArticle.style.left = "50%";
        console.log(btn);
    });
}

if(popupBtnDeleteUser){
    popupBtnDeleteUser.addEventListener("click", () => {
        popupDeleteArticle.style.left = "-700px";
        console.log(popupBtn);
    });
}