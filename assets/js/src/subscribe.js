const first_name_subscribe_input = document.getElementById("first_name_subscribe");
const last_name_subscribe_input = document.getElementById("last_name_subscribe");
const pseudo_subscribe_input = document.getElementById("pseudo_subscribe");
const email_subscribe_input = document.getElementById("email_subscribe");
const password_subscribe_input = document.getElementById("password1");
const password2_subscribe_input = document.getElementById("password2");
const error_first_name_subscribe = document.querySelector(".errorMsgSubscribeFirstName");
const error_last_name_subscribe = document.querySelector(".errorMsgSubscribeLastName");
const error_password_subscribe = document.querySelector(".errorMsgSubscribePassword");
const form = document.querySelector(".form_subscribe");



if (first_name_subscribe_input){


    first_name_subscribe_input.addEventListener("input", () => {

        if (first_name_subscribe_input.value.length < 3) {
            error_first_name_subscribe.textContent = "Le prénom renseignez est trop court !";
            error_first_name_subscribe.style.color = "red";

        } else {
            error_first_name_subscribe.textContent = "";
        }
    });
}

if (last_name_subscribe_input){


    last_name_subscribe_input.addEventListener("input", () => {

        if (last_name_subscribe_input.value.length < 3) {
            error_last_name_subscribe.textContent = "Le nom renseignez est trop court !";
            error_last_name_subscribe.style.color = "red";

        } else {
            error_last_name_subscribe.textContent = "";
        }
    });
}

