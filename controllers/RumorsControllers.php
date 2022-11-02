<?php

function toggleFollow() {
    $result = [
        'success' => 0,
        'msg' => 'Invalid data',
        'following' => 0,
        'user_id' => ''
    ];

    //Se il token non è valido ritornerà i valori di default di $result
    if (!isValidToken($_POST['csrf'] ?? '')) {
        $result ['msg']  = 'Invalid token';
        return $result;
    }

    //Se non c'è un valore userId ritornerà i valori di default di $result
    if (!($_POST['userId'] ?? '')) {
        $result ['msg']  = 'Invalid user Id';
        return  $result;

    }
    $following = $_POST['following'] ?? 0;
    $result['following'] =  $following ;
    $result['user_id'] = $_POST['userId'];

    try {
        
        $conn = dbConnect(); 
        $sql = 'REPLACE INTO followers (follower,followed,following) values (?,?,?)';
        $stm = $conn->prepare($sql);
        $res =  $stm->execute([getUserId(),$_POST['userId'],(int)(!$following)]);
        if($res) {
            $result['success'] = 1;
            $result['msg'] = $following ? 'User is not followed anymore' : 'User followed';
            $result['following'] =  $following ? 0:1 ;

        }

    }catch(Exception $e){
        $result['msg'] = $e->getMessage();
        $result['success'] = 0;

    }
   
    return $result;

}