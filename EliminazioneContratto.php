
<?php
    include './DBManager.php';
    include './connectDb.php';

    $Numero = "";
	if(count($_POST)>0) {
		$Numero = $_POST["Numero"];
	}	     
	else if(count($_GET)>0) {
		$Numero = $_GET["Numero"];
	}	
    if (is_null($Numero) || $Numero == "")
        return "";

    $qry = "DELETE FROM ContrattoTelefonico WHERE ";	
    
    if ($Numero != ""){
        $qry = $qry . "Telefonata.EffettuataDa = '" . $Numero . "';";
        $qry = $qry . "SIMAttiva.AssociataA = '" . $Numero . "';";
        $qry = $qry . "SIMDisattiva.EraAssociataA = '" . $Numero . "';";
        $qry = $qry . "ContrattoTelefonico.Numero = '" . $Numero . "';";
        $qry = $qry ." DELETE FROM ContrattoTelefonico WHERE ";
    }    

    try {   
        $result = $conn->query($qry);
    } catch(PDOException$e) {

        echo "<p>DB Error on Query: " . $e->getMessage() . "</p>";
        $error = true;
        echo("<script>alert(".$e->getMessage().")</script>");

        echo("ecco la ".$qry);
        echo $qry;
    }
    #anche questo potrebbe non servire
    if(!$error) {
        echo("<script>alert('Numero di telefono'".$Numero."' eliminato correttamente)</script>");

    }
    header('Location: '."ContrattoTelefonico.php");
    echo $qry;
    echo("<script>alert('Numero di telefono'".$Numero."' eliminato correttamente)</script>");
    die();
?>
