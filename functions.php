
<?php

//Funzioni utilizzate a livello globale per tutto il programma

//funzione che ritorna il valore di csrf per la convalida 
function isValidToken($token){
    return $token === $_SESSION['csrf'];

}

//Funzione che controlla se l'user è loggato 
function isUserLoggedIn(){
   //Ritornerà un valore numerico (1-0)
   return $_SESSION['userloggedin'] ?? 0;
}


function getUserEmail() {
   return $_SESSION['email'] ?? '';
}

function getUserId() {
   return  $_SESSION['id']  ?? 1;
}
