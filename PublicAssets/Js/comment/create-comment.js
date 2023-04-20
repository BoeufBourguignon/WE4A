doOnLoad(() =>
{
    let btnSendComment = document.getElementById("comment-post")

    if(btnSendComment !== null)
    {
        btnSendComment.addEventListener("click", () =>
        {
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
                // Poster le message via AJAX
                axios.post("/ajax/commentPost/add", {
                    idPost: btnSendComment.value,
                    message: quill.root.innerHTML
                })
                    .then(function (resp)
                    {
                        if (resp.data["response"] === true)
                            location.reload()
                        else
                        {
                            alert("Une erreur est survenue")
                            console.log(resp.data)
                        }
                    })
                    .catch(axiosCatchError)
            }
        })
    }
})