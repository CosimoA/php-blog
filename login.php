<?php
// require_once "config.php";

session_start();

// Verifica se l'utente è già autenticato, in tal caso reindirizza alla pagina principale
if (isset($_SESSION['user'])) {
    header("Location: index.php");
    exit;
}

// Verifica se il form è stato inviato
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Include il file di configurazione del database
    require_once "config.php";

    // Ottieni i dati inviati dal form
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Query per selezionare l'utente dal database
    $sql = "SELECT id, username, password FROM users WHERE username = ?";

    if ($stmt = $mysqli->prepare($sql)) {
        // Collega i parametri alla query
        $stmt->bind_param("s", $param_username);

        // Imposta i parametri
        $param_username = $username;

        // Esegui la query
        if ($stmt->execute()) {
            // Memorizza il risultato
            $stmt->store_result();

            // Verifica se l'utente esiste
            if ($stmt->num_rows == 1) {
                // Associa le variabili al risultato della query
                $stmt->bind_result($id, $username, $hashed_password);
                if ($stmt->fetch()) {
                    // Verifica la password
                    if (password_verify($password, $hashed_password)) {
                        // Password corretta: avvia una nuova sessione
                        session_start();

                        // Memorizza i dati dell'utente nella sessione
                        $_SESSION['user_id'] = $id;
                        $_SESSION['username'] = $username;

                        // Reindirizza alla pagina principale del blog
                        header("location: index.php");
                    } else {
                        // Password non corretta: mostra un messaggio di errore
                        $login_err = "Credenziali non valide.";
                    }
                }
            } else {
                // Nessun utente trovato: mostra un messaggio di errore
                $login_err = "Credenziali non valide.";
            }
        } else {
            echo "Oops! Qualcosa è andato storto. Riprova più tardi.";
        }

        // Chiudi lo statement
        $stmt->close();
    }

    // Chiudi la connessione
    $mysqli->close();
}
