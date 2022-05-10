<?php
require dirname(__DIR__) . '/functions.php';
?>

<!doctype html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    <link rel="stylesheet" href="<?php echo HOME_URL . 'assets/css/dist/main.min.css'; ?>">
</head>
<body>
    <nav id="nav-bar" <?php echo isset($_SESSION['user_id']) ? 'class="connect"' : 'class="disconnect"'; ?> >
        <div class="logo-nav-bar">
            <img src="<?php echo HOME_URL . 'assets/img/src/source/Logo_with.png'; ?>" alt="">
        </div>
        <ul class="nav-bar-list">
            <li class="title-nav-bar2"><a class="title-nav-bar" href="<?= HOME_URL; ?>">ACCUEIL</a></li>
            <li class="title-nav-bar2"><a class="title-nav-bar" href="<?php echo HOME_URL . 'views/blog.php'; ?>">BLOG</a></li>
            <li class="title-nav-bar2"><a class="title-nav-bar" href="<?php echo HOME_URL . 'views/profil.php'; ?>">PROFIl</a></li>
            <li class="title-nav-bar2"><a class="title-nav-bar" href="<?php echo HOME_URL . 'views/contact.php'; ?>">CONTACT</a></li>
            <li class="title-nav-bar2"><a class="title-nav-bar" href="<?php echo HOME_URL . 'views/dashboard.php'; ?>">DASHBOARD</a></li>
        </ul>
        <div class="content-btn-nav">
            <a class="btn-nav btn-nav-bar1" href="">S'inscrire</a>
            <a class="btn-nav btn-nav-bar2" href="">Connexion</a>
        </div>

    </nav>



