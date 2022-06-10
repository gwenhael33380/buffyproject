<?php
require dirname(__DIR__) . '/functions.php';
require_once PATH_PROJECT . '/connect.php';
require __DIR__ . '/header.php';
enabled_access(array('administrator', 'editor', 'user'));
$id_comment = intval($_GET['id']); // si le $_GET n'est pas numerique, il ne pourra pas le transformer en integer

if($id_comment) {
    $req = $db->prepare("
		SELECT id, comment_content
		FROM comments
		WHERE id = :id
	");

    $req->bindValue(':id', $id_comment, PDO::PARAM_INT);
    $req->execute();

    $comment = $req->fetch(PDO::FETCH_OBJ);
}
?>

    <h1 class="title">Mise à jour du commentaire</h1>

    <div class="file_form">
        <form action="<?php echo HOME_URL . 'requests/update_comment_post.php'; ?>" method="POST">
            <div>
                <label for="text">Contenu du commentaire</label>
                <textarea id="text" name="text" rows="10"><?php echo sanitize_html($comment->comment_content); ?></textarea>
            </div>
            <input type="hidden" name="id_comment" value="<?php echo $comment->id; ?>">
            <button type="submit">Mettre à jour le commentaire</button>
        </form>
    </div>

<?php
require __DIR__ . '/footer.php';
