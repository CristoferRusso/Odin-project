
<!--Form per i post dell'utente-->
<form id="rumorsform" method="post" action="actions.php">
    <div class="form-group">
        <label for="rumorsPost" class="form-label" style='color:rgba(101, 110, 194, 0.932); margin-top:70px;'>
            <h4>Your rumors</h4>
        </label>
        <input name="action" value="postRumors" type="hidden">
        <input type="hidden" name="csrf" value='<?= $_SESSION['csrf'] ?>'>
        <textarea class="form-control" id="rumorsPost" name='rumorsPost'rows="3" placeholder="Post something here"></textarea>
    </div>
    <div class="form-group">
        <button id="btnRumorsPost" class="btn btn-outline-primary" styletype="submit">Post</button>
    </div>
</form>