<?php
require dirname(__DIR__) . '/functions.php';
require_once PATH_PROJECT . '/connect.php';
define('TITLE', 'Formulaire d\'inscription');
require __DIR__ . '/header.php';

// les roles qui ont accès à la page
// les autres seront redirigés vers la page HOME
?>
    <main class="main_subscribe">
        <div class="bg-img-subscribe"></div>
        <section>
           <div class="content_title_subscribe">
            <h1 class="title-subscribe">Formulaire d'inscription</h1>
            </div>
            <div class="file_form">
                <form class="form-subscribe"action="<?php echo HOME_URL . 'requests/subscribe_post.php'; ?>" method="POST" enctype="multipart/form-data">
                    <div class="field-subscribe">
                        <label class="label-subscribe"f or="first_name">Prénom<span class="red">*</span></label>
                        <input class="input-form-subscribe" type="text" id="first_name" name="first_name" placeholder="Entrez votre prénom..."E>
                    </div>
                    <div class="field-subscribe">
                        <label class="label-subscribe" for="last_name">Nom<span class="red">*</span></label>
                        <input class="input-form-subscribe" type="text" id="last_name" name="last_name" placeholder="Entrez votre nom...">
                    </div>
                    <div class="field-subscribe">
                        <label class="label-subscribe" for="pseudo">Pseudo<span class="red">*</span></label>
                        <input class="input-form-subscribe" type="text" id="pseudo" name="pseudo" placeholder="Entrez votre psedo...">
                    </div>
                    <div class="field-subscribe">
                        <label class="label-subscribe" for="email">Email<span class="red">*</span></label>
                        <input class="input-form-subscribe" type="text" id="email" name="email" placeholder="Entrez votre Email...">
                    </div>

                    <div class="field-subscribe">
                        <label class="label-subscribe" for="password">Mot de passe<span class="red">*</span></label>
                        <input class="input-form-subscribe" type="password" id="password" name="password" placeholder="Veuillez choisir votre mot de passe">
                        <!-- On répete 2 fois le mot de passe pour vérifier qu'il est exact -->
                        <input class="input-form-subscribe input-margin" type="password" id="password2" name="password2" placeholder="Veuillez retapez votre mot de passe">
                        <p class="text-mdp">Le mot de passe doit comprendre entre 8 et 16 caractères, une majuscule, une minuscule, un chiffre et un caractère spécial, et pas d'espace</p>

                    </div>
                    <div class="field-subscribe flex-label-subscribe">
                        <label class="label-picture-subscribe" for="picture">Ajouter une image au format (jpg, jpeg, png, gif)</label>
                        <input type="hidden" name="MAX_FILE_SIZE" value="1048576"> <!-- 1Mo = 1024*1024 octets -->
                        <input  type="file" id="picture" name="picture" accept="image/*">

                        <?php
                        if(isset($_GET['msg_error'])) {
                            echo $_GET['msg_error'];
                        } ?>

                    </div>
                    <div class="content-button-form-contact">
                    <button class="button-submit-subscribe" type="submit">S'inscrire</button>
                    </div>
                </form>
            </div>
        </section>
    </main>

<?php
require __DIR__ . '/footer.php';
