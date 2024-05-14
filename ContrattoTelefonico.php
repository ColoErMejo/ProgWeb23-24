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
				<input id="Numero" name="Numero" type="text" placeholder="Numero di Telefono" class="search-box" />
				<select id="Tipo" name="Tipo">
					<option id="tutto" value="tutto">seleziona tipo contratto</option>
					<option id="a ricarica" value="a ricarica"> A ricarica </option>
					<option id="a consumo" value="a consumo"> A Consumo </option>
				</select>
				<input id="Data" name="Data" type="date" placeholder="gg/mm/aa" class="search-box" />
				<div class="buttons-container">
					<div class="buttons-operation">
						<a id="InsCont" href="InserimentoContratto.php"><img src="icons/plus.png" width="20px"
								height="20px"></a>
					</div>
					<form name="myform" method="POST">
						<input type="submit" value="Cerca" class="search-button" />
					</form>

				</div>
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
				$Numero = $_GET["Numero"];
				$DataAttivazione = $_GET["DataAttivazione"];
				$Tipo = $_GET["Tipo"];
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
						<th>Telefonate</th>
						<th>SIM Attiva</th>
						<th>SIM Disattive</th>
						<th>Modifica</th>
						<th>Elimina</th>
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
							<td> <?php echo $MinutiResidui; ?> </td>
							<td> <?php echo $CreditoResiduo; ?> </td>
							<?php

							$query = getTelefonateContrattoQry($Numero);
							try {
								$result = $conn->query($query);
							} catch (PDOException $e) {
								echo "<p>DB Error on Query: " . $e->getMessage() . "</p>";
								$error = true;
							}

							if (!$error) {
								foreach ($result as $riga) {
									$NumeroTelefonate = $riga["NumeroTelefonate"];
									?>
									<td><a href="Telefonata.php?EffettuataDa=<?php echo $Numero ?>"><?php echo $NumeroTelefonate; ?></a>
									</td> <?php
								}
							}


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
										?>
										<td><a
												href="SIM.php?StatoSIM=SIMAttiva&Codice=<?php echo $SIMAttiva ?>"><?php echo $SIMAttiva; ?></a>
										</td> <?php
									}
								} else {
									$SIMAttiva = "";
									?>
									<td> <?php echo $SIMAttiva; ?> </td> <?php
								}


							}


							$query = getSIMDisattiveContrattoQry($Numero);
							try {
								$result = $conn->query($query);
							} catch (PDOException $e) {
								echo "<p>DB Error on Query: " . $e->getMessage() . "</p>";
								$error = true;
							}
							if (!$error) {
								foreach ($result as $riga) {
									$NumeroSIMDisattive = $riga["NumeroSIMDisattive"];
									?>
									<td><a
											href="SIM.php?StatoSIM=SIMDisattiva&Contratto=<?php echo $Numero ?>"><?php echo $NumeroSIMDisattive; ?></a>
									</td> <?php
								}
							} ?>
							<td> <img src="icons\bin.png" height="20px" width="20px" onclick=<?php linkEliminaContratto($Numero) ?>></td>
						</tr>
					<?php } ?>
				</table>
			<?php } ?>
		</div>
	</div>

</body>

</html>