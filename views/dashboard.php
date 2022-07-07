<?php
require dirname(__DIR__) . '/functions.php';
require_once PATH_PROJECT . '/connect.php';
define('TITLE', 'Dashboard');
require __DIR__ . '/header.php';

// recap de tous les utilisateurs
// avec leur nom, prénom, pseudo, email, role, nombre d'articles, nombre de commentaires

enabled_access(array('administrator'));
 ?>


    <main class="content">

        <div class="dashboard"></div>
        <h1>Liste des utilisateurs</h1>

        <div id="popup_delete_user_dashboard">
            <p>
                supprimer l'utilisateur : <span id="id_user_dashboard" > </span>
            </p>
            <button id="button-delete_user_dashboard-yes">oui</button>
            <button id="button_delete_user_dashboard-no">non</button>
        </div>

        <div>
            <input id="search_filter" type="text">
            <button id="search_button" >Recherche</button>
        </div>

        <div id="users_dashboard" class="users-dashboard">


        </div>
    </main>
    <script>
        document.getElementById("users_dashboard").innerHTML='vide';

        document.getElementById("search_button").addEventListener('click', () => {
            filter = document.getElementById("search_filter").value
            console.log(filter);
            populate(filter);
        });

        function populate(filter) {
            fetch('../requests/get_users_dashboard.php?' + new URLSearchParams({
                filter: filter,
            }) )
                .then( (raw) => {
                    return raw.json();
                })
                .then((result) => {
                    let append = '';
                    result.forEach(element => {
                        url = "./dashboard_update.php?id=" +element.id;

                        append += "<div class='content_user_dashboard'>";
                             append += "<div class='user_dashboard'>";
                                append += "<div class='content_img_dashboard'>";
                                 append += "<img class='img_dashboard' src='<?php echo HOME_URL . 'assets/img/dist/profil/' ?>"
                                 append += element.file_name;
                                 append += "'>";
                                 append += "</div>";
                                 append += "<div class='content_desc_user'>";
                                    append += "<div class='desc_user_dashboard'>";
                                        append += "<p class='text_dashboard last_name_dashboard'>";
                                        append += "Nom : ";
                                        append += "<span class='span_text_dashboard'>";
                                        append += element.last_name;
                                        append += "</span>";
                                        append += "</p>";
                                        append += "<p class='text_dashboard first_name_dashboard'>";
                                        append += "Prénom : ";
                                        append += "<span class='span_text_dashboard'>";
                                        append += element.first_name;
                                        append += "</span>";
                                        append += "</p>";
                                        append += "<p class='text_dashboard pseudo_dashboard'>";
                                        append += "Pseudo : ";
                                        append += "<span class='span_text_dashboard'>";
                                        append += element.pseudo;
                                        append += "</span>";
                                        append += "</p>";
                                    append += "</div>";
                                    append += "<div class='desc_user_dashboard_2'>";
                                        append += "<p class='text_dashboard email_dashboard'>";
                                        append += "Email : ";
                                        append += "<span class='span_text_dashboard'>";
                                        append += element.email;
                                        append += "</span>";
                                        append += "</p>";
                                        append += "<p class='text_dashboard role_dashboard'>";
                                        append += "Rôle : ";
                                        append += "<span class='span_text_dashboard'>";
                                        append += element.role_name;
                                        append += "</span>";
                                        append += "</p>";
                                    append += "</div>";
                                    append += "<div>";
                                        append += "<div>";
                                            append += "<a href=' "+url+" '><i class='fa-solid fa-pencil'></i></a>";
                                        append += "</div>";
                                        append += "<div>";
                                             append += "<div id_user='";
                                             append += element.id;
                                             append += "' class='button_delete_user_dashboard'>";
                                             append += "<i class='fa-solid fa-trash-can'></i>";
                                             append += "</div>";
                                        append += "</div>";
                                    append += "</div>";
                                append += "</div>";
                             append += "</div>";
                        append += "</div>";
                    })

                    document.getElementById("users_dashboard").innerHTML = append;
                })
                .catch(function(error) {
                    console.log('undefined error');
                })
        }
        populate('');
    </script>
<?php

require PATH_PROJECT . '/views/footer.php';
