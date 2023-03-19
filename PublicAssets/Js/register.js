window.onload = () => {
    let passwordIndication = document.getElementById("password-indication")
    let password = document.getElementById("password")
    let passwordVerify = document.getElementById("password-verify")

    let passwordRegex = /^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&#])[A-Za-z\d@$!%*?&#]{8,}$/

    password.addEventListener("keyup", () => {
        if(!password.value.match(passwordRegex))
        {
            password.classList.add("input-error")
            passwordIndication.classList.add("txt-error")
        }
        else
        {
            password.classList.remove("input-error")
            passwordIndication.classList.remove("txt-error")
        }
    })

    passwordVerify.addEventListener("keyup", () => {
        if(password.value !== passwordVerify.value)
            passwordVerify.classList.add("input-error")
        else
            passwordVerify.classList.remove("input-error")
    })
}