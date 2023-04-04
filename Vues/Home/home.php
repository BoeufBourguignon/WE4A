<div id="canvas">
    <?php
    if(!$this->auth->getUser() == null)
        include_once(VIEWS."/Post/createPost.php")
    ?>

    <?php
    /** @var array $posts */
    foreach($posts as $post)
    {
        include(VIEWS."/Post/showPost.php");
    }
    ?>
</div>
