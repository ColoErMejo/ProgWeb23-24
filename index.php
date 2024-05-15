<!DOCTYPE HTML>
<html>

<head>
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
	<div class="container">
		<div class="research-filter">
			<img src="icons\trapgif.gif" width="300px">
		</div>

		<div class="content-results">
    		<h3>Introduzione</h3>
    		<p>Questo gestionale è stato progettato per amministrare facilmente il database di una nota compagnia telefonica. L'obiettivo è gestire tutti i contratti telefonici stipulati dalla compagnia, la relativa lista delle chiamate effettuate da ogni numero e la totalità delle SIM. Ogni SIM può essere attiva, disattiva o non attiva. L'utente può aggiungere nuovi contratti, specificando il numero di telefono, la data di attivazione, la tipologia di contratto (a ricarica / a consumo) e gli eventuali credito/minuti rimanenti. Si possono aggiornare i campi di ogni contratto telefonico ed eliminarne anche, in questo caso vengono eliminate anche tutte le tuple del registro delle chiamate associate a quel numero e cancellate le SIM associate.</p>
    		<img src="icons\truce.png">
		</div>
	</div>
</body>

</html>