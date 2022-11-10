<?php
// Collegamento alle credenziali del DB
require_once "config.php";
 
// Definizione delle variabili
$nome = "";
$cognome = "";
$email = "";
$password = "";
$nome_error = "";
$cognome_error = "";
$email_error = "";
$password_error = "";
 
// Submit dei dati inseriti nel form
if ($_SERVER["REQUEST_METHOD"] == "POST") {
 
    // Validazione del nome
    if (empty(trim($_POST["nome"]))) {
        $nome_error = "Campo obbligatorio - Inserisci il tuo nome";
    } else {
        $nome = trim($_POST["nome"]);
    }

    // Validazione del cognome
    if (empty(trim($_POST["cognome"]))) {
        $cognome_error = "Campo obbligatorio - Inserisci il tuo cognome";
    } else {
        $cognome = trim($_POST["cognome"]);
    }

    // Validazione dell'email
    if (empty(trim($_POST["email"]))) {
        $email_error = "Campo obbligatorio - Inserisci la tua email";
    } else {
        $sql = "SELECT id FROM utenti WHERE email = ?";
        
        if ($stmt = $mysqli->prepare($sql)) {
            $stmt->bind_param("s", $param_email);
            
            $param_email = trim($_POST["email"]);
            
            if ($stmt->execute()) {
                $stmt->store_result();
                
                // Verifico se l'email è già stata usata
                if ($stmt->num_rows == 1) {
                    $email_error = "L'email digitata è già stata utilizzata";
                } else {
                    $email = trim($_POST["email"]);
                }
            } else {
                echo "Oops! Qualcosa non ha funzionato. Riprova più tardi.";
            }

            $stmt->close();
        }
    }
    
    // Validazione della password
    if (empty(trim($_POST["password"]))) {
        $password_error = "Inserisci una password di almeno 8 e massimo 25 caratteri";     
    } elseif (strlen(trim($_POST["password"])) < 8 || strlen(trim($_POST["password"])) > 25) {
        $password_error = "La password deve contenere almeno 8 e massimo 25 caratteri";
    } else {
        $password = trim($_POST["password"]);
    }
    
    // Verifico la presenza di errori prima di salvare la riga nel DB
    if (empty($nome_error) && empty($cognome_error) && empty($email_error) && empty($password_error)) {
        
        $sql = "INSERT INTO utenti (nome, cognome, email, password) VALUES (?, ?, ?, ?)";
         
        if ($stmt = $mysqli->prepare($sql)) {
            $stmt->bind_param("ssss", $param_nome, $param_cognome, $param_email, $param_password);
            
            $param_nome = $nome;
            $param_cognome = $cognome;
            $param_email = $email;
            $param_password = $password; // Password salvata in chiaro --> versione con password criptata: password_hash($password, PASSWORD_DEFAULT); --> bisogna modificare la verifica della password nella pagina di login con password_verify().
            
            if ($stmt->execute()) {
                // Messaggio di successo
                $success = "Registrazione effettuata con successo! Stai per essere reindirizzato alla pagina di login.";

                // Redirect alla pagina di login
                header("refresh: 3; url=index.php");
            } else {
                echo "Oops! Qualcosa non ha funzionato. Riprova più tardi.";
            }

            $stmt->close();
        }
    }
    
    $mysqli->close();
}
?>

<!DOCTYPE html>
<html lang="it">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edusogno - Registrati</title>
</head>

<body>

    <header>
        <img src="./assets/img/logo.svg" alt="logo"/>
    </header>

    <main>

        <h2>Crea il tuo account</h2>

        <!-- Mostro un messaggio a registrazione effettuata con successo -->
        <?php if (!empty($success)) : ?>
            <span>
                <?php echo $success; ?>
            </span>

        <!-- Altrimenti mostro il form per effettuare la registrazione -->
        <?php else : ?>

        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">

            <!-- Campo inserimento nome -->
            <div>
                <label>Inserisci il nome</label>
                <input type="text" name="nome" value="<?php echo $nome; ?>" placeholder="Mario">
                <!-- Warning se l'utente fa il submit lasciando il campo nome vuoto -->
                <span><?php echo $nome_error; ?></span>
            </div>

            <!-- Campo inserimento cognome -->
            <div>
                <label>Inserisci il cognome</label>
                <input type="text" name="cognome" value="<?php echo $cognome; ?>" placeholder="Rossi">
                <!-- Warning se l'utente fa il submit lasciando il campo cognome vuoto -->
                <span><?php echo $cognome_error; ?></span>
            </div>

            <!-- Campo inserimento email -->
            <div>
                <label>Inserisci l'email</label>
                <input type="email" name="email" value="<?php echo $email; ?>" placeholder="name@example.com">
                <!-- Warning se l'utente fa il submit lasciando il campo email vuoto o utilizzando un'email già registrata -->
                <span><?php echo $email_error; ?></span>
            </div>

            <!-- Campo inserimento password -->
            <div>
                <label>Inserisci la password</label>
                <input type="password" name="password" value="<?php echo $password; ?>" placeholder="Scrivila qui">
                <!-- Warning se l'utente fa il submit lasciando il campo password vuoto o usando una password troppo corta o troppo lunga -->
                <span><?php echo $password_error; ?></span>
            </div>

            <!-- Bottone submit form -->
            <div>
                <input type="submit" value="REGISTRATI">
            </div>
            
        </form>

        <!-- Link per andare alla pagina di login -->
        <div>
            <p>Hai già un account? <a href="index.php">Accedi</a></p>
        </div>

        <?php endif; ?>

    </main>
    
</body>

</html>