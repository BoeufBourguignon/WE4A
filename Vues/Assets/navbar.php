<nav id='main-nav'>
    <a href="/home" id="main-title">Read<span class="txt-orange">it</span></a>
    <div id="navbar-search-container">
        <label for='search' hidden></label><input type='text' id='search' placeholder='Rechercher...'>
        <div id="navbar-search-content" class="d-none">
<!--            <a class="pointer" id="navbar-search-post">Rechercher '<span id="navbar-search-word"></span>'</a>-->
            <div id="navbar-search-categ"></div>
            <div id="navbar-search-user"></div>
        </div>
    </div>
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
