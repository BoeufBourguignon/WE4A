window.onload = () =>
{
    // Animation du bouton + menu déroulant de l'utilisateur

    let userBtn = document.getElementById("user-btn")

    // Si le bouton est null, c'est qu'aucun utilisateur n'est connecté
    if(userBtn !== null)
    {
        userBtn.addEventListener("click", () => {
            let userActions = document.getElementById("user-actions")
            userActions.ariaExpanded = userBtn.ariaExpanded = (userActions.ariaExpanded === "true" ? "false" : "true")
        })
    }
}