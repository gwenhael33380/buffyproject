
<!--Footer file-->

        <footer>
            <!--            contents font awesome-->
            <div class="footer-font-awsome">
                <p class="text-footer">Pour mieux suivre le site</p>
                <div class="content-fa">
                    <a href="https://facebook.com/" target="_blank"><i class="fa-color fa-brands fa-facebook-f"></i></a>
                    <a href="https://twitter.com/" target="_blank"><i class="fa-c fa-brands fa-twitter"></i></a>
                    <a href="https://www.instagram.com/" target="_blank"><i class="fa-c fa-brands fa-instagram"></i></a>
                </div>
            </div>

            <!--            link to different pages of the site-->
            <div class="content-link-footer">
                <a class="link-footer" href="<?php echo HOME_URL . 'views/contact.php'; ?>">Contact</a>
                <a class="link-footer" href="<?php echo HOME_URL . 'views/legal_notice.php'; ?>">Politique de confidentialité</a>
                <a class="link-footer" href="<?php echo HOME_URL . 'views/legal_notice.php'; ?>">Mentions légales</a>
            </div>
            <div>
                <?php


                $views = number_views()
                ?>
                <div class="content-counter">
                    <p class="counter_views" >Il y a eu <?php echo $views ?> visite<span class="plural_function_counter font_weight_counter"><?php echo plural($views)?></span> sur le site</p>

                </div>
            </div>

            <!--         made by and copyright-->
            <div class="copyright">
                <p class="text-copyright">Fait par Gwen-Haël</p>
                <p class="text-copyright-m text-copyright">© 2022 - BuffyProject TOUS DROITS RÉSERVÉS</p>
            </div>
            <div class="footer-end"></div>
            <div class="footer-end2"></div>
        </footer>

    <!--    external and internal javascript link-->
    <!--            CDN Jquery-->
    <script src="https://code.jquery.com/jquery-3.6.0.js" integrity="sha256-H+K7U5CnXl1h5ywQfKtSj8PCmoN9aaq30gDh27Xc0jk=" crossorigin="anonymous"></script>

    <!--            CDN JS Bootstrap           -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ho+j7jyWK8fNQe+A12Hb8AhRq26LrZ/JpcUGGOn+Y7RsweNrtN/tE3MoK7ZeZDyx" crossorigin="anonymous"></script>
    <!--          internal link JS -->
    <script type="text/javascript" src="<?php echo HOME_URL . 'assets/js/dist/scripts.min.js'; ?>"></script>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.7.2/jquery.min.js"></script>
    </body>
<?php include PATH_PROJECT . '/views/banner_cookie.php'; ?>
</html>