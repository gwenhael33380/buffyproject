<?php


require dirname(__DIR__) . '/functions.php'; //call function.php
enabled_access(array('administrator', 'editor', 'user')); //enabled targeted role access
require_once PATH_PROJECT . '/connect.php'; //call connect.php

define('TITLE', 'Ajout d\'un commentaire'); //define balise title
define('META_DESCRIPTION', 'page permettant d\'ajouter un commentaire via un formulaire. Une fois ce dernier rempli la soumission permet d\'ajouter un commentaire à la page de l\'article concerné. L\'accessibilité est réservée aux personnes ayant créé un compte et étant connectée au site.'); // Define meta description


//call header.php
require __DIR__ . '/header.php';

$id_article = intval($_GET['id']); //if the $_GET is not numeric, it will not be able to transform it into an integer






?>
    <!--Page add comment-->
    <main class="bg-color-add-comment">
        <section>
            <div class="bg-img-add-comment" ></div>
            <div class="msg-connexion">

                <?php

                //                message $_GET
                if(isset($_GET['msg'])) {
                    echo $_GET['msg'];
                } ?>
            </div>
            <div class="flex-content-title-add-comment">
                <div class="content-title-add-comment">
                    <h1 class="title-add-comment">Ajout de commentaire de l'article</h1>
                </div>
            </div>
            <div class="file_form-add-comment">

                <!--        URL where the form is sent-->
                <form action="<?php echo HOME_URL . 'requests/add_comment_post.php'; ?>" method="POST">
                    <div class="flex-form-add-comment">
                        <label class="label-add-comment" for="text">Votre commentaire</label>
                        <textarea id="textarea_add_comment" class="textarea-content-comment" maxlength="750"  name="text" rows="10"></textarea>
                        <div class="flex-counter-add-article margin-counter-add-article">
                            <div id="counter_content_add_comment">0</div>
                            <div>/750</div>
                        </div>
                    </div>

                    <!-- we send the id of the article to be able to attach the comment -->
                    <input type="hidden" name="id_article" value="<?php echo $id_article; ?>">
                    <div class="content-button-submit-add-comment">
                        <button class="button-submit-add-comment" type="submit">Ajouter le commentaire</button>
                    </div>
                </form>
            </div>
        </section>
    </main>

<?php
//call footer
require __DIR__ . '/footer.php';
