

$(document).ready(function(){

     $('#tab_location').DataTable({
          stateSave: true, dom: 'ftip', lengthMenu: [[5,10,20], [5,10,20]], pageLength: 20, order: [[1, 'asc']], columnDefs: [{"width": "10%", "sortable": false, "targets": 0}]
     });
});




$(document).on('click', '#tab_location td.action_col i.editIcon', function(){

     var id_location = $(this).closest('tr').attr('id_location');
     location.href='?pagina=location_edit&id_location='+id_location;
});


$(document).on('click', ' .add_new ', function(){
     location.href='?pagina=location_new';
});

