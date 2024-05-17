<?php
function getContrattoTelefonicoQry($Numero, $DataAttivazione, $Tipo): string
{
	$qry = "SELECT 	ContrattoTelefonico.Numero AS Numero, ContrattoTelefonico.DataAttivazione AS DataAttivazione, ContrattoTelefonico.Tipo AS Tipo, ContrattoTelefonico.MinutiResidui AS MinutiResidui, ContrattoTelefonico.CreditoResiduo AS CreditoResiduo " .
		"FROM ContrattoTelefonico " .
		"WHERE 1=1 ";
	if ($Numero != "")
		$qry = $qry . "AND ContrattoTelefonico.Numero = " . $Numero . " ";

	if ($DataAttivazione != "") {
		if (!empty($DataAttivazione)) {
			// Dividi la data in giorno, mese e anno
			$partiData = explode('-', $DataAttivazione);
			$annoCompleto = $partiData[0];
			$mese = $partiData[1];
			$giorno = $partiData[2];
			$anno = substr($annoCompleto, -2);
			// Formatta la data nel formato richiesto per la query SQL
			$DataSQL = "$giorno/$mese/$anno";
		}
		$qry .= "AND ContrattoTelefonico.DataAttivazione LIKE '%" . $DataSQL . "%' ";
	}

	if ($Tipo != "" && $Tipo != "tutto") {
		$qry = $qry . "AND ContrattoTelefonico.Tipo LIKE '%" . $Tipo . "%' ";
	}

	$qry = $qry . "ORDER BY ContrattoTelefonico.Numero ASC";

	return $qry;
}

function updateRow($numero, $tipo, $minutiResidui, $creditoResiduo)
{
	$qry = "UPDATE ContrattoTelefonico
				  SET 
					Tipo = '$tipo',
					MinutiResidui = '$minutiResidui',
					CreditoResiduo = '$creditoResiduo'
				  WHERE
					Numero = '$numero'";

	// Esegui la query
	if ($qry) {
		// L'aggiornamento è avvenuto con successo
		return true;
	} else {
		// Se si verifica un errore, stampa il messaggio di errore MySQL
		echo "Errore durante l'aggiornamento della riga: ";
		return false;
	}
}



function linkEliminaContratto($Numero)
{
	if (is_null($Numero) || $Numero == "")
		return "";
	return "<a href='EliminazioneContratto.php?Numero=" . $Numero . "'> Elimina </a>";
}

function getTelefonateContrattoQry($Numero): string
{
	$qry = "SELECT distinct count(*) AS NumeroTelefonate FROM Telefonata WHERE EffettuataDa = " . $Numero . " ";
	return $qry;
}

function getSIMAttivaContrattoQry($Numero): string
{
	$qry = "SELECT Codice FROM SIMAttiva WHERE AssociataA = " . $Numero;
	return $qry;
}

function getSIMDisattiveContrattoQry($Numero): string
{
	$qry = "SELECT distinct count(Codice) AS NumeroSIMDisattive FROM SIMDisattiva WHERE EraAssociataA = " . $Numero . " ";

	return $qry;
}

function getSIMQry($Codice, $TipoSIM, $Contratto): string
{
	$qry = "SELECT * FROM SIMAttiva WHERE 1=1 ";

	if ($Codice != "") {
		$qry .= "AND SIMAttiva.Codice LIKE '%" . $Codice . "%' ";
	}

	if ($TipoSIM != "" && $TipoSIM != "tutto") {
		$qry .= "AND SIMAttiva.TipoSIM LIKE '%" . $TipoSIM . "%' ";
	}

	if ($Contratto != "") {
		$qry .= "AND SIMAttiva.AssociataA = " . $Contratto . " ";
	}

	$qry .= "UNION ALL ";

	$qry .= "SELECT * FROM SIMDisattiva WHERE 1=1 ";

	if ($Codice != "") {
		$qry .= "AND SIMDisattiva.Codice LIKE '%" . $Codice . "%' ";
	}

	if ($TipoSIM != "" && $TipoSIM != "tutto") {
		$qry .= "AND SIMDisattiva.TipoSIM LIKE '%" . $TipoSIM . "%' ";
	}

	if ($Contratto != "") {
		$qry .= "AND SIMDisattiva.EraAssociataA = " . $Contratto . " ";
	}

	$qry .= "UNION ALL ";

	$qry .= "SELECT * FROM SIMNonAttiva WHERE 1=1 ";

	if ($Codice != "") {
		$qry .= "AND SIMNonAttiva.Codice LIKE '%" . $Codice . "%' ";
	}

	if ($TipoSIM != "" && $TipoSIM != "tutto") {
		$qry .= "AND SIMNonAttiva.TipoSIM LIKE '%" . $TipoSIM . "%' ";
	}

	if ($Contratto != "") {
		$qry .= "AND SIMNonAttiva.EraAssociataA = " . $Contratto . " ";
	}

	$qry = $qry . "ORDER BY Codice ASC";

	return $qry;
}

function getSIMAttivaQry($Codice, $TipoSIM, $Contratto): string
{
	$qry = "SELECT * FROM SIMAttiva WHERE 1=1 ";

	if ($Codice != "") {
		$qry .= "AND SIMAttiva.Codice LIKE '%" . $Codice . "%' ";
	}

	if ($TipoSIM != "" && $TipoSIM != "tutto") {
		$qry .= "AND SIMAttiva.TipoSIM LIKE '%" . $TipoSIM . "%' ";
	}

	if ($Contratto != "") {
		$qry .= "AND SIMAttiva.AssociataA = " . $Contratto . " ";
	}

	$qry = $qry . "ORDER BY SIMAttiva.Codice ASC";

	return $qry;
}

