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

function mostraInserimento(numero) {
  var nextPage = "http://tr3mm.altervista.org/ContrattoTelefonico.php?Numero=" + numero;
  window.location.href = nextPage;
}

function setEliminazione(numero) {
  return "<a href='EliminazioneContratto.php?Numero=" + numero + "' class='modal'  >Elimina</a>";
}

function updateModal(numero,dataAttivazione) {
  document.getElementById('myModal').style.display = "block";
  document.getElementById('myTable').classList.add('table-blur');
  document.getElementById('numero').innerText = numero;
  document.getElementById('dataAttivazione').innerText = dataAttivazione;
}

function closeModal() {
  document.getElementById('myModal').style.display = "none";
  document.getElementById('myTable').classList.remove('table-blur');
}
function updateData(tipo, minutiResidui, creditoResiduo) {
  var tipo = document.getElementById("Tipo").value;
  var minutiResidui = document.getElementById("MinutiResidui").value;
  var creditoResiduo = document.getElementById("CreditoResiduo").value;

  // Dati da inviare al backend
  var data = {
      Tipo: tipo,
      MinutiResidui: minutiResidui,
      CreditoResiduo: creditoResiduo
  };

  // Esegui una richiesta AJAX POST al backend PHP
  $.ajax({
      type: "POST",
      url: "ContrattoTelefonico.php",
      data: data,
      success: function(response) {
          // Gestisci la risposta del backend qui
          console.log("Aggiornamento completato!");
          console.log(response); // Puoi mostrare la risposta del backend nella console per debug
          
          // Aggiorna la pagina corrente con i nuovi dati ottenuti dal backend
          // Puoi decidere come desideri aggiornare la pagina, ad esempio, ricaricandola completamente o aggiornando solo parti specifiche
          window.location.reload(); // Ricarica la pagina per mostrare i nuovi dati
      },
      error: function(xhr, status, error) {
          // Gestisci gli errori qui
          console.error("Si è verificato un errore durante l'aggiornamento:", error);
      }
  });

  // Chiudi il modal dopo l'aggiornamento
  closeModal();
}
