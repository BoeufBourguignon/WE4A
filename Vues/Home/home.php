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
        <div class="post pointer" onclick="window.location='/post/<?php echo $post->getIdPost() ?>'">
            <?php
            include(VIEWS."/Post/includes/incPost.php");

            if($this->auth->getUser() !== null)
            {
                include(VIEWS."/Post/includes/postFooter.php");
            }
            ?>
        </div>
        <?php
    }
    ?>
</div>