doOnLoad(() =>
{
    // Evenements sur les boutons "supprimer"
    document.querySelectorAll(".delete-post").forEach((el) =>
    {
        el.addEventListener("click", () =>
        {
            if(confirm("Etes vous sûr de vouloir supprimer ce post ?"))
            {
                axios.post("/ajax/post/delete", {
                    idPost: el.value
                })
                    .then(function (resp)
                    {
                        if (resp.data["response"] === true)
                        {
                            alert("Le post a été supprimé")
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