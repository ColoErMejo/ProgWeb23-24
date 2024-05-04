/*Chiamata Telefonata.php
$(document).ready(function () {
  $(".tel").click(function () {
    $.ajax({
      url: "Telefonata.php",
    });
  });
});*/

/*carica filtri/contenuti*/
$(document).ready(function () {
  // Funzione per caricare i contenuti dei filtri e della tabella
  function caricaContenuti(url) {
    $.ajax({
      url: url,
      type: "GET",
      success: function (data) {
        $(".research-filter").html($(data).find(".research-filter").html());
        $(".content-results").html($(data).find(".content-results").html());
      },
    });
  }

  // Evento click per i bottoni che cambiano pagina
  $("#cont_tel").click(function () {
    caricaContenuti("ContrattoTelefonico.php");
  });

  /* $('#sim').click(function(){
      caricaContenuti('sim.php'); non ancora implementata
  });*/

  $("#tel").click(function () {
    caricaContenuti("Telefonata.php");
  });

  // Carica i contenuti della pagina iniziale
  caricaContenuti("index.php");
});
