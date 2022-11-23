<?php
session_start();
require 'controllers/loginSignupControllers.php';
require 'db/connection.php';
require 'models/rumors.php';
require 'functions.php';
require 'controllers/RumorsControllers.php';



//Assegna alla variabile action i dati inviati(#action login.php) e se non esiste una string vuota
$action = $_REQUEST['action'] ?? '';

//Controlla se è già presente una funzione 
//function_exist è una funzione nativa di php
if (function_exists($action)) {
    //Se esiste chiama la funzione
    echo json_encode($action());
    exit();
}

