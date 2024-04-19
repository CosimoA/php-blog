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
    <title>My-PHP-Blog</title>
    <link rel="stylesheet" href="style.css">

    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">

    <!-- FontAwesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" integrity="sha512-SnH5WK+bZxgPHs44uWIX+LLJAJ9/2PkPKZ5QiAj6Ta86w+fsb2TkcmfRyVX3pBnMFcV7oQPJkl9QevSCWr3W6A==" crossorigin="anonymous" referrerpolicy="no-referrer" />
</head>

<body>

    <!-- Modulo di login -->
    <div class="container mt-5 d-block" id="loginForm">
        <h2>Login</h2>
        <form action="login.php" method="post" onsubmit="handleLoginFormSubmit(event)">
            <label for="username">Username:</label>
            <input type="text" id="username" name="username" required><br><br>
            <label for="password">Password:</label>
            <input type="password" id="password" name="password" required><br><br>
            <input type="submit" value="Login">
            <button type="button" onclick="toggleLoginForm()" class="btn btn-secondary cancelBtn">Annulla</button>
        </form>
    </div>

    <div class="container mt-5">
        <!-- codice per visualizzare i post -->
    </div>

    <!-- Bootstrap Script-->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>

</html>