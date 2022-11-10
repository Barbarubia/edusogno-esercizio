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
</head>

<body>

    <header>
        <img src="./assets/img/logo.svg" alt="logo"/>
    </header>

    <main>
        <h2 class="my-5">Ciao <?php echo strtoupper(htmlspecialchars($_SESSION["nome"])); ?>, 
        <?php if (count($eventi) > 0) : ?>
        ecco i tuoi eventi:
        <?php else : ?>
        non hai nessun evento in programma.
        <?php endif; ?>
        </h2>

        <div class="container">
            <?php if (count($eventi) > 0) : ?>
                <?php foreach ($eventi as $evento) : ?>
                    <div>
                        <h3><?= $evento["nome_evento"] ?></h3>
                        <p><?= date("d-m-Y H:i", strtotime($evento["data_evento"])); ?></p>
                        <button name="login">JOIN</button>
                    </div>
                <?php endforeach; ?>
            <?php endif; ?>
        </div>
    </main>
    
</body>

</html>