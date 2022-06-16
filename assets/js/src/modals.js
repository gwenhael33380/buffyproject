

// Modal to connect home page
const modal_connect = document.querySelector(".modal_connect");
const to_connect = document.getElementById("to_connect");

if(to_connect) {
    to_connect.addEventListener('click', modal_connect, false);
}
const popupBtn = document.getElementById("popup-btn");

if(to_connect) {

    to_connect.addEventListener("click", () => {
        modal_connect.style.right = "37%";
    });
}
if(popupBtn) {

    popupBtn.addEventListener("click", () => {
        modal_connect.style.right = "-1500px";
    });
}


// modal delete article blog page
function open_modal_delete(elt) {
    console.log(elt.id);
    document.getElementById('modal_delete_article').style.right = '37%';
    document.getElementById('article_id').innerHTML=elt.id;

}
function close_modal_and_cancel_delete() {
    document.getElementById('modal_delete_article').style.right = '+10%';


}
function close_modal_and_do_delete() {
    document.getElementById('modal_delete_article').style.right = '+10%';


}
