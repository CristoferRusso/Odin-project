<?php
require 'functions.php';
require 'controllers/RumorsControllers.php'
?>
<main class="container">
    <h1 id="userRumorsTitle">ODIN RUMORS</h1>
    <div class="row">
        <!--Sezione di ricerca e invio notizie-->
        <?php  if (isUserLoggedIn()) { ?>
    <div class="col-md-10" >
        <div class="card bg-dark" style="padding:20px; " >
            <form class="form-inline" role="search" action="actions.php" id="filterPost">
                <input name="action" value="filterPost" type="hidden">          
                <h2 style='color:rgba(101, 110, 194, 0.932); float:left;'>Search for more rumors</h2>
                <input class="form-control me-2" name="filter" id="filterField" type="search" placeholder="Search" aria-label="Search" style='margin:5px'>
                <button class="btn btn-outline-primary" id="filterPostbtn"  styletype="submit">Search</button>
            </form>
            <?php
           
            require 'views/rumors-form.php';?>
        </div>
        <?php } ?>
        </div>
   
    
    
   
    <div class="col-md-10" id='news'>
            <?php

            //Sezione notizie
            $res = findAllRumors();
            if ($res['data']) {
                foreach ($res['data'] as $value) {
                    $buttonLabel = $value['following'] ? 'Unfollow' : 'Follow';
                    $btnClass = $value['following'] ? 'success' : 'primary';
            ?>
                    <div class="card bg-dark col-md-20" style="margin: 2px;" >
                        <div class="card-body ">
                            <h5 class="card-title" style="color:CornflowerBlue"><?= $value['name'] ?></h5>
                            <h6 class="card-subtitle mb-2 text-muted"><?= strip_tags($value['datetime']) ?></h6>
                            <p class="card-text" style='color:rgba(101, 110, 194, 0.932)'><?= $value['rumor'] ?></p>
                            <?php if (isUserLoggedIn() && $value['email'] != $_SESSION['email']) {
                            ?>
                            <button id="btnfollow" href="#" data-user="<?= $value['user_id']?>" data-following="<?= $value['following']?>" class="btn btn-<?= $btnClass ?>"><?= $buttonLabel ?></button>
                          <?php
                            } else if(isUserLoggedIn()) {
                            ?>

                            <form id='deleteform' method="POST" action="actions.php">
                             <button id='btndelete' name='btndelete' class="btn btn-outline-warning my-2 my-sm-0" type="button" >Delete</button>
                             <input type='hidden' name='actions' value="deletePost">
                             <input type='hidden' name='user_id' value="<?= getUserId()?>">
                            </form>
                             
                             <?php } ?>
                        </div>
                    </div>
                    
            <?php
                };
            } else {
                echo '<p>No rumors found' . $res['msg'] . '</p>';
            }; ?>
         
            
        </div>
      
    </div>
    </div>


</main>