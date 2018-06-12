
var id_record;

$(document).ready(function(){

     id_record = queryParameters.id_fornitore;
     semina_valori('fornitori','getRecord',{id_fornitore:id_record},'?pagina=fornitori_list');


     $('#tab_fatture, #tab_ddt').DataTable({
          dom: 'ftip', lengthMenu: [[5,10,20], [5,10,20]], pageLength: 5, order: [[1, 'asc']], columnDefs: [{"width": "10%", "sortable": false, "targets": 0}]
     });

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


     var ajax_obj = {pag:'fornitori', action:'updateRecord', redirect:true, wait:true, obj:{ valori:valori }, esegui:function(data) {
          location.href = '?pagina=fornitori_list';
     }};
     ajax_call(ajax_obj);

}


$(document).on('click', '.form_header .delete_this', function(){

     var valori = raccogli_valori();
     valori = toJSON(valori);


     var ajax_obj = {pag:'fornitori', action:'deleteRecord', redirect:true, wait:true, obj:{ valori:valori }, esegui:function(data) {
          location.href = '?pagina=fornitori_list';
     }};
     ajax_call(ajax_obj);
});