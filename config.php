<?php
// Credenziali database
define('DB_SERVER', 'localhost');
define('DB_USERNAME', 'root');
define('DB_PASSWORD', 'root');
define('DB_NAME', 'edusogno');
 
$mysqli = new mysqli(DB_SERVER, DB_USERNAME, DB_PASSWORD, DB_NAME);
 
// Verifica connessione
if($mysqli === false){
    die("ERRORE...Impossibile connettersi al database." . $mysqli->connect_error);
}
?>