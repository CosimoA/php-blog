<?php

require_once "config.php";

// Query per selezionare tutti i post
$sql = "SELECT p.*, c.name AS category_name FROM posts p JOIN categories c ON p.category_id = c.id";
$result = $mysqli->query($sql);

// Verifica se ci sono errori nella query
if (!$result) {
    die("Errore nella query: " . $mysqli->error);
}
session_start();

// Verifica se l'utente è loggato
if (isset($_SESSION['username']) && ($_SESSION['user_id'])) {
    $loggedInUser = $_SESSION['username'];
    $loginButton = '
        <a class="btn btn-primary createBtn mx-1">New Post</a>
        <a class="btn btn-success mx-1">Post Dashboard</a>
        <a href="logout.php" class="btn btn-danger mx-1">Logout</a>
        <a class="loginBtn d-none"></a>
        ';
} else {
    $loginButton = '
    <a class="btn btn-primary loginBtn mx-2">Login</a>
    <a class="createBtn d-none"></a>
    ';
};
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
    <header class="bg-dark py-3">
        <div class="container d-flex justify-content-between align-items-center">
            <h1 class="text-light">My-PHP-Blog</h1>
            <div class="d-flex align-items-center">
                <span class="mx-1 text-light">
                    <i class="fas fa-user-circle fa-lg text-light mr-2"></i>
                    <?php if (isset($loggedInUser)) : ?>
                        <?php echo $loggedInUser; ?>
                    <?php endif; ?>
                </span>

                <?php echo $loginButton; ?>
            </div>
        </div>
    </header>

    <!-- Modulo di login -->
    <div class="container mt-5" id="loginForm">
        <h2>Login</h2>
        <form action="login.php" method="post">
            <label for="username">Username:</label>
            <span id="usernameError" class="text-danger"></span>
            <input type="text" id="username" name="username" required><br><br>
            <label for="password">Password:</label>
            <span id="passwordError" class="text-danger"></span>
            <input type="password" id="password" name="password" required><br><br>
            <input type="submit" class="btn btn-primary p-2">
            <button type="button" class="btn btn-secondary cancelBtnLogin p-2">Annulla</button>
        </form>
    </div>

    <!-- Modulo di creazione Post -->
    <div class="container mt-5" id="createPost">
        <h2>Aggiungi Post</h2>
        <form action="create_post.php" method="post">
            <label for="title">Titolo:</label>
            <span id="titleError" class="text-danger"></span>
            <input type="text" id="title" name="title">

            <label for="content">Contenuto:</label>
            <span id="contentError" class="text-danger"></span>
            <textarea id="content" name="content"></textarea>

            <input type="submit" class="btn btn-primary p-2">
            <button type="button" class="btn btn-secondary cancelBtnCreate p-2">Annulla</button>
        </form>
    </div>


    <div class="container mt-5">
        <div id="postAccordion">

            <?php
            // Verifica se ci sono risultati
            if ($result->num_rows > 0) {
                // Output dei post
                while ($row = $result->fetch_object()) {
            ?>
                    <div class="card mb-3">
                        <img src="<?php echo $row->image; ?>" class="card-img-top" alt="...">
                        <div class="card-body">
                            <h5 class="card-title"><?= $row->title ?></h5>
                            <!-- Categoria del post -->
                            <p class="card-text ">Categoria:
                                <span class="badge bg-secondary"><?= $row->category_name ?></span>
                            </p>
                            <!-- Data di pubblicazione del post -->
                            <p class="card-text">Data di pubblicazione: <?= $row->created_at ?></p>
                            <!-- Contenuto del post -->
                            <p class="card-text collapse" id="collapse<?= $row->id ?>">
                                <?= $row->content ?>
                            </p>
                            <!-- Link per espandere/nascondere il contenuto -->
                            <a class="btn btn-primary" data-bs-toggle="collapse" href="#collapse<?= $row->id ?>" role="button" aria-expanded="false" aria-controls="collapse<?= $row->id ?>">Leggi di più</a>
                        </div>
                    </div>

            <?php
                }
            } else {
                echo "Nessun post presente.";
            }
            ?>
        </div>
    </div>

    <!-- Bootstrap Script-->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>

    <!-- JavaScript per mostrare/nascondere il modulo di login -->
    <script src="script.js" type="module"></script>
</body>

</html>