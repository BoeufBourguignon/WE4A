<link href="https://cdn.quilljs.com/1.3.6/quill.snow.css" rel="stylesheet">
<link href="/PublicAssets/Style/quill.css" rel="stylesheet">

<div class="post">
    <div id="post-editor">
        <div id="editor-container"></div>
    </div>
    <button type="button" id="send-post" class="btn btn-orange">Poster le message</button>
</div>

<script src="//cdn.quilljs.com/1.3.6/quill.min.js"></script>
<script>
        let quill = new Quill('#editor-container', {
            theme: 'snow',
            placeholder: 'Poster un message'
        });

        document.getElementById("send-post").addEventListener("click", () => {
            console.log(JSON.stringify(quill.getContents()))
        })
</script>