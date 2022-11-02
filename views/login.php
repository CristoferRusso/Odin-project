<?php //Finestra modale a comparsa per il bottone di login/signup 
?>
<div class="modal bg-dark" id="loginsignup" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="loginModalTitle">Login</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <!--Form di login all'interno della finestra modale-->
      <div class="modal-body">
        <form id='loginSignupForm' method='post'>
          <input type="hidden" name="action" id='action' value="login">
          <input type="hidden" name="csrf" value='<?= $_SESSION['csrf'] ?>'>
          <div class="form-group">
            <h4 style='color:rgba(101, 110, 194, 0.932);'>First social platform where you can share whatever you want, whatever your opinion on any topic Odin will not judge you.</h4>
            <label for="email">Email </label>
            <input type="email" class="form-control" placeholder="email address" id="email" name='email' aria-describedby="emailHelp">
            <small id="emailHelp" class="form-text text-muted">We'll never share your email with anyone else.</small>
          </div>
          <div class="form-group">
            <label for="password">Password</label>
            <input type="password" placeholder="password" class="form-control" id="password" name='password'>
            <div style="display: none ;" id="text-name">
              <label for="name">Your Username</label>
              <input type="hidden" placeholder="Username" id="name" name="name" class="form-control">
            </div>
          </div>
        </form>
      </div>
      <div class="modal-footer">
        <a href="#" id="toggleLogin" class="btn btn-outline-info my-2 my-sm-0">Sign up</a>
        <button type="button" id="loginSignupButton" class="btn btn-primary">Login</button>
      </div>
    </div>
  </div>
</div>
<!--Funzione di script al click del pulsante di registrazione-->
<script>
  $('#toggleLogin').click(function(evt) {


    let loginActive = $('#action');
    let modalTile = $('#loginModalTitle');
    let loginSignupButton = $('#loginSignupButton');
    evt.preventDefault();

    //La chiave loginActive indica se l'user vuole fare il login o la registrazione, valore(1-0)
    if (loginActive.val() === 'login') {
      //evt.targetinnerHTML va a modificare l'elemento stesso chiamato (toggleLogin)
      evt.target.innerHTML = 'Login';
      loginActive.val('signup');
      modalTile.html('Sign up');
      loginSignupButton.html('Sign up');
      document.getElementById('text-name').style = 'display: ;';
      document.getElementById('name').type = 'text';
    } else {
      loginActive.val('login');
      modalTile.html('Login');
      loginSignupButton.html('Login');
      evt.target.innerHTML = 'Signup';
      document.getElementById('text-name').style = 'display: none ;';
      document.getElementById('name').type = 'hidden';

    }
  });

  //Esegue la chiamata ajax per inviare i dati al server
  $('#loginSignupButton').click(function(evt) {
    evt.preventDefault();
    $.ajax({
      //Dati per l'invio 
      method: 'POST',
      url: 'actions.php',
      //Invia i dati presenti nel form(Tutti gli input che hanno un name) e li trasforma in una stringa
      data: $('#loginSignupForm').serialize(),
      //funzione che viene utilizzata quando l'invio dei dati avviene con successo
      success: function(data) {
        const result = JSON.parse(data);
        alert(result.msg);
        if (result.success) {
          location.href = 'index.php';
        }
      },
      failure: function() {
        console.log(data);

      }


    });
  });

  //Funzione per il logout dell'utente
  $('#logout').click(function(evt) {
    evt.preventDefault();
    $.ajax({
      //Dati per l'invio 
      method: 'POST',
      url: 'actions.php',
      //Invia i dati presenti nel form(Tutti gli input che hanno un name) e li trasforma in una stringa
      data: $('#logoutform').serialize(),
      //funzione che viene utilizzata quando l'invio dei dati avviene con successo
      success: function(data) {
        alert(data);
        location.href = 'index.php';

      },
      failure: function() {
        console.log(data);

      }


    });
  });
</script>