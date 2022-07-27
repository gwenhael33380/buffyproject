<?php
require dirname(__DIR__) . '/functions.php';
enabled_access(array('administrator'));
require_once PATH_PROJECT . '/connect.php';
define('TITLE', 'Dashboard');
require __DIR__ . '/header.php';

// recap de tous les utilisateurs
// avec leur nom, prénom, pseudo, email, role, nombre d'articles, nombre de commentaires



$req = $db->query("
	SELECT DISTINCT 
	    
	    (SELECT COUNT(c.id) count_comment FROM comments c WHERE c.id_user = u.id) total_comments, 
	    (SELECT COUNT(a.id) count_article FROM articles a WHERE a.id_user = u.id) total_articles, 
	        
	        u.*, r.id id_role, r.role_name, r.role_slug, a.id id_article, c.id id_comment, i.id as id_image, i.file_name
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


    <main class="content bgc-dashboard">
    <div class="content-bgi-dashboard"></div>
        <!--            display of request $_GET messages-->
        <div class="msg-connexion">
            <?php
            if(isset($_GET['msg'])) {
                echo $_GET['msg'];
            } ?>
        </div>
        <div class="content-title-dashboard">
            <div class="title-dashboard">Dashboard</div>
        </div>
        <div class="flex-content-title-list">
            <div class="content-title-list">
                <h1 class="title-list-user-dashboard">Liste des utilisateurs</h1>
            </div>
        </div>


            <div class="content-form-search">
                <input name="category" id="categoryFilter" type="text" placeholder="Trouver le pseudo d'un d'utilisateur">
                <i class="fa-solid fa-magnifying-glass relative-position-fa"></i>
            </div>



        <div  class="users-dashboard">

            <?php foreach($results as $result) :
                $count_article = $result->total_articles;
                $count_comment = $result->total_comments; ?>
                <div class="content_user_dashboard">
                    <div class="user_left user">

                        <!--                        sanitize_html permet d'évité l'injection SQL-->
                        <div class="">
                            <div class="content_img_dashboard">
                                <img class="img-user-profil-dashboard" src=" <?php echo HOME_URL.'assets/img/dist/profil/' . sanitize_html($result->file_name); ?>" alt="Image de l'utilisateur courant" >
                            </div>

                            <p class="info-user-dashboard">Nom : <span class="span-info-user-dashboard"><?php echo sanitize_html($result->last_name); ?></span></p>
                            <p class="info-user-dashboard">Prénom : <span class="span-info-user-dashboard"><?php echo sanitize_html($result->first_name); ?></span></p>
                            <p class="info-user-dashboard">Pseudo : <span class="result_pseudo span-info-user-dashboard"><?php echo sanitize_html($result->pseudo); ?></span></p>
                            <p class="info-user-dashboard">Email : <span class="span-info-user-dashboard"><?php echo sanitize_html($result->email); ?></span></p>
                            <p class="info-user-dashboard">Rôle : <span class="span-info-user-dashboard"><?php echo sanitize_html($result->role_name); ?></span></p>
                            <p class="info-user-dashboard">Nombre article<span class="span-info-user-dashboard"><?php echo plural($count_article); ?> : <?php echo $count_article; ?></span></p>
                            <p class="info-user-dashboard">Nombre de commentaire<span class="span-info-user-dashboard"><?php echo plural($count_comment); ?> : <?php echo $count_comment; ?></span></p>
                        </div>

                    </div>
                    <div class="flex-button-dashboard">

                        <!-- mise à jour de l'utilisateur -->
                        <a href="<?php echo HOME_URL . 'views/dashboard_update.php?id=' . $result->id; ?>"><i class="fa-solid fa-pencil favicon-update-user"></i></a>

                        <!-- suppression de l'utilisateur -->
                        <a class="delete_user" href="<?php echo HOME_URL . 'requests/dashboard_delete_post.php?id=' . $result->id; ?>"><i class="fa-solid fa-trash-can favicon-delete-user"></i></a>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </main>

<?php
include PATH_PROJECT . '/views/popup_delete_user_dashboard.php';
require PATH_PROJECT . '/views/footer.php';
