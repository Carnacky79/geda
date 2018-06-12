

$(document).ready(function(){

     $('#tab_servizi').DataTable({
          stateSave: true, dom: 'ftip', lengthMenu: [[5,10,20], [5,10,20]], pageLength: 20, order: [[1, 'asc']], columnDefs: [{"width": "10%", "sortable": false, "targets": 0}]
     });
});


$(document).on('click', '#tab_servizi td.action_col i.editIcon', function(){

     var id_servizio = $(this).closest('tr').attr('id_servizio');
     location.href='?pagina=servizi_edit&id_servizio='+id_servizio;
});


$(document).on('click', ' .add_new ', function(){
     location.href='?pagina=servizi_new';
});

