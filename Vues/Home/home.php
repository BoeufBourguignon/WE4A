<div id="canvas">
    <?php
    if(!$this->auth->getUser() == null)
        include_once(VIEWS."/Post/createPost.php")
    ?>

    <?php
    /**
     * @var array $posts
     */
    if(count($posts) == 0)
    {
        ?>
        <div class="post">
            <p>Il n'y a pas de posts pour le moment.</p>
        </div>
        <?php
    }
    else
    {
        foreach($posts as $post)
        {
            include(VIEWS."/Post/includes/postFull.php");
        }
    }
    ?>
</div>