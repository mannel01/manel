let perguntas = [];

fetch('quiz.json')
  .then(response => response.json())
  .then(data => {
    perguntas = data;
    carregarPergunta();
  })
  .catch(error => console.error('Erro ao carregar o JSON:', error));

const pergunta = document.getElementById("pergunta");
const opcoes = document.getElementById("opcoes");
const resultado = document.getElementById("resultado");
const proximo = document.getElementById("proximo");
const contador = document.getElementById("contador");
const barra_progresso = document.getElementById("progresso-bar");

let pergunta_atual = 0;
let pontuacao = 0;

function carregarPergunta() {
  const atual = perguntas[pergunta_atual];
  pergunta.textContent = atual.pergunta;
  contador.textContent = `Pergunta ${pergunta_atual + 1} de ${perguntas.length}`;
  barra_progresso.style.width = `${((pergunta_atual) / perguntas.length) * 100}%`;
  opcoes.innerHTML = "";

  atual.opcoes.forEach(opcao => {
    const botao = document.createElement("button");
    botao.textContent = opcao;
    botao.addEventListener("click", () => verificarResposta(opcao, botao));
    opcoes.appendChild(botao);
  });
}

function verificarResposta(resposta, opcaoEscolhida) {
  const atual = perguntas[pergunta_atual];
  const botoes = opcoes.querySelectorAll("button");

  botoes.forEach(botao => botao.disabled = true);

  if (resposta === atual.resposta_correta) {
    opcaoEscolhida.classList.add("correto");
    pontuacao++;
  } else {
    opcaoEscolhida.classList.add("errado");
    botoes.forEach(botao => {
      if (botao.textContent === atual.resposta_correta) {
        botao.classList.add("correto");
      }
    });
  }

  proximo.style.display = "block";
}

function proximaPergunta() {
  pergunta_atual++;
  if (pergunta_atual < perguntas.length) {
    proximo.style.display = "none";
    carregarPergunta();
  } else {
    mostrarResultado();
  }
}

function mostrarResultado() {
  barra_progresso.style.width = "100%";
  document.getElementById("quiz").style.display = "none";
  resultado.style.display = "block";

  let mensagem = "";
  if (pontuacao === perguntas.length) {
    mensagem = "🏆 Incrível! Você acertou tudo!";
  } else if (pontuacao >= perguntas.length * 0.7) {
    mensagem = "👏 Muito bem! Você mandou bem!";
  } else {
    mensagem = "⚽ Continue treinando, você vai melhorar!";
  }

  resultado.innerHTML = `
    <h2>${mensagem}</h2>
    <p>Você acertou <strong>${pontuacao}</strong> de ${perguntas.length} perguntas.</p>
    <button onclick="reiniciarQuiz()">Jogar novamente</button>
  `;
}

function reiniciarQuiz() {
  pergunta_atual = 0;
  pontuacao = 0;
  resultado.style.display = "none";
  document.getElementById("quiz").style.display = "block";
  proximo.style.display = "none";
  carregarPergunta();
}

proximo.addEventListener("click", proximaPergunta);