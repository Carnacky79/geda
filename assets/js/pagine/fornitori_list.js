

$(document).ready(function(){

     $('#tab_fornitori').DataTable({
          stateSave: true, dom: 'ftip', lengthMenu: [[5,10,20], [5,10,20]], pageLength: 20, order: [[1, 'asc']], columnDefs: [{"width": "10%", "sortable": false, "targets": 0}]
     });
});


$(document).on('click', '#tab_fornitori td.action_col i.editIcon', function(){

     var id_fornitore = $(this).closest('tr').attr('id_fornitore');
     location.href='?pagina=fornitori_edit&id_fornitore='+id_fornitore;
});


$(document).on('click', ' .add_new ', function(){
     location.href='?pagina=fornitori_new';
});