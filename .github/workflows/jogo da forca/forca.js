// forca.js
let palavraSelecionada = "";
let letrasCorretas = [];
let letrasErradas = [];
let tentativas = 6;

const jogoDiv = document.querySelector(".jogo");
const btnJogar = document.querySelectorAll("button")[1];
const btnAdicionar = document.querySelectorAll("button")[0];

btnJogar.addEventListener("click", iniciarJogo);
btnAdicionar.addEventListener("click", adicionarPalavra);

async function carregarPalavras() {
    const resposta = await fetch("forca.json");
    const dados = await resposta.json();
    return dados.palavras;
}

async function iniciarJogo() {
    const palavras = await carregarPalavras();
    palavraSelecionada = palavras[Math.floor(Math.random() * palavras.length)].toUpperCase();
    letrasCorretas = [];
    letrasErradas = [];
    tentativas = 6;
    renderizarJogo();
    document.addEventListener("keydown", verificarLetra);
}

function adicionarPalavra() {
    const nova = prompt("Digite uma nova palavra:");
    if (nova && nova.trim() !== "") {
        fetch("forca.json")
            .then(resp => resp.json())
            .then(dados => {
                dados.palavras.push(nova.toLowerCase());
                console.log("Nova palavra adicionada (salvar manualmente no arquivo):", nova);
                alert("Palavra adicionada! (não será salva no arquivo local por segurança)");
            });
    }
}

function renderizarJogo() {
    jogoDiv.innerHTML = `
        <div class="forca-status">
            <p>Tentativas restantes: ${tentativas}</p>
        </div>
        <div class="palavra">${getPalavraOculta()}</div>
        <div class="letras-erradas">
            <p>Letras erradas: ${letrasErradas.join(", ")}</p>
        </div>
        <div class="teclado">${gerarTeclado()}</div>
    `;
    atualizarForca();
}

function getPalavraOculta() {
    return palavraSelecionada
        .split("")
        .map(letra => (letrasCorretas.includes(letra) ? letra : "_"))
        .join(" ");
}

function verificarLetra(e) {
    const letra = e.key.toUpperCase();
    if (!/^[A-ZÇÃÕÂÊÎÔÛÁÉÍÓÚ]$/.test(letra)) return;

    if (palavraSelecionada.includes(letra)) {
        if (!letrasCorretas.includes(letra)) letrasCorretas.push(letra);
    } else {
        if (!letrasErradas.includes(letra)) {
            letrasErradas.push(letra);
            tentativas--;
        }
    }
    checarResultado();
    renderizarJogo();
}

function gerarTeclado() {
    const alfabeto = "ABCDEFGHIJKLMNOPQRSTUVWXYZ";
    return alfabeto
        .split("")
        .map(
            letra => `
            <button 
                class="tecla" 
                onclick="clicarTecla('${letra}')"
                ${letrasCorretas.includes(letra) || letrasErradas.includes(letra) ? "disabled" : ""}
            >
                ${letra}
            </button>`
        )
        .join("");
}

function clicarTecla(letra) {
    letra = letra.toUpperCase();
    if (palavraSelecionada.includes(letra)) {
        if (!letrasCorretas.includes(letra)) letrasCorretas.push(letra);
    } else {
        if (!letrasErradas.includes(letra)) {
            letrasErradas.push(letra);
            tentativas--;
        }
    }
    checarResultado();
    renderizarJogo();
}

function checarResultado() {
    const venceu = palavraSelecionada.split("").every(letra => letrasCorretas.includes(letra));
    if (venceu) {
        alert(`🎉 Você venceu! A palavra era: ${palavraSelecionada}`);
        document.removeEventListener("keydown", verificarLetra);
    } else if (tentativas <= 0) {
        alert(`💀 Fim de jogo! A palavra era: ${palavraSelecionada}`);
        document.removeEventListener("keydown", verificarLetra);
    }
}

function atualizarForca() {
    const status = document.querySelector(".forca-status");
    status.innerHTML = `
        <p>Tentativas restantes: ${tentativas}</p>
        <div class="boneco">
            <div class="cabeca" style="visibility:${tentativas <= 5 ? "visible" : "hidden"}"></div>
            <div class="corpo" style="visibility:${tentativas <= 4 ? "visible" : "hidden"}"></div>
            <div class="braco esq" style="visibility:${tentativas <= 3 ? "visible" : "hidden"}"></div>
            <div class="braco dir" style="visibility:${tentativas <= 2 ? "visible" : "hidden"}"></div>
            <div class="perna esq" style="visibility:${tentativas <= 1 ? "visible" : "hidden"}"></div>
            <div class="perna dir" style="visibility:${tentativas <= 0 ? "visible" : "hidden"}"></div>
        </div>
    `;
}
