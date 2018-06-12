

$(document).ready(function(){

     $('#tab_prodotti_presenti .sorting_1').css('cursor', 'pointer');

     $('#tab_prodotti_presenti').DataTable({
          stateSave: true, dom: 'ftip', lengthMenu: [[5,10,20], [5,10,20]], pageLength: 20, order: [[1, 'asc']], columnDefs: [{"width": "10%", "sortable": false, "targets": 0}, {"type": "num", "targets": 5}]
     });

     $('#tab_prodotti_mancanti').DataTable({
          stateSave: true, dom: 'ftip', lengthMenu: [[5,10,20], [5,10,20]], pageLength: 20, order: [[1, 'asc']], columnDefs: [{"width": "10%", "sortable": false, "targets": 0}]
     });
});




$(document).on('click', '#tab_prodotti_presenti td.sorting_1, #tab_prodotti_presenti td.action_col i.editIcon, #tab_prodotti_mancanti td.action_col i.editIcon', function(){

     var id_prodotto = $(this).closest('tr').attr('id_prodotto');

     if(Number($('#livello_utente').val())===1) {
          location.href='?pagina=prodotti_edit&id_prodotto='+id_prodotto;
     } else {
          location.href='?pagina=prodotti_edit_limited&id_prodotto='+id_prodotto;
     }
});


$(document).on('click', ' .add_new ', function(){
     location.href='?pagina=prodotti_new';
});



