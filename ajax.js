/*Chiamata Telefonata.php*/
$(document).ready(function () {
  $(".tel").click(function () {
    $.ajax({
      url: "Telefonata.php",
      success: function (result) {
        $(".content-results").html(result);
      },
    });
  });
});
