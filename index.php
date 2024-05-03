<!DOCTYPE HTML>
<html>

<head>
	<title>TrapPhone</title>
	<link rel="stylesheet" href="./style.css">
	<script type="text/javascript" src="./script.js"></script>
</head>

<body>
	<?php
	include 'header.html';
	include 'nav.html';
	include 'footer.html';
	include 'DBManager.php';
	?>
	<div id="research_filter">
		<form name="myform" method="POST">
			<input id="Numero" name="Numero" type="text" placeholder="Numero di Telefono" />
			<input id="DataAttivazione" name="DataAttivazione" type="text" placeholder="Data attivazione" />
			<input id="Tipo" name="Tipo" type="text" placeholder="Tipo SIM" />
			<input id="MinutiResidui" name="MinutiResidui" type="text" placeholder="Minuti Residui" />
			<input id="CreditoResiduo" name="CreditoResiduo" type="text" placeholder="Credito Residuo" />
			<input type="submit" value="Cerca" />
		</form>

		<div id="results">
			<?php
			$Numero = "";
			$DataAttivazione = "";
			$Tipo = "";
			$MinutiResidui = "";
			$CreditoResiduo = "";
			if (count($_POST) > 0) {
				$Numero = $_POST["Numero"];
				$DataAttivazione = $_POST["DataAttivazione"];
				$Tipo = $_POST["Tipo "];
				$MinutiResidui = $_POST["MinutiResidui"];
				$CreditoResiduo = $_POST["CreditoResiduo"];
			} else if (count($_GET) > 0) {
				$Numero = $_POST["Numero"];
				$DataAttivazione = $_POST["DataAttivazione"];
				$Tipo = $_POST["Tipo "];
				$MinutiResidui = $_POST["MinutiResidui"];
				$CreditoResiduo = $_POST["CreditoResiduo"];
			}
			$query = getContrattoTelefonicoQry($Numero, $DataAttivazione, $Tipo, $MinutiResidui, $CreditoResiduo);
			echo "<p>ContrattoTelefonicoQuery: " . $query . "</p>";

			include 'connectDB.php';

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
						<th># </th>
						<!--th>id </th-->
						<th>Numero</th>
						<th>Data Attivazione</th>
						<th>Tipo</th>
						<th>Minuti Residui</th>
						<th>Credito Residuo</th>
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
						$MinutiResidu = $riga["MinutiResidui"];
						$CreditoResiduo = $riga["CreditoResiduo"];

						?>
						<tr <?php echo $classRiga; ?>>
							<!--td > <?php echo $Numero; ?> </td-->
							<td> <?php echo $DataAttivazione; ?> </td>
							<td> <?php echo $Tipo; ?> </td>
						</tr>
					<?php } ?>
				</table>
			<?php } ?>

		</div>
	</div>
</body>

</html>