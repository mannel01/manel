const barra = document.getElementById("barra_admin");
const seta = document.getElementById("seta_baixar");

let aberta = false;

seta.addEventListener("click", () => {
    aberta = !aberta;

    if (aberta) {
        barra.style.top = "0px";
        seta.style.transform = "rotate(180deg)";
    } else {
        barra.style.top = "-80px";
        seta.style.transform = "rotate(0deg)";
    }
});
