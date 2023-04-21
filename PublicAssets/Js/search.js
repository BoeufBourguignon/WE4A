doOnLoad(() =>
{
    let input = document.getElementById("search")
    let navbarContent = document.getElementById("navbar-search-content")

    let divCategs = document.getElementById("navbar-search-categ")
    let divUsers = document.getElementById("navbar-search-user")

    input.addEventListener("focus", () =>
    {
        if(input.value.length > 0)
        {
            navbarContent.classList.remove("d-none")
        }
        else
        {
            navbarContent.classList.add("d-none")
        }
    })

    document.getElementById("canvas").addEventListener("click", () =>
    {
        if(input.value.length > 0)
        {
            navbarContent.classList.remove("d-none")
        }
        else
        {
            navbarContent.classList.add("d-none")
        }
    })

    input.addEventListener("keyup", () =>
    {
        if(input.value.length > 0)
        {
            navbarContent.classList.remove("d-none")

            //document.getElementById("navbar-search-word").innerHTML = input.value

            axios.get("/ajax/search/"+input.value)
                .then((resp) =>
                {
                    console.log(resp.data)

                    // categ
                    divCategs.innerHTML = ""
                    if(resp.data["categ"].length === 0)
                    {
                        divCategs.innerHTML = "<div class='muted'>Pas de résultat</div>"
                    }
                    else
                    {
                        resp.data["categ"].forEach((el) =>
                        {
                            divCategs.innerHTML += "<a class='pointer' href='/categ/"+el["nameCategory"]+"'>"+el["nameCategory"]+"</a>"
                        })
                    }

                    // users
                    divUsers.innerHTML = ""
                    if(resp.data["user"].length === 0)
                    {
                        divUsers.innerHTML = "<div class='muted'>Pas de résultat</div>"
                    }
                    else
                    {
                        resp.data["user"].forEach((el) =>
                        {
                            divUsers.innerHTML += "<a class='pointer' href='/user/"+el["username"]+"'>"+el["username"]+"</a>"
                        })
                    }
                })
                .catch(axiosCatchError)
        }
        else
        {
            navbarContent.classList.add("d-none")
        }
    })
})