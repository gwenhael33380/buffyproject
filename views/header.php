<?php

?>

<!doctype html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="shortcut icon" href="<?= HOME_URL . '/favicon.ico'; ?>" type="image/x-icon">
    <link rel="icon" href=""<?= HOME_URL . '/favicon.ico'; ?>" type="image/x-icon">
    <title>Buffy Project | <?php echo TITLE; ?></title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/css/bootstrap.min.css" integrity="sha384-TX8t27EcRE3e/ihU7zmQxVncDAy5uIKz4rEkgIXeMed4M0jlfIDPvg6uqKI2xXr2" crossorigin="anonymous">

    <link rel="stylesheet" href="<?php echo HOME_URL . 'assets/css/dist/main.min.css'; ?>">
</head>
<body >
<header>
    <div class="display-nav">
        <nav id="navbar" <?php echo isset($_SESSION['user_id']) ? 'class="connect"' : 'class="disconnect"'; ?> >
            <div class="logo-nav-bar">
                <a href="<?= HOME_URL; ?>"><img src="<?php echo HOME_URL . 'assets/img/src/source/Logo_with.png'; ?>" alt="Logo du site"></a>
            </div>
            <ul class="nav-bar-list">
                <li class="title-nav-bar2"><a class="title-nav-bar" href="<?= HOME_URL; ?>">ACCUEIL</a></li>
                <li class="title-nav-bar2"><a class="title-nav-bar" href="<?php echo HOME_URL . 'views/blog.php'; ?>">BLOG</a></li>
                <?php if(isset($_SESSION['id_user'])) : ?>
                    <li class="title-nav-bar2"><a class="title-nav-bar" href="<?php echo HOME_URL . 'views/user_profil.php'; ?>">PROFIL</a></li>4
                <?php endif; ?>
                <li class="title-nav-bar2"><a class="title-nav-bar" href="<?php echo HOME_URL . 'views/contact.php'; ?>">CONTACT</a></li>

                <?php if(isset($_SESSION['role_slug']) && $_SESSION['role_slug'] == 'administrator' ) : ?>
                    <li class="title-nav-bar2"><a class="title-nav-bar" href="<?php echo HOME_URL . 'views/dashboard.php'; ?>">DASHBOARD</a></li>

                <?php endif; ?>

            </ul>
            <div class="content-btn-nav">

                <ul class="nav-connect">
                    <?php if(isset($_SESSION['id_user'])) : ?>
                        <li class="disconnect cursor_pointer">
                            <a class="button-disconnect" href="<?= HOME_URL . 'requests/disconnect.php'; ?>">SE DECONNECTER</a>
                        </li>
                        <!-- si non connecté -->
                    <?php else : ?>
                        <li class="connect cursor_pointer">
                            <span id="to_connect" class="to_connect btn-nav btn-nav-bar2">CONNEXION</span>


                        </li>
                        <li>
                            <a class="btn-nav btn-nav-bar1" href="<?php echo HOME_URL . 'views/subscribe.php'; ?>">S'inscrire</a>
                        </li>

                    <?php endif; ?>
                </ul>

            </div>
        </nav>
    </div>
    <!--                            modal to connect-->
    <div class="modal_connect">
        <form action="<?php echo HOME_URL . 'requests/login_post.php'; ?>" method="POST">
            <p class="modal-connect-title" >Se connecter</p>
            <div class="content-form-modal">
                <label class="label-modal-connect" for="email">Email</label>
                <input  class="input-modal-connect" type="text" name="email" id="email">
            </div>
            <div class="content-form-modal">
                <label class="label-modal-connect" for="password">Mot de passe</label>
                <input  class="input-modal-connect" type="password" name="password" id="password">
            </div>
            <div class="content-button-connected">
                <button id="popup-btn" type="submit">Se connecter</button>
            </div>
        </form>
    </div>
</header>





