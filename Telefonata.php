<!DOCTYPE HTML>
<html>
<head>
    <title>Telefonata DB</title>
    <link rel="stylesheet" href="./css/trapPhone.css">
    <script type="text/javascript" src="./js/script.js"></script>
</head>
<body onload="setH1telefonata()">
<?php
include 'index.html';
include 'DBManager.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $ora_inizio = $_POST["ora_inizio"];
    $ora_fine = $_POST["ora_fine"];
    echo "Intervalli di date dalle $ora_inizio alle $ora_fine:";
}
?>
<div id="content">
    <form name="myform" method="POST" action="<?php echo $_SERVER["PHP_SELF"];?>">
        <input id="num" name="EffettuataDa" type="text" placeholder="Numero di telefono"/>
        <input id="date" name="Data" type="text" placeholder="Data"/>
        <input id="time" name="Ora" type="text" placeholder="Fascia Oraria"/>
        <label for="ora_inizio">Ora di inizio:</label>
        <select name="ora_inizio" id="ora_inizio">
            <?php
            for ($i = 0; $i < 24; $i++) {
                printf('<option value="%02d:00">%02d:00</option>', $i, $i);
            }
            ?>
        </select>
        <label for="ora_fine">Ora di fine:</label>
        <select name="ora_fine" id="ora_fine">
            <?php
            for ($i = 1; $i <= 24; $i++) {
                $hour = ($i == 24) ? "00" : sprintf("%02d", $i);
                printf('<option value="%02d:00">%02d:00</option>', $i, $i);
            }
            ?>
        </select>
        <input type="submit" value="Cerca"/>
    </form>
    <div id="results">
        <?php
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $ID = "";
            $EffettuataDa = $_POST["EffettuataDa"];
            $query = getTelefonataQry($ID, $EffettuataDa);

            include 'connectDB.php';

            try {
                $result = $conn->query($query);
                ?>
                <table class="table">
                    <tr class="header">
                        <th>ID</th>
                        <th>EffettuataDa</th>
                        <th>Data</th>
                        <th>Ora</th>
                        <th>Durata</th>
                        <th>Costo</th>
                    </tr>
                    <?php
                    $i = 0;
                    foreach ($result as $riga) {
                        $i++;
                        $classRiga = ($i % 2 == 0) ? 'class="rowEven"' : 'class="rowOdd"';
                        $EffettuataDa = $riga["EffettuataDa"];
                        $ID = $riga["ID"];
                        $Data = $riga["Data"];
                        $Ora = $riga["Ora"];
                        $Durata = $riga["Durata"];
                        $Costo = $riga["Costo"];
                        ?>
                        <tr <?php echo $classRiga; ?> >
                            <td><?php echo $ID; ?></td>
                            <td><?php echo $EffettuataDa; ?></td>
                            <td><?php echo $Data; ?></td>
                            <td><?php echo $Ora; ?></td>
                            <td><?php echo $Durata; ?></td>
                            <td><?php echo $Costo; ?></td>
                        </tr>
                        <?php
                    }
                    ?>
                </table>
                <?php
            } catch (PDOException $e) {
                echo "<p>Errore DB sulla query: " . $e->getMessage() . "</p>";
            }
        }
        ?>
    </div>
</div>
</body>
</html>
