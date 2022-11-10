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
        <!-- Qui va l'header con il logo -->
    </header>

    <main>
        <h2>Hai già un account?</h2>

        <!-- Form per effettuare il login -->
        <form>
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
                <input type="submit" value="ACCEDI">
            </div>
        </form>

        <!-- Link per registrarsi -->
        <div>
            <p>Non hai ancora un profilo? <a href="register.php">Registrati</a></p>
        </div>

    </main>
    
</body>

</html>