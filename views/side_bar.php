

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
                <a id="to_connect_side_bar" class="to_connect home-text-side-bar">CONNEXION</a>
            </li>
            <li class="content-button-side-bar">
                <a class="home-text-side-bar" href="<?php echo HOME_URL . 'views/subscribe.php'; ?>">S'inscrire</a>
            </li>
        <?php endif; ?>
    </ul>
</div>
