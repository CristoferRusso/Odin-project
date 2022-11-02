<?php
require 'controllers/loginSignupControllers.php';
require 'db/connection.php';
require 'functions.php';
require 'controllers/RumorsControllers.php';
session_start();


//Assegna alla variabile action i dati inviati(#action login.php) e se non esiste una string vuota
$action = $_POST['action'] ?? '';

//Controlla se è già presente una funzione di login o signup
//function_exist è una funzione nativa di php
if (function_exists($action)) {
    //Se esiste chiama la funzione
    echo json_encode($action());
    exit();
}

