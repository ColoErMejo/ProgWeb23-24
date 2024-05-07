<!DOCTYPE HTML>
<html lang="it">

<head>
    <title>Inserimento SIMNonAttive</title>

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

    $Codice = "";
    $TipoSIM = "";
    if (count($_POST) > 0) {
        $Codice = $_POST["Codice"];
        $TipoSIM = $_POST["TipoSIM"];
        $query = "INSERT INTO SIMNonAttiva (Codice, TipoSIM) 
                      VALUES ('$Codice', '$TipoSIM')";
        } 
        try {
            $conn->exec($query);
            echo "<h3 class='msg'>Data inserted successfully.</h3>";
        } catch (PDOException $e) {
            echo "<h3 class='msg'>DB Error on Insert: " . $e->getMessage() . "</h3>";
            $error = true;
        }
    $query = "SELECT DISTINCT Codice FROM Cliente";
    try {
        $result = $conn->query($query);
    } catch (PDOException $e) {
        echo "<h3 class='msg'>DB Error on Query: " . $e->getMessage() . "</h3>";
        $error = true;
    }
    ?>

    <div class="Container">
        <div id="research-filter">
            <h2>Inserimento SIM Non Attiva</h2>
            <form name="myform" method="POST">
                <label for="Codice">Codice SIM Non Attiva: </label>
                <input type="text" name="Codice" id="Codice" required /> <br>
                <label for="TipoSIM">Tipo SIM: </label>
                <input type="text" name="TipoSIM" id="TipoSIM" required /> <br><br>
                    <?php

                    foreach ($result as $riga) {
                        echo "<option value=" . $riga["Codice"] . ">" . $riga["Codice"] . "</option>";
                    }
                    ?>
            </form>
        </div>
    </div>
</body>
</html>