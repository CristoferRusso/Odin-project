<?php
require_once 'db/connection.php';


function findAllRumors(int $user_id = 0, $search = '', $userPost = '')
{
    
    $userPost =  $_SESSION['flag'];
    
    if (!$search) {
        $search = $_GET['filter'] ?? null;
    };


    $res = [
        'data' => [],
        'msg' => '',
    ];

    if($_SESSION['id']) {
        $loggedInUserid =  $_SESSION['id'];
    }else {
        $loggedInUserid =  $user_id;
    }



    try {
        //Questa query recupera tutti i rumors creati dall'utente 
        $sql = 'SELECT rumor,email, user_id,name, datetime, (select following from followers f where f.followed = t.user_id and follower=' .$loggedInUserid. ')as following ';
        $sql .= 'FROM `rumors` as t INNER JOIN users as u ON t.user_id=u.id';
        if ($userPost) {
            $sql .= " AND user_id ='$loggedInUserid' ";
        } else if ($user_id) {
            $sql .= " AND user_id ='$user_id' ";
        }
        $sql .= ' WHERE rumor like ?';
        
        $sql .= 'order by t.id DESC';

        $conn = dbConnect();
        $stm = $conn->prepare($sql);
        //Esegue la query uilizzando come parametro d'ingresso il valore presente nella variabile $search (input filter)
        $stm->execute(["%$search%"]);
        //Restituisce i valori come variabili array 
        $res['data'] =  $stm->fetchAll(PDO::FETCH_ASSOC);
    } catch (Exception $e) {
        $res['msg'] = $e->getMessage();
    }
    return $res;
} 


