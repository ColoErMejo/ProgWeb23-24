<!DOCTYPE HTML>
<html lang="it">

<head>
    <title>Inserimento Contratto Telefonico</title>
    <meta charset="UTF-8">
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

    $Numero = "";
    $DataAttivazione = "";
    $Tipo = "";
    $MinutiResidui = "";
    $CreditoResiduo = "";
    if (count($_GET) > 0) {
        $Numero = $_GET["Numero"];
    }
    if (count($_POST) > 0) {
        $Numero = $_POST["Numero"];
        $DataAttivazione = $_POST["DataAttivazione"];
        $Tipo = $_POST["Tipo"];
        if (isset($_POST["Tipo"])) {
            if ($Tipo === "a ricarica") {
                $CreditoResiduo = $_POST["CreditoResiduo"];
            } elseif ($Tipo === "a consumo") {
                $MinutiResidui = $_POST["MinutiResidui"];
            }
        }


        $query = "SELECT DISTINCT Numero FROM ContrattoTelefonico";
        try {
            $result = $conn->query($query);
            $trovato = false;
            foreach ($result as $riga) {
                $NumeroContratto = $riga["Numero"];
                if ($NumeroContratto == $Numero) {
                    $trovato = true;
                    echo "<h3 class='msg'>ERRORE: Numero di telefono già associato ad un altro contratto: </h3>";
                    break;
                }
            }
            if (!$trovato) {
                $query = insertContratto($Numero, $DataAttivazione, $Tipo, $MinutiResidui, $CreditoResiduo);
                try {
                    $result = $conn->query($query);
                    echo ("<script>alert('Query eseguita')</script>");

                } catch (PDOException $e) {
                    echo "<h3>DB Error on Query: " . $e->getMessage() . "</h3>";
                    $error = true;
                }

                if ($error) {
                    echo ("<script>alert(" . $error . ")</script>");
                }else{
                    echo("<script>mostraInserimento(".$Numero.")</script>");
                
                }
            }
        } catch (PDOException $e) {
            echo "<h3 class='msg'>DB Error on Query: " . $e->getMessage() . "</h3>";
            $error = true;
        }
    }
    ?>
    <div class="container">
        <div id="research-filter">
            <h2>Inserimento Contratto Telefonico</h2>
            <form name="myform" method="POST">
                <label for="Numero">Numero di telefono: </label>
                <input name="Numero" id="Numero" required><br><br>
                <label for="DataAttivazione">Data Attivazione: </label>
                <input type="date" name="DataAttivazione" id="DataAttivazione" value="<?php echo date('Y-m-d'); ?>" required /> <br><br>
                <select id="Tipo" name="Tipo" onchange="showHideFields()">
                    <option value="" disabled selected hidden>Tipologia Contratto</option>
                    <option value="a ricarica"> A ricarica </option>
                    <option value="a consumo"> A consumo </option>
                </select><br><br>
                <label id="minutiResiduiLabel" style="display: none;" for="MinutiResidui">Minuti Residui: </label>
                <input type="text" name="MinutiResidui" id="MinutiResidui" style="display: none;" />
                <label id="creditoResiduoLabel" style="display: none;" for="CreditoResiduo">Credito Residuo: </label>
                <input type="text" name="CreditoResiduo" id="CreditoResiduo" style="display: none;" /> <br>
                <input type="submit" value="Aggiungi" />
            </form>
        </div>
    </div>
   
</body>

</html>