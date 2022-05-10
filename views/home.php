<?php
require __DIR__ . '/header.php';

?>
<h1></h1>
<main>
<!--    Section 1 title and first section-->
    <section class="section-1-home">

    <div class="content-btn-nav-sect-1" >
            <a class="btn-nav-sec-1 bgc-btn-sec1" href="">Contact</a>
            <a class="btn-nav-sec-1 bgc-btn-sec2" href="">Blog</a>
    </div class="section-2-home">
    </section>
<!--    Section 2 character carousel-->
    <section class="section-2-home">
        <div class="content-title-home">
            <h1 class="title-home">accueil</h1>
        </div>
        <div class="spacing-home">
            <div class="content-text-personage">
                <h2 class="title-personage">les personnages</h2>
            </div>
        </div>
    </section>
<!--    Section 3 blog access-->
    <section class="section-3-home">
        <div class="content-title-acces-blog">
            <h2 class="title-acces-blog">le blog</h2>
        </div>
        <div class="img-acces-blog">
            <img src="<?php echo HOME_URL . 'assets/img/src/source/sarah-michelle-gellar.jpg'; ?>" alt="">
            <a href=""></a>
        </div>
    </section>

</main>



























<?php
require PATH_PROJECT . '/views/footer.php';
