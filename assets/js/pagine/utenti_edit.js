
var id_record;

$(document).ready(function(){

     id_record = queryParameters.id_utente;

     semina_valori('utenti','getRecord',{id_utente:id_record},'?pagina=utenti_list');
});



function salva_valori() {


     var valori = raccogli_valori();
     valori = toJSON(valori);

     var ajax_obj = {pag:'utenti', action:'updateRecord', redirect:true, wait:true, obj:{ valori:valori }, esegui:function(data) {
               location.href = '?pagina=utenti_list';
     }};
     ajax_call(ajax_obj);

}


$(document).on('click', '.form_header .delete_this', function(){

     var valori = raccogli_valori();
     valori = toJSON(valori);

     var ajax_obj = {pag:'utenti', action:'deleteRecord', redirect:true, wait:true, obj:{ valori:valori }, esegui:function(data) {
          location.href = '?pagina=utenti_list';
     }};
     ajax_call(ajax_obj);
});


