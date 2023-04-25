doOnLoad(() =>
{
    let titleInput = document.getElementById("title")
    let idPost = document.getElementById("idPost").value

    document.getElementById("edit-post").addEventListener("click", () =>
    {
        let img = document.getElementById("image-upload").files[0]

        let verified = true
        if (titleInput.value === "")
        {
            alert("Le titre ne doit pas être vide")
            verified = false
        }
        if (titleInput.value.length > 100)
        {
            alert("Le titre ne doit pas faire plus de 100 charactères")
            verified = false
        }
        if (quill.getContents().length < 2)
        {
            alert("Le message ne doit pas être vide")
            verified = false
        }
        if (quill.getLength().length > 500)
        {
            alert("Votre message est trop long")
            verified = false
        }
        if(img !== undefined && !['image/jpeg','image/png','image/gif'].includes(img.type))
        {
            alert("L'image doit être de format JPEG/JPG, PNG ou GIF")
            verified = false
        }
        if(img !== undefined && img.size > 50000000)
        {
            alert("La taille de l'image ne doit pas dépasser 50Mo")
            verified = false
        }

        if (verified)
        {
            let data = new FormData();
            data.append("title", titleInput.value)
            data.append("message", quill.root.innerHTML)
            data.append("idPost", idPost)
            data.append("image", img)

            axios.post("/ajax/post/edit", data)
                .then(function (resp)
                {
                    if (resp.data["response"] === true)
                        window.location = "/post/" + idPost
                    else
                    {
                        alert("Une erreur est survenue")
                        console.log(resp.data)
                    }
                })
                .catch(axiosCatchError)
        }
    })
})