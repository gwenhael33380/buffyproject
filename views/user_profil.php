<?php

require dirname(__DIR__) . '/functions.php';
require_once PATH_PROJECT . '/connect.php';
require PATH_PROJECT . '/views/header.php';
$msg_not_connect = '<div class="red">vous n\'êtes pas connecté</div>';
$user_id = ($_SESSION['id_user']);




if(empty($user_id)){
    header('Location:' . HOME_URL . '?msg=' . $msg_not_connect);

}

$req = $db->prepare("
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
	WHERE u.id = ?
	GROUP BY u.id
	ORDER BY r.id ASC
");

$req->execute(array($user_id));
$result = $req->fetch(PDO::FETCH_OBJ); ?>

    <main>
        <div class="bg-page-profil"></div>
        <div class="content-space-personel">
            <h1 class="space-personel">espace personnel</h1>
        </div>
        <div class="content-profil-user">
            <div class="profil_user">
                <h2 class="title-first-name">Bonjour <?php echo sanitize_html($result->first_name); ?></h2>
            </div>
        </div>
        <div class="users">
            <?php  $count_article = $result->count_article;
            $count_comment = $result->count_comment; ?>
            <div class="user">
                <div class="user_left">
                    <!--                   sanitize_html -> élimine la faille XSS-->
                    <div class="content-img-profil">
                        <img class="img-profil" src=" <?php echo HOME_URL .'assets/img/dist/profil/' . sanitize_html($result->file_name); ?>">
                    </div>
                    <p class="information-user"><span class="span-information-user">Nom</span> : <?php echo sanitize_html($result->last_name); ?></p>
                    <p class="information-user"><span class="span-information-user">Prénom</span> : <?php echo sanitize_html($result->first_name); ?></p>
                    <p class="information-user"><span class="span-information-user">Pseudo</span> : <?php echo sanitize_html($result->pseudo); ?></p>
                    <p class="information-user"><span class="span-information-user">Email</span> : <?php echo sanitize_html($result->email); ?></p>
                    <p class="information-user"><span class="span-information-user">Rôle</span> : <?php echo $result->role_name; ?></p>
                    <!--                    La fonction plural permet de mettre au pluriel si supperieur a 1 -->
                    <p class="information-user"><span class="span-information-user">Nombre article</span> <?php echo plural($count_article); ?> : <?php echo $count_article; ?></p>
                    <p class="information-user"><span class="span-information-user">Nombre de commentaire</span> <?php echo plural($count_comment); ?> : <?php echo $count_comment; ?></p>
                </div>
                <div class="user_right">

                    <!-- Mettre a jour l'utilisateur -->
                    <div class="content-button-profil">
                        <a class="button-modifie-profil"href="<?php echo HOME_URL . 'views/user_update.php?id=' . $result->id; ?>">modifier le profil</a>

                    </div>
                    <div class="content-button-profil2">
                        <a class="button-delete_user" href="<?php echo HOME_URL . 'requests/users_delete_post.php?id=' . $result->id; ?>">supprimer le profil</i></a>

                    </div>
                    <!-- Suppression de l'utilisateur -->
                </div>

            </div>

        </div>
    </main>































<?php
require __DIR__ . '/footer.php';
