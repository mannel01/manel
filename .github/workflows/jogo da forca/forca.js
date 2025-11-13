let palavraSelecionada = "";
let letrasCorretas = [];
let letrasErradas = [];
let tentativas = 6;

const jogoDiv = document.querySelector(".jogo");
const btnAdicionar = document.querySelectorAll("button")[0];
const btnJogar = document.querySelectorAll("button")[1];

btnJogar.addEventListener("click", iniciarJogo);
btnAdicionar.addEventListener("click", mostrarCampoAdicionar);

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

function mostrarCampoAdicionar() {
    jogoDiv.innerHTML = `
    <div class="adicionar-palavra">
        <h2>Adicionar nova palavra</h2>
        <input type="text" id="novaPalavra" placeholder="Digite a nova palavra" />
        <button id="salvarPalavra">Salvar</button>
        <button id="cancelar">Cancelar</button>
    </div>
    `;

    document.querySelector("#salvarPalavra").addEventListener("click", () => {
        const nova = document.querySelector("#novaPalavra").value.trim();
        if (nova) {
            console.log("Nova palavra adicionada", nova);
            jogoDiv.innerHTML = `
                <p class="mensagem">✅ Palavra "${nova}" adicionada!</p>
                <div class = botoes-finais>
                    <button id="voltarInicio">Voltar ao Menu</button>
                <div/>
            `;
            document.querySelector("#voltarInicio").addEventListener("click", renderizarTelaInicial);
        }
    });

    document.querySelector("#cancelar").addEventListener("click", renderizarTelaInicial);
}

function renderizarTelaInicial() {
    jogoDiv.innerHTML = `
        <p>Bem-vindo ao jogo da forca!</p>
        <p>Clique em <strong>Jogar</strong> para começar.</p>
    `;
}

function renderizarJogo() {
    jogoDiv.innerHTML = `
        <div class="forca-status">
            <p>Tentativas restantes: ${tentativas}</p>
        </div>
        <div class="boneco">
            <div class="cabeca" style="visibility:${tentativas <= 5 ? "visible" : "hidden"}"></div>
            <div class="corpo" style="visibility:${tentativas <= 4 ? "visible" : "hidden"}"></div>
            <div class="braco esq" style="visibility:${tentativas <= 3 ? "visible" : "hidden"}"></div>
            <div class="braco dir" style="visibility:${tentativas <= 2 ? "visible" : "hidden"}"></div>
            <div class="perna esq" style="visibility:${tentativas <= 1 ? "visible" : "hidden"}"></div>
            <div class="perna dir" style="visibility:${tentativas <= 0 ? "visible" : "hidden"}"></div>
        </div>
        <div class="palavra">${getPalavraOculta()}</div>
        <div class="letras-erradas">
            <p>Letras erradas: ${letrasErradas.join(", ")}</p>
        </div>
        <div class="teclado">${gerarTeclado()}</div>
    `;
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
    atualizarLetras(letra);
}


function clicarTecla(letra) {
    letra = letra.toUpperCase();
    atualizarLetras(letra);
}

function atualizarLetras(letra) {
    if (palavraSelecionada.includes(letra)) {
        if (!letrasCorretas.includes(letra)) letrasCorretas.push(letra);
    } else {
        if (!letrasErradas.includes(letra)) {
            letrasErradas.push(letra);
            tentativas--;
        }
    }
    renderizarJogo();
    checarResultado();
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

function checarResultado() {
    const venceu = palavraSelecionada.split("").every(letra => letrasCorretas.includes(letra));

    if (venceu) {
        mostrarMensagemFinal(`🎉 Você venceu! A palavra era: ${palavraSelecionada}`, true);
    } else if (tentativas <= 0) {
        mostrarMensagemFinal(`💀 Fim de jogo! A palavra era: ${palavraSelecionada}`, false);
    }
}

function mostrarMensagemFinal(texto, venceu) {
    jogoDiv.innerHTML = `
        <div class="mensagem-final ${venceu ? "vitoria" : "derrota"}">
            <h2>${texto}</h2>
            <div class="botoes-finais">
                <button id="jogarNovamente">Jogar Novamente</button>
                <button id="menuInicial">Menu Inicial</button>
            </div>
        </div>
    `;

    document.querySelector("#jogarNovamente").addEventListener("click", iniciarJogo);
    document.querySelector("#menuInicial").addEventListener("click", renderizarTelaInicial);
    document.removeEventListener("keydown", verificarLetra);
}

renderizarTelaInicial();