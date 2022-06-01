<?php
require dirname(__DIR__) . '/functions.php';
require_once PATH_PROJECT . '/connect.php';
require __DIR__ . '/header.php';

enabled_access(array('administrator'));
$id_article = intval($_GET['id']); // si le $_GET n'est pas numerique, il ne pourra pas le transformer en integer

if($id_article) {
    $req = $db->prepare("
		SELECT a.id, a.title, a.content, a.content_2, a.id_image, i.id_article, i.file_name
		FROM articles a
		LEFT JOIN images i
		ON a.id_image = i.id
		WHERE a.id = :id
        
	");
    var_dump($db->errorInfo());
    $req->bindValue(':id', $id_article, PDO::PARAM_INT);
    $req->execute();

    $article = $req->fetch(PDO::FETCH_OBJ);


    $file_name = HOME_URL . 'assets/img/dist/article/' . $article->file_name;
}

?>

    <h1 class="title">Formulaire de mise à jour d'un article</h1>

    <div class="file_form">
        <form action="<?php echo HOME_URL . 'requests/update_article_post.php'; ?>" method="POST" enctype="multipart/form-data">
            <div>
                <label for="title">Titre</label>
                <input type="text" id="title" name="title" value="<?php echo sanitize_html($article->title); ?>">
            </div>
            <div>
                <label for="text">Contenu de l'article</label>
                <textarea id="text" name="text" rows="10"><?php echo sanitize_html($article->content); ?></textarea>
            </div>
            <div>
                <label for="text2">Contenu de l'article 2</label>
                <textarea id="text2" name="text2" rows="10"><?php echo sanitize_html($article->content_2); ?></textarea>
            </div>
            <div>
                <label for="picture">Mettre à jour l'image (jpg, jpeg, png, gif)</label>
                <input type="hidden" name="MAX_FILE_SIZE" value="1048576"> <!-- 1Mo = 1024*1024 octets -->
                <input type="file" id="picture" name="picture" accept="image/*">
                <!-- TYPE MIME -->
                <!-- https://developer.mozilla.org/fr/docs/Web/HTTP/Basics_of_HTTP/MIME_types/Common_types -->
                <!-- https://developer.mozilla.org/fr/docs/Web/HTML/Attributes/accept -->

                <!-- si plusieurs fichiers à récupérer en même temps -->
                <!-- <input type="file" id="picture" name="picture[]" multiple> -->

                <div class="content-img-profil">
                    <img class="img-profil" src=" <?php echo HOME_URL .'assets/img/dist/articles/' . sanitize_html($article->file_name); ?>">
                </div>
            </div>
            <div class="msg_error"></div>
            <div class="current_img">
                <img src="<?php echo $file_name; ?>" alt="">
            </div>
            <input type="hidden" name="id_article" value="<?php echo $article->id; ?>">
            <input type="hidden" name="current_img" value="<?php echo $article->id_image; ?>">
            <button type="submit">Mettre à jour l'article</button>
        </form>
    </div>

<?php
require __DIR__ . '/footer.php';
