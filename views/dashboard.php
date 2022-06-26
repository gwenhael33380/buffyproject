<?php
require dirname(__DIR__) . '/functions.php';
require_once PATH_PROJECT . '/connect.php';
define('TITLE', 'Dashboard');
require __DIR__ . '/header.php';

// recap de tous les utilisateurs
// avec leur nom, prénom, pseudo, email, role, nombre d'articles, nombre de commentaires

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


    <main class="content">
        <div class="dashboard"></div>
        <h1>Liste des utilisateurs</h1>
        <div class="users-dashboard">
            <?php foreach($results as $result) :
                $count_article = $result->count_article;
                $count_comment = $result->count_comment; ?>
                <div class="user">
                    <div class="user_left">
<!--                        sanitize_html permet d'évité l'injection SQL-->
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
                        <!-- mise à jour de l'utilisateur -->
                        <a href="<?php echo HOME_URL . 'views/dashboard_update.php?id=' . $result->id; ?>"><i class="fa-solid fa-pencil"></i></a>

                        <!-- suppressiond de l'utilisateur -->
                        <a class="delete_user" href="<?php echo HOME_URL . 'requests/dashboard_delete_post.php?id=' . $result->id; ?>"><i class="fa-solid fa-trash-can"></i></a>
                    </div>



                </div>
            <?php endforeach; ?>
<?php foreach($results as $result) :
    $count_article = $result->count_article;
    $count_comment = $result->count_comment; ?>
            <table>
                <thead>
                <tr>

                    <td rowspan="4">Nom</td>
                    <td rowspan="4">Prénom</td>
                    <td rowspan="4">Pseudo</td>
                    <td rowspan="4">Email</td>
                    <td>Rôle</td>
                    <td rowspan="4">Nombre d'articles</td>
                    <td rowspan="4">Nombre de commentaire</td>
                </tr>
                <tbody>
                <tr>

                    <td><?php echo sanitize_html($result->last_name); ?></td>
                    <td><?php echo sanitize_html($result->first_name); ?></td>
                    <td><?php echo sanitize_html($result->pseudo); ?></td>
                    <td> <?php echo sanitize_html($result->email); ?></td>
                    <td> <?php echo $result->role_name; ?></td>
                    <td> <?php echo plural($count_article); ?> : <?php echo $count_article; ?></td>
                    <td> <?php echo plural($count_comment); ?> : <?php echo $count_comment; ?></td>
                </tr>
                </tbody>
                </tr>
                </thead>
            </table>
<?php endforeach; ?>
        </div>
    </main>
<?php
require PATH_PROJECT . '/views/footer.php';
