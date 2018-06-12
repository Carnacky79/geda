

$(document).ready(function(){

     $('#tab_iva').DataTable({
          stateSave: true, dom: 'tip', lengthMenu: [[5,10,20], [5,10,20]], pageLength: 20, order: [[1, 'asc']], columnDefs: [{"width": "10%", "sortable": false, "targets": 0}]
     });
});


$(document).on('click', '#tab_iva td.action_col i.editIcon', function(){

     var id_iva = $(this).closest('tr').attr('id_iva');
     location.href='?pagina=iva_edit&id_iva='+id_iva;
});


$(document).on('click', ' .add_new ', function(){
     location.href='?pagina=iva_new';
});

