<?php
session_start();

require 'models/userPost.php';
//Genera un numero randomico in binario(Viene creato un token in sessione per impedire la creazione di un pofilo da siti terzi)
//Guardare header.php e login.php
//Il token verrà inviato con la chiamata
if (empty ($_SESSION['csrf'])) {
$bytes = random_bytes(32);
//La funzione bin2hex trasforma il valore binario in esadecimale
$token = bin2hex(($bytes));
$_SESSION['csrf'] = $token;


}

require 'views/header.php';
$user_id = $_REQUEST['user_id'] ?? 0;
$search= $_REQUEST['filter'] ?? '';
$myPost = $_REQUEST['showMyPosts'] ?? '';
$Posts = findAllRumors($user_id, $search, $myPost );
require 'views/home.php';
require 'views/footer.php';

