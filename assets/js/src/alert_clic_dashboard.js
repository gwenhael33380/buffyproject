const button_alert_delete_user = document.querySelector(".delete_user_prohibited_alert");

if(button_alert_delete_user) {
    button_alert_delete_user.addEventListener("click", () => {
        alert('Pour des raison de sécurité du site, vous ne pouvez pas supprimer votre propre profil. ' +
            '\n' +
            'Merci de vous référé à un autre administrateur afin de mettre fin à votre activité sur notre site. Merci de votre compréhension. ' +
            '\n' +
            '\n' +
            'Nous somme toutefois reconnaissant pour votre contribution au développement de notre site');
    });
}