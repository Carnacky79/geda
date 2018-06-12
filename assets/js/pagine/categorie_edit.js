
var id_record;

$(document).ready(function(){

     id_record = queryParameters.id_categoria;
     semina_valori('categorie','getRecord',{id_categoria:id_record},'?pagina=categorie_list');


     $('#tab_prodotti').DataTable({
          dom: 'ftip', lengthMenu: [[5,10,20], [5,10,20]], pageLength: 10, order: [[1, 'asc']], columnDefs: [{"width": "10%", "sortable": false, "targets": 0}, {"type": "num", "targets": 4}]
     });
});


$(document).on('click', '#tab_prodotti td.action_col i.editIcon', function(){

     var id_prodotto = $(this).closest('tr').attr('id_prodotto');
     location.href='?pagina=prodotti_edit&id_prodotto='+id_prodotto;
});


function salva_valori() {


     var valori = raccogli_valori();
     valori = toJSON(valori);

     var ajax_obj = {pag:'categorie', action:'updateRecord', redirect:true, wait:true, obj:{ valori:valori }, esegui:function(data) {
          location.href = '?pagina=categorie_list';
     }};
     ajax_call(ajax_obj);

}


$(document).on('click', '.add_this', function(){

     window.open('?pagina=prodotti_new&id_categoria='+id_record,'_blank');
});



$(document).on('click', '.form_header .delete_this', function(){

     var valori = raccogli_valori();
     valori = toJSON(valori);

     var ajax_obj = {pag:'categorie', action:'deleteRecord', redirect:true, wait:true, obj:{ valori:valori }, esegui:function(data) {
          location.href = '?pagina=categorie_list';
     }};
     ajax_call(ajax_obj);
});