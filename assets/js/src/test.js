function filter(pattern) {
    // l'utilisateur a entré son filtre
    // il peut ajouter des jokers '*'
    // ils sont convertis en expression régulière
    let regexp = '';
    for(let c of pattern) {
        if(c=='*')
            regexp += '(.*)';
        else
            regexp += c;
    }

    // on sélectionne toutes les divs 'user'
    const users = document.querySelectorAll('.user');
    users.forEach(user => {
        console.log("--- "+pattern);
        // par défaut elles sont, pour l'instant, visibles
        user.style.display = 'block';
        // mais cachées si pas volontairement montrées
        let flag = false;
        // on parcourt tous les 'spans' de la 'div' courante
        for( child of user.children) {
            console.log("+++ " + regexp);
            // on applique l'expression régulière
            let str = child.innerText.match(new RegExp(regexp,'i'));
            // s'il y a un match
            if(str != null) {
                console.log("filtered : " + str + "/" + child.innerText);
                // la 'div' parente mérite d'être vue
                flag = true;
                // pas la peine d'aller plus loin
                break;
            }
        }
        // aucune 'span' n'a matché
        // la div courante est masquée
        if(flag == false) {
            user.style.display = 'none';
        }
    });
}

const filter_field = document.getElementById('filter');
filter_field.addEventListener("keyup", function() {
    console.log("Filter " + this.value);
    filter(this.value);
});

console.log('coucou');