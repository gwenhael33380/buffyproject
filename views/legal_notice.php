<?php
require dirname(__DIR__) . '/functions.php'; //call function.php
require_once PATH_PROJECT . '/connect.php'; //call connect.php
define('TITLE', 'Mention l\'égale');//title tag definition
define('META_DESCRIPTION', ''); // Define meta description

require __DIR__ . '/header.php'; //call header.php

?>

<main>
    <section>
        <div class="bg-page-legal-notice"></div>

            <div class="content-title-page-legal-notice">
                <h1 class="title-page-legal-notice">Mentions légal</h1>
            </div>

        <div class="content-legal-mention">
            <h2 class="title-legal-notice"> <strong> BuffyProject</strong> est un site indépendant</h2>
            <p>Il est hébergé par :</p>

            <div class="content-address-host">
                <p>Planet Hoster</p>
                <p>4416 Rue Louis B. Mayer</p>
                <p>Laval, </p>
                <p>QUEBEC</p>
                <p>H7P 0G1</p>
                <p>Canada</p>
                <div class="flex-contact-lega-notice">
                    <a href="tel:+33(0)176604143">Téléphone +33(0)176604143</a>
                </div>

            </div>
            <div class="use-of-personal-data">
                <h2>Utilisation des données personnelles collectées</h2>
                <div class="content-comment-info-legal-notice">
                    <h3>Commentaires</h3>
                    <p>Quand vous laissez un commentaire sur notre site web, les données inscrites dans le formulaire de commentaire, mais aussi votre adresse IP et l’agent utilisateur de votre navigateur sont collectés pour nous aider à la détection des commentaires indésirables.</p>
                </div>
                <div class="content-comment-info-legal-notice">
                    <h3>Médias</h3>
                    <p>Si vous êtes un utilisateur ou une utilisatrice enregistrée et que vous téléversez des images sur le site web, nous vous conseillons d’éviter de téléverser des images contenant des données EXIF de coordonnées GPS. Les visiteurs de votre site web peuvent télécharger et extraire des données de localisation depuis ces images.</p>
                </div>
                <div class="content-comment-info-legal-notice">
                    <h3>Formulaires de contact</h3>
                    <p>Quand vous utilisez le formulaire de contact, les données inscrites ne sont pas utilisées à des fins commerciales.</p>
                </div>
                <div class="content-comment-info-legal-notice">
                    <h3>Cookies</h3>
                    <p>Lorsque vous aurez créé un compte et que vous vous connecterez, nous mettrons en place un cookie afin que vous puissiez visualiser votre dernière connexion dans la page de votre profil. Cette information est aussi consultable par les administrateurs du site.</p>
                    <p>Un autre cookie est généré quand vous accepter l'utilisation des cookies, ces deux cookies ont une durée de validité d'un an, au bout de ses délais le cookie ayant atteint cette date sera automatiquement supprimée de votre navigateur.</p>
                </div>
                <div class="content-comment-info-legal-notice">
                    <h3>Contenu embarqué depuis d’autres sites</h3>
                    <p>Les articles de ce site peuvent inclure des contenus intégrés (par exemple des vidéos, images, articles…). Le contenu intégré depuis d’autres sites se comporte de la même manière que si le visiteur se rendait sur cet autre site.</p>
                    <p>Ces sites web pourraient collecter des données sur vous, utiliser des cookies, embarquer des outils de suivis tiers, suivre vos interactions avec ces contenus embarqués si vous disposez d’un compte connecté sur leur site web.</p>
                </div>
                <div class="content-comment-info-legal-notice">
                    <h3>Utilisation et transmission de vos données personnelles</h3>
                    <p>BuffyProject Blog ne partage vos informations personnelles avec aucun tiers.</p>
                </div>
                <div class="content-comment-info-legal-notice">
                    <h3>Durées de stockage de vos données</h3>
                    <p>Pour les utilisateurs et utilisatrices qui s’inscrivent sur notre site, nous stockons également les données personnelles indiquées dans leur profil. Tous les utilisateurs et utilisatrices peuvent voir, modifier ou supprimer leurs informations personnelles à tout moment. Les gestionnaires du site peuvent aussi voir et modifier ces informations.</p>
                </div>
                <div class="content-comment-info-legal-notice">
                    <h3>Les droits que vous avez sur vos données</h3>
                    <p>Si vous avez un compte et que vous avez laissé des commentaires sur le site, vous pouvez demander à recevoir un fichier contenant toutes les données personnelles que nous possédons à votre sujet, incluant celles que vous nous avez fournies. Vous pouvez également demander la suppression des données personnelles vous concernant.</p>
                </div>
                <div class="content-comment-info-legal-notice">
                    <h3>Informations de contact</h3>
                    <p>Pour toute question relative aux présentes conditions d’utilisation du site, vous pouvez nous écrire à l’adresse mail suivante : <a href="mailto:le.corre.gwen.hael@dev-events.com">le.corre.gwen.hael@dev-events.com</a></p>
                </div>
            </div>
        </div>
        <div class="content-button-return-home-page">
            <a href="<?php echo HOME_URL . '/views/home.php'  ?>" class="button-return-home-page">Retour à la page principal</a>
        </div>
    </section>
</main>














































<?php
require __DIR__ . '/footer.php'; //call header.php