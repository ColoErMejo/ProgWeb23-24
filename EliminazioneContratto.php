
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
        $qry = $qry . "ContrattoTelefonico.Numero = '" . $Codice . "';";
        $qry = $qry ." DELETE FROM Lettura WHERE ";
        $qry = $qry . "Lettura.CodUtenza = '" . $Codice . "';";
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
        echo("<script>alert('Utenza'".$Codice."' eliminata correttamente)</script>");

    }
    header('Location: '."Utenza.php");
    echo $qry;
    echo("<script>alert('Utenza'".$Codice."' eliminata correttamente)</script>");
    die();
?>
