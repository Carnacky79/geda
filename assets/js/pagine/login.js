

$(document).ready(function(){
     $('#email, #password').val('');
});



$(document).keydown(function (e){
    if(e.keyCode == 13){
        $('.form_valori').submit();
    }
});




function salva_valori() {

     var valori = raccogli_valori();
     valori = toJSON(valori);

     $.ajax ({
          beforeSend: function() { spinner('start'); beforeSave(); },
          complete: function() {
               afterSave();
          },
          type: 'POST',
          url: 'assets/ajax/login.php?action=login',
          data: { valori:valori },
          success:function(data){

               if(data!=='true') {
                    attenzione('error--Attenzione, credenziali errate');
               } else {
                    location.href = '?pagina=home';
               }
          },
          error:function(error){ attenzione(); }
     });

}