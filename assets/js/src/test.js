const popupBtnDeleteUserDashboard = document.getElementsByClassName("button_delete_user_dashboard");

document.getElementById("button-delete_user_dashboard-yes").addEventListener("click", (evt) => {
    const id = document.getElementById("id_user_dashboard");
    console.log(id.textContent);

});

// document.getElementById("button-delete_user_dashboard-no").addEventListener("click", (evt) => {
// });


for ( let i = 0; i < popupBtnDeleteUserDashboard.length; i++ ){
    console.log('hello');

     popupBtnDeleteUserDashboard[i].addEventListener("click", (evt) => {
        let elt = evt.currentTarget;
         console.log(elt);

         let id = elt.getAttribute("id_user");
         document.getElementById("id_user_dashboard").innerHTML=id
         console.log(id);
         // console.log('cpicpi');
//     // popup.style.left = "50%";
//     // console.log(btn3);
});
}