/*Chiamata Telefonata.php*/
$(document).ready(function () {
  $(".tel").click(function () {
    $.ajax({
      url: "Telefonata.php",
    });
  });
});
