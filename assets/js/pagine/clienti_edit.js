
var id_record;

$(document).ready(function(){

     id_record = queryParameters.id_cliente;
     semina_valori('clienti','getRecord',{id_cliente:id_record},'?pagina=clienti_list');
});


$(document).on('click', '#tab_fatture td.action_col i.editIcon', function(){

     var id_fattura = $(this).closest('tr').attr('id_fattura');
     var type = $(this).closest('tr').attr('type');
     location.href='?pagina=fatture_edit&id_fattura='+id_fattura+'&type='+type;
});

$(document).on('click', '#tab_ddt td.action_col i.editIcon', function(){

     var id_ddt = $(this).closest('tr').attr('id_ddt');
     var type = $(this).closest('tr').attr('type');
     location.href='?pagina=ddt_edit&id_ddt='+id_ddt+'&type='+type;
});


function salva_valori() {

     var valori = raccogli_valori();
     valori = toJSON(valori);

     var ajax_obj = {pag:'clienti', action:'updateRecord', redirect:true, wait:true, obj:{ valori:valori }, esegui:function(data) {
          location.href = '?pagina=clienti_list';
     }};
     ajax_call(ajax_obj);

}


$(document).on('click', '.form_header .delete_this', function(){

     var valori = raccogli_valori();
     valori = toJSON(valori);

     var ajax_obj = {pag:'clienti', action:'deleteRecord', redirect:true, wait:true, obj:{ valori:valori }, esegui:function(data) {
          location.href = '?pagina=clienti_list';
     }};
     ajax_call(ajax_obj);
});