<link href="https://cdn.quilljs.com/1.3.6/quill.snow.css" rel="stylesheet">
<link href="/PublicAssets/Style/quill/quill-global.css" rel="stylesheet">
<link href="/PublicAssets/Style/quill/quill-create.css" rel="stylesheet">

<div class="post">
    <div id="post-header">
        <div id="category-group">
            <input type="hidden" id="category-id">
            <label for="category" class="d-none">Catégorie</label>
            <input type="text" id="category" placeholder="Choisir une catégorie" aria-selected="false">
            <div id="category-list">
                <div id="new-category" class="d-none category-list-option">Créer la catégorie "<span id="new-category-name"></span>"</div>
            </div>
        </div>
        <div id="category-title">
            <label for="title" class="d-none"></label>
            <input type="text" id="title" placeholder="Choisir un titre">
        </div>
    </div>
    <div id="post-editor">
        <div id="editor-container"></div>
    </div>
    <div id="input-image">
        <input type="file" id="image-upload" accept="image/*" hidden>
        <label for="image-upload" class="btn btn-clear" id="btn-upload-image">Ajouter une image</label>
        <div id="post-img-preview-group" class="d-none">
            <div><img id="post-img-preview" alt="Preview" src="data:,"></div>
            <button id="img-preview-btn-delete" class="btn btn-danger">Supprimer l'image</button>
        </div>
    </div>
    <button type="button" id="send-post" class="btn btn-orange">Poster le message</button>
</div>

<script src="//cdn.quilljs.com/1.3.6/quill.min.js"></script>
<script src="/PublicAssets/Js/quill.js"></script>
