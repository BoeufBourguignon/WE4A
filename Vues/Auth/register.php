<div id="canvas">
    <div class="post">
        <form id="login-form" method="post" action="/form_register">
            <h1>S'inscrire</h1>
            <div>
                <label for="username" class="d-inblock">Nom d'utilisateur</label>
                <input id="username" type="text" name="username" class="d-inblock" required>
                <label for="password" class="d-inblock">Mot de passe</label>
                <input id="password" type="password" name="password" class="d-inblock" pattern="^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&#])[A-Za-z\d@$!%*?&#]{8,}$" required>
                <p id="password-indication" class="no-margin muted">Le mot de passe doit contenir au moins une lettre majuscule, une lettre minuscule, un chiffre et doit être d'au moins 8 caractères</p>
                <label for="password-verify" class="d-inblock">Vérifier le mot de passe</label>
                <input id="password-verify" type="password" name="password-verify" class="d-inblock" required>
            </div>
            <?php
            echo \Src\Utils::getSessionMsgAsErreur("register_error");
            ?>
            <button type="submit" class="btn btn-orange">S'inscrire</button>
            <p class="muted">Vous avez déjà un compte ? <a class="txt-orange" href="/login">Se connecter</a></p>
        </form>
    </div>
</div>
