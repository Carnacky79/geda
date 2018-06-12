
var id_record;

$(document).ready(function(){

     id_record = $('#id_utente').val();

     semina_valori('utenti','getProfilo',{id_utente:id_record},'?pagina=home');
});



function salva_valori() {


     var valori = raccogli_valori();
     valori = toJSON(valori);

     var ajax_obj = {pag:'utenti', action:'updateProfilo', redirect:true, wait:true, obj:{ valori:valori }, esegui:function(data) {
               location.href = '?pagina=home';
     }};
     ajax_call(ajax_obj);

}


