<?php
session_start();

// Verifica se l'utente è loggato
if (isset($_SESSION['username'])) {
    $loggedInUser = $_SESSION['username'];
    $loginButton = '<a href="logout.php" class="btn btn-danger mx-2">Logout</a>';
} else {
    $loginButton = '<a href="login.php" class="btn btn-primary mx-2">Login</a>';
}
?>

<!DOCTYPE html>
<html lang="it">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My-PHP-Blog</title>
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
                <span class="mr-2 text-light">
                    <i class="fas fa-user-circle fa-lg text-light mr-2"></i>
                    <?php if (isset($loggedInUser)) : ?>
                        <?php echo $loggedInUser; ?>
                    <?php endif; ?>
                </span>

                <?php echo $loginButton; ?>
            </div>
        </div>
    </header>

    <div class="container mt-5">
        <!-- codice per visualizzare i post -->
    </div>

    <!-- Bootstrap Script-->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>

</html>