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
            <input id="AssociataA" name="AssociataA" type="text" placeholder="AssociataA" />
            <input id="EraAssociataA" name="EraAssociataA" type="text" placeholder="EraAssociataA" />
			<input id="DataAttivazione" name="DataAttivazione" type="text" placeholder="Data attivazione" />
            <input id="DataDisattivazione" name="DataDisattivazione" type="text" placeholder="Data disattivazione" />
			
			<input type="submit" value="Cerca" />
		</form>

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