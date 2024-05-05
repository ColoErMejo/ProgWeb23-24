<!DOCTYPE HTML>
<html>

<head>
	<title>Telefonata DB</title>
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

	if ($_SERVER["REQUEST_METHOD"] == "POST") {
		$ora_inizio = $_POST["ora_inizio"];
		$ora_fine = $_POST["ora_fine"];
		echo "Intervalli di date dalle $ora_inizio alle $ora_fine:";
	}
	?>
	<div class="container">
		<div class="research-filter">
			<form name="myform" method="POST" action="<?php echo $_SERVER["PHP_SELF"]; ?>">
				<input id="num" name="ID" type="text" placeholder="ID" />
				<input id="num" name="EffettuataDa" type="text" placeholder="Numero di telefono" />
				<input id="date" name="Data" type="text" placeholder="Data" />
				<label for="ora_inizio">Ora di inizio:</label>
				<select name="ora_inizio" id="ora_inizio">
					<?php
					for ($i = 0; $i < 24; $i++) {
						printf('<option value="%02d:00">%02d:00</option>', $i, $i);
					}
					?>
				</select>
				<label for="ora_fine">Ora di fine:</label>
				<select name="ora_fine" id="ora_fine">
					<?php
					for ($i = 1; $i <= 24; $i++) {
						$hour = ($i == 24) ? "00" : sprintf("%02d", $i);
						printf('<option value="%02d:00">%02d:00</option>', $i, $i);
					}
					?>
				</select>
				<input type="submit" value="Cerca" />
			</form>
		</div>

		<div class="content-results">
			<?php
			$ID = "";
			$EffettuataDa = "";
			if (count($_POST) > 0) {
				$ID = $_POST["ID"];
				$EffettuataDa = $_POST["EffettuataDa"];
			} else if (count($_GET) > 0) {
				$ID = $_POST["ID"];
				$EffettuataDa = $_POST["EffettuataDa"];
			}
			$query = getTelefonataQry($ID, $EffettuataDa);
			//-- echo "<p>ContrattoTelefonicoQuery: " . $query . "</p>"; 
			
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
						<th>ID</th>
						<th>EffettuataDa</th>
						<th>Data</th>
						<th>Durata</th>
						<th>Costo</th>
					</tr>
					<?php
					$i = 0;
					foreach ($result as $riga) {
						$i = $i + 1;
						$classRiga = 'class="rowOdd"';
						if ($i % 2 == 0) {
							$classRiga = 'class="rowEven"';
						}
						$ID = $riga["ID"];
						$EffettuataDa = $riga["EffettuataDa"];
						$Data = $riga["Data"];
						$Durata = $riga["Durata"];
						$Costo = $riga["Costo"];
						?>
						<tr <?php echo $classRiga; ?>>
							<td> <?php echo $ID; ?> </td>
							<td> <?php echo $EffettuataDa; ?> </td>
							<td> <?php echo $Data ?> </td>
							<td> <?php echo $Durata; ?> </td>
							<td> <?php echo $Costo; ?> </td>
						</tr>
					<?php } ?>
				</table>
			<?php } ?>
		</div>
	</div>
</body>

</html>