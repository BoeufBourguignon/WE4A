doOnLoad(() =>
{
    // Variables
    let categoryInput = document.getElementById("category")
    let divCategoryList = document.getElementById("category-list")
    let categoryId = document.getElementById("category-id")
    let newCateg = document.getElementById("new-category")
    let newCategName = document.getElementById("new-category-name")
    let title = document.getElementById("title")
    let imgInput = document.getElementById("image-upload")
    let imgPreviewGroup = document.getElementById("post-img-preview-group")
    let imgPreview = document.getElementById("post-img-preview")

    document.getElementById("img-preview-btn-delete").addEventListener("click", () =>
    {
        imgInput.value = ""
        imgPreview.src = "data:,"
        imgPreviewGroup.classList.add("d-none")
    })

    if(document.getElementById("post-editor") !== null)
    {
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

        // Evennement "appuie sur le bouton envoyer post"
        document.getElementById("send-post").addEventListener("click", () =>
        {
            let img = imgInput.files[0]

            // Vérifications
            let verified = true
            if (categoryId.value.length === "" || categoryInput.value === "")
            {
                alert("Erreur de choix de catégorie. Veuillez réessayer")
                verified = false
            }
            if (title.value === "")
            {
                alert("Le titre ne doit pas être vide")
                verified = false
            }
            if (title.value.length > 100)
            {
                alert("Le titre ne doit pas faire plus de 100 caractères")
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
                data.append("title", title.value)
                data.append("categoryId", categoryId.value)
                data.append("message", quill.root.innerHTML)
                data.append("image", img)

                // Poster le message via AJAX
                axios.post("/ajax/post/post", data)
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


        // Ouvrir/fermer le choix de la catégorie
        document.getElementById("category-group").addEventListener("click", (e) =>
        {
            e.stopPropagation()
            categoryInput.ariaSelected = "true"
        })
        window.addEventListener("click", () =>
        {
            categoryInput.ariaSelected = "false"
        })
        document.querySelectorAll("input, button").forEach((el) =>
        {
            if (el.id !== "category")
            {
                el.addEventListener("focus", () =>
                {
                    categoryInput.ariaSelected = "false"
                })
            }
        })


        // Afficher les catégories via AJAX
        categoryInput.addEventListener("keyup", () =>
        {
            if (categoryInput.ariaSelected === "false")
                categoryInput.ariaSelected = "true"

            if (categoryInput.value.length !== 0)
            {
                axios({
                    method: 'get',
                    url: '/ajax/searchCateg/' + categoryInput.value
                })
                    .then(function (resp)
                    {
                        //Affiche les catégories trouvées
                        document.querySelectorAll("#category-list .category-list-option.ajax-option").forEach((e) => e.remove())

                        resp.data["categs"].forEach((el) =>
                        {
                            let newDiv = document.createElement("div")
                            newDiv.classList.add("category-list-option")
                            newDiv.classList.add("ajax-option")
                            newDiv.innerHTML = el["nameCategory"]

                            newDiv.addEventListener("click", (e) =>
                            {
                                e.stopPropagation()
                                categoryInput.value = el["nameCategory"]
                                categoryId.value = el["idCategory"]
                                categoryInput.ariaSelected = "false"
                                document.querySelectorAll("#category-list .category-list-option.ajax-option").forEach((e) => e.remove())
                                newCateg.classList.add("d-none")
                            })

                            divCategoryList.appendChild(newDiv)
                        })

                        // Affiche/cache le bouton "nouvelle catégorie"
                        if (resp.data["categ_exists"] === false)
                        {
                            newCategName.innerHTML = categoryInput.value
                            newCateg.classList.remove("d-none")
                        } else
                        {
                            newCateg.classList.add("d-none")
                        }
                    })
                    .catch(axiosCatchError)
            } else
            {
                newCateg.classList.add("d-none")
            }
        })


        // Créer une catégorie via AJAX
        document.getElementById("new-category").addEventListener("click", () =>
        {
            // Crée la catégorie
            axios({
                method: 'post',
                url: '/ajax/create/category',
                data: "categ=" + categoryInput.value
            })
                .then(function (resp)
                {
                    if (resp.data["response"] === true)
                    {
                        categoryInput.value = categoryInput.value.toLowerCase()
                        alert("La catégorie " + categoryInput.value + " a été correctement créée")
                        categoryId.value = resp.data["categId"]
                        categoryInput.ariaSelected = "false"
                        document.querySelectorAll("#category-list .category-list-option.ajax-option").forEach((e) => e.remove())
                        newCateg.classList.add("d-none")
                    }
                })
                .catch(axiosCatchError)
        })
    }
})
