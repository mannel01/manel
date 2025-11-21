function ValidarCampos() {
    toogleEmailErrors();
    toogleButtonsDisable();
}


function toogleEmailErrors() {
    const email = document.getElementById("email").value;
    if(!email){
        document.getElementById("email-obrigatorio").style.display = "block";
        document.getElementById("email-invalido").style.display = "none";
    } else if(ValidarEmail(email)){
        document.getElementById("email-invalido").style.display = "none";
        document.getElementById("email-obrigatorio").style.display = "none";
    } else{
        document.getElementById("email-invalido").style.display = "block";
        document.getElementById("email-obrigatorio").style.display = "none";
    }
}

function toogleButtonsDisable() {
    const emailValid = isEmailValid();
    document.getElementById("ButtonCadastrar").disabled = !emailValid;
}

function isEmailValid() {
    const Email = document.getElementById("email").value;
    if (!Email) {
        return false;
    }
    return ValidarEmail(Email);
}

function ValidarEmail(email) {
    return /\S+@\S+\.\S+/.test(email);
}


function Login() {
    window.location.href = "../Log/Login.html";
}

