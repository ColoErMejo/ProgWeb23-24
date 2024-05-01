$(document).ready(function () {
  var lastClickedIndex = -1; // Memorizza l'indice dell'ultimo bottone cliccato

  // Quando passi sopra un bottone, l'animazione si muove verso quel bottone
  $("nav a").hover(function () {
    var index = $(this).index();
    moveAnimation(index);
  });

  // Funzione per muovere l'animazione al bottone specificato
  function moveAnimation(index) {
    var animationWidth = $("nav a").eq(index).width();
    var leftOffset = 0;
    for (var i = 0; i < index; i++) {
      leftOffset += $("nav a").eq(i).outerWidth();
    }
    $(".animation").css({ width: animationWidth, left: leftOffset });
  }

  // Quando clicchi su un bottone, aggiungi le classi active e btn-clicked e memorizza l'indice del bottone cliccato
  $("nav a").click(function () {
    var index = $(this).index();
    $("nav a").removeClass("active btn-clicked"); // Rimuove le classi active e btn-clicked da tutti i bottoni
    $(this).addClass("active btn-clicked"); // Aggiunge le classi active e btn-clicked al bottone cliccato
    lastClickedIndex = index; // Memorizza l'indice del bottone cliccato
  });

  // Quando esci dalla navbar, reimposta l'animazione all'ultimo bottone cliccato
  $("nav").mouseleave(function () {
    moveAnimation(lastClickedIndex);
  });
  // Quando il mouse entra nella navbar, rimuovi le classi active e btn-clicked da tutti i bottoni
  // e reimposta queste classi sull'ultimo bottone cliccato
  $("nav").mouseenter(function () {
    $("nav a").removeClass("active btn-clicked"); // Rimuove le classi active e btn-clicked da tutti i bottoni
  });
  // Quando esci dalla navbar, reimposta le classi active e btn-clicked
  // all'ultimo bottone cliccato solo se non è stato cliccato alcun altro bottone mentre il mouse era sulla navbar
  $("nav").mouseleave(function () {
    if (lastClickedIndex !== -1 && $("nav a.active").length === 0) {
      $("nav a").removeClass("active btn-clicked"); // Rimuove le classi active e btn-clicked da tutti i bottoni
      $("nav a").eq(lastClickedIndex).addClass("active btn-clicked"); // Aggiunge le classi active e btn-clicked all'ultimo bottone cliccato
    }
  });
});
