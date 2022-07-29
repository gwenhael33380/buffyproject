<?php

require dirname(__DIR__) . '/functions.php'; //call function.php

enabled_access(array('administrator', 'editor', 'user')); //enabled targeted role access

require_once PATH_PROJECT . '/connect.php'; //call connect.php

define('TITLE', 'Mise a jour du commentaire'); //title tag definition
define('META_DESCRIPTION', 'page permettant de mettre à jour un commentaires via un formulaire. Une fois ce dernier rempli la soumission permet d\'ajouter un commentaire à la page de l\'article concerné. L\'accessibilité est réservée aux personnes ayant créé un compte.'); // Define meta description

require __DIR__ . '/header.php'; //call header.php



$id_comment = intval($_GET['id']); // if the $_GET is not numeric, it will not be able to transform it into an integer
$id_article = intval($_GET['id_article']);//            //                  //                      //          //

if($id_comment) {
//    request from previous comment
    $req = $db->prepare("
		SELECT id, comment_content
		FROM comments
		WHERE id = :id
	");


    $req->bindValue(':id', $id_comment, PDO::PARAM_INT); //    bind values


    $req->execute(); //    execution of the request

//    we get only one result of the query
    $comment = $req->fetch(PDO::FETCH_OBJ);
}
?>
    <main>
        <section>
            <div class="bg-img-update-comment"></div>
            <div>

                <!--           Requests message-->
                <?php

                //if content is present in the $_GET variable then it will be generated in this tag
                if(isset($_GET['msg'])) {
                    echo $_GET['msg'];
                } ?>
            </div>
            <div class="flex-content-title-add-comment">
                <div class="content-title-add-comment">
                    <h1 class="title-add-comment">Mise à jour du commentaire</h1>

                </div>
            </div>

            <div class="file_form-add-comment">

                <!--processing the form with the data collecting the update how-->
                <form action="<?php echo HOME_URL . 'requests/update_comment_post.php'; ?>" method="POST">
                    <div class="flex-form-add-comment">
                        <label class="label-add-comment" for="text">Contenu du commentaire</label>
                        <textarea id="textarea_update_comment" class="textarea-content-comment" name="text" rows="10"><?php echo sanitize_html($comment->comment_content); ?></textarea> <!--view comment content-->
                        <input type="hidden" name="id_article" value="<?php echo $id_article; ?>"> <!--variable traveling through the form in hidden mode-->
                        <input type="hidden" name="id_comment" value="<?php echo $comment->id; ?>"> <!--variable traveling through the form in hidden mode-->
                        <div class="flex-counter-add-article">
                            <div id="counter_content_update_comment">0</div>
                            <div>/750</div>
                        </div>
                    </div>
                    <div class="content-button-submit-add-comment margin-content-button-update-comment">
                        <button class="button-submit-add-comment" type="submit">Mettre à jour le commentaire</button>
                    </div>
                </form>
            </div>
        </section>
    </main>


<?php
require __DIR__ . '/footer.php';
