<?php      
	function getContrattoTelefonicoQry ($Numero, $DataAttivazione, $Tipo) : string {
		$qry = "SELECT 	ContrattoTelefonico.Numero AS Numero, ContrattoTelefonico.DataAttivazione AS DataAttivazione, ContrattoTelefonico.Tipo AS Tipo, ContrattoTelefonico.MinutiResidui AS MinutiResidui, ContrattoTelefonico.CreditoResiduo AS CreditoResiduo " .			
						"FROM ContrattoTelefonico ".
						"WHERE 1=1 ";	
		if ($Numero != "")
			$qry = $qry . "AND ContrattoTelefonico.Numero = " . $Numero . " ";

		if ($DataAttivazione != "")
			$qry = $qry . "AND ContrattoTelefonico.DataAttivazione LIKE '%" . $DataAttivazione . "%' ";

		if ($Tipo != "" && $Tipo != "tutto")
			$qry = $qry . "AND ContrattoTelefonico.Tipo LIKE '%" . $Tipo . "%' ";
		return $qry;
	}

	function getTelefonateContrattoQry($Numero) : string {
		$qry = "SELECT distinct count(*) AS NumeroTelefonate FROM Telefonata WHERE EffettuataDa = " . $Numero . " ";
		return $qry;
	}

	function getSIMAttivaContrattoQry($Numero) : string {
		$qry = "SELECT Codice FROM SIMAttiva WHERE AssociataA = " . $Numero;
		return $qry;
	}

	function getSIMDisattiveContrattoQry($Numero) : string {
		$qry = "SELECT distinct count(Codice) AS NumeroSIMDisattive FROM SIMDisattiva WHERE EraAssociataA = " . $Numero . " ";
		return $qry;
	}

	function getSIMQry($Codice, $TipoSIM): string {
		$qry = "SELECT * FROM SIMAttiva WHERE 1=1 ";
		
		if ($Codice != "") {
			$qry .= "AND SIMAttiva.Codice LIKE '%" . $Codice . "%' ";
		}
	
		if ($TipoSIM != "" && $TipoSIM != "tutto") {
			$qry .= "AND SIMAttiva.TipoSIM LIKE '%" . $TipoSIM . "%' ";
		}
	
		$qry .= "UNION ALL ";
	
		$qry .= "SELECT * FROM SIMDisattiva WHERE 1=1 ";
		
		if ($Codice != "") {
			$qry .= "AND SIMDisattiva.Codice LIKE '%" . $Codice . "%' ";
		}
	
		if ($TipoSIM != "" && $TipoSIM != "tutto") {
			$qry .= "AND SIMDisattiva.TipoSIM LIKE '%" . $TipoSIM . "%' ";
		}
	
		$qry .= "UNION ALL ";
	
		$qry .= "SELECT * FROM SIMNonAttiva WHERE 1=1 ";
		
		if ($Codice != "") {
			$qry .= "AND SIMNonAttiva.Codice LIKE '%" . $Codice . "%' ";
		}
	
		if ($TipoSIM != "" && $TipoSIM != "tutto") {
			$qry .= "AND SIMNonAttiva.TipoSIM LIKE '%" . $TipoSIM . "%' ";
		}
	
		return $qry;
	}

	function getSIMAttivaQry($Codice, $TipoSIM): string {
		$qry = "SELECT * FROM SIMAttiva WHERE 1=1 ";
		
		if ($Codice != "") {
			$qry .= "AND SIMAttiva.Codice LIKE '%" . $Codice . "%' ";
		}
	
		if ($TipoSIM != "" && $TipoSIM != "tutto") {
			$qry .= "AND SIMAttiva.TipoSIM LIKE '%" . $TipoSIM . "%' ";
		}

		return $qry;
	}

	function getSIMDisattivaQry($Codice, $TipoSIM): string {
		$qry = "SELECT * FROM SIMDisattiva WHERE 1=1 ";
		
		if ($Codice != "") {
			$qry .= "AND SIMDisattiva.Codice LIKE '%" . $Codice . "%' ";
		}
	
		if ($TipoSIM != "" && $TipoSIM != "tutto") {
			$qry .= "AND SIMDisattiva.TipoSIM LIKE '%" . $TipoSIM . "%' ";
		}

		return $qry;
	}

	function getSIMNonAttivaQry($Codice, $TipoSIM): string {
		$qry = "SELECT * FROM SIMNonAttiva WHERE 1=1 ";
		
		if ($Codice != "") {
			$qry .= "AND SIMNonAttiva.Codice LIKE '%" . $Codice . "%' ";
		}
	
		if ($TipoSIM != "" && $TipoSIM != "tutto") {
			$qry .= "AND SIMNonAttiva.TipoSIM LIKE '%" . $TipoSIM . "%' ";
		}

		return $qry;
	}

	function getTelefonataQry ($ID, $EffettuataDa) : string {
		$qry = "SELECT * FROM Telefonata WHERE 1=1 ";
		if ($ID != "")
			$qry = $qry . "AND Telefonata.ID =" . $ID . " ";
		
		if ($EffettuataDa != "")
			$qry = $qry . "AND Telefonata.EffettuataDa = " . $EffettuataDa . " ";
		
		/*$qry = $qry . 
		 					"GROUP BY Telefonata.ID, Telefonata.EffettuataDa, " .
									"Telefonata.Data, " . 
									"Telefonata.Ora, " . 
									"Telefonata.Durata " .
									"Telefonata.Costo " .
							"ORDER BY Telefonata.EffettuataDa";*/
		return $qry;
	}

	
	function formatLink ($lnk) : string	{
		if (is_null($lnk) || $lnk == "")
			return "";
		return "<a href='" . $lnk . "'>Click here</a>";
	}					
	function formatYoutubeLink ($lnk) : string	{
		if (is_null($lnk) || $lnk == "")
			return "";
		return "<a href='" . $lnk . "'>YouTube: Click here</a>";
	}					
	function formatDirectorLink ($lnk, $name) : string	{
		if (is_null($lnk) || $lnk == "")
			return "";
		return "<a href='directors.php?id=" . $lnk . "'>" . $name . "</a>";
	}					
	function formatArtistLink ($lnk, $name) : string	{
		if (is_null($lnk) || $lnk == "")
			return "";
		return "<a href='artists.php?id=" . $lnk . "'>" . $name . "</a>";
	}	
	function formatVideoDirectorLink ($lnk, $n) : string	{
		if (is_null($lnk) || $lnk == "")
			return "";
		return "<a href='index.php?idDir=" . $lnk . "'>" . $n . "</a>";
	}	
	function formatVideoArtistLink ($lnk, $n) : string	{
		if (is_null($lnk) || $lnk == "")
			return "";
		return "<a href='index.php?idArt=" . $lnk . "'>" . $n . "</a>";
	}	