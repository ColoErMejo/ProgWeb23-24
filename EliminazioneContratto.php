
<?php
    include './DBManager.php';
    include './connectDB.php';

    $Numero = "";
	if(count($_POST)>0) {
		$Numero = $_POST["Numero"];
	}	     
	else if(count($_GET)>0) {
		$Numero = $_GET["Numero"];
	}	
    if (is_null($Numero) || $Numero == "")
        return "";

    $qry = "";
    $qry = "DELETE FROM Telefonata WHERE ";
    $qry = $qry . "Telefonata.EffettuataDa = '" . $Numero . "';";
    $qry = $qry . " DELETE FROM SIMAttiva WHERE ";
    $qry = $qry . "SIMAttiva.AssociataA = '" . $Numero . "';";
    $qry = $qry . " DELETE FROM SIMDisattiva WHERE ";
    $qry = $qry . "SIMDisattiva.EraAssociataA = '" . $Numero . "';"; 
    $qry = $qry . " DELETE FROM ContrattoTelefonico WHERE ";	
    $qry = $qry . "ContrattoTelefonico.Numero = '" . $Numero . "'"; 

    try {   
        $result = $conn->query($qry);
        echo("<script>alert(Il contratto " . $Numero . " è stato eliminato e con esso tutte le sue informazioni)</script>");
    } 
    catch(PDOException$e) {
        echo "<p>DB Error on Query: " . $e->getMessage() . "</p>";
        echo("<script>alert(".$e->getMessage().")</script>");
        echo $qry;
    }    

    header('Location: '."ContrattoTelefonico.php");
    die();
?>
