<?php
// mise à jour de l'utilisateur courant
// avec leur nom, prénom, pseudo, email, role,  lien vers les articles (update) et rajout de bouton de suppression (si admin), lien vers les commentaires (update) et rajout de bouton de suppression (si admin)
require dirname(__DIR__) . '/functions.php';
require_once PATH_PROJECT . '/connect.php';
define('TITLE', 'Mise à jour du profil');
require __DIR__ . '/header.php';

//enabled_access(array('administrator'));
$id_user = intval($_GET['id']); // si le $_GET n'est pas numerique, il ne pourra pas le transformer en integer
if ($_SESSION['role_slug'] == administrator){
    $id_user = intval($_GET['id']);
}
else {
    $id_user = intval($_SESSION['id_user']);
}
if($id_user) {
    $req = $db->prepare("
		SELECT u.id, u.first_name, u.last_name, u.pseudo, u.email, u.id_image, a.id id_article, a.title, a.content, c.id id_comment, c.comment_content, i.id as id_image, i.file_name
		FROM users u
		LEFT JOIN articles a
		ON u.id = a.id_user
		LEFT JOIN comments c
		ON u.id = c.id_user
		INNER JOIN roles r
		ON u.id_role = r.id
		LEFT JOIN images i
	    ON u.id_image = i.id
		WHERE u.id = :id
	");
    $req->bindValue(':id', $id_user, PDO::PARAM_INT);
    $req->execute();

    $user = $req->fetch(PDO::FETCH_OBJ);
}


// $repeat = TRUE;
?>

    <main class="main-user-update">
        <div class="bg-img-user-update"></div>
            <div class="content-title-user-update">
                 <h1 class="title-form-update">Formulaire de mise à jour de <?php echo sanitize_html($user->first_name); ?></h1>
            </div>

        <?php
        $articles = array();
        $comments = array();
        ?>
        <div class="file_form">
            <form action="<?php echo HOME_URL . 'requests/user_update_post.php'; ?>" method="POST" enctype="multipart/form-data">
                <div class="flex-form-user-update">
                    <label class="label-user-update" for="first_name">Prénom </label>
                    <input class="input-user-update" type="text" id="first_name" name="first_name" value="<?php echo sanitize_html($user->first_name); ?>">
                </div>
                <div class="flex-form-user-update">
                    <label class="label-user-update" for="last_name">Nom </label>
                    <input class="input-user-update" type="text" id="last_name" name="last_name" value="<?php echo sanitize_html($user->last_name); ?>">
                </div>
                <div class="flex-form-user-update">
                    <label class="label-user-update" for="pseudo">Pseudo </label>
                    <input type="hidden" name="initial_pseudo" value="<?php echo sanitize_html($user->pseudo); ?>">
                    <input class="input-user-update" type="text" id="pseudo" name="pseudo" value="<?php echo sanitize_html($user->pseudo); ?>">
                </div>
                <div class="flex-form-user-update">
                    <label class="label-user-update" for="email">Email </label>
                    <input type="hidden" name="initial_email" value="<?php echo sanitize_html($user->email); ?>">
                    <input class="input-user-update" type="text" id="email" name="email" value="<?php echo sanitize_html($user->email); ?>">
                </div>

                <div class="flex-form-user-update">
                    <label class="label-user-update" for="password">Modifié le mot de passe </label>
                    <input class="input-user-update" type="password" id="password" name="password" autocomplete="new-password" placeholder="Entrez le nouveau mot de passe...">
                    <!-- On répete 2 fois le mot de passe pour vérifier qu'il est exact -->
                    <input class="input-user-update" type="password" id="password2" name="password2" placeholder="Retapez votre mot de passe...">
                    <p class="text-mdp-user-update">Mot de passe entre 8 et 16 caractères, une majuscule, une minuscule, un chiffre et un caractère spécial, et pas d'espace</p>

                </div>

                <div class="content-change-img-user-update">

                    <input type="hidden" name="id_image" value="<?php echo $user->id_image; ?>">
                    <input type="hidden" name="initial_image" value="<?php echo sanitize_html($user->file_name); ?>">
                    <input type="hidden" name="MAX_FILE_SIZE" value="1048576"> <!-- 1Mo = 1024*1024 octets -->
                    <input type="file" id="picture" name="picture" accept="image/*">
                    <label class="label-update-picture" for="picture">Ajouter une image (jpg, jpeg, png, gif)</label>



                    <div class="current_img"><img src="<?php echo IMG_URL . 'dist/profil/' . sanitize_html($user->file_name); ?>"alt=""></div>
                </div>
                <div  class="content-button-submit">
                    <input type="hidden" name="id_user" value="<?php echo $user->id; ?>">
                    <button class="button-submit-user_update" type="submit">Mettre à jour l'utilisateur</button>
                </div>
            </form>
        </div>
        <?php

        if($user->id_article != NULL) :
            // ouverture du buffer (mise en cache)
            ob_start(); ?>
            <div class="article">
                <div>
                    <p><?php echo sanitize_html($user->title); ?></p>
                    <p>Résumé : <?php echo sanitize_html($user->content); ?></p>
                </div>

                <div>
                    <!-- update article -->
                    <a href="<?php echo HOME_URL . 'views/update_article.php?id=' . $user->id_article; ?>"><i class="fa-solid fa-pencil"></i></a>

                    <!-- delete article -->
                    <a class="delete_article" href="<?php echo HOME_URL . 'requests/delete_article_post.php?id=' . $user->id_article; ?>"><i class="fa-solid fa-trash-can"></i></a>
                </div>
            </div>
            <?php
            // récupération du buffer et stockage dans une variable
            $articles[] = ob_get_clean();
        endif;
        if($user->id_comment != NULL) :
            ob_start(); ?>
            <div class="comment">
                <p>Commentaire : <?php echo sanitize_html($user->comment_content); ?></p>
                <div>
                    <!-- update comment -->
                    <a href="<?php echo HOME_URL . 'views/comment_update.php?id=' . $user->id_comment; ?>"><i class="fa-solid fa-pencil"></i></a>

                    <!-- delete comment -->
                    <a class="delete_comment" href="<?php echo HOME_URL . 'requests/delete_comment_post.php?id=' . $user->id_comment; ?>"><i class="fa-solid fa-trash-can"></i></a>
                </div>

            </div>
            <?php
            $comments[] = ob_get_clean();
        endif;


        // var_dump($articles);
        // var_dump($comments);

        ?>
        <?php if(!empty($articles)) : ?>
            <div class="articles">
                <h2>Les articles</h2>
                <?php
                foreach($articles as $article) :
                    echo $article;
                endforeach; ?>
            </div>
        <?php endif; ?>
        <?php if(!empty($comments)) : ?>
            <div class="comments_dashboard">
                <h2>Les commentaires</h2>
                <?php
                foreach($comments as $comment) :
                    echo $comment;
                endforeach; ?>
            </div>
        <?php
        endif; ?>
    </main>
<?php
//include PATH_PROJECT . '/views/pop_up_delete.php';
require __DIR__ . '/footer.php';
