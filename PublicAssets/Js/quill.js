let quill = new Quill('#editor-container', {
    theme: 'snow',
    placeholder: 'Poster un message',
    modules: {
        toolbar: [
            [{ header: [1, 2, false] }],
            ['bold', 'italic', 'underline', 'strike'],
            [{'color': []}],
            ['link', 'blockquote']
        ]
    }
});
