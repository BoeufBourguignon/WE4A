<div id="canvas">
    <div class="post">
        <form id="login-form" method="post" action="/form_login">
            <h1>Se connecter</h1>
            <div>
                <label for="username" class="d-inblock">Nom d'utilisateur</label>
                <input id="username" type="text" name="username" class="d-inblock" required>
                <label for="password" class="d-inblock">Mot de passe</label>
                <input id="password" type="password" name="password" class="d-inblock" required>
            </div>
            <?php
            echo \Src\Utils::getSessionMsg("login_error");
            ?>
            <button type="submit" class="btn btn-orange">Se connecter</button>
            <p class="muted">Pas de compte ? <a class="txt-orange" href="/register">S'inscrire</a></p>
        </form>
    </div>
</div>
