<link href="https://cdn.quilljs.com/1.3.6/quill.snow.css" rel="stylesheet">
<link href="/PublicAssets/Style/quill.css" rel="stylesheet">

<div class="post">
    <div id="post-header">
        <div id="category-group">
            <label for="category" class="d-none"></label>
            <input type="text" id="category" placeholder="Choisir une catégorie" aria-selected="false">
            <div id="category-list">
                <!--<p id="category-list-close" class="no-margin txt-orange">Fermer</p>-->
                <div id="new-category" class="d-none category-list-option" onclick="window.open('/add/category', 'Create category', 'width=600,height=400')">Créer la catégorie "<span id="new-category-name"></span>"</div>
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
    <button type="button" id="send-post" class="btn btn-orange">Poster le message</button>
</div>

<script src="//cdn.quilljs.com/1.3.6/quill.min.js"></script>
<script src="/PublicAssets/Js/quill.js"></script>