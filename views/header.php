<!doctype html> <!--specification of language rules-->

<html lang="fr"> <!--language-->
<head>
    <meta charset="UTF-8"> <!--    character encoding-->
    <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0"> <!--    display setup-->
    <meta http-equiv="X-UA-Compatible" content="ie=edge"> <!--    Compatibility of Microsoft EADGE-->
    <link rel="shortcut icon" href="<?= HOME_URL . '/favicon.ico'; ?>" type="image/x-icon"> <!--    link Favicon-->
    <link rel="icon" href=""<?= HOME_URL . '/favicon.ico'; ?>" type="image/x-icon"> <!--    link Favicon-->
    <title>Buffy Project | <?php echo TITLE; ?></title> <!--    balise title dynamic-->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/css/bootstrap.min.css" integrity="sha384-TX8t27EcRE3e/ihU7zmQxVncDAy5uIKz4rEkgIXeMed4M0jlfIDPvg6uqKI2xXr2" crossorigin="anonymous"> <!--    link CDN Bootstrap-->
    <link rel="stylesheet" href="<?php echo HOME_URL . 'assets/css/dist/main.min.css'; ?>"> <!--    link CSS style-->
    <?php  if(defined('META_DESCRIPTION')) : ?>
    <meta name="description" content="<?php echo META_DESCRIPTION; ?>"
    <?php else : ?>
        <meta name="description" content="<?php echo META_DEFAULT; ?>">
    <?php endif; ?>

</head>
    <body>
        <header>

        <!--    Contents link nav bar-->
            <div class="display-nav">
                <nav id="navbar" class="relative <?php echo isset($_SESSION['user_id']) ? 'connect' : 'disconnect'; ?>" >
                    <div class="logo-nav-bar">
                        <a href="<?= HOME_URL; ?>"><img src="<?php echo HOME_URL . 'assets/img/src/source/Logo_with.png'; ?>" alt="Logo du site"></a>
                    </div>
                    <ul class="nav-bar-list">
                        <li class="title-nav-bar2"><a class="title-nav-bar" href="<?= HOME_URL; ?>">ACCUEIL</a></li>
                        <li class="title-nav-bar2"><a class="title-nav-bar" href="<?php echo HOME_URL . 'views/blog.php'; ?>">BLOG</a></li>

<!--                        if the id_user exists then we display the link to the profile-->
                        <?php if(isset($_SESSION['id_user'])) : ?>
                            <li class="title-nav-bar2"><a class="title-nav-bar" href="<?php echo HOME_URL . 'views/user_profil.php'; ?>">PROFIL</a></li>
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
                    <?php

                    //                message $_GET
                    if(isset($_GET['msg'])) {
                        echo $_GET['msg'];
                    } ?>
                </nav>

            </div>


            <?php

            include PATH_PROJECT . '/views/modal_to_connect.php'; //           include modal to connect modal_to_connect.php
            include PATH_PROJECT . '/views/side_bar.php'; //            include modal to connect side bar breakpoint 1023px side_bar.php

            ?>
        </header>