let categoryInput = document.getElementById("category")
let divCategoryList = document.getElementById("category-list")
let categoryId = document.getElementById("category-id")
let newCateg = document.getElementById("new-category")
let newCategName = document.getElementById("new-category-name")


// Poster le message
document.getElementById("send-post").addEventListener("click", () =>
{
    console.log(JSON.stringify(quill.getContents()))
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
    if(el.id !== "category")
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
    if(categoryInput.ariaSelected === "false")
        categoryInput.ariaSelected = "true"

    if(categoryInput.value.length !== 0)
    {
        axios({
            method:'get',
            url:'/ajax/searchCateg/'+categoryInput.value
        })
            .then(function(resp)
            {
                //Affiche les catégories trouvées
                document.querySelectorAll("#category-list .category-list-option.ajax-option").forEach((e) => e.remove())

                resp.data["categs"].forEach((el) =>
                {
                    console.log(el)

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
            .catch(function(e)
            {
                alert("Une erreur s'est produite")
                console.log(e)
            })
    }
    else
    {
        newCateg.classList.add("d-none")
    }
})


// Créer une catégorie
document.getElementById("new-category").addEventListener("click", () =>
{
    // Crée la catégorie
    axios({
        method:'post',
        url:'/create/category',
        data: "categ="+categoryInput.value
    })
        .then(function(resp)
        {
            if(resp.data["response"] === true)
            {
                categoryId.value = resp.data["categId"]
                categoryInput.ariaSelected = "false"
                document.querySelectorAll("#category-list .category-list-option.ajax-option").forEach((e) => e.remove())
                newCateg.classList.add("d-none")
            }
        })
        .catch(function()
        {
            alert("Une erreur s'est produite")
        })
})