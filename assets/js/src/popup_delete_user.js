const btn3 = document.querySelector(".btnDeleteProfil");
const content_popup = document.querySelector(".popup");
const popupBtnDeleteUser = document.getElementById("popupBtnDeleteUser");


if(btn3){
    btn3.addEventListener("click", () => {
        content_popup.classList.toggle('toggle_modal_delete_user');
        console.log(btn3);
    });
}

if(popupBtnDeleteUser){
    popupBtnDeleteUser.addEventListener("click", () => {
        content_popup.classList.remove('toggle_modal_delete_user');
        console.log(popupBtn);
    });
}


