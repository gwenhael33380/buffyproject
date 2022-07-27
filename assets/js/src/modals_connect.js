
// Modal to connect home page
const modal_connect = document.querySelector(".modal_connect");
const to_connect = document.getElementById("to_connect");

if(to_connect) {
    to_connect.addEventListener('click', modal_connect, false);
}
const popupBtn = document.getElementById("popup-btn");

if(to_connect) {

    to_connect.addEventListener("click", () => {
        modal_connect.classList.toggle('toggle_modal');
    });
}
if(popupBtn) {

    popupBtn.addEventListener("click", () => {
        modal_connect.style.right = "-700px";
    });
}

// Modal connect side bar 1023px
const modal_connect_side_bar = document.querySelector(".modal_connect_side_bar");
const to_connect_side_bar = document.getElementById("to_connect_side_bar");

if(to_connect_side_bar) {
    to_connect_side_bar.addEventListener('click', modal_connect_side_bar, false);
}
const popupBtn_side_bar = document.getElementById("popup_btn_side_bar");

if(to_connect_side_bar) {

    to_connect_side_bar.addEventListener("click", () => {
        modal_connect_side_bar.style.right.classList.toggle('toggle_modal_side_bar');
        sideBar.classList.remove("active");
    });
}

if(popupBtn_side_bar) {

    popupBtn_side_bar.addEventListener("click", () => {
        modal_connect_side_bar.style.right = "-700px";
    });
}



