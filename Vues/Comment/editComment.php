<?php
/**
 * @var Model\Comment $comment
 */
?>
<link href="https://cdn.quilljs.com/1.3.6/quill.snow.css" rel="stylesheet">
<link href="/PublicAssets/Style/quill/quill-global.css" rel="stylesheet">

<div id="canvas">
    <div class="post">
        <input type="hidden" id="idPost" value="<?php echo $comment->getIdPost() ?>">
        <div id="post-editor">
            <div id="editor-container"></div>
        </div>
        <button type="button" id="edit-comment" class="btn btn-orange" value="<?php echo $comment->getIdComment() ?>">
            Enregistrer les modifications</button>
        <a class="btn btn-clear" href="/post/<?php echo $comment->getIdPost() ?>">Annuler</a>
    </div>
</div>

<script src="//cdn.quilljs.com/1.3.6/quill.min.js"></script>
<script src="/PublicAssets/Js/quill.js"></script>
<script>
    quill.root.innerHTML = "<?php echo addslashes($comment->getContent()) ?>"
</script>