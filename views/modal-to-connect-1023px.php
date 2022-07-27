<div class="modal_connect_side_bar">
    <form action="<?php echo HOME_URL . 'requests/login_post.php'; ?>" method="POST">
        <p class="modal-connect-title-side-bar" >Se connecter</p>
        <div class="content-form-modal-side-bar">
            <label class="label-modal-connect-side-bar" for="email">Email</label>
            <input  class="input-modal-connect-side-bar" type="text" name="email" ">
        </div>
        <div class="content-form-modal-side-bar">
            <label class="label-modal-connect-side-bar" for="password">Mot de passe</label>
            <input  class="input-modal-connect-side-bar" type="password" name="password">
        </div>
        <div class="content-button-connected-side-bar">
            <button id="popup_btn_side_bar" type="submit">Se connecter</button>
        </div>
    </form>
</div>
