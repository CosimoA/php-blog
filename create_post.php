<?php
session_start();

// Verifica se l'utente è autenticato, altrimenti reindirizza alla pagina di login
if (!isset($_SESSION['username']) || !isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

// Include il file di configurazione del database
require_once "config.php";

// Inizializza le variabili per la memorizzazione dei dati del post e gli errori
$title = $content = "";
$title_err = $content_err = "";

// Processa i dati del form quando viene inviato
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Valida il titolo
    if (empty(trim($_POST["title"]))) {
        $title_err = "Inserisci un titolo.";
    } else {
        $title = trim($_POST["title"]);
    }

    // Valida il contenuto
    if (empty(trim($_POST["content"]))) {
        $content_err = "Inserisci il contenuto.";
    } else {
        $content = trim($_POST["content"]);
    }

    // Se non ci sono errori di validazione, procedi con l'inserimento del post nel database
    if (empty($title_err) && empty($content_err)) {
        // Prepara la query di inserimento
        $sql = "INSERT INTO posts (title, content, user_id) VALUES (?, ?, ?)";

        if ($stmt = $mysqli->prepare($sql)) {
            // Collega i parametri alla query
            $stmt->bind_param("ssi", $param_title, $param_content, $param_user_id);

            // Imposta i parametri
            $param_title = $title;
            $param_content = $content;
            $param_user_id = $_SESSION['user_id'];

            // Esegui la query
            if ($stmt->execute()) {
                // Reindirizza alla pagina principale dopo l'inserimento del post
                header("location: index.php");
                exit;
            } else {
                echo "Oops! Qualcosa è andato storto. Riprova più tardi.";
            }

            // Chiudi lo statement
            $stmt->close();
        }
    }

    // Chiudi la connessione al database
    $mysqli->close();
}
