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
				<input id="Codice" name="Codice" type="text" placeholder="Codice" class="search-box" />
				<input id="Contratto" name="Contratto" type="text" placeholder="Numero di telefono"
					class="search-box" />

				<select id="TipoSIM" name="TipoSIM" class="custom-select">
					<option value="tutto">Seleziona tipo SIM</option>
					<option value="standard">Standard</option>
					<option value="micro">Micro</option>
					<option value="elettronica">Elettronica</option>
				</select>

				<select id="StatoSIM" name="StatoSIM" class="custom-select">
					<option value="tutto">seleziona stato SIM</option>
					<option value="SIMAttiva">attiva</option>
					<option value="SIMDisattiva">disattiva</option>
					<option value="SIMNonAttiva">non attiva</option>
				</select>
				<div class="buttons-container">
					<input type="submit" value="Cerca" class="search-button" />
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
				$Contratto = $_POST["Contratto"];
			} else if (count($_GET) > 0) {
				$Codice = $_GET["Codice"];
				$TipoSIM = $_GET["TipoSIM"];
				$StatoSIM = $_GET["StatoSIM"];
				$Contratto = $_GET["Contratto"];
			}

			if ($StatoSIM == "" || $StatoSIM == "tutto") {
				$query = getSIMQry($Codice, $TipoSIM, $Contratto);
				//echo "<p>SIMQuery: " . $query . "</p>";

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
								<?php if ($AssociataA == "") { ?>
									<td> <?php echo $AssociataA; ?> </td>
								<?php } else { ?>
									<td> <a
											href="ContrattoTelefonico.php?Numero=<?php echo $AssociataA ?>"><?php echo $AssociataA; ?></a>
									</td>
								<?php }

								if ($EraAssociataA == "") { ?>
									<td> <?php echo $EraAssociataA; ?> </td>
								<?php } else { ?>
									<td> <a
											href="ContrattoTelefonico.php?Numero=<?php echo $EraAssociataA ?>"><?php echo $EraAssociataA; ?></a>
									</td>
								<?php } ?>
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
									<td> <a
											href="ContrattoTelefonico.php?Numero=<?php echo $AssociataA ?>"><?php echo $AssociataA; ?></a>
									</td>
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
										<td> <a
												href="ContrattoTelefonico.php?Numero=<?php echo $EraAssociataA ?>"><?php echo $EraAssociataA; ?></a>
										</td>
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