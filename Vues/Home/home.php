<div id="canvas">
    <?php
    if(!$this->auth->getUser() == null)
        include_once(VIEWS."/Post/createPost.php")
    ?>

    <?php
    /**
     * @var array $posts
     * @var Model\Post $post
     */
    foreach($posts as $post)
    {
        ?>
        <div class="post">
            <?php
            include(VIEWS."/Post/includes/incPost.php");

            include(VIEWS."/Post/includes/postFooter.php");
            ?>
        </div>
        <?php
    }
    ?>
</div>