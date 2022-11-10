<?php
// Inizio sessione
session_start();
 
// Collegamento alle credenziali del DB
require_once "config.php";
 
// Definizione delle variabili
$email = "";
$password = "";
$email_error = "";
$password_error = "";
$login_error = "";
 
// Submit dei dati inseriti nel form
if ($_SERVER["REQUEST_METHOD"] == "POST"){
 
    // Controllo se il campo email è vuoto
    if (empty(trim($_POST["email"]))) {
        $email_error = "- Campo obbligatorio!";
    } else {
        $email = trim($_POST["email"]);
    }
    
    // Controllo se il campo password è vuoto
    if (empty(trim($_POST["password"]))) {
        $password_error = "- Campo obbligatorio!";
    } else {
        $password = trim($_POST["password"]);
    }
    
    // Validazione delle credenziali inserite
    if (empty($email_error) && empty($password_error)) {
        $sql = "SELECT id, nome, cognome, email, password FROM utenti WHERE email = ?";
        
        if ($stmt = $mysqli->prepare($sql)) {
            $stmt->bind_param("s", $param_email);
            
            $param_email = $email;
            
            if ($stmt->execute()) {
                $stmt->store_result();
                
                // Controllo se l'email è presente nel DB. Se sì verifico la password
                if ($stmt->num_rows == 1) {                    
                    $stmt->bind_result($id, $nome, $cognome, $email, $password);
                    
                    if($stmt->fetch()){
                        // Verifico se la password immessa è corretta --> La password è salvata in chiaro nel DB
                        if ($_POST["password"] == $password) {
                            // La password è corretta
                            session_start();
                        
                            // Memorizzo i dati in variabili di sessione
                            $_SESSION["loggedin"] = true;
                            $_SESSION["id"] = $id;
                            $_SESSION["nome"] = $nome;
                            $_SESSION["cognome"] = $cognome;
                            $_SESSION["email"] = $email;                            
                            
                            // Redirect alla pagina dell'user
                            header("location: user.php");
                        } else {
                            // La password è sbagliata, mostro messaggio di errore
                            $login_error = "Credenziali errate. Verifica l'email e la password inserite.";
                        }
                    }
                } else {
                    // L'email non esiste nel DB, mostro messaggio di errore
                    $login_error = "Credenziali errate. Verifica l'email e la password inserite.";
                }
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
    <title>Edusogno - Login</title>
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

        <h2 class="page-title">Hai già un account?</h2>

        <!-- Form per effettuare il login -->
        <div class="container">
            <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">

                <!-- Campo inserimento email -->
                <div class="form-field">
                    <label class="<?php echo (!empty($email_error)) ? 'error-msg' : ''; ?>">Inserisci l'email
                    <!-- Warning se l'utente fa il submit lasciando il campo email vuoto -->
                    <?php echo $email_error; ?>
                    </label>
                    <input type="email" name="email" class="<?php echo (!empty($email_error)) ? 'error-input' : ''; ?>" value="<?php echo $email; ?>" placeholder="name@example.com">
                </div>

                <!-- Campo inserimento password -->
                <div class="form-field">
                    <label class="<?php echo (!empty($password_error)) ? 'error-msg' : ''; ?>">Inserisci la password
                    <!-- Warning se l'utente fa il submit lasciando il campo password vuoto -->
                    <?php echo $password_error; ?>
                    </label>
                    <input type="password" name="password" class="<?php echo (!empty($password_error)) ? 'error-input' : ''; ?>" placeholder="Scrivila qui">
                </div>

                <!-- Bottone submit form -->
                <div class="form-submit">
                    <input class="button" type="submit" value="ACCEDI">
                </div>

                <!-- Messaggio credenziali errate -->
                <?php 
                if(!empty($login_error)){
                    echo '<div class="error">' . $login_error . '</div>';
                }        
                ?>
                
            </form>

            <!-- Link per registrarsi -->
            <p class="link-msg">Non hai ancora un profilo? <a href="register.php">Registrati</a></p>

        </div>

    </main>
    
</body>

</html>