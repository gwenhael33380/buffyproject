const button_alert_delete_user = document.querySelector(".delete_user_prohibited_alert");
const button_alert_update_user = document.querySelector(".update_user_prohibited_alert");

if(button_alert_delete_user) {
    button_alert_delete_user.addEventListener("click", () => {
        alert('Pour des raison de sécurité du site, vous ne pouvez pas modifié ou supprimer ce profil. ' +
            '\n' +
            'Pour plus d\'informations ou toute demande relative à la gestion de ce compte, Merci d\'envoyer un mail à l\'adresse mentionner sur cette dernière. . ' +
            '\n' +
            '\n' +
            'Merci de votre compréhention.');
    });
}

if(button_alert_update_user) {
    button_alert_update_user.addEventListener("click", () => {
        alert('Pour des raison de sécurité du site, vous ne pouvez pas modifié ou supprimer ce profil. ' +
            '\n' +
            'Pour plus d\'informations ou toute demande relative à la gestion de ce compte, Merci d\'envoyer un mail à l\'adresse mentionner sur le profil de ce compte. ' +
            '\n' +
            '\n' +
            'Merci de votre compréhention.');
    });
}