<?php

echo $this ->auth ->getUser() -> getUsername();
?>


<div id="canvas">
    <div class="post">
    <form action="changer_mot_de_passe" method="post">
  <label for="ancien_mot_de_passe">Ancien mot de passe :</label>
  <input type="password" id="ancien_mot_de_passe" name="ancien_mot_de_passe"><br>

  <label for="nouveau_mot_de_passe">Nouveau mot de passe :</label>
  <input type="password" id="nouveau_mot_de_passe" name="nouveau_mot_de_passe"><br>

  <label for="confirmer_mot_de_passe">Confirmer le nouveau mot de passe :</label>
  <input type="password" id="confirmer_mot_de_passe" name="confirmer_mot_de_passe"><br>

  <input type="submit" value="Changer le mot de passe">
</form>
    </div>
</div>


<div id="canvas">
    <div class="post">

<form action="changer_nom_utilisateur" method="post">
  <label for="nouveau_nom_utilisateur">Nouveau nom d'utilisateur :</label>
  <input type="text" id="nouveau_nom_utilisateur" name="nouveau_nom_utilisateur"><br>

  <input type="submit" value="Changer le nom d'utilisateur">
</form>
</div>
</div>


<div id="canvas">
    <div class="post">
<form action="changer_photo_profil" method="post" enctype="multipart/form-data">
  <label for="nouvelle_photo_profil">Nouvelle photo de profil :</label>
  <input type="file" id="nouvelle_photo_profil" name="nouvelle_photo_profil"><br>

  <input type="submit" value="Changer la photo de profil">
<?php
echo \Src\Utils::getSessionMsgAsErreur("photo_error");
echo \Src\Utils::getSessionMsgAsSuccess("photo_success");
  ?>
</form>
</div>
</div>
