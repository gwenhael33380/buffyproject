<ul class="navigation
">
    <!-- chevron de gauche -->
    <?php if($current_page == 1) : ?>
        <li class="disabled"><i class="fas fa-chevron-left"></i></li>
    <?php else : ?>
        <li class=""><a href="<?php echo HOME_URL . 'views/blog.php'; ?>?page=<?php echo $current_page - 1; ?>"><i class="fas fa-chevron-left"></i></a></li>
    <?php endif; ?>

    <!-- navigation en cliquant directement sur la page demandée -->
    <?php for($i = 1; $i <= $number_pages; $i++) : ?>

        <?php if($i == $current_page) : ?>
            <li class="active"><?php echo $i; ?></li>
        <?php else: ?>
            <li class="futur_page"><a href="<?php echo HOME_URL . 'views/blog.php'; ?>?page=<?php echo $i; ?>"><?php echo $i; ?></a></li>
        <?php endif; ?>

    <?php endfor; ?>



    <!-- chevron de droite -->
    <?php if($current_page == $number_pages) : ?>
        <li class="disabled"><i class="fas fa-chevron-right"></i></li>
    <?php else : ?>
        <li class=""><a href="<?php echo HOME_URL . 'views/blog.php'; ?>?page=<?php echo $current_page + 1; ?>"><i class="fas fa-chevron-right"></i></a></li>
    <?php endif; ?>
</ul>