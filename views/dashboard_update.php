<?php
require dirname(__DIR__) . '/functions.php';
enabled_access(array('administrator'));
require_once PATH_PROJECT . '/connect.php';
define('TITLE', 'Mise a jour d\'un utilisateur');
require __DIR__ . '/header.php';


$id_user = intval($_GET['id']); // si le $_GET n'est pas numerique, il ne pourra pas le transformer en integer

if($id_user) {
    $req = $db->prepare("
		SELECT u.id, u.first_name, u.last_name, u.pseudo, u.email, a.id id_article, a.title, a.content, c.id id_comment, c.comment_content, r.id id_role, p.id as id_image, p.file_name
		FROM user u
		LEFT JOIN article a
		ON u.id = a.id_user
		LEFT JOIN comment c
		ON u.id = c.id_user
		INNER JOIN role r
		ON u.id_role = r.id
		LEFT JOIN picture p
	    ON u.id_image = p.id
		WHERE u.id = :id
	");
    $req->bindValue(':id', $id_user, PDO::PARAM_INT);

    $req->execute();

    $users = $req->fetchAll(PDO::FETCH_OBJ);
}
$id_user = 0;
// $repeat = TRUE;
?>
    <main class="main-user-update-dashboard content">
        <div class="bg-img-user-update-dashboard"></div>
        <div class="content-title-update-user-dashboard">
            <h1 class="title_dashboard">Formulaire de mise à jour de <?php echo sanitize_html($users[0]->first_name . ' ' . $users[0]->last_name); ?></h1>
        </div>



        <?php

        // recupération des roles
        $req = $db->query("
		SELECT *
		FROM role
	");

        $roles = $req->fetchAll(PDO::FETCH_OBJ);

        foreach($users as $user) :
            if($id_user != $user->id) : // afficher un nouveau formulaire à chaque utilisateur
                $id_user = $user->id;
                // if($repeat) : 			// affichera un seul formulaire
                // 	$repeat = FALSE;
                ?>

                <div class="file_form_user_update_dashboard">
                    <form action="<?php echo HOME_URL . 'requests/dashboard_update_post.php'; ?>" method="POST" enctype="multipart/form-data">
                        <div class="flex-form-user-update-dashboard">
                            <label class="label-user-update-dashboard" for="first_name">Prénom </label>
                            <input type="hidden" name="id_user" value="<?php echo $user->id; ?>">
                            <input class="input-user-update-dashboard" type="text" id="first_name" name="first_name" value="<?php echo sanitize_html($user->first_name); ?>" required>
                        </div>
                        <div class="flex-form-user-update-dashboard">
                            <label class="label-user-update-dashboard" for="last_name">Nom </label>
                            <input class="input-user-update-dashboard" type="text" id="last_name" name="last_name" value="<?php echo sanitize_html($user->last_name); ?>" required>
                        </div>
                        <div class="flex-form-user-update-dashboard">
                            <label class="label-user-update-dashboard" for="pseudo">Pseudo </label>
                            <input type="hidden" name="initial_pseudo" value="<?php echo sanitize_html($user->pseudo); ?>" required>
                            <input class="input-user-update-dashboard" type="text" id="pseudo" name="pseudo" value="<?php echo sanitize_html($user->pseudo); ?>" required>
                        </div>
                        <div class="flex-form-user-update-dashboard">
                            <label class="label-user-update-dashboard" for="email">Email </label>
                            <input type="hidden" name="initial_email" value="<?php echo sanitize_html($user->email); ?>" required>
                            <input class="input-user-update-dashboard" type="text"  name="email" value="<?php echo sanitize_html($user->email); ?>" required>
                        </div>
                        <div class="flex-form-user-update-dashboard">
                            <label class="label-user-update-dashboard" for="password">Modifié le mot de passe </label>
                            <input  class="input-user-update-dashboard" type="password"  name="password" autocomplete="new-password" placeholder="Entrez le nouveau mot de passe...">
                            <!-- On répete 2 fois le mot de passe pour vérifier qu'il est exact -->
                            <input class="input-user-update-dashboard" type="password" id="password2" name="password2" placeholder="Retapez votre mot de passe...">
                            <p class="text-mdp-user-update">Mot de passe entre 8 et 16 caractères, une majuscule, une minuscule, un chiffre et un caractère spécial, et pas d'espace</p>
                        </div>

                        <div class="flex-form-user-update-dashboard">
                            <label class="label-user-update-dashboard" for="role_select">Role</label>
                            <select class="input-user-update-dashboard" name="role" id="role">
                                <?php foreach ($roles as $role): ?>
                                    <option value="<?php echo $role->id ?>" <?php if($role->id == $user->id_role) echo 'selected'; ?> ><?php echo $role->role_name; ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div class="content-change-img-user-update-dashboard">
                        <div class="current_img">
                            <img class="current-img-user-update-dashboard" src="<?php echo HOME_URL . 'assets/img/dist/profil/' . sanitize_html($user->file_name); ?>" alt="Image de profil actuel">
                        </div>
                            <div class="content-label-picture-dashboard">
                                <input type="hidden" name="id_image" value="<?php echo $user->id_image; ?>">
                                <input type="hidden" name="initial_image" value="<?php echo sanitize_html($user->file_name); ?>">
                                <input type="hidden" name="MAX_FILE_SIZE" value="1048576"> <!-- 1Mo = 1024*1024 octets -->
                                <input type="file" id="picture" name="picture" accept="image/*">
                                <label class="label-update-picture" for="picture">Ajouter une image (jpg, jpeg, png, gif) 1 Mo Max<span class="red">*</span></label>
                            </div>
                        </div>
                        <div class="content-button-submit-dashboard">
                            <button class="button-submit-update-user-dashboard" type="submit">Mettre à jour l'utilisateur</button>
                        </div>
                    </form>
                </div>
            <?php
            endif;
        endforeach;?>
    </main>
<?php
require __DIR__ . '/footer.php';
