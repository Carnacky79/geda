

$(document).ready(function(){

     $('#tab_giornate').DataTable({
          stateSave: true, dom: 'ftip', lengthMenu: [[5,10,20], [5,10,20]], pageLength: 20, order: [[1, 'asc']], columnDefs: [{"width": "10%", "sortable": false, "targets": 0}]
     });
});




$(document).on('click', '#tab_giornate td.action_col i.editIcon', function(){

     var id_giornata = $(this).closest('tr').attr('id_giornata');
     location.href='?pagina=giornate_edit&id_giornata='+id_giornata;
});


$(document).on('click', ' .add_new ', function(){
     location.href='?pagina=giornate_new';
});

