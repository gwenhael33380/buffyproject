<?php

?>

<!doctype html>
<!--language-->
<html lang="fr">
<head>

<!--    character encoding-->
    <meta charset="UTF-8">

<!--    display setup-->
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">

<!--    Compatibility of Microsoft EADGE-->
    <meta http-equiv="X-UA-Compatible" content="ie=edge">

<!--    link Favicon-->
    <link rel="shortcut icon" href="<?= HOME_URL . '/favicon.ico'; ?>" type="image/x-icon">
    <link rel="icon" href=""<?= HOME_URL . '/favicon.ico'; ?>" type="image/x-icon">

<!--    balise title dynamic-->
    <title>Buffy Project | <?php echo TITLE; ?></title>

<!--    link CDN Bootstrap-->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/css/bootstrap.min.css" integrity="sha384-TX8t27EcRE3e/ihU7zmQxVncDAy5uIKz4rEkgIXeMed4M0jlfIDPvg6uqKI2xXr2" crossorigin="anonymous">

<!--    link CSS style-->
    <link rel="stylesheet" href="<?php echo HOME_URL . 'assets/css/dist/main.min.css'; ?>">
</head>
    <body>
        <header>

        <!--    Contents link nav bar-->
            <div class="display-nav">
                <nav id="navbar" <?php echo isset($_SESSION['user_id']) ? 'class="connect"' : 'class="disconnect"'; ?> >
                    <div class="logo-nav-bar">
                        <a href="<?= HOME_URL; ?>"><img src="<?php echo HOME_URL . 'assets/img/src/source/Logo_with.png'; ?>" alt="Logo du site"></a>
                    </div>
                    <ul class="nav-bar-list">
                        <li class="title-nav-bar2"><a class="title-nav-bar" href="<?= HOME_URL; ?>">ACCUEIL</a></li>
                        <li class="title-nav-bar2"><a class="title-nav-bar" href="<?php echo HOME_URL . 'views/blog.php'; ?>">BLOG</a></li>

<!--                        if the id_user exists then we display the link to the profile-->
                        <?php if(isset($_SESSION['id_user'])) : ?>
                            <li class="title-nav-bar2"><a class="title-nav-bar" href="<?php echo HOME_URL . 'views/user_profil.php'; ?>">PROFIL</a></li>4
                        <?php endif; ?>
                        <li class="title-nav-bar2"><a class="title-nav-bar" href="<?php echo HOME_URL . 'views/contact.php'; ?>">CONTACT</a></li>


<!--                        if the id_user exists and it is equal to administrator then we display the link to the profile-->
                        <?php if(isset($_SESSION['role_slug']) && $_SESSION['role_slug'] == 'administrator' ) : ?>
                            <li class="title-nav-bar2"><a class="title-nav-bar" href="<?php echo HOME_URL . 'views/dashboard.php'; ?>">DASHBOARD</a></li>
                        <?php endif; ?>
                    </ul>
                    <div class="content-btn-nav">

                        <ul class="nav-connect">


<!--                            if id_user exists then the disconnected button is displayed, otherwise the connection button and the register button are displayed.-->
                            <?php if(isset($_SESSION['id_user'])) : ?>
                                <li class="disconnect cursor_pointer">
                                    <a class="button-disconnect" href="<?= HOME_URL . 'requests/disconnect.php'; ?>">SE DECONNECTER</a>
                                </li>
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

            <!--         Contents link side bar 1024px              -->
            <div id="side-bar">
                <div class="toggle-btn" id="btnSideBar">
                    <span></span>
                    <span></span>
                    <span></span>
                </div>
                <ul>
                    <li class="content-side-bar-home"><a class="home-text-side-bar" href="<?= HOME_URL; ?>">ACCUEIL</a></li>
                    <li class="content-button-side-bar"><a class="home-text-side-bar" href="<?php echo HOME_URL . 'views/blog.php'; ?>">BLOG</a></li>
                    <?php if(isset($_SESSION['id_user'])) : ?>
                        <li class="content-button-side-bar"><a class="home-text-side-bar" href="<?php echo HOME_URL . 'views/user_profil.php'; ?>">PROFIL</a></li>
                    <?php endif; ?>
                    <li class="content-button-side-bar"><a class="home-text-side-bar" href="<?php echo HOME_URL . 'views/contact.php'; ?>">CONTACT</a></li>

                    <?php if(isset($_SESSION['role_slug']) && $_SESSION['role_slug'] == 'administrator' ) : ?>
                        <li class="content-button-side-bar"><a class="home-text-side-bar" href="<?php echo HOME_URL . 'views/dashboard.php'; ?>">DASHBOARD</a></li>
                    <?php endif; ?>
                    <?php if(isset($_SESSION['id_user'])) : ?>
                        <li class="content-button-side-bar">
                            <a class="home-text-side-bar" href="<?= HOME_URL . 'requests/disconnect.php'; ?>">SE DECONNECTER</a>
                        </li>
                    <?php else : ?>
                        <li class="content-button-side-bar">
                            <a id="to_connect_side_bar" class="home-text-side-bar">CONNEXION</a>
                        </li>
                        <li class="content-button-side-bar">
                            <a class="home-text-side-bar" href="<?php echo HOME_URL . 'views/subscribe.php'; ?>">S'inscrire</a>
                        </li>
                    <?php endif; ?>
                </ul>
            </div>

            <!--                           include modal to connect-->
<!--            --><?php
//            include PATH_PROJECT . '/views/modal_to_connect.php';
//            ?>

            <div class="modal_connect">
                <form action="<?php echo HOME_URL . 'requests/login_post.php'; ?>" method="POST">
                    <p class="modal-connect-title" >Se connecter</p>
                    <div class="content-form-modal">
                        <label class="label-modal-connect" for="email">Email</label>
                        <input  class="input-modal-connect" type="text" name="email">
                    </div>
                    <div class="content-form-modal">
                        <label class="label-modal-connect" for="password">Mot de passe</label>
                        <input  class="input-modal-connect" type="password" name="password">
                    </div>
                    <div class="content-button-connected">
                        <button id="popup-btn" type="submit">Se connecter</button>
                    </div>
                </form>
            </div>
            <!--   Contents modal to connect side bar 1023px-->
            <div class="modal_connect_side_bar">
                <form action="<?php echo HOME_URL . 'requests/login_post.php'; ?>" method="POST">
                    <p class="modal-connect-title-side-bar" >Se connecter</p>
                    <div class="content-form-modal-side-bar">
                        <label class="label-modal-connect-side-bar" for="email">Email</label>
                        <input  class="input-modal-connect-side-bar" type="text" name="email" ">
                    </div>
                    <div class="content-form-modal-side-bar">
                        <label class="label-modal-connect-side-bar" for="password">Mot de passe</label>
                        <input  class="input-modal-connect-side-bar" type="password" name="password">
                    </div>
                    <div class="content-button-connected-side-bar">
                        <button id="popup_btn_side_bar" type="submit">Se connecter</button>
                    </div>
                </form>
            </div>
        </header>