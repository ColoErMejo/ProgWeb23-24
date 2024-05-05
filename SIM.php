<!DOCTYPE HTML>
<html lang="it">

<head>
    <title>SIM DB</title>
    <link rel="stylesheet" href="./css/style.css">
	<script type="text/javascript" src="./js/script.js"></script>
</head>


<body>
	<?php
	include 'header.html';
	include 'nav.html';
	include 'footer.html';
	include 'DBManager.php';
    include 'connectDB.php';
	?>

<div class="research-filter">
		<form name="myform" method="POST">
			<input id="Codice" name="Codice" type="text" placeholder="Codice" />
            <input id="TipoSIM" name="TipoSIM" type="text" placeholder="Tipo SIM" />
            <input type="checkbox" id="simAttive" value="SIMAttiva" onchange="selectTable(this)"> SIM Attive
            <input type="checkbox" id="simDisattive" value="SIMDisattiva" onchange="selectTable(this)"> SIM Disattive<br>
            <input type="checkbox" id="simNonAttive" value="SIMNonAttiva" onchange="selectTable(this)"> SIM Non Attive
			<input type="submit" value="Cerca" />
		</form>
        <div id="risultati"></div>

<script>
$(document).ready(function(){
    // Quando la pagina è pronta, esegui la richiesta AJAX
    $.ajax({
        url: 'DBManager.php', // Il percorso del tuo file PHP principale
        method: 'POST', // Utilizziamo il metodo POST per inviare dati al tuo file PHP principale
        data: {action: 'visualizza_SIMAttive'}, // Passiamo un parametro 'action' per identificare quale azione eseguire nel file PHP principale
        success: function(response){
            // Se la richiesta ha avuto successo, visualizza i risultati nella pagina
            $('#risultati').html(response);
        },
        error: function(xhr, status, error){
            // In caso di errore durante la richiesta AJAX
            console.error(error);
        }
    });
});
</script>

		<div class="content-results">
			<?php
			$Codice = "";
            $TipoSIM = "";
			if (count($_POST) > 0) {
				$Codice = $_POST["Codice"];
                $TipoSIM = $_POST["TipoSIM"];
			} else if (count($_GET) > 0) {
                $Codice = $_POST["Codice"];
				$TipoSIM = $_POST["TipoSIM"];
			}
			$query = getSIMQry($Codice, $TipoSIM);
			echo "<p>SIMQuery: " . $query . "</p>"; 

			try {
				$result = $conn->query($query);
			} catch (PDOException $e) {
				echo "<p>DB Error on Query: " . $e->getMessage() . "</p>";
				$error = true;
			}
			if (!$error) {
				?>

				<table class="table">
					<tr class="header">
						<th>Codice</th> 
						<th>Tipo</th>
                        <th>Associata a</th>
						<th>Era Associata A</th>
						<th>Data Attivazione</th>
						<th>Data Disattivazione</th>
					</tr>
					<?php
					$i = 0;
					foreach ($result as $riga) {
						$i = $i + 1;
						$classRiga = 'class="rowOdd"';
						if ($i %  2== 0) {
							$classRiga = 'class="rowEven"';
						}
						$Codice = $riga["Codice"];
						$TipoSIM = $riga["TipoSIM"];
                        $AssociataA = $riga["AssociataA"];
						$EraAssociataA = $riga["EraAssociataA"];
						$DataAttivazione = $riga["DataAttivazione"];
						$DataDisattivazione = $riga["DataDisattivazione"];
						?>
						<tr <?php echo $classRiga; ?>>
						    <td> <?php echo $Codice; ?> </td>
							<td> <?php echo $TipoSIM; ?> </td>
                            <td> <?php echo $AssociataA; ?> </td>
							<td> <?php echo $EraAssociataA; ?> </td>
                            <td> <?php echo $DataAttivazione; ?> </td>
                            <td> <?php echo $CreditoRDataDisattivazioneesiduo; ?> </td>
						</tr>
					<?php } ?>
				</table>
			<?php } ?>
		</div>
	</div>
</body>
</html>