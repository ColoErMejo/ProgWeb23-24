function setH1telefonata() {
  $("#h1Title").eq(0).html("Telefonata DB");
}

function setH1contrattotelefonico() {
  $("#h1Title").eq(0).html("Contratto telefonico DB");
}

function setH1sim() {
  $("#h1Title").eq(0).html("SIM DB");
}

function changeTitle() {
  let titleHead = document.title;
  window.addEventListener("blur", () => {
    document.title = "Ehi torna qui!";
  });
  window.addEventListener("focus", () => {
    document.title = titleHead;
  });
}
window.onload = changeTitle;

function showHideFields() {
  var tipoContratto = document.getElementById("Tipo").value;
  var tipoContratto2 = document.getElementById("Tipo2").value;
  var minutiResiduiLabel = document.getElementById("minutiResiduiLabel");
  var minutiResiduiLabel2 = document.getElementById("minutiResiduiLabel2");
  var minutiResiduiInput = document.getElementById("MinutiResidui");
  var minutiResiduiInput2 = document.getElementById("MinutiResidui2");
  var creditoResiduoLabel = document.getElementById("creditoResiduoLabel");
  var creditoResiduoLabel2 = document.getElementById("creditoResiduoLabel2");
  var creditoResiduoInput = document.getElementById("CreditoResiduo");
  var creditoResiduoInput2 = document.getElementById("CreditoResiduo2");

  if (tipoContratto === "a consumo" || tipoContratto2 === "a consumo") {
    minutiResiduiLabel.style.display = "block";
    minutiResiduiLabel2.style.display = "block";
    minutiResiduiInput.style.display = "block";
    minutiResiduiInput2.style.display = "block";
    creditoResiduoLabel.style.display = "none";
    creditoResiduoLabel2.style.display = "none";
    creditoResiduoInput.style.display = "none";
    creditoResiduoInput2.style.display = "none";
  } else if (
    tipoContratto === "a ricarica" ||
    tipoContratto2 === "a ricarica"
  ) {
    minutiResiduiLabel.style.display = "none";
    minutiResiduiLabel2.style.display = "none";
    minutiResiduiInput.style.display = "none";
    minutiResiduiInput2.style.display = "none";
    creditoResiduoLabel.style.display = "block";
    creditoResiduoLabel2.style.display = "block";
    creditoResiduoInput.style.display = "block";
    creditoResiduoInput2.style.display = "block";
  }
}

function mostraInserimento(numero) {
  var nextPage =
    "http://tr3mm.altervista.org/ContrattoTelefonico.php?Numero=" + numero;
  window.location.href = nextPage;
}

function updateModal(Numero, DataAttivazione) {
  document.getElementById("myModal").style.display = "block";
  document.getElementById("tabellaContratto").classList.add("table-blur");
  document.getElementById("Numero").innerText = Numero;
  document.getElementById("DataAttivazione").innerText = DataAttivazione;
}

function deleteModal(Numero) {
  document.getElementById("myModal2").style.display = "block";
  document.getElementById("tabellaContratto").classList.add("table-blur");
  document.getElementById("Numero").innerText = Numero;
  document.getElementById("DataAttivazione").innerText = DataAttivazione;
}

function setEliminazione(Numero) {
  var url = "EliminazioneContratto.php?Numero=" + encodeURIComponent(Numero);
  window.location.href = url;
  closeModal();
}

function insertModal() {
  document.getElementById("myModal3").style.display = "block";
  document.getElementById("tabellaContratto").classList.add("table-blur");
  document.getElementById("Numero").innerText = Numero;
  document.getElementById("DataAttivazione").innerText = DataAttivazione;
}

function closeModal() {
  document.getElementById("myModal").style.display = "none";
  document.getElementById("myModal2").style.display = "none";
  document.getElementById("myModal3").style.display = "none";
  document.getElementById("tabellaContratto").classList.remove("table-blur");
}

