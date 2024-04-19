<?php
session_start();

// Termina la sessione
session_unset();
session_destroy();

// Reindirizza a index.php
header("Location: index.php");
exit;
