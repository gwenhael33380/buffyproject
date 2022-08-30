<?php
require dirname(__DIR__) . '/functions.php'; //call function.php

//enabled targeted role access
enabled_access(array('administrator')); //enabled targeted role access


require_once PATH_PROJECT . '/connect.php'; //call connect.php
define('TITLE', 'Dashboard');//title tag definition
define('META_DESCRIPTION', 'la page du dashboard permet aux administrateurs de gérer l\'ensemble des utilisateurs et visualiser toutes les informations concernant la vie du site. Cette page a aussi pour fonction de mettre à jour les utilisateurs en cas d\'incident avec les identifiants ou des informations personnelles inappropriées. Cette page permet aussi la suppression d\'un utilisateur.'); // Define meta description

require __DIR__ . '/header.php';//call header




// recap de tous les utilisateurs
// avec leur nom, prénom, pseudo, email, role, nombre d'articles, nombre de commentaires



$req = $db->query("
	SELECT DISTINCT 
	    
	    (SELECT COUNT(c.id) count_comment FROM comment c WHERE c.id_user = u.id) total_comments, 
	    (SELECT COUNT(a.id) count_article FROM article a WHERE a.id_user = u.id) total_articles, 
	        
	        u.*, r.id id_role, r.role_name, r.role_slug, a.id id_article, c.id id_comment, p.id as id_image, p.file_name
            FROM user u
            LEFT JOIN role r
            ON u.id_role = r.id
            LEFT JOIN article a
            ON a.id_user = u.id
            LEFT JOIN comment c
            ON c.id_user = u.id
            LEFT JOIN picture p
            ON u.id_image = p.id
            GROUP BY u.id
            ORDER BY r.id ASC
");


$req->execute();
$results = $req->fetchAll(PDO::FETCH_OBJ); ?>



    <main class="content bgc-dashboard">
    <div class="content-bgi-dashboard"></div>
        <div class="content-title-dashboard">
            <div class="title-dashboard">Dashboard</div>
        </div>
        <div class="flex-content-title-list">
            <div class="content-title-list">
                <h1 class="title-list-user-dashboard">Liste des utilisateurs</h1>
            </div>
        </div>
<!--             search function-->
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
                        <!--                        sanitize_html avoids SQL injection-->
                        <div>
                            <div class="content_img_dashboard">
                                <img class="img-user-profil-dashboard" src=" <?php echo HOME_URL.'assets/img/dist/profil/' . sanitize_html($result->file_name); ?>" alt="Image de l'utilisateur courant">
                            </div>

                            <p class="info-user-dashboard">Nom : <span class="span-info-user-dashboard"><?php echo sanitize_html($result->last_name); ?></span></p>
                            <p class="info-user-dashboard">Prénom : <span class="span-info-user-dashboard"><?php echo sanitize_html($result->first_name); ?></span></p>
                            <p class="info-user-dashboard">Pseudo : <span class="result_pseudo span-info-user-dashboard"><?php echo sanitize_html($result->pseudo); ?></span></p>
                            <p class="info-user-dashboard">Email : <span class="span-info-user-dashboard"><?php echo sanitize_html($result->email); ?></span></p>
                            <p class="info-user-dashboard">Rôle : <span class="span-info-user-dashboard"><?php echo sanitize_html($result->role_name); ?></span></p>
                            <?php if (!empty($count_article)) : ?>
                            <p class="info-user-dashboard ">Nombre article<span class="span-info-user-dashboard"><?php echo plural($count_article); ?> : <?php echo $count_article; ?></span></p>
                            <?php endif ?>
                            <p class="info-user-dashboard">Nombre de commentaire<span class="span-info-user-dashboard"><?php echo plural($count_comment); ?> : <?php echo $count_comment; ?></span></p>
                        </div>
                    </div>
                    <div class="flex-button-dashboard">

                         <?php if ($result->id == 16):?>
                         <a class="update_user_prohibited_alert"><i class="fa-solid fa-xmark alert-delete-prohibited"></i></a>

                        <?php else: ?>
                        <!-- update user -->
                        <a href="<?php echo HOME_URL . 'views/dashboard_update.php?id=' . $result->id; ?>"><i class="fa-solid fa-pencil favicon-update-user"></i></a>
                         <?php endif ?>
                        <!-- delete user -->

                            <?php if ($result->id == 16):?>
                            <a class="delete_user_prohibited_alert"><i class="fa-solid fa-xmark alert-delete-prohibited"></i></a>


                        <?php else: ?>
                            <a class="delete_user" href="<?php echo HOME_URL . 'requests/users_delete_dashboard_post.php?id=' . $result->id; ?>"><i class="fa-solid fa-trash-can favicon-delete-user"></i></a>

                        <?php endif ?>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </main>

<?php
include PATH_PROJECT . '/views/popup_delete_user_dashboard.php';
require PATH_PROJECT . '/views/footer.php';