function updateData(Numero, Tipo, CreditoResiduo, MinutiResidui) {
  var url =
    "ModificaContratto.php?Numero=" +
    encodeURIComponent(Numero) +
    "&Tipo=" +
    encodeURIComponent(Tipo) +
    "&CreditoResiduo=" +
    encodeURIComponent(CreditoResiduo) +
    "&MinutiResidui=" +
    encodeURIComponent(MinutiResidui);
  window.location.href = url;
  closeModal();
}

function insertData(
  Numero2,
  DataAttivazione2,
  Tipo2,
  CreditoResiduo2,
  MinutiResidui2
) {
  var url =
    "InserisciContratto.php?Numero=" +
    encodeURIComponent(Numero2) +
    "&DataAttivazione=" +
    encodeURIComponent(DataAttivazione2) +
    "&Tipo=" +
    encodeURIComponent(Tipo2) +
    "&CreditoResiduo=" +
    encodeURIComponent(CreditoResiduo2) +
    "&MinutiResidui=" +
    encodeURIComponent(MinutiResidui2);
  window.location.href = url;
  closeModal();
}

//ordinamento tabella in base al campo su cui si clicca
function sortTable(n, type, tableID) {
  const table = document.getElementById(tableID);
  const rows = Array.from(table.rows).slice(1); // Ottieni tutte le righe tranne l'intestazione
  const dir = table.getAttribute("data-sort-dir") === "asc" ? "desc" : "asc";
  table.setAttribute("data-sort-dir", dir);

  rows.sort((rowA, rowB) => {
    const x = rowA.getElementsByTagName("TD")[n].innerHTML;
    const y = rowB.getElementsByTagName("TD")[n].innerHTML;
    return compareValues(x, y, type, dir);
  });

  // Rimuovi tutte le righe esistenti
  while (table.rows.length > 1) {
    table.deleteRow(1);
  }

  // Aggiungi le righe ordinate
  rows.forEach((row) => table.appendChild(row));
}

function compareValues(x, y, type, dir) {
  if (type === "num") {
    x = parseFloat(x);
    y = parseFloat(y);
  } else if (type === "date") {
    x = parseDate(x);
    y = parseDate(y);
  }
  if (dir === "asc") {
    return x > y ? 1 : x < y ? -1 : 0;
  } else {
    return x < y ? 1 : x > y ? -1 : 0;
  }
}

function parseDate(dateString) {
  // Assumiamo che il formato delle date sia gg/mm/aaaa
  const parts = dateString.split("/");
  const day = parseInt(parts[0], 10);
  const month = parseInt(parts[1], 10) - 1; // Mesi da 0 a 11
  const year = parseInt(parts[2], 10);
  return new Date(year, month, day);
}

function controlloModifica() {
  var tipoContratto = document.getElementById('Tipo').value;
  var minutiResidui = document.getElementById('MinutiResidui').value;
  var creditoResiduo = document.getElementById('CreditoResiduo').value;

  if (tipoContratto === "") {
      alert("Per favore, seleziona una tipologia di contratto.");
      return; // Ferma l'esecuzione della funzione se il contratto non è selezionato
  }

  if (tipoContratto === "a ricarica" && (minutiResidui === "" || creditoResiduo === "")) {
      alert("Per favore, inserisci i minuti residui e il credito residuo per un contratto a ricarica.");
      return; // Ferma l'esecuzione della funzione se i campi obbligatori non sono compilati
  }
}

function controlloInserimento() {
  var tipoContratto = document.getElementById('Tipo2').value;
  var minutiResidui = document.getElementById('MinutiResidui2').value;
  var creditoResiduo = document.getElementById('CreditoResiduo2').value;

  if (tipoContratto === "") {
      alert("Per favore, seleziona una tipologia di contratto.");
      return; // Ferma l'esecuzione della funzione se il contratto non è selezionato
  }

  if (tipoContratto === "a ricarica" && (minutiResidui === "" || creditoResiduo === "")) {
      alert("Per favore, inserisci i minuti residui e il credito residuo per un contratto a ricarica.");
      return; // Ferma l'esecuzione della funzione se i campi obbligatori non sono compilati
  }
}