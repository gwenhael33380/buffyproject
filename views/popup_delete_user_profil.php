<!--popup delete user user profil.php-->

<div class="popup">
    <h3 class="title-popup-delete-user">Etes vous sûre de vouloir supprimer votre profil ?</h3>
    <div class="content-img-delete-user">
        <img class="img-delete-profil" src="<?php echo HOME_URL . 'assets/img/dist/source/delete_user.jpg'; ?> " alt="Image de Sarah Michel Gelard sautant dans le vide">
    </div>
    <p class="text-popup-delete-user" >Cette action est irreversible et entrainera la perte de toutes vos données sur le site !</p>
    <div class="content-button-popup-delete-user">
        <a id="popupBtnDeleteUser" class="button-delete-user button-delete-1" >Annulé</a>
        <a  class="button-delete-user button-delete-2" href="<?php echo HOME_URL . 'requests/users_delete_post.php?id=' . $result->id; ?>" > OK</a>
    </div>
</div>