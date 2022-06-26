

const modal_connect_side_bar = document.querySelector(".modal_connect_side_bar");
const to_connect_side_bar = document.getElementById("to_connect_side_bar");

if(to_connect_side_bar) {
    to_connect_side_bar.addEventListener('click', modal_connect_side_bar, false);
}
const popupBtn_side_bar = document.getElementById("popup_btn_side_bar");

if(to_connect_side_bar) {

    to_connect_side_bar.addEventListener("click", () => {
        modal_connect_side_bar.style.right = "4%";
        sideBar.classList.remove("active");
    });
}

if(popupBtn_side_bar) {

    popupBtn_side_bar.addEventListener("click", () => {
        modal_connect_side_bar.style.right = "-700px";
    });
}


