<?php

require dirname(__DIR__) . '/functions.php'; //call function.php
enabled_access(array('administrator', 'editor')); //access enabled for administrator
require_once PATH_PROJECT . '/connect.php'; //call connect.php
define('TITLE', 'Mise à jour d\'un article'); //title tag definition
define('META_DESCRIPTION', 'La page update article permet de mettre à jour un article du site BuffyProject via un formulaire çà partir de la page article d\'où l\'administrateur a soumis la requête de mettre à jour un article spécifique. '); // Define meta description
$id_article = intval($_GET['id']); //converts the value of the id to numeric
$article_id_user = intval($_GET['article_id_user']); //converts the value of the id to numeric

if (isset($_SESSION['id_user']) && $_SESSION['id_user'] == $article_id_user || $_SESSION['role_slug'] == 'administrator'){

    require __DIR__ . '/header.php'; //call header.php

    if($id_article) {

//    request article
        $req = $db->prepare("
		SELECT  a.id id_article,  a.title, a.content, a.id_image, p.file_name, p.alt
		FROM article a
		LEFT JOIN picture p
		ON a.id_image = p.id
		WHERE a.id = :id
        
	");

        $req->bindValue(':id', $id_article, PDO::PARAM_INT);
        $req->execute();

        $article = $req->fetch(PDO::FETCH_OBJ);
        $file_name = HOME_URL . 'assets/img/dist/article/' . $article->file_name;
    }


    ?>

    <!--    article update form. Warning !!! use of the class of the add article form-->
    <main class="content">
        <div class="bg-img-add-article"></div>
        <div class="content_title_update_article">
            <h1 class="title_update_article">Formulaire de mise à jour d'un article</h1>
        </div>
        <div class="file_form_update_article">

            <!--        content of fields sent to sent on the form processing page-->
            <form action="<?php echo HOME_URL . 'requests/update_article_post.php'; ?>" method="POST" enctype="multipart/form-data">
                <div class="flex-form-add-article">
                    <label class="label-title-add-article" for="title">Titre</label>

                    <input type="hidden" name="id_article" value="<?php echo $article->id_article; ?>"> <!--view article content-->

                    <input id="input_title_update_article" class="input-add-article-title" minlength="3" maxlength="40"  type="text" id="title" name="title" placeholder="Veuillez renseigner un titre..." value="<?php echo sanitize_html($article->title); ?>" required> <!--view article content-->
                    <div class="flex-counter-add-article">
                        <div id="counter_title_update_article">0</div>
                        <div>/40</div>
                    </div>
                </div>
                <div class="flex-form-add-article">
                    <label class="label-content-add-article" for="text">Contenu de l'article</label>
                    <textarea id="input_textarea_update_article" class="textarea-add-article-content" minlength="750" maxlength="3000" name="text" rows="10" placeholder="Contenu à renseigner, Merci de renseigner un minimum de 750 caractères et un maximum de 3000..." required><?php echo sanitize_html($article->content); ?></textarea> <!--view article content-->
                    <div class="flex-counter-add-article">
                        <div id="counter_content_update_article">0</div>
                        <div>/3000</div>
                    </div>
                </div>
                <div class="content-description-article">
                    <label class="label-content-add-article" for="alt">Veuillez renseigner une description courte de l'image</label>
                    <input id="input_alt_update_article" class="input-alt-article" minlength="5" maxlength="40" type="text" placeholder="Veuillez renseigner 10 caractères minimum, maximum 40..." name="alt"  value="<?php echo sanitize_html($article->alt); ?>" required> <!--view article content-->
                    <div class="flex-counter-add-article">
                        <div id="counter_alt_update_article">0</div>
                        <div>/40</div>
                    </div>
                </div>
                <div class="content-add-img-article">
                    <div class ="text-info-format-img">
                        <span class="red">*N'ajoutez que des images en mode paysage.</span> Merci de respecté cette convention. Tout manquement à cette règle fera l'objet d'une suppression de l'article concerné ! Merci pour votre compréhension.
                    </div>
                    <label class="label-add-img-article margin-bottom" for="images">Ajouter une image (jpg, jpeg, png, gif) 1Mo MAX<span class="red" >*</span></label>

                    <input type="hidden" name="current_img" value="<?php echo sanitize_html($article->file_name); ?>"> <!--variable traveling through the form in hidden mode-->
                    <input type="hidden" name="id_image" value="<?php echo sanitize_html($article->id_image); ?>"> <!--variable traveling through the form in hidden mode-->
                    <input type="hidden" name="article_id_user" value="<?php echo sanitize_html($article_id_user); ?>"> <!--variable traveling through the form in hidden mode-->
                    <input type="hidden" name="MAX_FILE_SIZE" value="1048576"> <!--size restriction at 1MB or 1024*1028 bytes -->
                    <input type="file" id="picture" name="picture" accept="image/*"> <!--image chosen by the user-->
                    <div class="content-current-img-update-article">
                        <div class="current_img margin-bottom">
                            <img class="current-img-update-article" src="<?php echo HOME_URL . 'assets/img/dist/articles/' . sanitize_html($article->file_name); ?>"> <!--current picture-->
                        </div>
                    </div>
                </div>

                <div class="content-button-add-article margin_bottom-update-article">
                    <button class="button-submit-add-article" type="submit">Mettre à jour l'article</button>
                </div>
            </form>
        </div>
    </main>

    <?php

//call footer
    require __DIR__ . '/footer.php';

}else{
    header('Location:' . HOME_URL . '?msg=<p class="msg_error">Vous n\'avez pas l\'autorisation d\'accédé à cette page</p>');

}
