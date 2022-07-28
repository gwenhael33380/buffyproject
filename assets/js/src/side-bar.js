const sideBar = document.querySelector("#side-bar");
const content = document.querySelector(".content");
const btn = document.querySelector("#btnSideBar");
if (btn){
    btn.addEventListener("click", () => {
        sideBar.classList.toggle("active");
        console.log(btn);
        console.log(sideBar)
    });

}
if (content){
    content.addEventListener("click", () => {
        sideBar.classList.remove("active");
    });
}