function getSIMDisattivaQry($Codice, $TipoSIM, $Contratto): string
{
	$qry = "SELECT * FROM SIMDisattiva WHERE 1=1 ";

	if ($Codice != "") {
		$qry .= "AND SIMDisattiva.Codice LIKE '%" . $Codice . "%' ";
	}

	if ($TipoSIM != "" && $TipoSIM != "tutto") {
		$qry .= "AND SIMDisattiva.TipoSIM LIKE '%" . $TipoSIM . "%' ";
	}

	if ($Contratto != "") {
		$qry .= "AND SIMDisattiva.EraAssociataA = " . $Contratto . " ";
	}

	$qry = $qry . "ORDER BY SIMDisattiva.Codice ASC";

	return $qry;
}

function getSIMNonAttivaQry($Codice, $TipoSIM, $Contratto): string
{
	$qry = "SELECT * FROM SIMNonAttiva WHERE 1=1 ";

	if ($Codice != "") {
		$qry .= "AND SIMNonAttiva.Codice LIKE '%" . $Codice . "%' ";
	}

	if ($TipoSIM != "" && $TipoSIM != "tutto") {
		$qry .= "AND SIMNonAttiva.TipoSIM LIKE '%" . $TipoSIM . "%' ";
	}

	if ($Contratto != "") {
		$qry .= "AND SIMNonAttiva.EraAssociataA != NULL";
	}

	$qry = $qry . "ORDER BY SIMNonAttiva.Codice ASC";

	return $qry;
}

function getTelefonataQry($ID, $EffettuataDa, $Data): string
{

	$qry = "SELECT * FROM Telefonata WHERE 1=1 ";
	if ($ID != "")
		$qry = $qry . "AND Telefonata.ID =" . $ID . " ";

	if ($EffettuataDa != "")
		$qry = $qry . "AND Telefonata.EffettuataDa = " . $EffettuataDa . " ";

	if ($Data != "") {
		if (!empty($Data)) {
			// Dividi la data in giorno, mese e anno
			$partiData = explode('-', $Data);
			$annoCompleto = $partiData[0];
			$mese = $partiData[1];
			$giorno = $partiData[2];
			$anno = substr($annoCompleto, -2);
			// Formatta la data nel formato richiesto per la query SQL
			$DataSQL = "$giorno/$mese/$anno";
		}
		$qry .= "AND Telefonata.Data LIKE '%" . $DataSQL . "%' ";
	}

	$qry = $qry . "ORDER BY Telefonata.EffettuataDa, Telefonata.ID";

	return $qry;
}

function insertContratto($Numero, $DataAttivazione, $Tipo, $MinutiResidui, $CreditoResiduo): string
{
	$DataSQL = "";
	if ($DataAttivazione != "") {
		if (!empty($DataAttivazione)) {
			// Dividi la data in giorno, mese e anno
			$partiData = explode('-', $DataAttivazione);
			$annoCompleto = $partiData[0];
			$mese = $partiData[1];
			$giorno = $partiData[2];
			$anno = substr($annoCompleto, -2);
			// Formatta la data nel formato richiesto per la query SQL
			$DataSQL = "$giorno/$mese/$anno";
		}
	}
	$qry = "INSERT INTO ContrattoTelefonico(Numero, DataAttivazione, Tipo, MinutiResidui, CreditoResiduo) VALUES(";

	$qry .= "\"" . $Numero . "\", ";
	if ($DataSQL != "") {
		$qry .= "\"" . $DataSQL . "\", ";
	} else {
		$qry .= "\"NULL\", ";
	}
	$qry .= "\"" . $Tipo . "\", ";
	if ($MinutiResidui != "") {
		$qry .= "\"" . $MinutiResidui . "\", ";
		$qry .= "NULL )";
	} elseif ($CreditoResiduo != "") {
		$qry .= "NULL, ";
		$qry .= "\"" . $CreditoResiduo . "\") ";
	}
	echo "<script> alert(" . $qry . ")</script>";
	return $qry;
}

function formatLink($lnk): string
{
	if (is_null($lnk) || $lnk == "")
		return "";
	return "<a href='" . $lnk . "'>Click here</a>";
}
function formatYoutubeLink($lnk): string
{
	if (is_null($lnk) || $lnk == "")
		return "";
	return "<a href='" . $lnk . "'>YouTube: Click here</a>";
}
function formatDirectorLink($lnk, $name): string
{
	if (is_null($lnk) || $lnk == "")
		return "";
	return "<a href='directors.php?id=" . $lnk . "'>" . $name . "</a>";
}
function formatArtistLink($lnk, $name): string
{
	if (is_null($lnk) || $lnk == "")
		return "";
	return "<a href='artists.php?id=" . $lnk . "'>" . $name . "</a>";
}
function formatVideoDirectorLink($lnk, $n): string
{
	if (is_null($lnk) || $lnk == "")
		return "";
	return "<a href='index.php?idDir=" . $lnk . "'>" . $n . "</a>";
}
function formatVideoArtistLink($lnk, $n): string
{
	if (is_null($lnk) || $lnk == "")
		return "";
	return "<a href='index.php?idArt=" . $lnk . "'>" . $n . "</a>";
}