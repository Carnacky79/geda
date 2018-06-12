
var id_record;

$(document).ready(function(){

     id_record = queryParameters.id_iva;

     semina_valori('iva','getRecord',{id_iva:id_record},'?pagina=iva_list');
});



function salva_valori() {

     var valori = raccogli_valori();
     valori = toJSON(valori);

     var ajax_obj = {pag:'iva', action:'updateRecord', redirect:true, wait:true, obj:{ valori:valori }, esegui:function(data) {
          location.href = '?pagina=iva_list';
     }};
     ajax_call(ajax_obj);
}


$(document).on('click', '.form_header .delete_this', function(){

     var valori = raccogli_valori();
     valori = toJSON(valori);

     var ajax_obj = {pag:'iva', action:'deleteRecord', redirect:true, wait:true, obj:{ valori:valori }, esegui:function(data) {
          location.href = '?pagina=iva_list';
     }};
     ajax_call(ajax_obj);
});