<link href="https://cdn.quilljs.com/1.3.6/quill.snow.css" rel="stylesheet">
<link href="/PublicAssets/Style/quill.css" rel="stylesheet">

<div class="post">
    <div id="category-group">
        <label for="category" class="d-none"></label>
        <input type="text" id="category" placeholder="Choisir une catégorie" aria-selected="false">
        <div id="category-list">
            <p id="category-list-close" class="no-margin txt-orange">Fermer</p>
            <a class="category-list-option" href="/category/create" target="_blank">&CirclePlus;&nbsp;Nouvelle catégorie</a>
        </div>
    </div>
    <div id="post-editor">
        <div id="editor-container"></div>
    </div>
    <button type="button" id="send-post" class="btn btn-orange">Poster le message</button>
</div>

<script src="//cdn.quilljs.com/1.3.6/quill.min.js"></script>
<script src="/PublicAssets/Js/quill.js"></script>