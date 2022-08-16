const sideBar = document.querySelector("#side-bar");
const content = document.querySelector(".content");
const btn = document.querySelector("#btnSideBar");

    btn.addEventListener("click", (event) => {
        event.preventDefault();
        sideBar.classList.toggle("active");
    });



    content.addEventListener("click", (event) => {
        event.preventDefault();
        sideBar.classList.remove("active");
    });





