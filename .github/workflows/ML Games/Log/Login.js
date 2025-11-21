function ValidarCampos() {
    toogleEmailErrors();
    toogleButtonsDisable();
}

function isEmailValid() {
    const Email = document.getElementById("email").value;
    if (!Email) {
        return false;
    }
    return ValidarEmail(Email);
}

function toogleEmailErrors() {
    const email = document.getElementById("email").value;
    if(!email){
        document.getElementById("email-invalido").style.display = "none";
    } else if(ValidarEmail(email)){
        document.getElementById("email-invalido").style.display = "none";
    } else{
        document.getElementById("email-invalido").style.display = "block";
    }
}

function toogleButtonsDisable() {
    const emailValid = isEmailValid();
    document.getElementById("ButtonEntrar").disabled = !emailValid;
}

function Login() {
    window.location.href = "../Home/Home.html";
}

function Admin() {
    window.location.href = "../Admins/Admin.html";
}

function ValidarEmail(email) {
    return /\S+@\S+\.\S+/.test(email);
}