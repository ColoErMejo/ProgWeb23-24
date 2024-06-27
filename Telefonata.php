<!DOCTYPE HTML>
<html>

<head>
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
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
	?>
	<div class="container">
		<div class="research-filter">
			<form name="myform" method="POST" autocomplete="off" action="<?php echo $_SERVER["PHP_SELF"]; ?>">
				<input id="EffettuataDa" name="EffettuataDa" type="text" placeholder="Effettuata Da" class="search-box"
					pattern="[0-9]+" title="Inserisci un numero di telefono valido" />
				<input id="Data" name="Data" type="date" placeholder="gg/mm/aa" class="search-box" />
				<div class="buttons-container">
					<input type="submit" value="Cerca" class="search-button" />
				</div>
			</form>
		</div>

		<div class="content-results">
			<?php
			$ID = "";
			$EffettuataDa = "";
			$Data = "";
			if (count($_POST) > 0) {
				$ID = $_POST["ID"];
				$EffettuataDa = $_POST["EffettuataDa"];
				$Data = $_POST["Data"];
			} else if (count($_GET) > 0) {
				$ID = $_GET["ID"];
				$EffettuataDa = $_GET["EffettuataDa"];
				$Data = $_GET["Data"];
			}
			$query = getTelefonataQry($ID, $EffettuataDa, $Data);
			//echo "<p>ContrattoTelefonicoQuery: " . $query . "</p>"; 
			
			try {
				$result = $conn->query($query);
			} catch (PDOException $e) {
				echo "<p>DB Error on Query: " . $e->getMessage() . "</p>";
				$error = true;
			}
			if (!$error) {
				?>
				<table class="table" id="tabellaTelefonata">
					<tr class="header">
						<th>ID</th>
						<th onclick="sortTable(1, 'num', 'tabellaTelefonata')" class="th-cursor-pointer">EffettuataDa ↕</th>
						<th onclick="sortTable(2, 'date', 'tabellaTelefonata')" class="th-cursor-pointer">Data ↕</th>
						<th>Ora</th>
						<th onclick="sortTable(4, 'num', 'tabellaTelefonata')" class="th-cursor-pointer">Durata ↕</th>
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
						$Ora = $riga["Ora"];
						$Durata = $riga["Durata"];
						$Costo = $riga["Costo"];
						?>
						<tr <?php echo $classRiga; ?>>
							<td> <?php echo $ID; ?> </td>
							<td> <?php echo $EffettuataDa; ?> </td>
							<td> <?php echo $Data ?> </td>
							<td> <?php echo $Ora ?> </td>
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