<?php      
	function getContrattoTelefonicoQry ($Numero, $DataAttivazione, $Tipo, $MinutiResidui, $CreditoResiduo) : string {
		$qry = "SELECT 	ContrattoTelefonico.Numero AS numero, ContrattoTelefonico.DataAttivazione AS DataAttivazione, ContrattoTelefonico.tipo AS tipo, ContrattoTelefonico.MinutiResidui AS MinutiResidui, ContrattoTelefonico.CreditoResiduo AS CreditoResiduo " .
							" SIMAttiva.DataAttivazione AS DataAttivazioneSIM, Artist.Name AS nArtist, " .
        					" COUNT(Telefonata.EffettuataDa) AS NumeroChiamate".
							"FROM ContrattoTelefonico 	" .
    						"JOIN Telefonata ON Telefonata.EffettuataDa=ContrattoTelefonico.Numero " .
    						"JOIN SIMAttiva ON SIMAttiva.AssociataA=ContrattoTelefonico.Numero " .
                            "JOIN SIMDisattiva ON SIMDisattiva.EraAssociataA=ContrattoTelefonico.Numero " .
							"WHERE 1=1 ";	
		if ($Numero != "")
			$qry = $qry . "AND ContrattoTelefonico.Numero = " . $Numero . " ";

		if ($DataAttivazione != "")
			$qry = $qry . "AND ContrattoTelefonico.DataAttivazione LIKE '%" . $DataAttivazione . "%' ";

		if ($Tipo != "")
			$qry = $qry . "AND ContrattoTelefonico.Tipo = " . $tipo . " ";

		if ($MinutiResidui != "" && $CreditoResiduo != "") {
    		$qry = $qry . "AND ContrattoTelefonico.MInutiResidui = " . $MinutiResidui . " ";
    		$qry = $qry . "AND ContrattoTelefonico.CreditoResiduo = " . $CreditoResiduo . " ";	
		return $qry;
	}

	function getSIMQry ($Codice, $TipoSIM, $AssociataA, $DataAttivazione, $EraAssociataA, $DataDisattivazione) : string {
		$qry = "SELECT SIMAttiva.codice AS Acodice, SIMDisattiva.codice AS Dcodice, SIMNonAttiva.codice AS Ncodice, " . 
									"COUNT(*) AS nVideoclips " . 
							"FROM Artist JOIN Video " .
								"ON Artist.id=Video.idArtist " .
							"WHERE 1=1 ";	
		if ($id != "")
			$qry = $qry . "AND Artist.id = " . $id . " ";
		if ($name != "")
			$qry = $qry . "AND Artist.Name LIKE '%" . $name . "%' ";
    	
		$qry = $qry . "GROUP BY Artist.id, Artist.Name " .
								" ORDER BY Artist.id ";

		return $qry;
	}
	
	function getQry ($name, $id) : string {
		$qry = "SELECT Director2.id AS id, " . 
									"Director2.Name AS Name, " . 
									"Director2.WikipediaLink AS Wiki, " .
									"Director2.ImvdbLink AS Imvdb, " .
									"Director2.ImdbLink AS Imdb, " .
									"COUNT(*) AS nVideoclips " . 
							"FROM Director2 JOIN Video " .
								"ON Director2.id=Video.idDirector " .
							"WHERE 1=1 ";
		if ($name != "")
			$qry = $qry . "AND Director2.Name LIKE '%" . $name . "%' ";
		if ($id != "")
			$qry = $qry . "AND Director2.id = " . $id . " ";
		
		$qry = $qry . 
		 					"GROUP BY Director2.id, Director2.Name, " .
									"Director2.WikipediaLink, " . 
									"Director2.ImvdbLink, " . 
									"Director2.ImdbLink " .
							"ORDER BY Director2.Name";
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

?>

