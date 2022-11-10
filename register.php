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

        <!-- Form per effettuare la registrazione -->
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">

            <!-- Campo inserimento nome -->
            <div>
                <label>Inserisci il nome</label>
                <input type="text" name="nome" placeholder="Mario">
            </div>

            <!-- Campo inserimento cognome -->
            <div>
                <label>Inserisci il cognome</label>
                <input type="text" name="cognome" placeholder="Rossi">
            </div>

            <!-- Campo inserimento email -->
            <div>
                <label>Inserisci l'email</label>
                <input type="email" name="email" placeholder="name@example.com">
            </div>

            <!-- Campo inserimento password -->
            <div>
                <label>Inserisci la password</label>
                <input type="password" name="password" placeholder="Scrivila qui">
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

    </main>
    
</body>

</html>