<?php
/**
 * @var Model\Comment $comment
 */
?>
<link href="https://cdn.quilljs.com/1.3.6/quill.snow.css" rel="stylesheet">
<link href="/PublicAssets/Style/quill/quill-global.css" rel="stylesheet">

<div id="canvas">
    <div class="post">
        <input type="hidden" id="idComment" value="<?php echo $comment->getIdComment() ?>">
        <div id="post-editor">
            <div id="editor-container"></div>
        </div>
        <button type="button" id="edit-comment" class="btn btn-orange">Enregistrer les modifications</button>
        <a class="btn btn-clear" href="/home">Annuler</a>
    </div>
</div>

<script src="//cdn.quilljs.com/1.3.6/quill.min.js"></script>
<script src="/PublicAssets/Js/quill.js"></script>
<script>
    quill.root.innerHTML = "<?php echo addslashes($comment->getContent()) ?>"
</script>