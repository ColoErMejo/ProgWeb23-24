<!DOCTYPE HTML>
<html lang="it">

<head>
	<title>Contratto Telefonico DB</title>
	<link rel="stylesheet" href="./css/style.css">
	<script type="text/javascript" src="./js/script.js"></script>

	<link rel="stylesheet" href="https://code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
	<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
	<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
</head>


<body>
	<?php
	include 'header.html';
	include 'nav.html';
	include 'footer.html';
	include 'DBManager.php';
	include 'connectDB.php';
	?>
	<div class="container">
		<div class="research-filter">
			<form name="myform" method="POST">
				<input id="Numero" name="Numero" type="text" placeholder="Numero di Telefono" />
				<input id="DataAttivazione" name="DataAttivazione" type="text" placeholder="Data attivazione" />
				<script>
					$(function () {
						$("#DataAttivazione").datepicker({
							dateFormat: "dd-mm-y"
						});
					});
				</script>
				<select id="Tipo" name="Tipo" placeholder="Tipo Contratto">
					<option value="tutto">seleziona tipo contratto</option>
					<option value="a consumo">a consumo</option>
					<option value="a ricarica">a ricarica</option>
				</select>
				<input type="submit" value="Cerca" />
			</form>
		</div>

		<div class="content-results">
			<?php
			$Numero = "";
			$DataAttivazione = "";
			$Tipo = "";
			if (count($_POST) > 0) {
				$Numero = $_POST["Numero"];
				$DataAttivazione = $_POST["DataAttivazione"];
				$Tipo = $_POST["Tipo"];
			} else if (count($_GET) > 0) {
				$Numero = $_POST["Numero"];
				$DataAttivazione = $_POST["DataAttivazione"];
				$Tipo = $_POST["Tipo"];
			}
			$query = getContrattoTelefonicoQry($Numero, $DataAttivazione, $Tipo);
			echo "<p>ContrattoTelefonicoQuery: " . $query . "</p>";

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
						<th>Numero</th>
						<th>Data Attivazione</th>
						<th>Tipo</th>
						<th>Minuti Residui</th>
						<th>Credito Residuo</th>
						<th>SIM Attiva</th>
					</tr>
					<?php
					$i = 0;
					foreach ($result as $riga) {
						$i = $i + 1;
						$classRiga = 'class="rowOdd"';
						if ($i % 2 == 0) {
							$classRiga = 'class="rowEven"';
						}
						$Numero = $riga["Numero"];
						$DataAttivazione = $riga["DataAttivazione"];
						$Tipo = $riga["Tipo"];
						$MinutiResidui = $riga["MinutiResidui"];
						$CreditoResiduo = $riga["CreditoResiduo"];
						?>
						<tr <?php echo $classRiga; ?>>
							<td> <?php echo $Numero; ?> </td>
							<td> <?php echo $DataAttivazione; ?> </td>
							<td> <?php echo $Tipo; ?> </td>
							<<<<<<< Updated upstream <td> <?php echo $MinutiResidui; ?> </td>
								<td> <?php echo $CreditoResiduo; ?> </td>
						</tr>
						=======
						<td> <?php echo $MinutiResidui; ?> </td>
						<td> <?php echo $CreditoResiduo; ?> </td>

						<?php
						$query = getSIMAttivaContrattoQry($Numero);
						try {
							$result = $conn->query($query);
						} catch (PDOException $e) {
							echo "<p>DB Error on Query: " . $e->getMessage() . "</p>";
							$error = true;
						}
						if (!$error) {
							if ($result->rowCount() > 0) {
								foreach ($result as $riga) {
									$SIMAttiva = $riga["Codice"];
								}
							} else {
								$SIMAttiva = "";
							}
							?>
							<td> <?php echo $SIMAttiva; ?> </td> <?php
						}

						/*
																			  $query = getSIMDisattiveContrattoQry($Numero);
																			  try {
																				  $result = $conn->query($query);
																			  } catch (PDOException $e) {
																				  echo "<p>DB Error on Query: " . $e->getMessage() . "</p>";
																				  $error = true;
																			  }
																			  if (!$error) {
																				  foreach($result as $riga){
																					  $NumeroSIMDisattive = $riga["NumeroSIMDisattive"];
																					  ?> <td><a href=""><?php echo $NumeroSIMDisattive; ?></a></td> <?php
																				  }
																			  }*/

						?></tr>


					<?php } ?>
				</table>
			<?php } ?>
		</div>
	</div>

</body>

</html>