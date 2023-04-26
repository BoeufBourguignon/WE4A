<div id="canvas">
    <div class="post">
        <form class="custom-form" action="changer_mot_de_passe" method="post">
            <div>
                <label for="ancien_mot_de_passe" class="d-inblock">Ancien mot de passe :</label>
                <input type="password" id="ancien_mot_de_passe" name="ancien_mot_de_passe" class="d-inblock">

                <label for="nouveau_mot_de_passe" class="d-inblock">Nouveau mot de passe :</label>
                <input type="password" id="nouveau_mot_de_passe" name="nouveau_mot_de_passe" class="d-inblock">

                <label for="confirmer_mot_de_passe" class="d-inblock">Confirmer le nouveau mot de passe :</label>
                <input type="password" id="confirmer_mot_de_passe" name="confirmer_mot_de_passe" class="d-inblock">
            </div>

            <?php
            echo \Src\Utils::getSessionMsgAsErreur("mot_de_passe_error");
            echo \Src\Utils::getSessionMsgAsSuccess("mot_de_passe_success");
            ?>
            <button type="submit" class="btn btn-orange">Changer le mot de passe</button>
        </form>
    </div>
</div>

<div id="canvas">
    <div class="post">

        <form class="custom-form" action="changer_nom_utilisateur" method="post">
            <div>
                <label for="nouveau_nom_utilisateur" class="d-inblock">Nouveau nom d'utilisateur :</label>
                <input type="text" id="nouveau_nom_utilisateur" name="nouveau_nom_utilisateur" class="d-inblock">
            </div>

            <?php
            echo \Src\Utils::getSessionMsgAsErreur("username_error");
            echo \Src\Utils::getSessionMsgAsSuccess("username_sucess");
            ?>
            <button type="submit" class="btn btn-orange">Changer le nom d'utilisateur</button>
        </form>
    </div>
</div>

<div id="canvas">
    <div class="post">
        <form class="custom-form" action="changer_photo_profil" method="post" enctype="multipart/form-data">
            <div>
                <label for="nouvelle_photo_profil" class="d-inblock">Nouvelle photo de profil :</label>
                <input type="file" id="nouvelle_photo_profil" name="nouvelle_photo_profil" class="d-inblock">
            </div>

            <?php
            echo \Src\Utils::getSessionMsgAsErreur("photo_error");
            echo \Src\Utils::getSessionMsgAsSuccess("photo_success");
            ?>
            <button type="submit" class="btn btn-orange">Changer la photo de profil</button>
        </form>
    </div>
</div>
