<?php      
	function getContrattoTelefonicoQry ($Numero, $DataAttivazione, $Tipo) : string {
		$qry = "SELECT 	ContrattoTelefonico.Numero AS Numero, ContrattoTelefonico.DataAttivazione AS DataAttivazione, ContrattoTelefonico.Tipo AS Tipo, ContrattoTelefonico.MinutiResidui AS MinutiResidui, ContrattoTelefonico.CreditoResiduo AS CreditoResiduo " .			
						"FROM ContrattoTelefonico ".
						"WHERE 1=1 ";	
		if ($Numero != "")
			$qry = $qry . "AND ContrattoTelefonico.Numero = " . $Numero . " ";

		if ($DataAttivazione != "")
			$qry = $qry . "AND ContrattoTelefonico.DataAttivazione LIKE '%" . $DataAttivazione . "%' ";

		if ($Tipo != "")
			$qry = $qry . "AND ContrattoTelefonico.Tipo LIKE '%" . $Tipo . "%' ";
		return $qry;
	}

	function getSIMQry($Codice, $TipoSIM): string {
		$qry = "SELECT * FROM SIMAttiva WHERE 1=1 ";
		
		if ($Codice != "") {
			$qry .= "AND SIMAttiva.Codice LIKE '%" . $Codice . "%' ";
		}
	
		if ($TipoSIM != "") {
			$qry .= "AND SIMAttiva.TipoSIM LIKE '%" . $TipoSIM . "%' ";
		}
	
		$qry .= "UNION ALL ";
	
		$qry .= "SELECT * FROM SIMDisattiva WHERE 1=1 ";
		
		if ($Codice != "") {
			$qry .= "AND SIMDisattiva.Codice LIKE '%" . $Codice . "%' ";
		}
	
		if ($TipoSIM != "") {
			$qry .= "AND SIMDisattiva.TipoSIM LIKE '%" . $TipoSIM . "%' ";
		}
	
		$qry .= "UNION ALL ";
	
		$qry .= "SELECT * FROM SIMNonAttiva WHERE 1=1 ";
		
		if ($Codice != "") {
			$qry .= "AND SIMNonAttiva.Codice LIKE '%" . $Codice . "%' ";
		}
	
		if ($TipoSIM != "") {
			$qry .= "AND SIMNonAttiva.TipoSIM LIKE '%" . $TipoSIM . "%' ";
		}
	
		return $qry;
	}
	$visualizza_SIMAttive = "SELECT * FROM SIMAttive";
	
	function getTelefonataQry ($ID, $EffettuataDa) : string {
		$qry = "SELECT Telefonata.ID AS ID, Telefonata.EffettuataDa AS EffettuataDa, Telefonata.Ora AS Ora, Telefonata.Durata AS Durata,Telefonata.Costo AS Costo," . 
							"FROM Telefonata" .
							"WHERE 1=1 ";
		if ($ID != "")
			$qry = $qry . "AND Telefonata.ID LIKE '%" . $ID . "%' ";
		
		if ($EffettuataDa != "")
			$qry = $qry . "AND Telefonata.EffettuataDa LIKE '% " . $EffettuataDa . "%' ";
		
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