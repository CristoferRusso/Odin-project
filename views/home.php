<?php
require 'functions.php';

?>
<main class="container">
    <h1>ODIN RUMORS</h1>
    <div class="row">
        <div class="col-md-8" id='news'>
            <?php

            //Sezione notizie
            $res = findAllRumors(getUserId());
            if ($res['data']) {
                foreach ($res['data'] as $value) {
                    $buttonLabel = $value['following'] ? 'Unfollow' : 'Follow';
                    $btnClass = $value['following'] ? 'success' : 'primary';
            ?>
                    <div class="card py-3 bg-dark" style="width: 40rem; margin:4px;">
                        <div class="card-body">
                            <h5 class="card-title" style="color:CornflowerBlue"><?= $value['name'] ?></h5>
                            <h6 class="card-subtitle mb-2 text-muted"><?= strip_tags($value['datetime']) ?></h6>
                            <p class="card-text" style='color:rgba(101, 110, 194, 0.932)'><?= $value['rumor'] ?></p>
                            <?php if (isUserLoggedIn() && $value['email'] != $_SESSION['email']) {
                            ?>
                            <a href="#" data-user="<?= $value['user_id']?>" data-following="<?= $value['following']?>" class="btn btn-<?= $btnClass ?>"><?= $buttonLabel ?></a>
                          <?php
                            }
                            ?>
                        </div>
                    </div>
            <?php
            
                };
            } else {
                echo '<p>No rumors found' . $res['msg'] . '</p>';
            };
            if (isUserLoggedIn() && $value['email'] != $_SESSION['email']) {
            ?>
            <!--Sezione di ricerca e invio notizie-->
        </div>
        <div class="card py-6 bg-dark"  style="width: 20rem; padding:1%; margin:2px;">
            <form class="form-inline" role="search">
                <h4 style='color:rgba(101, 110, 194, 0.932);'>Search for more rumors</h4>
                <input class="form-control me-2" type="search" placeholder="Search" aria-label="Search" style='margin:5px'>
                <button class="btn btn-outline-primary"  styletype="submit">Search</button>
            </form>
            <form>
            <div class="form-group">
                <label for="exampleFormControlTextarea1" class="form-label" style='color:rgba(101, 110, 194, 0.932); margin-top:70px;'><h4>Your rumors</h4></label>
                <textarea class="form-control" id="exampleFormControlTextarea1" rows="3"></textarea>
            </div>
            <div class="form-group">
                <button class="btn btn-outline-primary" styletype="submit">Howls</button>
            </div>
            </form>
        </div>
        <?php } ?>
    </div>
    </div>


</main>