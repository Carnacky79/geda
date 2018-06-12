
var id_record;

$(document).ready(function(){

     id_record = queryParameters.id_location;

     semina_valori('location','getRecord',{id_location:id_record},'?pagina=location_list');


     $('#tab_prodotti_presenti').DataTable({
          stateSave: true, dom: 'ftip', lengthMenu: [[5,10,20], [5,10,20]], pageLength: 20, order: [[1, 'asc']], columnDefs: [{"width": "10%", "sortable": false, "targets": 0}, {"type": "num", "targets": 5}]
     });
});



$(document).on('click', '#tab_prodotti_presenti td.action_col i.editIcon, #tab_prodotti_mancanti td.action_col i.editIcon', function(){

     var id_prodotto = $(this).closest('tr').attr('id_prodotto');

     if(Number($('#livello_utente').val())===1) {
          location.href='?pagina=giacenze_edit&id_prodotto='+id_prodotto;
     } else {
          location.href='?pagina=giacenze_edit_limited&id_prodotto='+id_prodotto;
     }
});



function salva_valori() {


     var valori = raccogli_valori();
     valori = toJSON(valori);

     var ajax_obj = {pag:'location', action:'updateRecord', redirect:true, wait:true, obj:{ valori:valori }, esegui:function(data) {
          location.href = '?pagina=location_list';
     }};
     ajax_call(ajax_obj);

}


$(document).on('click', '.form_header .delete_this', function(){

     var valori = raccogli_valori();
     valori = toJSON(valori);

     var ajax_obj = {pag:'location', action:'deleteRecord', redirect:true, wait:true, obj:{ valori:valori }, esegui:function(data) {
          location.href = '?pagina=location_list';
     }};
     ajax_call(ajax_obj);
});


