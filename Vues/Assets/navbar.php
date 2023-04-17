<nav id='main-nav'>
    <a href="/home">Accueil</a>
    <label for='search' class="d-none">Rechercher</label><input type='text' id='search' placeholder='Rechercher...'>
    <?php if ($this->auth->getUser()) { ?>
        <div id="user-profile">
            <button id="user-btn" aria-expanded="false">
                <img alt="user profile picture" src="<?php echo $this->auth->getUser()->getAvatar() ?>">
                <?php echo $this->auth->getUser()->getUsername() ?>
            </button>
            <div id="user-actions" aria-expanded="false">
                <a href="/profile">Profile</a>
                <a href="/user/<?php echo $this->auth->getUser()->getUsername() ?>">Mes posts</a>
                <a href="/logout" class="txt-danger">Se déconnecter</a>
            </div>
        </div>
    <?php } else { ?>
        <a href="/login" class="btn btn-orange">
            Se connecter
        </a>
    <?php } ?>
</nav>
