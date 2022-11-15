
<!doctype html>
<html lang="en">
  <head>
   
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <link rel="stylesheet" href="css/bootstrap.css">
    <link rel='stylesheet' href='css/style2.css'>

    <title>Odin</title>
  </head>
  <body>
  <header>
  <!-- Barra di navigazione principale -->
  <nav class="navbar navbar-expand-md navbar-dark fixed-top bg-dark">
    <img src="images/OIP.jpg" alt="" id='icon'>
    <a class="navbar-brand" href="#" id='brand'>OdinWorld</a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarCollapse" aria-controls="navbarCollapse" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarCollapse">
      <ul class="navbar-nav mr-auto">
      <?php if (!empty($_SESSION['userloggedin'])) {
         ?>
        <li class="nav-item ">
          <a class="nav-link" href="index.php">Timeline <span class="sr-only">(current)</span></a>
        </li>
      
        <li class="nav-item">
          <a class="nav-link" id='yourPost' href="yourPost.php">Your posts</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" id='' href="">Who you follow</a>
        </li>
        <li class="nav-item">
          <a class="nav-link " href="#">Options</a>
        </li>
        <?php } ?>
      </ul>
 
        <?php    

        //Se l'utente risulta in sessione (Ha fatto il login) la finetra modale di login/signup sarà sostituito da quello di logout
        if(empty($_SESSION['userloggedin'])){
        
        ?>
        <!-- Pulsante di attivazione della finestra modale con data-target dell'id della finestra modale presente in login.php-->
        <button data-toggle="modal" data-target="#loginsignup" class="btn btn-outline-primary my-2 my-sm-0" type="button">Login/Signup</button>
        <?php } else {?>
          <!--Questo form riconduce ad action.php-->
           <h6 style='color:rgba(101, 110, 194, 0.932); margin-right:20px;'>You are logged with <?= $_SESSION['email']?></h6>  
          <form method='POST' action ='actions.php' id='logoutform'>
          <input type='hidden' name='csrf' id='csrf' value="<?= $_SESSION['csrf']?>">
          <input type='hidden'  name='action' value='logout'>
          <button id='logout' class="btn btn-outline-primary my-2 my-sm-0" type="button">Logout</button>
          </form>
          <?php } ?>
        </div>
  </nav>







</header>