
var id_record;

$(document).ready(function(){

     id_record = queryParameters.id_servizio;

     semina_valori('servizi','getRecord',{id_servizio:id_record},'?pagina=servizi_list');
});



function salva_valori() {


     var valori = raccogli_valori();
     valori = toJSON(valori);

     var ajax_obj = {pag:'servizi', action:'updateRecord', redirect:true, wait:true, obj:{ valori:valori }, esegui:function(data) {
          location.href = '?pagina=servizi_list';
     }};
     ajax_call(ajax_obj);

}


$(document).on('click', '.form_header .delete_this', function(){

     var valori = raccogli_valori();
     valori = toJSON(valori);

     var ajax_obj = {pag:'servizi', action:'deleteRecord', redirect:true, wait:true, obj:{ valori:valori }, esegui:function(data) {
          location.href = '?pagina=servizi_list';
     }};
     ajax_call(ajax_obj);
});