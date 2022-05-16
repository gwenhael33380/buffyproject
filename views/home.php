<?php
require __DIR__ . '/header.php';


?>
    <main>
        <!--    Section 1 title and first section-->
        <section class="section-1-home">

            <div class="content-btn-nav-sect-1" >
                <a class="btn-nav-sec-1 bgc-btn-sec1" href="">Contact</a>
                <a class="btn-nav-sec-1 bgc-btn-sec2" href="">Blog</a>
            </div>
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
        <section class="section-3-h">
            <div class="content-title-acces-blog">
                <h2 class="title-acces-blog">le blog</h2>
            </div>
            <div class="content-img-acces-blog">
                <div class="content-img-flex-blog">
                    <div>
                        <img class="img-acces-blog" src="<?php echo HOME_URL . 'assets/img/src/source/sarah-michelle-gellar.jpg'; ?>" alt="">
                    </div>
                    <div class="content-button-acces-blog">
                        <a class="button-acces-blog" href="<?php echo HOME_URL . 'views/blog.php'; ?>">BLOG</a>
                    </div>
                </div>
            </div>
        </section>

        <!--        Section 4 page contact acces-->

        <section class="section-4-home">
            <div class="content-title-acces-contact">
                <h2 class="title-acces-contact">contact</h2>
            </div>
            <div class="content-contact">
                <div class="content-img-flex-contact">

                    <div class="content-button-acces-contact">
                        <a class="button-acces-contact"href="<?php echo HOME_URL . 'views/contact.php'; ?>">contact</a>
                    </div>
                    <div >
                        <img class="img-acces-contact" src="<?php echo HOME_URL . 'assets/img/src/source/buffy-the-vampire-slayer-.jpg'; ?>" alt="">
                    </div>
                </div>
            </div>

        </section>

    </main>



























<?php
require PATH_PROJECT . '/views/footer.php';
