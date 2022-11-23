<?php

function toggleFollow()
{
    $result = [
        'success' => 0,
        'msg' => 'Invalid data',
        'following' => 0,
        'user_id' => ''
    ];

    //Se il token non è valido ritornerà i valori di default di $result
    if (!isValidToken($_POST['csrf'] ?? '')) {
        $result['msg']  = 'Invalid token';
        return $result;
    }

    //Se non c'è un valore userId ritornerà i valori di default di $result
    if (!($_POST['userId'] ?? '')) {
        $result['msg']  = 'Invalid user Id';
        return  $result;
    }
    $following = $_POST['following'] ?? 0;
    $result['following'] =  $following;
    $result['user_id'] = $_POST['userId'];

    try {

        $conn = dbConnect();
        $sql = 'REPLACE INTO followers (follower,followed,following) values (?,?,?)';
        $stm = $conn->prepare($sql);
        $res =  $stm->execute([getUserId(), $_POST['userId'], (int)(!$following)]);
        if ($res) {
            $result['success'] = 1;
            $result['msg'] = $following ? 'User is not followed anymore' : 'User followed';
            $result['following'] =  $following ? 0 : 1;
        }
    } catch (Exception $e) {
        $result['msg'] = $e->getMessage();
        $result['success'] = 0;
    }

    return $result;
}

function postRumors()
{
    $result = [
        'success' => 0,
        'msg' => 'Invalid data',
        'post' => ''
    ];

    //Se il token non è valido ritornerà i valori di default di $result
    if(!isValidToken($_POST['csrf'] ?? '')){
        $result['msg'] = 'Invalid token';
        return $result;
    }
    //Se non c'è un valore userId ritornerà i valori di default di $result
    if (!($_POST['rumorsPost'] ?? '')) {
        $result['msg']  = 'Invalid post';
        return  $result;
    }
    try {

        $conn = dbConnect();
        $sql = 'INSERT INTO rumors (user_id,rumor,datetime) values (?,?,NOW())';
        $stm = $conn->prepare($sql);
    $res =  $stm->execute([getUserId(), $_POST['rumorsPost']/*, Data e ora*/]);
        if ($res) {
            $result['post'] = getPostHtml($_POST['rumorsPost']);
            $result['success'] = 1;
            $result['msg'] = 'Posted';
            
        } else {
            $result['success'] = 0;
            $result['msg'] = 'Error';
        }
    } catch (Exception $e) {
        $result['msg'] = $e->getMessage();
        $result['success'] = 0;
    }
    return $result;
}



function getPostHtml($post) {
    $htmlpost =  "<div class='card bg-dark' style='margin: 2px; '>
    <div class='card-body'>
        <h5 class='card-title' style='color:CornflowerBlue'>".getUserEmail()."</h5>
        <h6 class='card-subtitle mb-2 text-muted'>".date('Y-m-d H:i:s')."</h6>
        <p class='card-text' style='color:rgba(101, 110, 194, 0.932)'>".$post."</p>
    </div>
    
</div>";

return $htmlpost;

}



function deletePost($user_id) {

    try {

        $conn = dbConnect();
        $sql = 'DELETE FROM rumors WHERE id = ?';
        $stm = $conn->prepare($sql);
        $res = $stm->execute([$user_id]);
        if ($res) {
            $result['success'] = 1;
            $result['msg'] = 'Post deleted';
            
        } else {
            $result['success'] = 0;
            $result['msg'] = 'Error';
        }
    } catch (Exception $e) {
        $result['msg'] = $e->getMessage();
        $result['success'] = 0;
    }
    return $result;

}

function filterPost()  {

    $result = [
        'success' => 1,
        'msg' => '',
        'post' => ''
    ];
    try {
    $filter = $_GET['filter'] ?? null;
    $posts = findAllRumors(getUserId(), $filter);
    if ($posts['data']) {
        foreach($posts['data'] as $post) {
            $result['post'] .= getPostTpl($post);
        }
    }
    }catch(Exception $e) {
        $result ['success'] = 0;
        $result['msg'] = $e->getMessage();

    }
    return $result;
}

function getPostTpl(array $post) {
    $buttonLabel = $post['following'] ? 'Unfollow' : 'Follow';
    $btnClass = $post['following'] ? 'success' : 'primary';
    $htmlpost =  "<div class='card bg-dark'>
    <div class='card-body'>
        <h5 class='card-title' style='color:CornflowerBlue'>".$post['name']."</h5>    
        <h6 class='card-subtitle mb-2 text-muted'>".$post['datetime']."</h6>
        <p class='card-text' style='color:rgba(101, 110, 194, 0.932)'>".$post['rumor']."</p>";
 
       if (isUserLoggedIn() && $post['email'] != $_SESSION['email']) {
          $htmlpost .=  '<button id="btnfollow" href="#" data-user="'.$post ['user_id'].'" data-following="'.$post['following'].'" class="btn btn-'.$btnClass.'">'.$buttonLabel.'</button>';
       }  else if(isUserLoggedIn()) {
        $htmlpost .= "<form id='deleteform' method='post' action='actions.php'>
        <button id='btndelete' name='btndelete' class='btn btn-outline-warning my-2 my-sm-0' type='button' >Delete</button>
        <input type='hidden' name='actions' value='deletePost'>
        <input type='hidden' name='user_id' value=".getUserId().">
       </form>";
       }

    $htmlpost .="</div> 
             </div>";
 
 
 return $htmlpost;
 
 }

 function flag() {
    $_SESSION['flag'] = $_POST['yourPostFlag'];
    
 }
 

