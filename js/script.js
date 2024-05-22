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

function updateModal(Numero, DataAttivazione) {
  document.getElementById('myModal').style.display = "block";
  document.getElementById('myTable').classList.add('table-blur');
  document.getElementById('Numero').innerText = Numero;
  document.getElementById('DataAttivazione').innerText = DataAttivazione;
}

function deleteModal(Numero) {
  document.getElementById('myModal2').style.display = "block";
  document.getElementById('myTable').classList.add('table-blur');
  document.getElementById('Numero').innerText = Numero;
  document.getElementById('DataAttivazione').innerText = DataAttivazione;
}

function setEliminazione(Numero) {
  var url = 'EliminazioneContratto.php?Numero=' + encodeURIComponent(Numero);
  window.location.href = url;
  closeModal();
}

function insertModal() {
  document.getElementById('myModal3').style.display = "block";
  document.getElementById('myTable').classList.add('table-blur');
}

function closeModal() {
  document.getElementById('myModal').style.display = "none";
  document.getElementById('myModal2').style.display = "none";
  document.getElementById('myModal3').style.display = "none";
  document.getElementById('myTable').classList.remove('table-blur');
}

function updateData(Numero, Tipo, CreditoResiduo, MinutiResidui) {

  var url = 'ModificaContratto.php?Numero=' + encodeURIComponent(Numero) +
            '&Tipo=' + encodeURIComponent(Tipo) +
            '&CreditoResiduo=' + encodeURIComponent(CreditoResiduo) +
            '&MinutiResidui=' + encodeURIComponent(MinutiResidui);
  window.location.href = url;
  closeModal();
}

function insertData(Numero, DataAttivazione, Tipo, CreditoResiduo, MinutiResidui) {

  var url = 'InserisciContratto.php?Numero=' + encodeURIComponent(Numero) +
            '&DataAttivazione=' + encodeURIComponent(DataAttivazione) +
            '&Tipo=' + encodeURIComponent(Tipo) +
            '&CreditoResiduo=' + encodeURIComponent(CreditoResiduo) +
            '&MinutiResidui=' + encodeURIComponent(MinutiResidui);
  window.location.href = url;
  closeModal();
}

//ordinamento tabella in base al campo su cui si clicca
function sortTable(n, type, tableID) {
	const table = document.getElementById(tableID);
	const rows = Array.from(table.rows).slice(1); // Ottieni tutte le righe tranne l'intestazione
	const dir = table.getAttribute('data-sort-dir') === 'asc' ? 'desc' : 'asc';
	table.setAttribute('data-sort-dir', dir);

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
	rows.forEach(row => table.appendChild(row));
}

function compareValues(x, y, type, dir) {
	if (type === 'num') {
		x = parseFloat(x);
		y = parseFloat(y);
	} else if (type === 'date') {
		x = parseDate(x);
		y = parseDate(y);
	}
	if (dir === 'asc') {
		return x > y ? 1 : x < y ? -1 : 0;
	} else {
		return x < y ? 1 : x > y ? -1 : 0;
	}
}

function parseDate(dateString) {
	// Assumiamo che il formato delle date sia gg/mm/aaaa
	const parts = dateString.split('/');
	const day = parseInt(parts[0], 10);
	const month = parseInt(parts[1], 10) - 1; // Mesi da 0 a 11
	const year = parseInt(parts[2], 10);
	return new Date(year, month, day);
}