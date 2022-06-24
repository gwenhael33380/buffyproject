

// Modal to connect home page
const modal_connect = document.querySelector(".modal_connect");
const to_connect = document.getElementById("to_connect");

if(to_connect) {
    to_connect.addEventListener('click', modal_connect, false);
}
const popupBtn = document.getElementById("popup-btn");

if(to_connect) {

    to_connect.addEventListener("click", () => {
        modal_connect.style.right = "30%";
    });
}
if(popupBtn) {

    popupBtn.addEventListener("click", () => {
        modal_connect.style.right = "-700px";
    });
}


