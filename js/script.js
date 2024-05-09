function setH1telefonata() {       
	$("#h1Title").eq(0).html("Telefonata DB");
}

function setH1contrattotelefonico() {       
	$("#h1Title").eq(0).html("Contratto telefonico DB");
}

function setH1sim() {       
	$("#h1Title").eq(0).html("SIM DB");
}
function showHideFields() {
    var tipoContratto = document.getElementById("Tipo").value;
    var minutiResiduiLabel = document.getElementById("minutiResiduiLabel");
    var minutiResiduiInput = document.getElementById("MinutiResidui");
    var creditoResiduoLabel = document.getElementById("creditoResiduoLabel");
    var creditoResiduoInput = document.getElementById("CreditoResiduo");

    if (tipoContratto === "a consumo") {
        minutiResiduiLabel.style.display = "block";
        minutiResiduiInput.style.display = "block";
        creditoResiduoLabel.style.display = "none";
        creditoResiduoInput.style.display = "none";
    } else if (tipoContratto === "a ricarica") {
        minutiResiduiLabel.style.display = "none";
        minutiResiduiInput.style.display = "none";
        creditoResiduoLabel.style.display = "block";
        creditoResiduoInput.style.display = "block";
    }
}

function mostraInserimento(numero){
    var nextPage = "http://tr3mm.altervista.org/ContrattoTelefonico.php?Numero=" + numero;
    window.location.href = nextPage;
}
