window.onload = () => {
    let userBtn = document.getElementById("user-btn")

    userBtn.addEventListener("click", () => {
        let userActions = document.getElementById("user-actions")
        userActions.ariaExpanded = userBtn.ariaExpanded = (userActions.ariaExpanded === "true" ? "false" : "true")
    })
}