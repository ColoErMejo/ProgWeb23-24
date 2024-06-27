<?php
session_start();
$show_modal = isset($_SESSION['show_modal']) ? $_SESSION['show_modal'] : false;
unset($_SESSION['show_modal']);
?>

<!DOCTYPE HTML>
<html lang="it">

<head>
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Contratto Telefonico DB</title>
	<script type="text/javascript" src="./js/script.js"></script>
	<link rel="stylesheet" href="https://code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
	<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
	<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
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
		<!-- Modifica Contratto -->
		<div id="myModal" class="modal">
			<div class="modal-content">
				<span class="close" onclick="closeModal()">&times;</span>
				<h3 class="modal-title">Modifica Contratto Telefonico</h3>
				<p>Numero: <span id="Numero"><?php echo $Numero; ?></span> <br> Data Attivazione: <span
						id="DataAttivazione"><?php echo $DataAttivazione; ?></span></p>
				<form id="updateForm" autocomplete="off">
					<label for="Tipo">Tipo:</label>
					<select id="Tipo" name="Tipo" class="modal-select" onchange="showHideFields()">
						<option value="" disabled selected hidden>Tipologia Contratto</option>
						<option value="a ricarica">A ricarica</option>
						<option value="a consumo">A consumo</option>
					</select>
					<span id="tipoWarning" class="warning">Campo obbligatorio</span><br>
					<label id="minutiResiduiLabel" style="display: none;" for="MinutiResidui">Minuti Residui: </label>
					<input type="number" name="MinutiResidui" id="MinutiResidui" class="modal-input"
						style="display: none;" />
					<span id="minutiResiduiWarning" class="warning">Campo obbligatorio</span><br>
					<label id="creditoResiduoLabel" style="display: none;" for="CreditoResiduo">Credito Residuo:</label>
					<input type="number" name="CreditoResiduo" id="CreditoResiduo" class="modal-input"
						style="display: none;" />
					<span id="creditoResiduoWarning" class="warning">Campo obbligatorio</span><br>
					<button type="button" onclick="controlloModifica()" class="search-button">Aggiorna</button>
				</form>
			</div>
		</div>

		<!-- Eliminazione Contratto -->
		<div id="myModal2" class="modal">
			<div class="modal-content">
				<span class="close" onclick="closeModal()">&times;</span>
				<h3 class="modal-title">Eliminazione Contratto Telefonico</h3>
				<p>Sei davvero sicuro di voler eliminare il Contratto Telefonico? </p>
				<form id="deleteForm">
					<button type="button" onclick="setEliminazione(document.getElementById('Numero').textContent)"
						class="search-button">Elimina</button>
				</form>
			</div>
		</div>

		<!-- Inserimento Contratto -->
		<div id="myModal3" class="modal">
			<div class="modal-content">
				<span class="close" onclick="closeModal()">&times;</span>
				<h3 class="modal-title">Inserimento Contratto Telefonico</h3>
				<form id="createForm" autocomplete="off">
					<label for="Numero2">Numero di telefono: </label>
					<input type="number" name="Numero" id="Numero2" class="modal-input" required min="1" max="9999999999">
					<span id="numeroWarning" class="warning">Campo obbligatorio</span><br><br>
					<label for="DataAttivazione2">Data Attivazione: </label>
					<input type="date" name="DataAttivazione" id="DataAttivazione2" class="modal-input"
						value="<?php echo date('Y-m-d'); ?>" required />
					<span id="dataAttivazioneWarning2" class="warning">Campo obbligatorio</span><br><br>
					<label for="Tipo2">Tipo:</label>
					<select id="Tipo2" name="Tipo" class="modal-select" onchange="showHideFields()">
						<option value="" disabled selected hidden>Tipologia Contratto</option>
						<option value="a ricarica">A ricarica</option>
						<option value="a consumo">A consumo</option>
					</select>
					<span id="tipoWarning2" class="warning">Campo obbligatorio</span>
					<label id="minutiResiduiLabel2" style="display: none;" for="MinutiResidui2">Minuti Residui: </label>
					<input type="number" name="MinutiResidui" id="MinutiResidui2" class="modal-input"
						style="display: none;" />
					<span id="minutiResiduiWarning2" class="warning">Campo obbligatorio</span>
					<label id="creditoResiduoLabel2" style="display: none;" for="CreditoResiduo2">Credito
						Residuo:</label>
					<input type="number" name="CreditoResiduo" id="CreditoResiduo2" class="modal-input"
						style="display: none;" />
					<span id="creditoResiduoWarning2" class="warning">Campo obbligatorio</span>
					<button type="button" onclick="controlloInserimento()" class="search-button">Inserisci</button>
				</form>
			</div>
		</div>

		<!-- Errore Contratto -->
		<div id="myModal4" class="modal">
			<div class="modal-content">
				<span class="close" onclick="closeModal()">&times;</span>
				<h3 class="modal-title">Errore!</h3>
				<p>Il numero che hai inserito e' gia' presente nel database, <br>
					si prega di modificarne il valore </p>
			</div>
		</div>

		<script>
			var showModal = <?php echo json_encode($show_modal); ?>;
		</script>

		<div class="research-filter">
			<form name="myform" method="POST" autocomplete="off">
				<input id="Numero" name="Numero" type="number" placeholder="Numero di Telefono" class="search-box"
					pattern="[0-9]+" title="Inserisci un numero di telefono valido">
				<select id="Tipo" name="Tipo" class="select-box">
					<option id="tutto" value="" selected disabled>Tipologia contratto</option>
					<option id="a ricarica" value="a ricarica"> A ricarica </option>
					<option id="a consumo" value="a consumo"> A Consumo </option>
				</select>
				<input id="DataAttivazione" name="DataAttivazione" type="date" placeholder="gg/mm/aa"
					class="search-box" />
				<div class="buttons-container">
					<form name="myform" method="POST">
						<input type="submit" value="Cerca" class="search-button" />
						<input type="button" value="Aggiungi" class="add-button" onclick="insertModal()" />
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
			//echo "<p>ContrattoTelefonicoQuery: " . $query . "</p>";
			
			try {
				$result = $conn->query($query);
			} catch (PDOException $e) {
				echo "<p>DB Error on Query: " . $e->getMessage() . "</p>";
				$error = true;
			}
			if (!$error) {
				?>

				<table class="table" id="tabellaContratto">
					<tr class="header">
						<th onclick="sortTable(0, 'num', 'tabellaContratto')" class="th-cursor-pointer">Numero ↕</th>
						<th onclick="sortTable(1, 'date', 'tabellaContratto')" class="th-cursor-pointer">Data Attivazione ↕
						</th>
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
									if($NumeroTelefonate != 0){
									?>
									<td><a href="Telefonata.php?EffettuataDa=<?php echo $Numero ?>"><?php echo $NumeroTelefonate; ?></a>
									</td> <?php
									} else {
										?>
										<td><?php echo $NumeroTelefonate;?> </td> <?php
									}
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
									if($NumeroSIMDisattive != 0) {
									?>
									<td><a
											href="SIM.php?StatoSIM=SIMDisattiva&Contratto=<?php echo $Numero ?>"><?php echo $NumeroSIMDisattive; ?></a>
									</td> <?php 
									}
									else{
										?>
									<td><?php echo $NumeroSIMDisattive; ?></td> <?php
									}
								}
							} ?>
							<td>
								<a onclick="updateModal('<?php echo $Numero; ?>', '<?php echo $DataAttivazione; ?>')"
									class="cliccabile">
									<img src="icons\pencil.png" height="20px" width="20px" class="icon-pencil" alt="Modifica">
								</a>
							</td>
							<td><a onclick="deleteModal('<?php echo $Numero; ?>')" class='cliccabile'>
									<img src="icons\bin-hover.png" height="20px" width="20px" class="icon-bin"
										alt="Elimina"></button></a>
						</tr>
					<?php } ?>
				</table>
			<?php } ?>
		</div>
	</div>

</body>

</html>