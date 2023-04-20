doOnLoad(() =>
{
    document.getElementById("edit-comment").addEventListener("click", () =>
    {
        let idComment = document.getElementById("edit-comment").value
        let idPost = document.getElementById("idPost").value

        let verified = true
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
            axios.post("/ajax/comment/edit", {
                message: quill.root.innerHTML,
                idComment: idComment
            })
                .then(function (resp)
                {
                    if (resp.data["response"] === true)
                        window.location = "/post/"+idPost
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