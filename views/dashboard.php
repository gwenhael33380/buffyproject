<?php
require dirname(__DIR__) . '/functions.php';
require_once PATH_PROJECT . '/connect.php';
define('TITLE', 'Dashboard');
require __DIR__ . '/header.php';

// recap de tous les utilisateurs
// avec leur nom, prénom, pseudo, email, role, nombre d'articles, nombre de commentaires

enabled_access(array('administrator'));

$req = $db->query("
	SELECT DISTINCT COUNT(c.id) count_comment, COUNT(a.id) count_article, u.*, r.id id_role, r.role_name, r.role_slug, a.id id_article, c.id id_comment, i.id as id_image, i.file_name
	FROM users u
	LEFT JOIN roles r
	ON u.id_role = r.id
	LEFT JOIN articles a
	ON a.id_user = u.id
	LEFT JOIN comments c
	ON c.id_user = u.id
	LEFT JOIN images i
	ON u.id_image = i.id
	GROUP BY u.id
	ORDER BY r.id ASC
");
$req->execute();
$results = $req->fetchAll(PDO::FETCH_OBJ); ?>

    <style type="text/css">
        .highlighted{
            background-color: #2BA6CB; color:#FFF
        }
    </style>


    <main class="content">
        <div class="dashboard"></div>
        <h1>Liste des utilisateurs</h1>
        <label for="">Filtrer les pseudos</label>
        <input type="text" name="category" id="categoryFilter" placeholder="Trouver un utilisateur">
        <div id="filter" class="users-dashboard filter side-nav">

            <?php foreach($results as $result) :
                $count_article = $result->count_article;
                $count_comment = $result->count_comment; ?>
                <div class="user">
                    <div class="user_left">

                        <!--                        sanitize_html permet d'évité l'injection SQL-->
<!--                        <img class="img-user-profil-dashboard" src=" --><?php //echo HOME_URL.'assets/img/dist/profil/' . sanitize_html($result->file_name); ?><!--">-->
                        <p class="info-user-dashboard">Nom : <?php echo sanitize_html($result->last_name); ?></p>
                        <p class="info-user-dashboard">Prénom : <?php echo sanitize_html($result->first_name); ?></p>
                        <p class="info-user-dashboard">Pseudo : <span id="search_pseudo"><?php echo sanitize_html($result->pseudo); ?></span></p>
                        <p class="info-user-dashboard">Email : <?php echo sanitize_html($result->email); ?></p>
                        <p class="info-user-dashboard">Rôle : <?php echo $result->role_name; ?></p>

                        <p class="info-user-dashboard">Nombre article<?php echo plural($count_article); ?> : <?php echo $count_article; ?></p>
                        <p class="info-user-dashboard">Nombre de commentaire<?php echo plural($count_comment); ?> : <?php echo $count_comment; ?></p>
                    </div>
                    <div class="user_right">
<p></p>
                        <!-- mise à jour de l'utilisateur -->
                        <a href="<?php echo HOME_URL . 'views/dashboard_update.php?id=' . $result->id; ?>"><i class="fa-solid fa-pencil"></i></a>

                        <!-- suppression de l'utilisateur -->
                        <a class="delete_user" href="<?php echo HOME_URL . 'requests/dashboard_delete_post.php?id=' . $result->id; ?>"><i class="fa-solid fa-trash-can"></i></a>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </main>

<?php

require PATH_PROJECT . '/views/footer.php';
