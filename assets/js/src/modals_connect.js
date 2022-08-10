
// Modal to connect


// sideBar is a constant present in the document side-bar.js

const modal_connect = document.querySelector(".modal_connect");
const to_connect = document.querySelectorAll(".to_connect");
const popupBtn = document.getElementById("popup-btn");
const cross_btn = document.querySelector(".param_cross")


to_connect.forEach((modals_connect) => {
    modals_connect.addEventListener('click', () => {
        modal_connect.classList.toggle('toggle_modal');
        sideBar.classList.remove("active");
    });

    popupBtn.addEventListener("click", () => {
        modal_connect.classList.remove("toggle_modal");


    });
    cross_btn.addEventListener("click", () => {
        modal_connect.classList.remove("toggle_modal");


    });
});








