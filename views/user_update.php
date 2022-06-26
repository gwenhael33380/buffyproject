<?php

//current user update with their surname, first name, nickname, email, role, password and profile picture

//call the functions file
require dirname(__DIR__) . '/functions.php';


//call the connect file
require_once PATH_PROJECT . '/connect.php';

//define balise title
define('TITLE', 'Mise à jour du profil');
//Call the header.php file containing the nav bar
require __DIR__ . '/header.php';

//define the roles with access to the update page, this referred to the function.php file
enabled_access(array('administrator', 'editor', 'user'));


//user id definition
$id_user = intval($_GET['id']); // I transform the $_GET into an integer with the intval() function, otherwise it cannot be interpreted as an integer

if ($_SESSION['role_slug'] == 'administrator'){
    $id_user = intval($_GET['id']);
}
else {
    $id_user = intval($_SESSION['id_user']);
}

//
//if the user id is present, then a prepared query is made in the database
//
// !!! the prepared query is mandatory because it includes variables. !!!
if($id_user) {
    $req = $db->prepare("
		SELECT u.id, u.first_name, u.last_name, u.pseudo, u.email, u.id_image, i.id as id_image, i.file_name
		FROM users u
		LEFT JOIN images i
	    ON u.id_image = i.id
		WHERE u.id = :id
	");

//    I bind the values of the query
    $req->bindValue(':id', $id_user, PDO::PARAM_INT);

//    I execute the request
    $req->execute();

//    I will look for a single result of the query
    $user = $req->fetch(PDO::FETCH_OBJ);
}



?>
<!--source code of user_update.php with use of query results and sanitize_html() "this referred to file function.php" which converts special characters into HTML entities.

It also helps to protect against the XSS flaw -->

    <main class="main-user-update content">
        <div class="bg-img-user-update"></div>
            <div class="content-title-user-update">
                 <h1 class="title-form-update">Formulaire de mise à jour de <?php echo sanitize_html($user->first_name); ?></h1>
            </div>
        <div class="file_form_user_update">
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
                    <div class="current_img"><img src="<?php echo IMG_URL . 'dist/profil/' . sanitize_html($user->file_name); ?>"alt="image de votre profil avant la mise a jour"></div>
                    <input type="hidden" name="id_image" value="<?php echo $user->id_image; ?>">
                    <input type="hidden" name="initial_image" value="<?php echo sanitize_html($user->file_name); ?>">
                    <input type="hidden" name="MAX_FILE_SIZE" value="1048576">
                    <input type="file" id="picture" name="picture" accept="image/*">
                    <label class="label-update-picture" for="picture">Ajouter une image (jpg, jpeg, png, gif)</label>
                </div>
                <div  class="content-button-submit">
                    <input type="hidden" name="id_user" value="<?php echo $user->id; ?>">
                    <button class="button-submit-user_update" type="submit">Mettre à jour l'utilisateur</button>
                </div>
            </form>
        </div>



    </main>
<?php
//Call the footer.php file containing the footer
require __DIR__ . '/footer.php';
