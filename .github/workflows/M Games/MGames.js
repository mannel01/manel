const login = document.querySelector(".login");
const cadastrar = document.querySelector(".cadastrar");

const btnIrParaLogin = document.querySelector(".txtEntrar a");
const btnIrParaCadastrar = document.querySelector(".txtCadastrar a");

// Começa mostrando o login
login.classList.add("active");

// Vai para login
btnIrParaLogin.addEventListener("click", (e) => {
    e.preventDefault();
    cadastrar.classList.remove("active");
    login.classList.add("active");
});

// Vai para cadastro
btnIrParaCadastrar.addEventListener("click", (e) => {
    e.preventDefault();
    login.classList.remove("active");
    cadastrar.classList.add("active");
});
