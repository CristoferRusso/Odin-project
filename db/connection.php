<?php

//Funzione di collegamento al server in locale 
//(PDO è una funzione nativa di php)
function dbConnect(){
    $dsn = 'mysql:dbname=odin;host=127.0.0.1';
    $user = 'root';
    $password = '06051994Numenor.';
    
    $dbh = new PDO($dsn, $user, $password);

    return $dbh;
}

