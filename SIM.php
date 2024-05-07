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
	<div class="container">
		<div class="research-filter">
			<form name="myform" method="POST">
				<input id="Codice" name="Codice" type="text" placeholder="Codice" class="search-box" /><br>
				<input id="Contratto" name="Contratto" type="text" placeholder="Numero di telefono"
					class="search-box" /><br>

				<select id="TipoSIM" name="TipoSIM" class="custom-select" />
				<option value="tutto">seleziona tipo SIM</option>
				<option value="standard">standard</option>
				<option value="micro">micro</option>
				<option value="elettronica">elettronica</option>
				</select><br>

				<select id="StatoSIM" name="StatoSIM" class="custom-select" />
				<option value="tutto">seleziona stato SIM</option>
				<option value="SIMAttiva">attiva</option>
				<option value="SIMDisattiva">disattiva</option>
				<option value="SIMNonAttiva">non attiva</option>
				</select>
				<!--<a href="InserimentoSIMNonAttiva.php">
					<img src="icons\plus.png" width="20px" height="20px">
				</a><br>-->
				<div class="buttons-container">
					<input type="submit" value="Cerca" class="search-button" />
					<input type="submit" value="Aggiungi SIM" class="add-button" />
				</div>


			</form>
		</div>

		<div class="content-results">
			<?php
			$Codice = "";
			$TipoSIM = "";
			$StatoSIM = "";
			$Contratto = "";
			if (count($_POST) > 0) {
				$Codice = $_POST["Codice"];
				$TipoSIM = $_POST["TipoSIM"];
				$StatoSIM = $_POST["StatoSIM"];
				$Contratto = $POST_["Contratto"];
			} else if (count($_GET) > 0) {
				$Codice = $_GET["Codice"];
				$TipoSIM = $_GET["TipoSIM"];
				$StatoSIM = $_GET["StatoSIM"];
				$Contratto = $GET_["Contratto"];
			}

			if ($StatoSIM == "" || $StatoSIM == "tutto") {
				$query = getSIMQry($Codice, $TipoSIM, $Contratto);
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
							if ($i % 2 == 0) {
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
								<td> <?php echo $DataDisattivazione; ?> </td>
							</tr>
						<?php } ?>
					</table>
				<?php }

			} else if ($StatoSIM == "SIMAttiva") {
				$query = getSIMAttivaQry($Codice, $TipoSIM, $Contratto);
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
								<th>Data Attivazione</th>
							</tr>
							<?php
							$i = 0;
							foreach ($result as $riga) {
								$i = $i + 1;
								$classRiga = 'class="rowOdd"';
								if ($i % 2 == 0) {
									$classRiga = 'class="rowEven"';
								}
								$Codice = $riga["Codice"];
								$TipoSIM = $riga["TipoSIM"];
								$AssociataA = $riga["AssociataA"];
								$DataAttivazione = $riga["DataAttivazione"];
								?>
								<tr <?php echo $classRiga; ?>>
									<td> <?php echo $Codice; ?> </td>
									<td> <?php echo $TipoSIM; ?> </td>
									<td> <?php echo $AssociataA; ?> </td>
									<td> <?php echo $DataAttivazione; ?> </td>
								</tr>
						<?php } ?>
						</table>
				<?php }

			} else if ($StatoSIM == "SIMDisattiva") {
				$query = getSIMDisattivaQry($Codice, $TipoSIM, $Contratto);
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
									<th>Era Associata A</th>
									<th>Data Attivazione</th>
									<th>Data Disattivazione</th>
								</tr>
							<?php
							$i = 0;
							foreach ($result as $riga) {
								$i = $i + 1;
								$classRiga = 'class="rowOdd"';
								if ($i % 2 == 0) {
									$classRiga = 'class="rowEven"';
								}
								$Codice = $riga["Codice"];
								$TipoSIM = $riga["TipoSIM"];
								$EraAssociataA = $riga["EraAssociataA"];
								$DataAttivazione = $riga["DataAttivazione"];
								$DataDisattivazione = $riga["DataDisattivazione"];
								?>
									<tr <?php echo $classRiga; ?>>
										<td> <?php echo $Codice; ?> </td>
										<td> <?php echo $TipoSIM; ?> </td>
										<td> <?php echo $EraAssociataA; ?> </td>
										<td> <?php echo $DataAttivazione; ?> </td>
										<td> <?php echo $DataDisattivazione; ?> </td>
									</tr>
						<?php } ?>
							</table>
				<?php }

			} else if ($StatoSIM == "SIMNonAttiva") {
				$query = getSIMNonAttivaQry($Codice, $TipoSIM, $Contratto);
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
									</tr>
							<?php
							$i = 0;
							foreach ($result as $riga) {
								$i = $i + 1;
								$classRiga = 'class="rowOdd"';
								if ($i % 2 == 0) {
									$classRiga = 'class="rowEven"';
								}
								$Codice = $riga["Codice"];
								$TipoSIM = $riga["TipoSIM"];
								?>
										<tr <?php echo $classRiga; ?>>
											<td> <?php echo $Codice; ?> </td>
											<td> <?php echo $TipoSIM; ?> </td>
										</tr>
						<?php } ?>
								</table>
				<?php }

			} ?>

		</div>

	</div>
</body>

</html>