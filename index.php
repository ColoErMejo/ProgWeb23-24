<!DOCTYPE HTML>
<html>

<head>
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>TrapPhone</title>
	<link rel="stylesheet" type="text/css" href="./css/style.css">
	<script type="text/javascript" src="./js/script.js"></script>
	<script type="text/javascript" src="./js/ajax.js"></script>
	<!--Chiamate Ajax-->
</head>

<body>
	<?php
	include 'header.html';
	include 'nav.html';
	include 'footer.html';
	include 'DBManager.php';
	include 'connectDB.php';
	?>
	<div class="container" id="containerHome">

		<!--<img src="icons\trapgif.gif" width="300px" alt="TrapGif">-->
		<h3>Introduzione</h3>
		<p>Questo sito web è stato sviluppato per amministrare efficacemente il database di una rinomata compagnia
			telefonica. L'obiettivo principale è la gestione completa dei contratti telefonici stipulati dalla
			compagnia, inclusa la registrazione delle chiamate effettuate da ogni numero e la gestione delle SIM card.
			Le SIM possono avere uno stato attivo, disattivo o non attivo.
			Gli utenti hanno la possibilità di aggiungere nuovi contratti, specificando il numero di telefono, la data
			di attivazione, il tipo di contratto (a ricarica o a consumo) e gli eventuali minuti o credito residui. È
			inoltre possibile aggiornare i dettagli di ciascun contratto telefonico, nonché eliminarli. In caso di
			eliminazione di un contratto, tutte le registrazioni delle chiamate associate a quel numero verranno
			cancellate, insieme alle SIM associate.</p>
	</div>

</body>

</html>