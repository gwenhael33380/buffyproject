<?php

//call function
require dirname(__DIR__) . '/functions.php';

//call connect
require_once PATH_PROJECT . '/connect.php';

//title tag definition
define('TITLE', 'Ajout d\'un commentaire');

//call header
require __DIR__ . '/header.php';

//enabled targeted role access
enabled_access(array('administrator', 'editor', 'user'));

$id_article = intval($_GET['id']); //if the $_GET is not numeric, it will not be able to transform it into an integer
$name_article = $_GET['title_article']; //if the $_GET is not numeric, it will not be able to transform it into an integer
?>
    <!--Page add comment-->
    <main class="bg-color-add-comment">
        <div class="bg-img-add-comment" ></div>
        <section>
            <div class="flex-content-title-add-comment">
                <div class="content-title-add-comment">
                    <h1 class="title-add-comment">Ajout de commentaire de l'article : <?php echo $name_article ?></h1>
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
