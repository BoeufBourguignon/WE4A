doOnLoad(() =>
{
    document.querySelectorAll(".delete-comment").forEach((el) =>
    {
        el.addEventListener("click", () =>
        {
            if(confirm("Etes-vous sûr de vouloir supprimer ce commentaire ?"))
            {
                axios.post("/ajax/comment/delete", {
                    idComment: el.value
                })
                    .then(function (resp)
                    {
                        if (resp.data["response"] === true)
                        {
                            alert("Le commentaire a été supprimé")
                            location.reload()
                        }
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
})