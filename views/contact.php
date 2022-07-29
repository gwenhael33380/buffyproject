<?php


require dirname(__DIR__) . '/functions.php'; //call function.php
require_once PATH_PROJECT . '/connect.php'; //call connect.php

define('TITLE', 'Page de contact'); //title tag definition
define('META_DESCRIPTION', 'la page contact permet met à disposition de tous un formulaire pour contacter l\'administrateur du site en cas de problème lié au site ou simplement soumettre des idées sur des axes d\'améliorations du site.'); // Define meta description

require __DIR__ . '/header.php'; //call header

?>
    <main class="main-page-contact content">
        <section>
            <div class="bg-page-contact">

            </div>
            <div class="content-title-contact">
                <h2 class="title-form-contact">Formulaire de contact</h2>
            </div>
                <div class="content-form-contact">

<!--                    returns the content of the fields to the form form post.php-->
                    <form action="<?=HOME_URL. 'requests/form_post.php'?>" method="post">
                        <div class="field-contact">
                            <label class="form-label"for="email">Email<span class="red">*</span></label>
                            <input class="input-form" type="text" id="email" name="email" placeholder="email..."/>
                        </div>
                        <div class="field-contact">
                            <label class="form-label" for="subject">Sujet <span class="red">*</span> </label>
                            <input class="input-form" type="text" name="subject" minlength="10" maxlength="120" placeholder="sujet, minimum 10 caractères, maximum 120...." />
                        </div>
                        <div class="field-contact">
                            <label class="form-label" for="message">Votre message<span class="red">*</span></label>
                            <textarea class="textarea-form" name="message" cols="40" rows="5" minlength="60" placeholder="60 cartactères minimum..."></textarea>
                        </div>
                        <div class="content-button-form-contact">
                            <button class="button-form" type="submit">envoyer </button>
                        </div>
                    </form>
                </div>
        </section>
    </main>





























<?php
require PATH_PROJECT . '/views/footer.php';
