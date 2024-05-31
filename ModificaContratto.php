<?php
include 'connectDB.php';

// Controlla se è stata inviata una richiesta POST
if ($_SERVER['REQUEST_METHOD'] == 'GET') {
    // Ottieni i valori dai parametri GET
    $Numero = $_GET['Numero'];
    $Tipo = $_GET['Tipo'];
    $MinutiResidui = $_GET['MinutiResidui'];
    $CreditoResiduo = $_GET['CreditoResiduo'];

    // Costruisci la query di aggiornamento condizionata
    $query = "UPDATE ContrattoTelefonico SET Tipo = :Tipo";

    // Aggiungi i parametri alla lista dei parametri
    $params = [':Tipo' => $Tipo, ':Numero' => $Numero];

    // Aggiungi campi aggiuntivi alla query e ai parametri in base al tipo di contratto
    if ($Tipo == 'a consumo') {
        $query .= ", MinutiResidui = :MinutiResidui, CreditoResiduo = NULL";
        $params[':MinutiResidui'] = $MinutiResidui;
    } elseif ($Tipo == 'a ricarica') {
        $query .= ", MinutiResidui = NULL, CreditoResiduo = :CreditoResiduo";
        $params[':CreditoResiduo'] = $CreditoResiduo;
    }

    // Aggiungi la clausola WHERE per verificare il Numero
    $query .= " WHERE Numero = :Numero";

    try {
        // Prepara la query
        $stmt = $conn->prepare($query);

        // Esegui la query con i parametri
        $stmt->execute($params);

        // Reindirizza alla pagina ContrattoTelefonico.php
        header('Location: ContrattoTelefonico.php');
        exit();
    } catch (PDOException $e) {
        // Gestisci eventuali errori
        echo "Errore nell'aggiornamento del contratto: " . $e->getMessage();
    }
}

