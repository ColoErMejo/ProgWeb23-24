<?php
include 'connectDB.php';

// Controlla se è stata inviata una richiesta POST
if ($_SERVER['REQUEST_METHOD'] == 'GET') {
    // Ottieni i valori dai parametri GET
    $Numero = $_GET['Numero'];
    $Tipo = $_GET['Tipo'];
    $MinutiResidui = $_GET['MinutiResidui'];
    $CreditoResiduo = $_GET['CreditoResiduo'];
    
    $query = "SELECT DISTINCT Numero= :Numero FROM ContrattoTelefonico";
    try {
        $stmt = $conn->prepare($query);
        $stmt->bindParam(':Numero', $Numero);
        $stmt->execute();

        $trovato = false;
        $result = $conn->query($query);
            $trovato = false;
            foreach ($result as $riga) {
                $NumeroContratto = $riga["Numero"];
                if ($NumeroContratto == $Numero) {
                    $trovato = true;
                    echo "<h3 class='msg'>ERRORE: Numero di telefono gia' associato ad un altro contratto: </h3>";
                    break;
                }
            }
        if (!$trovato) {
            $query = "INSERT INTO ContrattoTelefonico (Numero, DataAttivazione, Tipo, MinutiResidui, CreditoResiduo) 
                      VALUES (:Numero, :DataAttivazione, :Tipo, :MinutiResidui, :CreditoResiduo)";

            try {
                $stmt = $conn->prepare($query);
                $stmt->bindParam(':Numero', $Numero);
                $stmt->bindParam(':DataAttivazione', $DataAttivazione);
                $stmt->bindParam(':Tipo', $Tipo);
                $stmt->bindParam(':MinutiResidui', $MinutiResidui);
                $stmt->bindParam(':CreditoResiduo', $CreditoResiduo);
                $stmt->execute();

                echo ("<script>alert('Query eseguita')</script>");
            } catch (PDOException $e) {
                echo "<h3>DB Error on Query: " . $e->getMessage() . "</h3>";
                $error = true;
            }

            if (isset($error) && $error) {
                echo ("<script>alert('Errore durante l'inserimento del contratto')</script>");
            } else {
                echo("<script>mostraInserimento('$Numero')</script>");
            }
        }
    } catch (PDOException $e) {
        echo "<h3 class='msg'>DB Error on Query: " . $e->getMessage() . "</h3>";
    }
} else {
    echo "<h3 class='msg'>ERRORE: Numero di telefono non specificato.</h3>";
}
