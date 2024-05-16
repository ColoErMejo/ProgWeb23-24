<!DOCTYPE HTML>
<html lang="it">

<head>
	<title>Contratto Telefonico DB</title>
	
	<script type="text/javascript" src="./js/script.js"></script>

	<link rel="stylesheet" href="https://code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
	<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
	<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
	<link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
	<link rel="stylesheet" href="./css/style.css">

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
	<div id="id01" class="w3-modal">
		<div class="w3-modal-content w3-card-4 w3-animate-zoom modal-dimension-custom">
			<header class="w3-container w3-red">
				<span onclick="document.getElementById('id01').style.display='none'" class="w3-button w3-red w3-xlarge w3-display-topright">&times;</span>
				<h2>ATTENZIONE!</h2>
			</header>
			<div class="w3-bar w3-border-bottom">
				<div class="w3-container city">
					<p>Sei veramente sicuro di voler elimare questa utenza?</p>
					<p>Non si torna più indietro</p>
				</div>

				<div class="w3-container w3-light-gre w3-padding">
					<button class="w3-button w3-right w3-red w3-border  " onclick="document.getElementById('id01').style.display='none'"> <span id="eliminare_contratto"></span> </button>
					<button class="w3-button w3-right w3-white w3-border w3-margin-right-custom" onclick="document.getElementById('id01').style.display='none'">Close</button>
				</div>

			</div>
		</div>

	</div>
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
						<!--
						<a id="InsCont" href="InserimentoContratto.php"><img src="icons/plus.png" width="20px"
								height="20px"></a> -->
					</div>
					<form name="myform" method="POST">
						<input type="submit" value="Cerca" class="search-button" />
						<input type="button" value="Aggiungi" class="add-button"
							onclick="window.location.href='InserimentoContratto.php'" />
					</form>
					<!--<a id="InsCont" href="InserimentoContratto.php"><img src="icons/plus.png" width="20px"
								height="20px"></a>-->
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
			//echo "<p>ContrattoTelefonicoQuery: " . $query . "</p>";
			
			try {
				$result = $conn->query($query);
			} catch (PDOException $e) {
				echo "<p>DB Error on Query: " . $e->getMessage() . "</p>";
				$error = true;
			}
			if (!$error) {
				?>
		
				<table class="table" id="myTable">
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
							<td> <a href="ModificaContratto.php"> <img src="icons\pencil.png" height="20px" width="20px"></a></td>
							<td><a onclick="document.getElementById('id01').style.display='block'; document.getElementById('eliminare_contratto').innerHTML=setEliminazione(<?php echo $Numero ?>); " class='cliccabile'"><img src="icons\bin.png" height="20px" width="20px"></button></a>
						</tr>
					<?php } ?>
				</table>
			<?php } ?>
		</div>
	</div>

</body>

</html>