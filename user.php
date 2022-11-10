<?php
// Inizio sessione
session_start();
 
// Controllo se l'utente è già loggato, altrimenti redirect alla pagina di login
if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true){
    header("location: index.php");
    exit;
}

// Collegamento alle credenziali del DB
require_once "config.php";

// Seleziono tutti gli eventi a cui partecipa l'utente loggato
$sql = "SELECT nome_evento, data_evento FROM eventi WHERE attendees LIKE '%{$_SESSION["email"]}%';";
$risposta = $mysqli->query($sql);
$eventi = $risposta->fetch_all(MYSQLI_ASSOC);
?>

<!DOCTYPE html>
<html lang="it">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edusogno - Pagina di <?php echo htmlspecialchars($_SESSION["nome"]) . " " . htmlspecialchars($_SESSION["cognome"]); ?></title>
    <!-- Link Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=DM+Sans:wght@400;500;700&display=swap" rel="stylesheet">
    <!-- Link CSS -->
    <link rel="stylesheet" href="./assets/styles/style.css">
</head>

<body>

    <header>
        <img src="./assets/img/logo.svg" alt="logo"/>
    </header>

    <main>
        <!-- Messaggio di benvenuto con controllo se l'utente ha degli eventi programmati -->
        <h2 class="page-title">Ciao <?php echo strtoupper(htmlspecialchars($_SESSION["nome"])); ?>, 
        <?php if (count($eventi) > 0) : ?>
        ecco i tuoi eventi:
        <?php else : ?>
        non hai nessun evento in programma.
        <?php endif; ?>
        </h2>

        <?php if (count($eventi) > 0) : ?>
            <div class="events-container">
                <?php foreach ($eventi as $evento) : ?>
                    <div class="event-card">
                        <h3 class="event-name"><?= $evento["nome_evento"] ?></h3>
                        <p class="event-date"><?= date("d-m-Y H:i", strtotime($evento["data_evento"])); ?></p>
                        <button class="button" name="join">JOIN</button>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>
    </main>
    
</body>

</html>