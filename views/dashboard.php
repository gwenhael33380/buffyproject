<?php
require dirname(__DIR__) . '/functions.php';
require_once PATH_PROJECT . '/connect.php';
define('TITLE', 'Dashboard');
require __DIR__ . '/header.php';

// recap de tous les utilisateurs
// avec leur nom, prénom, pseudo, email, role, nombre d'articles, nombre de commentaires

enabled_access(array('administrator'));
//
//$req = $db->query("
//	SELECT DISTINCT COUNT(c.id) count_comment, COUNT(a.id) count_article, u.*, r.id id_role, r.role_name, r.role_slug, a.id id_article, c.id id_comment, i.id as id_image, i.file_name
//	FROM users u
//	LEFT JOIN roles r
//	ON u.id_role = r.id
//	LEFT JOIN articles a
//	ON a.id_user = u.id
//	LEFT JOIN comments c
//	ON c.id_user = u.id
//	LEFT JOIN images i
//	ON u.id_image = i.id
//	GROUP BY u.id
//	ORDER BY r.id ASC
//");
//$req->execute();
//$results = $req->fetchAll(PDO::FETCH_OBJ); ?>


    <main class="content">
        <div class="dashboard"></div>
        <h1>Liste des utilisateurs</h1>
        <div>
            <input id="search_filter" type="text">
            <button id="search_button" >Search</button>
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
            fetch('../requests/get_users.php?' + new URLSearchParams({
                filter: filter,
            }) )
                .then( (raw) => {
                    return raw.json();
                })
                .then((result) => {
                    let append = '';
                    result.forEach(element => {
                        append += "<div>";
                        append += "<span class='left_name' >";
                        append += element.first_name;
                        append += "</span>";
                        append += "<span class='right_name'>";
                        append += element.last_name;
                        append += "</span>";
                        append += "<span class='image_path'>";
                        append += "<img src='<?php echo HOME_URL . 'assets/img/dist/profil/' ?>"
                        append += element.file_name;
                        append += "'>";
                        append += "</span>";
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
