<?php

//Verifica il corretto inserimento dei dati

function verifyData()
{
    $result = [
        'success' => 1,
        'msg' => '',
        
    ];
    //Controlla che sia presente il token
    $token = $_POST['csrf'] ?? '';

    if(!isValidToken($token)) {
        $result ['success'] = 0;
        $result ['msg'] = 'Invalid request';
        return $result;
    }
    //Attribuisce a ogni variabile il valore rispettivo dei vari input( se non esiste ritorna una stringa vuota) 
    $email = $_POST['email'] ?? '';
    $password = $_POST['password'] ?? '';
    $name = $_POST['name'] ?? '';
    //Controlla che sia stata inserita l'email
    if ($email) {
        //Funzione che controlla che il valore inserito sia una email valida 
        $email = filter_var($email, FILTER_VALIDATE_EMAIL);
    }
    //Eseguito se non è presente l'email
    if (!$email) {
        //Va ad assegnare alle varie chaivi dell'array il valore di 0 su success e l'errore su msg
        $result['success'] = 0;
        //(Concatena il messaggio di errore a quello già presente nel caso esista)
        $result['msg'] .= 'Email address is required ';
    }

    //Medesimo processo per la password(Il ciclo verifica che la password sia formata da una stringa lunga almeno 6 caratteri)
    if (!$password || strlen($password) < 6) {
        $result['success'] = 0;
        $result['msg'] .= 'Password address is required ';
    }

    if(strlen($password) < 6){
        $result['success'] = 0;
        $result['msg'] .= 'Password must be at least 6 characters long ';

    }
   
    
    //Ritorna i dati inseriti dall'utente (password,email,name)
    $result['password'] = $password;
    $result['email'] = $email;
    $result['name'] = $name;
    return $result;
   
}






//Se i dati sono presenti fa il login
function login()
{
    $result = verifyData();

    //Verifica che password e email siano stati inseriti controllando il valore della chiave success presente nell'array
    if ($result['success']) {
        $res = verifyUserLogin($result['email'], $result['password'], $result['name']);
        if($res['success']) {
            $_SESSION['userloggedin'] = 1;
            $_SESSION['email'] =  $result['email'];
            $_SESSION['id'] = $res ['data'] ['id'];
            $_SESSION['name'] =  $result['name'];
            //Azzera csrf
            unset($_SESSION['csrf']);

        };
        return $res;
    } else {
        return $result;
    }
}





//Funzione per la verifica di login
function  verifyUserLogin($email, $password)
{
    $result = [
      
        'success' => 1,
        'msg' => 'User loggedin correctly',
        'data' => []
    ];
    try{

        //Controlla che l'utente sia già registrato//    
        $conn = dbConnect();
        //Query
        $sql = 'SELECT * FROM users WHERE email =? ';
        //Prepara la query
        $stm = $conn->prepare($sql);
        //Esegue la query assegnando al segnaposto(?) la variabile email
        $res = $stm->execute([$email]);

        if($res && $stm->rowCount()) {
            $row = $stm->fetch(PDO::FETCH_ASSOC);
            $result['data'] = $row;
            //Fa un confronto con la password inserita dall'utente e quella presente nel db che recuperiamo da $row
            if(!password_verify($password, $row['password'])){
                $result['success'] = 0;
                $result['msg'] = 'Email or password incorrects';

            }

        }else {
            $result['success'] = 0;
            $result['msg'] = 'NO user found whit this email';
        }


    }catch(Exception $e){
        $result['success'] = 0;
        $result['msg'] = $e->getMessage();
    

    }
    return $result;
}






//Se i dati sono presenti fa la signup
function signup()
{
    $result = verifyData();

    //Verifica che password e email siano stati inseriti controllando il valore della chiave success presente nell'array
    if ($result['success']) {
        $res = insertUser($result['email'], $result['password'], $result['name']);
        if($res['success']) {
            $_SESSION['userloggedin'] = 0;
            $_SESSION['email'] =  $result['email'];
            $_SESSION['name'] =   $result['name'];
            unset($_SESSION['csrf']);
        }
        return $res;
    } else {
        return $result;
    }
}






//Funzione per la verifica della creazione di un nuovo utente
function insertUser($email, $password,$name)
{
    $result = [
        'success' => 1,
        'msg' => ''
    ];


    try{

    
    $conn = dbConnect();
    //Query
    $sql = 'SELECT email FROM users WHERE email =? ';
    //Prepara la query
    $stm = $conn->prepare($sql);
    //Esegue la query assegnando al segnaposto(?) la variabile email
    $res = $stm->execute([$email]);
    if ($res) {
        //Se stm ha una stringa maggiore di 0 vuol dire che la variabile presente è già stata presa(email)
        if ($stm->rowCount() > 0) {
            $result['msg'] = 'Email as alredy been taken ';
            $result['success'] = 0;
            return $result;
        }
    } else {
        $result['msg'] = 'Error reading user table';
        $result['success'] = 0;
        return $result;
    }

    //Esegue la registrazione dell'utente
    $sql = 'INSERT INTO users (email,name, password) values (:email,:name, :password)';
    //Viene eseguita la hash della password inserita dall'utente
    $password = password_hash($password, PASSWORD_DEFAULT);
    $stm = $conn->prepare($sql);
    $res = $stm->execute([':email' => $email, ':password' => $password, ':name' => $name]);
    if ($res && $stm->rowCount()) {
        $result['msg'] = 'User registered correctly, login to post something';
        return $result;
    } else {
        $result['msg'] = 'Problem inserting user';
        $result['success'] = 0;
    }
   //Eccezzione necessaria in caso di errore 
  }catch(Exception $e){
    $result['success'] = 0;
    $result['msg'] = $e->getMessage();

  }
  return $result;
}


function logout() {
    session_destroy();
    return "Have a good day :)";

}

