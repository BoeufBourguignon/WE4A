<?php $lastUsername = \Src\Utils::getSessionMsg("last_username") ?>

<div id="canvas">
    <div class="post">
        <form id="login-form" method="post" action="/form_login">
            <input name="typeFormulaire" value="changerUsername" type="hidden">

            <h1>Se connecter</h1>
            <div>
                <label for="username" class="d-inblock">Nom d'utilisateur</label>
                <input id="username" type="text" name="username" class="d-inblock" required value="<?php echo $lastUsername ?>">
                <label for="password" class="d-inblock">Mot de passe</label>
                <input id="password" type="password" name="password" class="d-inblock" required <?php if($lastUsername != null) echo "autofocus" ?>>
            </div>
            <?php
            echo \Src\Utils::getSessionMsgAsErreur("login_error");
            echo \Src\Utils::getSessionMsgAsSuccess("register_success");
            ?>
            <button type="submit" class="btn btn-orange">Se connecter</button>
            <p class="muted">Pas de compte ? <a class="txt-orange" href="/register">S'inscrire</a></p>
        </form>
    </div>
</div>

<div id="canvas">
    <div class="post">
        <form id="login-form" method="post" action="/form_login">
            <input name="typeFormulaire" value="changerPassword" type="hidden">

            <h1>Se connecter</h1>
            <div>
                <label for="username" class="d-inblock">Nom d'utilisateur</label>
                <input id="username" type="text" name="username" class="d-inblock" required value="<?php echo $lastUsername ?>">
                <label for="password" class="d-inblock">Mot de passe</label>
                <input id="password" type="password" name="password" class="d-inblock" required <?php if($lastUsername != null) echo "autofocus" ?>>
            </div>
            <?php
            echo \Src\Utils::getSessionMsgAsErreur("login_error");
            echo \Src\Utils::getSessionMsgAsSuccess("register_success");
            ?>
            <button type="submit" class="btn btn-orange">Se connecter</button>
            <p class="muted">Pas de compte ? <a class="txt-orange" href="/register">S'inscrire</a></p>
        </form>
    </div>
</div>
