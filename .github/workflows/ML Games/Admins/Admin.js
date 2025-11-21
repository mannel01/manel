function ValidarCampos() {
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

