<?php
$sName = explode("/", $_SERVER['SCRIPT_NAME']);
foreach( $sName AS $value ) {
    if( substr($value, -4, 4) == ".php" ) {
        $currentPage = $value;

        // OU
        //----- (si on veut la page sans le .php)

        $currentArray = explode(".", $value);
        $currentPage = $currentArray[0];
    }
}





?>

<!doctype html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title><?php echo $currentPage; ?></title>
    <link rel="shortcut icon" href="<?= HOME_URL . '/favicon.ico'; ?>" type="image/x-icon">
    <link rel="icon" href=""<?= HOME_URL . '/favicon.ico'; ?>" type="image/x-icon">
    <link rel="stylesheet" href="<?php echo HOME_URL . 'assets/css/dist/main.min.css'; ?>">
</head>
<body>
<header class="nav-bar-fixed">
    <nav id="nav-bar" <?php echo isset($_SESSION['user_id']) ? 'class="connect"' : 'class="disconnect"'; ?> >
        <div class="logo-nav-bar">
            <img src="<?php echo HOME_URL . 'assets/img/src/source/Logo_with.png'; ?>" alt="">
        </div>
        <ul class="nav-bar-list">

            <?php
            if(isset($_GET['msg'])) {
                echo $_GET['msg'];
            } ?>
            <li class="title-nav-bar2"><a class="title-nav-bar" href="<?= HOME_URL; ?>">ACCUEIL</a></li>
            <li class="title-nav-bar2"><a class="title-nav-bar" href="<?php echo HOME_URL . 'views/blog.php'; ?>">BLOG</a></li>
            <li class="title-nav-bar2"><a class="title-nav-bar" href="<?php echo HOME_URL . 'views/user_profil.php'; ?>">PROFIL</a></li>
            <li class="title-nav-bar2"><a class="title-nav-bar" href="<?php echo HOME_URL . 'views/contact.php'; ?>">CONTACT</a></li>

            <?php if(isset($_SESSION['role_slug']) && $_SESSION['role_slug'] == 'administrator' ) : ?>
                <li class="title-nav-bar2"><a class="title-nav-bar" href="<?php echo HOME_URL . 'views/dashboard.php'; ?>">DASHBOARD</a></li>
            <?php endif; ?>

        </ul>
        <div class="content-btn-nav">
            <div>
                <ul class="nav-connect">
                    <?php if(isset($_SESSION['id_user'])) : ?>
                        <li class="disconnect cursor_pointer">
                            <a class="button-disconnect" href="<?= HOME_URL . 'requests/disconnect.php'; ?>">SE DECONNECTER</a>
                        </li>
                        <!-- si non connecté -->
                    <?php else : ?>
                        <li class="connect cursor_pointer">
                            <span class="to_connect btn-nav btn-nav-bar2">CONNEXION</span>
                            <div class="modal_connect">
                                <form action="<?php echo HOME_URL . 'requests/login_post.php'; ?>" method="POST">
                                    <p>Se connecter</p>
                                    <div>
                                        <label for="email">Email</label>
                                        <input type="text" name="email" id="email">
                                    </div>
                                    <div>
                                        <label for="password">Mot de passe</label>
                                        <input type="password" name="password" id="password">
                                    </div>
                                    <button type="submit">Envoyer</button>
                                </form>
                            </div>
                        </li>
                        <li>
                            <a class="btn-nav btn-nav-bar1" href="<?php echo HOME_URL . 'views/subscribe.php'; ?>">S'inscrire</a>
                        </li>

                    <?php endif; ?>
                </ul>
            </div>
        </div>
</header>

</nav>



