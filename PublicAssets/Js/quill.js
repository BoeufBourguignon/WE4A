let quill = new Quill('#editor-container', {
    theme: 'snow',
    placeholder: 'Poster un message',
    modules: {
        toolbar: [
            [{ header: [1, 2, false] }],
            ['bold', 'italic', 'underline', 'strike'],
            [{'color': []}],
            ['link', 'blockquote'],
            ['image', 'code-block']
        ]
    }
});

document.getElementById("send-post").addEventListener("click", () => {
    console.log(JSON.stringify(quill.getContents()))
})


let categoryInput = document.getElementById("category")
categoryInput.addEventListener("focusin", () => {
    categoryInput.ariaSelected = "true"
})

document.getElementById("category-list-close").addEventListener("click", () => {
    categoryInput.ariaSelected = "false"
})