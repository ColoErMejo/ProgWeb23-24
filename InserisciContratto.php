<?php
include 'connectDB.php';
echo '<script type="text/javascript" src="./js/script.js"></script>';

// Controlla se è stata inviata una richiesta GET
if ($_SERVER['REQUEST_METHOD'] == 'GET') {
    // Verifica che tutti i parametri siano impostati e non vuoti
    if (isset($_GET['Numero']) && isset($_GET['DataAttivazione']) && isset($_GET['Tipo']) && isset($_GET['MinutiResidui']) && isset($_GET['CreditoResiduo'])) {
        $Numero = $_GET['Numero'];
        $DataAttivazione = $_GET['DataAttivazione'];
        $Tipo = $_GET['Tipo'];

        if ($Tipo == 'a consumo') {
            $MinutiResidui = $_GET['MinutiResidui'];
            $CreditoResiduo = NULL;
        } else {
            $MinutiResidui = NULL;
            $CreditoResiduo = $_GET['CreditoResiduo'];
        }

        // Verifica che la data di attivazione non sia vuota e la formatta
        if ($DataAttivazione != "") {
            if (!empty($DataAttivazione)) {
                // Dividi la data in giorno, mese e anno
                $partiData = explode('-', $DataAttivazione);
                $annoCompleto = $partiData[0];
                $mese = $partiData[1];
                $giorno = $partiData[2];
                $anno = substr($annoCompleto, -2);
                // Formatta la data nel formato richiesto per la query SQL
                $DataSQL = "$giorno/$mese/$anno";
            }
        }

        // Query per verificare se il numero esiste già
        $query = "SELECT Numero FROM ContrattoTelefonico WHERE Numero = :Numero";
        try {
            $stmt = $conn->prepare($query);
            $stmt->bindParam(':Numero', $Numero, PDO::PARAM_INT);
            $stmt->execute();

            $trovato = false;
            // Verifica se il numero esiste già
            if ($stmt->rowCount() > 0) {
                $trovato = true;
            }
            if ($trovato) {
                $_SESSION['show_modal'] = true;
                header('Location: ContrattoTelefonico.php');
                exit();
            } else {
                // Se non trovato, puoi fare qualcosa di diverso o restare sulla stessa pagina
                echo "Numero non trovato. Rimani su questa pagina o fai altro.";
            }

            // Se il numero non esiste, inserisce il nuovo contratto
            if (!$trovato) {
                $query = "INSERT INTO ContrattoTelefonico (Numero, DataAttivazione, Tipo, MinutiResidui, CreditoResiduo) 
                          VALUES (:Numero, :DataAttivazione, :Tipo, :MinutiResidui, :CreditoResiduo)";

                try {
                    $stmt = $conn->prepare($query);
                    $stmt->bindParam(':Numero', $Numero, PDO::PARAM_INT);
                    $stmt->bindParam(':DataAttivazione', $DataSQL); // Utilizzo della data formattata
                    $stmt->bindParam(':Tipo', $Tipo);
                    if ($Tipo == 'a consumo') {
                        $stmt->bindParam(':MinutiResidui', $MinutiResidui, PDO::PARAM_INT);
                        $stmt->bindValue(':CreditoResiduo', NULL, PDO::PARAM_NULL);
                    } else {
                        $stmt->bindValue(':MinutiResidui', NULL, PDO::PARAM_NULL);
                        $stmt->bindParam(':CreditoResiduo', $CreditoResiduo, PDO::PARAM_INT);
                    }
                    $stmt->execute();

                    echo ("<script>alert('Query eseguita')</script>");
                    header('Location: ContrattoTelefonico.php');
                    exit();
                } catch (PDOException $e) {
                    echo "<h3>DB Error on Query: " . $e->getMessage() . "</h3>";
                    echo ("<script>alert('Errore durante l'inserimento del contratto')</script>");
                }
            }
        } catch (PDOException $e) {
            echo "<h3 class='msg'>DB Error on Query: " . $e->getMessage() . "</h3>";
        }
    } else {
        echo "<h3 class='msg'>ERRORE: Tutti i parametri devono essere specificati.</h3>";
    }
} else {
    echo "<h3 class='msg'>ERRORE: Metodo di richiesta non supportato.</h3>";
}
