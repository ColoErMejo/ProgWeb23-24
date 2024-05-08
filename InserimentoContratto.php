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
    $Tipo  = "";
    $MinutiResidui = "";
    $CreditoResiduo  = "";
    if (count($_POST) > 0) {
        $Numero = $_POST["Numero"];
        $DataAttivazione = $_POST["DataAttivazione"];
        $Tipo  = $_POST["Tipo"];
        if(isset($_POST["Tipo"]))  {
            $Tipo = "a ricarica";
            $MinutiResidui  = "";
            $CreditoResiduo = $_POST["CreditoResiduo"];
        } else {
            $Tipo = "a consumo";
            $MinutiResidui  = $_POST["MinutiResidui"];
            $CreditoResiduo = "";
        }

            $query = insertContratto($Numero, $DataAttivazione, $Tipo, $MinutiResidui, $Creditoresiduo);
            try {
                $result = $conn->query($query);
            } catch (PDOException $e) {
                echo "<h3>DB Error on Query: " . $e->getMessage() . "</h3>";
                $error = true;
            }
            if (!$error) {
                echo ("<script>alert('Inserimento andato a buon fine')</script>");
                header('Location: ' . "Utenza.php");
            } else {
                echo ("<script>alert(" . $error . ")</script>");
            }
        }
    $query = "SELECT DISTINCT Numero FROM ContrattoTelefonico";
    try {
        $result = $conn->query($query);
    } catch (PDOException $e) {
        echo "<h3 class='msg'>DB Error on Query: " . $e->getMessage() . "</h3>";
        $error = true;
    }
    ?>

    <div class="container">
        <?php
        include '../Extra/nav.html';
        ?>
        <div id="content-results">
            <h2>Inserimento Contratto Telefonico</h2>
            <form name="myform" method="POST">
                <label for="Numero">Numero di telefono: </label>
                <input name="Numero" id="Numero" required><br><br>
                <label for="DataAttivazione">Data Attivazione: </label>
                <input type="date" name="DataAttivazione" id="DataAttivazione" required /> <br><br>
                <select id="Tipo" name="Tipo">
                    <option value="" disabled selected hidden>Tipologia Contratto</option> 
					<option id="a ricarica" value="a ricarica"> a ricarica </option>
					<option id="a consumo" value="a consumo"> a consumo </option>
				</select><br><br>
                <label for="MinutiResidui">Minuti Residui: </label>
                <input type="text" name="MinutiResidui" id="MinutiResidui" /> <br><br>
                <label for="CreditoResiduo">Credito Residuo: </label>
                <input type="text" name="CreditoResiduo" id="CreditoResiduo" /> <br><br>
                <input type="submit" value="Aggiungi" />
            </form>
        </div>
    </div>
</body>
<script type="text/javascript" src="../js/script.js" defer></script>

</html>
