<!--Contents modal to connect-->

<div class="modal_connect">
    <form action="<?php echo HOME_URL . 'requests/login_post.php'; ?>" method="POST">
        <p class="modal-connect-title" >Se connecter</p>

            <i class="fa-solid fa-xmark param_cross"></i>

        <div class="content-form-modal">
            <label class="label-modal-connect" for="email">Email</label>
            <input  class="input-modal-connect" type="text" name="email" required>
        </div>
        <div class="content-form-modal">
            <label class="label-modal-connect" for="password">Mot de passe</label>
            <input  class="input-modal-connect" type="password" name="password" required>
        </div>
        <div class="content-button-connected">
            <button id="popup-btn" type="submit">Se connecter</button>
        </div>
    </form>
</div>