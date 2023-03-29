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

// Poster le message
document.getElementById("send-post").addEventListener("click", () =>
{
    console.log(JSON.stringify(quill.getContents()))
})


// Ouvrir/fermer le choix de la catégorie
let categoryInput = document.getElementById("category")
window.addEventListener("click", () =>
{
    categoryInput.ariaSelected = "false"
})
document.getElementById("category-group").addEventListener("click", (e) =>
{
    e.stopPropagation()
    categoryInput.ariaSelected = "true"
})
// document.getElementById("category-list-close").addEventListener("click", () =>
// {
//     categoryInput.ariaSelected = "false"
// })


// Afficher les catégories via AJAX
categoryInput.addEventListener("keyup", () =>
{
    if(categoryInput.ariaSelected === "false")
        categoryInput.ariaSelected = "true"

    let newCateg = document.getElementById("new-category")
    let newCategName = document.getElementById("new-category-name")

    if(categoryInput.value.length !== 0)
    {
        axios({
            method:'get',
            url:'/ajax/searchCateg/<?php echo $categ ?>'
        })
            .then(function(resp)
            {

                if(resp.data["categ_exists"] === false)
                {
                    newCategName.innerHTML = categoryInput.value
                    newCateg.classList.remove("d-none")
                }
                else
                {
                    newCateg.classList.add("d-none")
                }
            })
    }
    else
    {
        newCateg.classList.add("d-none")
    }
})