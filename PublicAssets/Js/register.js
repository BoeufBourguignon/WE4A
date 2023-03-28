window.onload = () => {
    let passwordIndication = document.getElementById("password-indication")
    let password = document.getElementById("password")
    let passwordVerify = document.getElementById("password-verify")

    let passwordRegex = /^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&#])[A-Za-z\d@$!%*?&#]{8,}$/

    password.addEventListener("keyup", () => {
        if(!password.value.match(passwordRegex))
        {
            password.classList.add("input-danger")
            passwordIndication.classList.add("txt-danger")
        }
        else
        {
            password.classList.remove("input-danger")
            passwordIndication.classList.remove("txt-danger")
        }
    })

    passwordVerify.addEventListener("keyup", () => {
        if(password.value !== passwordVerify.value)
            passwordVerify.classList.add("input-danger")
        else
            passwordVerify.classList.remove("input-danger")
    })
}