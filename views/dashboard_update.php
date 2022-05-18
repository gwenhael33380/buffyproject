<?php
// mise à jour de l'utilisateur courant
// avec leur nom, prénom, pseudo, email, role,  lien vers les articles (update) et rajout de bouton de suppression (si admin), lien vers les commentaires (update) et rajout de bouton de suppression (si admin)

require __DIR__ . '/header.php';
require_once PATH_PROJECT . '/connect.php';
enabled_access(array('administrator'));
$id_user = intval($_GET['id']); // si le $_GET n'est pas numerique, il ne pourra pas le transformer en integer

if($id_user) {
    $req = $db->prepare("
		SELECT u.id, u.first_name, u.last_name, u.pseudo, u.email, a.id id_article, a.title, a.content, c.id id_comment, c.comment_content, r.id id_role, i.id as id_image, i.file_name
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

    $users = $req->fetchAll(PDO::FETCH_OBJ);



    var_dump($users);




}
$id_user = 0;
// $repeat = TRUE;
?>

    <h1 class="title_dashboard">Formulaire de mise à jour de <?php echo sanitize_html($users[0]->first_name . ' ' . $users[0]->last_name); ?></h1>
    <main>

        <?php
        $articles = array();
        $comments = array();

        // recupération des roles
        $req = $db->query("
		SELECT *
		FROM roles
	");
        $roles = $req->fetchAll(PDO::FETCH_OBJ);
        foreach($users as $user) :
            if($id_user != $user->id) : // afficher un nouveau formulaire à chaque utilisateur
                $id_user = $user->id;
                // if($repeat) : 			// affichera un seul formulaire
                // 	$repeat = FALSE;
                ?>
                <div class="file_form">
                    <form action="<?php echo HOME_URL . 'requests/dashboard_update_post.php'; ?>" method="POST" enctype="multipart/form-data">
                        <div>
                            <label for="first_name">Prénom</label>
                            <input type="text" id="first_name" name="first_name" value="<?php echo sanitize_html($user->first_name); ?>">
                        </div>
                        <div>
                            <label for="last_name">Nom</label>
                            <input type="text" id="last_name" name="last_name" value="<?php echo sanitize_html($user->last_name); ?>">
                        </div>
                        <div>
                            <label for="pseudo">Pseudo</label>
                            <input type="text" id="pseudo" name="pseudo" value="<?php echo sanitize_html($user->pseudo); ?>">
                        </div>
                        <div>
                            <label for="email">Email</label>
                            <input type="text" id="email" name="email" value="<?php echo sanitize_html($user->email); ?>">
                        </div>
                        <div>
                            <label for="role">Role</label>
                            <select name="role" id="role">
                                <?php foreach ($roles as $role): ?>
                                    <option value="<?php echo $role->id ?>" <?php if($role->id == $user->id_role) echo 'selected'; ?>><?php echo $role->role_name; ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div>
                            <label for="picture">Modifié l'image (jpg, jpeg, png, gif)</label>
                            <input type="hidden" name="MAX_FILE_SIZE" value="1048576"> <!-- 1Mo = 1024*1024 octets -->
                            <input type="file" id="picture" name="picture" accept="image/*">
                            <!-- TYPE MIME -->
                            <!-- https://developer.mozilla.org/fr/docs/Web/HTTP/Basics_of_HTTP/MIME_types/Common_types -->
                            <!-- https://developer.mozilla.org/fr/docs/Web/HTML/Attributes/accept -->

                            <!-- si plusieurs fichiers à récupérer en même temps -->
                            <!-- <input type="file" id="picture" name="picture[]" multiple> -->


                        </div>

                        <input type="hidden" name="id_user" value="<?php echo $user->id; ?>">
                        <button type="submit">Mettre à jour l'utilisateur</button>
                    </form>
                </div>
            <?php
            endif;
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

        endforeach;
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
