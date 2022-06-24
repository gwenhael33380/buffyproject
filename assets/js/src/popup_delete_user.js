const btn3 = document.querySelector(".btnDeleteProfil");
const popup = document.querySelector(".popup");
const popupBtnDeleteUser = document.getElementById("popupBtnDeleteUser");


if(btn3){
    btn3.addEventListener("click", () => {
        popup.style.left = "50%";
        console.log(btn3);
    });
}

if(popupBtnDeleteUser){
    popupBtnDeleteUser.addEventListener("click", () => {
        popup.style.left = "-700px";
        console.log(popupBtn);
    });
}


