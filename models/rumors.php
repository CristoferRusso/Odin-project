<?php
require_once 'db/connection.php';
 function findAllRumors(int $user_id) {
    $res = [
        'data' => [],
        'msg' => '',
    ];
    try{
    //Questa query recupera tutti i rumors creati dall'utente 
    $sql = 'SELECT rumor,email, user_id,name, datetime, (select following from followers f where f.followed = user_id and follower='.$user_id.')as following ';
    $sql .= 'FROM `rumors` as t INNER JOIN users as u ON t.user_id=u.id  order by datetime DESC';
   
   
    $conn = dbConnect();
    $stm = $conn->query($sql);
    
    $res['data'] = $stm->fetchAll(PDO::FETCH_ASSOC);
    } catch (Exception $e) {
        $res['msg'] = $e->getMessage();

    }
    return $res;

}
