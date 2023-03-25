<div id="canvas">
    <?php
    if(!$this->auth->getUser() == null)
        include_once(VIEWS."/Post/createPost.php")
    ?>

    <div class="post">
        <h1>Test</h1>
    </div>
</div>
