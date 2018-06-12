

$(document).ready(function(){

     $('#tab_categorie').DataTable({
          stateSave: true, dom: 'ftip', lengthMenu: [[5,10,20], [5,10,20]], pageLength: 20, order: [[1, 'asc']], columnDefs: [{"width": "10%", "sortable": false, "targets": 0}, {"type": "num", "targets": 3}]
     });
});


$(document).on('click', '#tab_categorie td.action_col i.editIcon', function(){

     var id_categoria = $(this).closest('tr').attr('id_categoria');
     location.href='?pagina=categorie_edit&id_categoria='+id_categoria;
});



$(document).on('click', ' .add_new ', function(){
     location.href='?pagina=categorie_new';
});