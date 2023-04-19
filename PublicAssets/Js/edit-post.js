doOnLoad(() =>
{
    let titleInput = document.getElementById("title")
    let idPost = document.getElementById("idPost").value

    document.getElementById("edit-post").addEventListener("click", () =>
    {
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

        if (verified)
        {
            axios.post("/ajax/post/edit", {
                title: titleInput.value,
                message: quill.root.innerHTML,
                idPost: idPost
            })
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