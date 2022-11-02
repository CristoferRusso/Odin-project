$('#news .btn').click(function(evt) {
    evt.preventDefault();
    const ele = $(evt.target);
    //Target  associa l'evento a l'elemento cliccato e va a leggere data-user (home.php)
    const userId = ele.attr('data-user');
    //leggere data-following (home.php)
    let following = ele.attr('data-following');
    const btnClass = following ? 'btn-success' : 'btn-primary';
   
    $.ajax ({
        method: 'POST',
        url: 'actions.php',
        data:{ 
            userId,
            following,
            action: 'toggleFollow',
            csrf:$('#csrf').val(),
            
        },

        success: function (data) {
          
            //JSON.parse converte la stringa che si riceve in risposta dal serve in un oggetto javascript
            const result = JSON.parse(data);
            //Cambia la visualizzazione dei pulsanti 
            if (result.success) {
                following = result.following;
            if(result.following) {
                ele.attr('data-following', 1);
                ele.addClass('btn-success');
                ele.removeClass('btn-primary');
                ele.html('Unfollow');
               
            }else{
                ele.attr('data-following', 0);
                ele.removeClass('btn-success');
                ele.addClass('btn-primary');
                ele.html('Follow');
                
            }
         
        }
    }
        });
});