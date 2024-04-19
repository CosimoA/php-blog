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
?>

<!DOCTYPE html>
<html lang="it">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
</head>

<body>
    <h2>Login</h2>
    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
        <label for="username">Username:</label>
        <input type="text" id="username" name="username" required><br><br>

        <label for="password">Password:</label>
        <input type="password" id="password" name="password" required><br><br>

        <input type="submit" value="Login">
    </form>
    <?php
    // Mostra eventuali messaggi di errore
    if (isset($login_err)) {
        echo '<p style="color: red;">' . $login_err . '</p>';
    }
    ?>
</body>

</html>