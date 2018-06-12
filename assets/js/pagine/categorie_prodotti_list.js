

$(document).ready(function(){

     $('#tab_categorie_prodotti').DataTable({
          dom: 'Rtri', lengthMenu: [[5,10,20], [5,10,20]], pageLength: 20, order: [[1, 'asc']], columnDefs: [{"width": "10%", "sortable": false, "targets": 0}]
     });
     TableManageButtons.init();
});


$(document).on('click', '#tab_categorie_prodotti td.action_col i.editIcon', function(){

     var id_categoria_prodotto = $(this).closest('tr').attr('id_categoria_prodotto');
     location.href='?pagina=categorie_prodotti_edit&id_categoria_prodotto='+id_categoria_prodotto;
});



$(document).on('click', ' .add_new ', function(){
     location.href='?pagina=categorie_prodotti_new';
});