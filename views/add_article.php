
<?php
require dirname(__DIR__) . '/functions.php';
require_once PATH_PROJECT . '/connect.php';
require __DIR__ . '/header.php';
// les roles qui ont accès à la page
// les autres seront redirigés vers la page HOME
enabled_access(array('administrator', 'editor'));

$title = isset($_GET['title']) ? $_GET['title'] : FALSE;
$content = isset($_GET['content']) ? $_GET['content'] : FALSE;
?>

    <h1 class="title-add-article">Formulaire d'ajout d'un article</h1>

    <div class="file_form">
        <form action="<?php echo HOME_URL . 'requests/add_article_post.php'; ?>" method="POST" enctype="multipart/form-data">
            <div>
                <label for="title">Titre</label>
                <input type="text" id="title" name="title" value="<?php if($title) echo $title; ?>">
            </div>
            <div>
                <label for="text">Contenu de l'article</label>
                <textarea id="text" name="text" rows="10"><?php if($content) echo $content; ?></textarea>
            </div>
            <div>
                <label for="text2">Contenu de l'article 2</label>
                <textarea id="text2" name="text2" rows="10"><?php if($content) echo $content; ?></textarea>
            </div>

            <div>

                <label for="images">Ajouter une image (jpg, jpeg, png, gif)</label>
                <input type="hidden" name="MAX_FILE_SIZE" value="1048576"> <!-- 1Mo = 1024*1024 octets -->
                <input type="file" id="images-add-article" name="images" accept="image/*">
                <!-- TYPE MIME -->
                <!-- https://developer.mozilla.org/fr/docs/Web/HTTP/Basics_of_HTTP/MIME_types/Common_types -->
                <!-- https://developer.mozilla.org/fr/docs/Web/HTML/Attributes/accept -->

                <!-- si plusieurs fichiers à récupérer en même temps -->
                <!-- <input type="file" id="picture" name="picture[]" multiple> -->


            </div>
            <div>
                <label for="alt">Veuillez renseigner une description courte de l'image</label>
                <input id="input-alt"type="text" name="alt">
            </div>
            <button type="submit">Valider</button>
        </form>
    </div>

<?php
require __DIR__ . '/footer.php';
