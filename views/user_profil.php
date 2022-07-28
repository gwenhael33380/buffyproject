<?php

require dirname(__DIR__) . '/functions.php';
enabled_access(array('administrator', 'editor', 'user'));
//var_dump($_COOKIE['last_visit']);die;

require_once PATH_PROJECT . '/connect.php';
define('TITLE', 'Votre profil');
require PATH_PROJECT . '/views/header.php';

$msg_not_connect = '<div class="red">vous n\'êtes pas connecté</div>';
$user_id = ($_SESSION['id_user']);






if(empty($user_id)){
    header('Location:' . HOME_URL . '?msg=' . $msg_not_connect);

}

$req = $db->prepare("

	SELECT DISTINCT 
	    
	    (SELECT COUNT(c.id) count_comment
	     FROM comments c 
	     WHERE c.id_user = :user_id) total_comments, 
	    
	    (SELECT COUNT(a.id) count_article 
	     FROM articles a 
	     WHERE a.id_user = :user_id) total_articles, 
	       
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
            WHERE u.id = :user_id
            GROUP BY u.id
            ORDER BY r.id ASC
    ");
$req->bindValue(':user_id', $user_id, PDO::PARAM_INT);

$result= $req->execute();

$result = $req->fetch(PDO::FETCH_OBJ);


?>


<?php
    include PATH_PROJECT . '/views/popup_delete_user_profil.php';  //include popup delete user popup_delete_user_profil.php
?>
<!--main section-->
    <main class="content">
        <div class="msg-connexion">
            <?php
            if(isset($_GET['msg'])) {
                echo $_GET['msg'];
            } ?>
        <div class="bg-page-profil"></div>
        <div class="content-space-personel">
            <h1 class="space-personel">espace personnel</h1>
        </div>
        <div class="content-profil-user">
            <div class="profil_user">
                <h2 class="title-first-name">Bonjour <?php echo sanitize_html($result->first_name); ?></h2>
            </div>
        </div>
        <div class="users">
            <?php  $count_article = $result->total_articles;
            $count_comment = $result->total_comments; ?>
            <div class="user">
                <div class="user_left">
                    <!--                   sanitize_html -> élimine la faille XSS-->
                    <div class="content-img-profil">
                        <img class="img-profil" src=" <?php echo HOME_URL .'assets/img/dist/profil/' . sanitize_html($result->file_name); ?>">
                    </div>
                    <div class="content-information-user">
                        <p class="information-user"><span class="span-information-user">Nom</span> : <span><?php echo sanitize_html($result->last_name); ?></span></p>

                    </div>
                    <div class="content-information-user">
                        <p class="information-user"><span class="span-information-user">Prénom</span> : <span> <?php echo sanitize_html($result->first_name); ?></span></p>

                    </div>
                    <div class="content-information-user">
                        <p class="information-user"><span class="span-information-user">Pseudo</span> : <span> <?php echo sanitize_html($result->pseudo); ?></span></p>

                    </div>
                    <div class="content-information-user">
                        <p class="information-user"><span class="span-information-user">Email</span> : <span> <?php echo sanitize_html($result->email); ?></span></p>

                    </div>
                    <div class="content-information-user">
                        <p class="information-user"><span class="span-information-user">Rôle</span> : <span> <?php echo $result->role_name; ?></span></p>

                    </div>

                    <!--                    La fonction plural permet de mettre au pluriel si supperieur a 1 -->
                    <?php if (!empty($count_article)) : ?>
                    <p class="information-user"><span class="span-information-user">Nombre d'article</span><?php echo plural($count_article); ?> : <?php echo $count_article; ?></p>
                    <?php endif ?>
                    <p class="information-user"><span class="span-information-user">Nombre de commentaire</span><?php echo plural($count_comment); ?> : <?php echo $count_comment; ?></p>

                    <?php
                    if(isset($_COOKIE['last_visit']))

                    {
                        echo '<p class="information-user"><span class="span-information-user">Date de votre dernière visite</span> : ' . $_COOKIE['last_visit'] . '</p>' ; // &#232 = "è"
                    }
                    else
                    {
                        echo '<p class="information-user">C\'est la première fois que vous visitez ce site</p>';
                    }
                    ?>

                </div>
                <div class="user_right">
                    <!-- Mettre a jour l'utilisateur -->
                    <div class="content-button-profil">
                        <a class="button-modifie-profil"href="<?php echo HOME_URL . 'views/user_update.php?id=' . $result->id; ?>">modifier le profil</a>
                    </div>
                    <div class="content-button-profil2">
                        <a class="btnDeleteProfil" >supprimer le profil</i></a>
                    </div>
                    <!-- Suppression de l'utilisateur -->
                </div>
            </div>
        </div>
    </main>































<?php
require __DIR__ . '/footer.php';
