<?php
require __DIR__ . '/header.php';

?>
    <main class="main-page-contact">
        <section>
            <div class="bg-page-contact">

            </div>
            <div class="content-title-contact">
                <h2 class="title-form-contact">Fomrulaire de contact</h2>
            </div>
            <div>
                <form action="<?=HOME_URL. 'requests/form_post.php'?>" method="post">
                    <div>
                        <label for="email">email<span class="red"></span>*</label>
                        <input type="text" id="email" name="email" value="" placeholder="email..."/>
                    </div>
                    <div>
                        <label for="subject">sujet <span class="red">*</span> </label>
                        <input type="text" name="subject" value="" placeholder="sujet..." />
                    </div>
                    <div>
                        <label for="message">Votre message<span class="red">*</span></label>
                        <textarea name="message" cols="40" rows="5" placeholder="60 cartactères minimum..."></textarea>
                    </div>
                    <button class="button-form" type="submit">envoyer </button>
                </form>
            </div>
        </section>

    </main>





























<?php
require PATH_PROJECT . '/views/footer.php';
