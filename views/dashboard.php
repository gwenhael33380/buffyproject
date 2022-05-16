<?php
require __DIR__ . '/header.php';

// recap de tous les utilisateurs
// avec leur nom, prénom, pseudo, email, role, nombre d'articles, nombre de commentaires
require_once PATH_PROJECT . '/connect.php';
enabled_access(array('administrator'));

$req = $db->query("
	SELECT DISTINCT COUNT(c.id) count_comment, COUNT(a.id) count_article, u.*, r.id id_role, r.role_name, r.role_slug, a.id id_article, c.id id_comment, i.id as id_image, i.file_name
	FROM users u
	LEFT JOIN roles r
	ON u.id_role = r.id
	LEFT JOIN articles a
	ON a.id_user = u.id
	LEFT JOIN comments c
	ON c.id_user = u.id
	LEFT JOIN images i
	ON u.id_image = i.id
	GROUP BY u.id
	ORDER BY r.id ASC
");
$req->execute();
$results = $req->fetchAll(PDO::FETCH_OBJ); ?>
<div class="dashboard"></div>
    <h1>Liste des utilisateurs</h1>
<!--   --><?php //var_dump($results);?>
    <main> <!-- j'ajoute le "main" car le script JS fait appel à lui pour retrouver la popup DELETE -->
        <div class="users">
            <?php foreach($results as $result) :
                $count_article = $result->count_article;
                $count_comment = $result->count_comment; ?>
                <div class="user">
                    <div class="user_left">
                        <img src=" <?php echo HOME_URL.'assets/img/src/profil/' . sanitize_html($result->file_name); ?>">
                        <p>Nom : <?php echo sanitize_html($result->last_name); ?></p>
                        <p>Prénom : <?php echo sanitize_html($result->first_name); ?></p>
                        <p>Pseudo : <?php echo sanitize_html($result->pseudo); ?></p>
                        <p>Email : <?php echo sanitize_html($result->email); ?></p>
                        <p>Rôle : <?php echo $result->role_name; ?></p>
                        <p>Nombre article<?php echo plural($count_article); ?> : <?php echo $count_article; ?></p>
                        <p>Nombre de commentaire<?php echo plural($count_comment); ?> : <?php echo $count_comment; ?></p>
                    </div>
                    <div class="user_right">
                        <!-- update user -->
                        <a href="<?php echo HOME_URL . 'views/dashboard_update.php?id=' . $result->id; ?>"><i class="fa-solid fa-pencil"></i></a>

                        <!-- delete user -->
                        <a class="delete_user" href="<?php echo HOME_URL . 'requests/dashboard_delete_post.php?id=' . $result->id; ?>"><i class="fa-solid fa-trash-can"></i></a>
                    </div>

                </div>
            <?php endforeach; ?>
        </div>
    </main>
<?php
require PATH_PROJECT . '/views/footer.php';
