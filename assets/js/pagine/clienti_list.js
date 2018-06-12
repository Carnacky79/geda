

$(document).ready(function(){

     $('#tab_clienti').DataTable({
          stateSave: true, dom: 'ftip', lengthMenu: [[5,10,20], [5,10,20]], pageLength: 20, order: [[1, 'asc']], columnDefs: [{"width": "10%", "sortable": false, "targets": 0}]
     });
});


$(document).on('click', '#tab_clienti td.action_col i.editIcon', function(){

     var id_cliente = $(this).closest('tr').attr('id_cliente');
     location.href='?pagina=clienti_edit&id_cliente='+id_cliente;
});


$(document).on('click', ' .add_new ', function(){
     location.href='?pagina=clienti_new';
});