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
        $email_error = "Inserisci la tua email";
    } else {
        $email = trim($_POST["email"]);
    }
    
    // Controllo se il campo password è vuoto
    if (empty(trim($_POST["password"]))) {
        $password_error = "Inserisci la tua password";
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
</head>

<body>

    <header>
        <img src="./assets/img/logo.svg" alt="logo"/>
    </header>

    <main>

        <h2>Hai già un account?</h2>

        <!-- Form per effettuare il login -->
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">

            <!-- Campo inserimento email -->
            <div>
                <label>Inserisci l'email</label>
                <input type="email" name="email" value="<?php echo $email; ?>" placeholder="name@example.com">
                <!-- Warning se l'utente fa il submit lasciando il campo email vuoto -->
                <span><?php echo $email_error; ?></span>
            </div>

            <!-- Campo inserimento password -->
            <div>
                <label>Inserisci la password</label>
                <input type="password" name="password" placeholder="Scrivila qui">
                <!-- Warning se l'utente fa il submit lasciando il campo password vuoto -->
                <span><?php echo $email_error; ?></span>
            </div>

            <!-- Bottone submit form -->
            <div>
                <input type="submit" value="ACCEDI">
            </div>

            <!-- Messaggio credenziali errate -->
            <div>
                <?php 
                if(!empty($login_error)){
                    echo $login_error;
                }        
                ?>
            </div>
            
        </form>

        <!-- Link per registrarsi -->
        <div>
            <p>Non hai ancora un profilo? <a href="register.php">Registrati</a></p>
        </div>

    </main>
    
</body>

</html>