$('#news #btnfollow').click(function(evt) {
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
        location.href = 'index.php';
    }
    
        });
});

//Funzione per la publicazione di un nuovo post sulla pagina
$('#rumorsform #btnRumorsPost').click(function(evt) {
    evt.preventDefault();
    const rumorsPost = $('#rumorsPost').val();
    if(!rumorsPost|| rumorsPost.length <4){
        alert('Tweet min length is 3!');
        return false;
    }
    const data = $('#rumorsform').serialize();
   
  
    $.ajax ({
    method: 'POST',
    url: 'actions.php',
    data: data,
   
    success: function (data) { 
         //JSON.parse converte la stringa che si riceve in risposta dal serve in un oggetto javascript     
        const postdata = JSON.parse(data);
        location.href = 'index.php';
        //Se la chaimata non avviene con successo mostra un alert con l'errore
        if(!postdata['success']){
          
            alert(postdata['msg']);
            return;
        }
        //?
        const post = document.getElementById('news');
        const firstChild = post.firstChild;
        const myDiv = document.createElement('div');
        myDiv.innerHTML = postdata['post'];
        post.insertBefore(myDiv,firstChild);
        
        

    }
    })
   
})

//Funzione per la cancellazione di un post 
$('#deleteform #btndelete').click(function(evt) {
    evt.preventDefault();
    alert ('test function');
    $.ajax ({
    
    method: 'GET',
    url: 'actions.php',
    data: $('#deleteform').serialize(),
    action: 'deletePost',
  
   
    success: function (data) {     
    alert (data)
       return data;
       

    }
    })
   
})

//Funzione per la ricerca di un post sulla pagina
$('#filterPost #filterPostbtn').click(function(evt) {
    evt.preventDefault();
    const filterField = $('#filterField').val();
    if(!filterField || filterField.length <4){
        alert('Text min length is 3!');
        return false;
    }
    const data = $('#filterPost').serialize();
   
  
    $.ajax ({
    method: 'GET',
    url: 'actions.php',
    data: data,
   
    success: function (data) {      
        const postdata = JSON.parse(data);
        
        if(!postdata['success']){
            alert(postdata['msg']);
            
            return;
        }
        const post = document.getElementById('news');
        news.innerHTML = postdata['post'];
        
        
        
    }
    })
   
})
