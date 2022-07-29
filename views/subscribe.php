<?php


require dirname(__DIR__) . '/functions.php'; //call function.php
require_once PATH_PROJECT . '/connect.php'; //call connect.php

define('TITLE', 'Formulaire d\'inscription'); //title tag definition
define('META_DESCRIPTION', 'Cette page permet à un internaute de s\'inscrire sur le site ByffyProject afin d\'y participer via le blog du site en entrent des informations personnelles. Une fois inscrit, l\'internaute peut immédiatement se connecter et profiter de son statut d\'utilisateur.'); // Define meta description



require __DIR__ . '/header.php'; //call header.php
?>
    <main class="main_subscribe content">
        <div class="bg-img-subscribe"></div>
        <div>
            <?php
            if(isset($_GET['msg'])) {
                echo $_GET['msg'];
            } ?>
        </div>
        <section>
           <div class="content_title_subscribe">
            <h1 class="title-subscribe">Formulaire d'inscription</h1>
            </div>
            <div class="file_form">

<!--                form with the link to the processing of the subscription content-->
                <form class="form-subscribe"action="<?php echo HOME_URL . 'requests/subscribe_post.php'; ?>" method="POST" enctype="multipart/form-data">
                    <div class="field-subscribe">
                        <label class="label-subscribe"f or="first_name">Prénom<span class="red">*</span></label>
                        <input class="input-form-subscribe" type="text" id="first_name" name="first_name" minlength="3" placeholder="Entrez votre prénom...">
                    </div>
                    <div class="field-subscribe">
                        <label class="label-subscribe" for="last_name">Nom<span class="red">*</span></label>
                        <input class="input-form-subscribe" type="text" id="last_name" name="last_name" minlength="3" placeholder="Entrez votre nom...">
                    </div>
                    <div class="field-subscribe">
                        <label class="label-subscribe" for="pseudo">Pseudo<span class="red">*</span></label>
                        <input class="input-form-subscribe" type="text" id="pseudo" name="pseudo" placeholder="Entrez votre pseudo...">
                    </div>
                    <div class="field-subscribe">
                        <label class="label-subscribe" for="email">Email<span class="red">*</span></label>
                        <input class="input-form-subscribe" type="text" id="email" name="email" placeholder="Entrez votre Email...">
                    </div>

                    <div class="field-subscribe">
                        <label class="label-subscribe" for="password">Mot de passe<span class="red">*</span></label>
                        <input class="input-form-subscribe" type="password" id="password" name="password" placeholder="Veuillez choisir votre mot de passe">

                        <!-- Repeat the password twice to verify that it is correct. -->
                        <input class="input-form-subscribe input-margin" type="password" id="password2" name="password2" placeholder="Veuillez retapez votre mot de passe">
                        <p class="text-mdp">Le mot de passe doit comprendre entre 8 et 16 caractères, une majuscule, une minuscule, un chiffre et un caractère spécial, et pas d'espace</p>
                    </div>
                    <div class="field-subscribe flex-label-subscribe">
                        <label class="label-picture-subscribe" for="picture">Ajouter une image à votre profil (Facultatif) au format (jpg, jpeg, png, gif) 1Mo MAX.</label>
                        <input type="hidden" name="MAX_FILE_SIZE" value="1048576"> <!-- 1Mo = 1024*1024 octets -->
                        <input  type="file" id="picture" name="picture" accept="image/*">
                        <div class="current_img"><img></div>


                    </div>
                    <div class="content-button-form-contact">
                    <button class="button-submit-subscribe" type="submit">S'inscrire</button>
                    </div>
                </form>
            </div>
        </section>
    </main>

<?php

//call footer
require __DIR__ . '/footer.php';
