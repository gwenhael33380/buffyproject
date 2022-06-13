
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
<main>
    <div class="bg-img-add-article"></div>
    <div>
        <div class="content-title-add-article">
            <h1 class="title-add-article">Formulaire d'ajout d'un article</h1>
        </div>

        <div class="file_form">
            <form action="<?php echo HOME_URL . 'requests/add_article_post.php'; ?>" method="POST" enctype="multipart/form-data">
                <div>
                    <label for="title">Titre <span class="red" >*</span></label>
                    <input type="text" id="title" name="title" value="<?php if($title) echo $title; ?>">
                </div>
                <div>
                    <label for="text">Contenu de l'article <span class="red" >*</span></label>
                    <textarea id="text" name="text" rows="10" minlength="750" maxlength="3000" placeholder="Premier contenue à renseigner. Merci de renseigner un minimum de 750 caractères et un maximum de 3000..."><?php if($content) echo $content; ?></textarea>
                </div>
                <div>
                    <label for="text2">Contenu de l'article 2</label>
                    <textarea id="text2" name="text2" rows="10" minlength="750" maxlength="3000" placeholder="Deuxième contenue à renseigner (Facultatif). Merci de renseigner un minimum de 750 caractères et un maximum de 3000..."><?php if($content) echo $content; ?></textarea>
                </div>
                <div>
                    <label for="images">Ajouter une image (jpg, jpeg, png, gif) <span class="red" >*</span></label>
                    <input type="hidden" name="MAX_FILE_SIZE" value="1048576"> <!-- 1Mo = 1024*1024 octets -->
                    <input type="file" id="images-add-article" name="images" accept="image/*">
                </div>
                <div>
                    <label for="alt">Veuillez renseigner une description courte de l'image <span class="red" >*</span></label>
                    <input id="input-alt"type="text" name="alt">
                </div>
                <div class="msg-add-comment red">
                    <?php
                    if(isset($_GET['msg'])) {
                        echo $_GET['msg'];
                    } ?>
                </div>
                <button type="submit-button-add-article">Valider</button>
            </form>
        </div>
    </div>
</main>
<?php
require __DIR__ . '/footer.php';
