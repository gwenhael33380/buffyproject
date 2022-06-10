<?php
require dirname(__DIR__) . '/functions.php';
require_once PATH_PROJECT . '/connect.php';
define('TITLE', 'Accueil');

require __DIR__ . '/header.php';


?>
    <main>
        <!--    Section 1 title and first section-->
        <section class="section-1-home">

            <div class="msg-connexion">
                <?php
                if(isset($_GET['msg'])) {
                    echo $_GET['msg'];
                } ?>
            </div>
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
                    <h2 class="title-personage">Buffy Project</h2>
                </div>
            </div>
            <div class="bg-carousel">
                <div id="carouselExampleControls" class="carousel slide" data-ride="carousel">
                    <div class="carousel-inner">
                        <div class="carousel-item active">
                            <div class="cards-wrapper">
                                <div class="card">
                                    <img src="<?php echo HOME_URL . 'assets/img/src/carousel/1.buffy.png'; ?>" class="card-img-top" alt="Buffy Anne Summers peronnage principal">
                                    <div class="card-body">
                                        <h3 class="card-title">Buffy Anne Summers</h3>
                                        <div class="content-link-carousel">
                                            <a href="https://fr.wikipedia.org/wiki/Buffy_Summers" target="_blank" class="btn btn-carousel">En savoir plus...</a>
                                        </div>
                                    </div>
                                </div>
                                <div class="card d-none d-md-block">
                                    <img src="<?php echo HOME_URL . 'assets/img/src/carousel/2.angel.png'; ?>" class="card-img-top" alt="Angle alias Angelus personnage principal">
                                    <div class="card-body">
                                        <h3 class="card-title">Angel alias Angelus</h3>
                                        <div class="content-link-carousel">
                                            <a href="https://fr.wikipedia.org/wiki/Angel_(Buffy_contre_les_vampires)" target="_blank" class="btn btn-carousel2">En savoir plus...</a>
                                        </div>
                                    </div>
                                </div>
                                <div class="card d-none d-md-block">
                                    <img src="<?php echo HOME_URL . 'assets/img/src/carousel/3.giles.png'; ?>" class="card-img-top" alt="Giles personnage secondaire">
                                    <div class="card-body">
                                        <h3 class="card-title">Ruppert Giles</h3>
                                        <div class="content-link-carousel">
                                            <a href="https://fr.wikipedia.org/wiki/Rupert_Giles" target="_blank" class="btn btn-carousel">En savoir plus...</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="carousel-item">
                            <div class="cards-wrapper">
                                <div class="card">
                                    <img src="<?php echo HOME_URL . 'assets/img/src/carousel/4.alex.png'; ?>" class="card-img-top" alt="Alexander Harris personnage principal">
                                    <div class="card-body">
                                        <h3 class="card-title">Alexander Harris</h3>
                                        <div class="content-link-carousel">
                                            <a href="https://fr.wikipedia.org/wiki/Alexander_Harris" target="_blank" class="btn btn-carousel2">En savoir plus...</a>
                                        </div>
                                    </div>
                                </div>
                                <div class="card d-none d-md-block">
                                    <img src="<?php echo HOME_URL . 'assets/img/src/carousel/5.willow.png'; ?>" class="card-img-top" alt="Willow Rosenberg personnage principal">
                                    <div class="card-body">
                                        <h3 class="card-title">Willow Rosenberg</h3>
                                        <div class="content-link-carousel">
                                            <a href="https://fr.wikipedia.org/wiki/Willow_Rosenberg" target="_blank" class="btn btn-carousel">En savoir plus...</a>
                                        </div>
                                    </div>
                                </div>
                                <div class="card d-none d-md-block">
                                    <img src="<?php echo HOME_URL . 'assets/img/src/carousel/6.oz.png'; ?>" class="card-img-top" alt="Oz personnage secondaire">
                                    <div class="card-body">
                                        <h3 class="card-title">Oz</h3>
                                        <div class="content-link-carousel">
                                            <a href="https://fr.wikipedia.org/wiki/Oz_(Buffy)" target="_blank" class="btn btn-carousel2">En savoir plus...</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="carousel-item">
                            <div class="cards-wrapper">
                                <div class="card">
                                    <img src="<?php echo HOME_URL . 'assets/img/src/carousel/7.riley.png'; ?>" class="card-img-top" alt="Riley Finn personnage secondaire">
                                    <div class="card-body">
                                        <h3 class="card-title">Riley Finn</h3>
                                        <div class="content-link-carousel">
                                            <a href="https://fr.wikipedia.org/wiki/Riley_Finn" target="_blank" class="btn btn-carousel">En savoir plus...</a>
                                        </div>
                                    </div>
                                </div>
                                <div class="card d-none d-md-block">
                                    <img src="<?php echo HOME_URL . 'assets/img/src/carousel/8.dawn.png'; ?>" class="card-img-top" alt="Dawn Summers personnage principal">
                                    <div class="card-body">
                                        <h3 class="card-title">Dawn Summers</h3>
                                        <div class="content-link-carousel">
                                            <a href="https://fr.wikipedia.org/wiki/Dawn_Summers" target="_blank" class="btn btn-carousel2">En savoir plus...</a>
                                        </div>
                                    </div>
                                </div>
                                <div class="card d-none d-md-block">
                                    <img src="<?php echo HOME_URL . 'assets/img/src/carousel/9.joyce'; ?>" class="card-img-top" alt="Joyce Summers personnage secondaire">
                                    <div class="card-body">
                                        <h3 class="card-title">Joyce Summers</h3>
                                        <div class="content-link-carousel">
                                            <a href="https://fr.wikipedia.org/wiki/Joyce_Summers" target="_blank" class="btn btn-carousel">En savoir plus...</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="carousel-item">
                            <div class="cards-wrapper">
                                <div class="card">
                                    <img src="<?php echo HOME_URL . 'assets/img/src/carousel/10.spike.png'; ?>" class="card-img-top" alt="Spike alias Willam le sanguinaire personnage secondaire">
                                    <div class="card-body">
                                        <h3 class="card-title">Spike alias Willam le sanguinaire</h3>
                                        <div class="content-link-carousel">
                                            <a href="https://fr.wikipedia.org/wiki/Spike_(Buffy)" target="_blank" class="btn btn-carousel2">En savoir plus...</a>
                                        </div>
                                    </div>
                                </div>
                                <div class="card d-none d-md-block">
                                    <img src="<?php echo HOME_URL . 'assets/img/src/carousel/11.cordelia'; ?>" class="card-img-top" alt="Cordelia chase personnage secondaire">
                                    <div class="card-body">
                                        <h5 class="card-title">Cordelia chase</h5>
                                        <div class="content-link-carousel">
                                            <a href="https://fr.wikipedia.org/wiki/Cordelia_Chase" target="_blank" class="btn btn-carousel">En savoir plus...</a>
                                        </div>
                                    </div>
                                </div>
                                <div class="card d-none d-md-block">
                                    <img src="<?php echo HOME_URL . 'assets/img/src/carousel/12.wesley.png'; ?>" class="card-img-top" alt="Wesley Wyndam-Pryce personnage secondaire">
                                    <div class="card-body">
                                        <h3 class="card-title">Wesley Wyndam-Pryce</h3>
                                        <div class="content-link-carousel">
                                            <a href="https://fr.wikipedia.org/wiki/Wesley_Wyndam-Pryce" target="_blank" class="btn btn-carousel2">En savoir plus...</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="carousel-item">
                            <div class="cards-wrapper">
                                <div class="card">
                                    <img src="<?php echo HOME_URL . 'assets/img/src/carousel/13.tara.png'; ?>" class="card-img-top" alt="Tara Maclay personnage secondaire">
                                    <div class="card-body">
                                        <h3 class="card-title">Tara Maclay</h3>
                                        <div class="content-link-carousel">
                                            <a href="https://fr.wikipedia.org/wiki/Tara_Maclay" target="_blank" class="btn btn-carousel">En savoir plus...</a>
                                        </div>
                                    </div>
                                </div>
                                <div class="card d-none d-md-block">
                                    <img src="<?php echo HOME_URL . 'assets/img/src/carousel/14.faith.png'; ?>" class="card-img-top" alt="Faith Lehane personnage secondaire">
                                    <div class="card-body">
                                        <h3 class="card-title">Faith Lehane</h3>
                                        <div class="content-link-carousel">
                                            <a href="https://fr.wikipedia.org/wiki/Faith_Lehane" target="_blank" class="btn btn-carousel2">En savoir plus...</a>
                                        </div>
                                    </div>
                                </div>
                                <div class="card d-none d-md-block">
                                    <img src="<?php echo HOME_URL . 'assets/img/src/carousel/15.jenny.png'; ?>" class="card-img-top" alt="Jenny Calendar personnage seconadaire">
                                    <div class="card-body">
                                        <h3 class="card-title">Jenny Calendar</h3>
                                        <div class="content-link-carousel">
                                            <a href="https://fr.wikipedia.org/wiki/Jenny_Calendar" target="_blank" class="btn btn-carousel">En savoir plus...</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <a class="carousel-control-prev" href="#carouselExampleControls" role="button" data-slide="prev">
                        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                        <span class="sr-only">Previous</span>
                    </a>
                    <a class="carousel-control-next" href="#carouselExampleControls" role="button" data-slide="next">
                        <span class="carousel-control-next-icon" aria-hidden="true"></span>
                        <span class="sr-only">Next</span>
                    </a>
                </div>
            </div>
        </section>
        <section class="section-3-h">
            <div class="content-title-acces-blog">
                <h2 class="title-acces-blog">le blog</h2>
            </div>
            <div class="content-img-acces-blog">
                <div class="content-img-flex-blog">
                    <img class="img-acces-blog" src="<?php echo HOME_URL . 'assets/img/src/source/sarah-michelle-gellar.jpg'; ?>" alt="image représentant l'accès au blog">
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

                    <img class="img-acces-contact" src="<?php echo HOME_URL . 'assets/img/src/source/buffy-the-vampire-slayer-.jpg'; ?>" alt="image représentant l'accès à la page contact">
                </div>
            </div>
        </section>

    </main>
<?php
require PATH_PROJECT . '/views/footer.php';
