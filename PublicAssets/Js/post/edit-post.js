doOnLoad(() =>
{
    const titleInput = document.getElementById("title")
    const idPost = document.getElementById("idPost").value
    const imgInput = document.getElementById("image-upload")
    const imgPreviewGroup = document.getElementById("post-img-preview-group")
    const imgPreview = document.getElementById("post-img-preview")
    const imgDelete = document.getElementById("img-delete")

    document.getElementById("img-preview-btn-delete").addEventListener("click", () =>
    {
        imgInput.value = ""
        imgPreview.src = "data:,"
        imgPreviewGroup.classList.add("d-none")
        imgDelete.value = "true"
    })

    imgInput.addEventListener("change", () =>
    {
        let img = imgInput.files
        if(FileReader && img && img.length)
        {
            imgPreviewGroup.classList.remove("d-none")

            let fr = new FileReader()
            fr.onload = () =>
            {
                imgPreview.src = fr.result
            }
            fr.readAsDataURL(img[0])
        }
    })

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
            data.append("img-delete", imgDelete.value)

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