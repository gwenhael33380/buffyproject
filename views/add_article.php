
<?php
require dirname(__DIR__) . '/functions.php';
require_once PATH_PROJECT . '/connect.php';
define('TITLE', 'Ajout d\'un article');
require __DIR__ . '/header.php';
// les roles qui ont accès à la page
// les autres seront redirigés vers la page HOME
enabled_access(array('administrator'));

$title = isset($_GET['title']) ? $_GET['title'] : FALSE;
$content = isset($_GET['content']) ? $_GET['content'] : FALSE;


?>
<main class="bg-color-add-article" >
    <div class="bg-img-add-article"></div>
    <div class="msg-add-comment red">
        <?php
        if(isset($_GET['msg'])) {
            echo $_GET['msg'];
        } ?>
    </div>
    <div>
        <div class="content-title-add-article">
            <h1 class="title-add-article">Formulaire d'ajout d'un article</h1>
        </div>

        <div>
            <form action="<?php echo HOME_URL . 'requests/add_article_post.php'; ?>" method="POST" enctype="multipart/form-data">
                <div class="flex-form-add-article" >
                    <label class="label-title-add-article" for="title">Titre <span class="red" >*</span></label>
                    <input id="input_title_add_article" class="input-add-article-title" type="text" id="title" name="title" minlength="3" maxlength="40" placeholder="Veuillez renseigner un titre, 3 caractères minimum, maximum 40..."<?php if($title) echo $title; ?>>
                    <div class="flex-counter-add-article">
                        <div id="counter_title_add_article">0</div>
                        <div>/40</div>
                    </div>

                </div>
                <div class="flex-form-add-article" >
                    <label class="label-content-add-article" for="text">Contenu de l'article <span class="red" >*</span></label>
                    <textarea id="input_textarea_add_article" class="textarea-add-article-content" id="text" name="text" rows="10" minlength="750" maxlength="3000" placeholder="Contenu à renseigner, Merci de renseigner un minimum de 750 caractères et un maximum de 3000..."><?php if($content) echo $content; ?></textarea>
                    <div class="flex-counter-add-article">
                        <div id="counter_content_add_article" style="text-align:right">0</div>
                        <div>/3000</div>
                    </div>
                </div>
                <div class="content-description-article">
                    <label class="label-content-add-article" for="alt">Veuillez renseigner une description courte de l'image <span class="red" >*</span></label>
                    <input id="input_alt_add_article" class="input-alt-article" minlength="5" maxlength="40" placeholder="Veuillez renseigner 5 caractères minimum, maximum 40..." type="text" name="alt">
                    <div class="flex-counter-add-article">
                        <div id="counter_alt_add_article" style="text-align:right">0</div>
                        <div>/40</div>
                    </div>
                </div>
                <div class="content-add-img-article">
                    <label class="label-add-img-article" for="images">Ajouter une image (jpg, jpeg, png, gif)<span class="red">*</span>
                        <br>  <span class="red">N'ajoutez que des images en mode paysage.  </span> Merci de respecté cette convention. Tout manquement à cette règle fera l'objet d'une suppression de l'article concerné ! Merci pour votre compréhension.</label>
                    <input type="hidden" name="MAX_FILE_SIZE" value="1048576"> <!-- 1Mo = 1024*1024 octets -->
                    <input type="file" id="images-add-article" name="images" accept="image/*">
                </div>
                <div class="content-button-add-article" >
                    <button class="button-submit-add-article" type="submit-button-add-article">Soumettre le formulaire</button>
                </div>
            </form>
        </div>
    </div>
</main>

<?php
require __DIR__ . '/footer.php';
