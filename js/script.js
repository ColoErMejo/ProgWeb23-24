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

document.getElementsByClassName("tablink")[0].click();
function openCity(evt, cityName) {
  var i, x, tablinks;
  x = document.getElementsByClassName("city");
  for (i = 0; i < x.length; i++) {
    x[i].style.display = "none";
  }
  tablinks = document.getElementsByClassName("tablink");
  for (i = 0; i < x.length; i++) {
    tablinks[i].classList.remove("w3-light-grey");
  }
  document.getElementById(cityName).style.display = "block";
  evt.currentTarget.classList.add("w3-light-grey");
}
window.onclick = function(event) {
  if (event.target == modal) {
    modal.style.display = "none";
  }
}



function setEliminazione(numero){
    return "<a href='EliminazioneContratto.php?Numero=" + numero + "' class='modal'  >Elimina</a>";
  }



function ordinatabella(n) {
    var table, rows, switching, i, x, y, shouldSwitch, dir, switchcount = 0;
    table = document.getElementById("myTable");
    switching = true;
    dir = "asc"; 
    while (switching) {
      switching = false;
      rows = table.rows;
      for (i = 1; i < (rows.length - 1); i++) {
        shouldSwitch = false;
        x = rows[i].getElementsByTagName("TD")[n];
        y = rows[i + 1].getElementsByTagName("TD")[n];       
        if(n==0 || n==4){
          if (dir == "asc") {
            if (Number(x.innerHTML) > Number(y.innerHTML)) {
              shouldSwitch= true;
              break;
            }
          } else if (dir == "desc") {
            if (Number(x.innerHTML) < Number(y.innerHTML)) {
              shouldSwitch = true;
              break;
            }
          }
        }else{
          if (dir == "asc") {
            if (x.innerHTML.toLowerCase() > y.innerHTML.toLowerCase()) {
              shouldSwitch= true;
              break;
            }
          } else if (dir == "desc") {
            if (x.innerHTML.toLowerCase() < y.innerHTML.toLowerCase()) {
              shouldSwitch = true;
              break;
            }
          }
        }
      }
      if (shouldSwitch) {
        rows[i].parentNode.insertBefore(rows[i + 1], rows[i]);
        switching = true;
        switchcount ++;      
      } else {
        if (switchcount == 0 && dir == "asc") {
          dir = "desc";
          switching = true;
        }
      }
    }
}