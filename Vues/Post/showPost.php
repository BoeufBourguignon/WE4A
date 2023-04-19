<?php
/**
 * @var Model\Post $post
 * @var array $comments
 */
?>
<link href="https://cdn.quilljs.com/1.3.6/quill.snow.css" rel="stylesheet">
<link href="/PublicAssets/Style/quill/quill-global.css" rel="stylesheet">

<div id="canvas">
    <?php
    $isShowPost = true;
    include(VIEWS."/Post/includes/postFull.php");
    ?>

    <div class="post" id="comments">
        <h2>Publier un commentaire</h2>
        <div id="new-comment">
            <div id="post-editor">
                <div id="editor-container"></div>
            </div>
            <button type="button" id="comment-post" class="btn btn-small btn-orange"
                    value="<?php echo $post->getIdPost() ?>">Commenter</button>
        </div>
        <h2>Commentaires</h2>
        <?php
        /** @var Model\Comment $comment */
        foreach($comments as $comment)
        {
            include(VIEWS."/Comment/showComment.php");
        }
        ?>
    </div>
</div>

<script src="//cdn.quilljs.com/1.3.6/quill.min.js"></script>
<script src="/PublicAssets/Js/quill.js"></script>