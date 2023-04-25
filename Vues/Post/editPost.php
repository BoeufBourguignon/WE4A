<?php
/**
 * @var Model\Post $post
 */
?>
<link href="https://cdn.quilljs.com/1.3.6/quill.snow.css" rel="stylesheet">
<link href="/PublicAssets/Style/quill/quill-global.css" rel="stylesheet">
<link href="/PublicAssets/Style/quill/quill-edit.css" rel="stylesheet">

<div id="canvas">
    <div class="post">
        <div class="post-header">
            <div class="post-edit-title">
                <label for="title" class="d-none"></label>
                <input type="text" id="title" placeholder="Modifier le titre" value="<?php echo $post->getTitle() ?>">
                <input type="hidden" id="idPost" value="<?php echo $post->getIdPost() ?>">
            </div>
        </div>
        <div id="post-editor">
            <div id="editor-container"></div>
        </div>
        <div id="input-image">
            <input type="file" id="image-upload" accept="image/*" hidden>
            <label for="image-upload" class="btn btn-clear" id="btn-upload-image">Ajouter une image</label>
        </div>
        <button type="button" id="edit-post" class="btn btn-orange">Enregistrer les modifications</button>
        <a class="btn btn-clear" href="/post/<?php echo $post->getIdPost() ?>">Annuler</a>
    </div>
</div>

<script src="//cdn.quilljs.com/1.3.6/quill.min.js"></script>
<script src="/PublicAssets/Js/quill.js"></script>
<script>
    quill.root.innerHTML = "<?php echo addslashes($post->getContent()) ?>"
</script>