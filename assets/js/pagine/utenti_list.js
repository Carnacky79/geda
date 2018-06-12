

$(document).ready(function(){

     $('#tab_utenti').DataTable({
          stateSave: true, dom: 'ftip', lengthMenu: [[5,10,20], [5,10,20]], pageLength: 20, order: [[1, 'asc']], columnDefs: [{"width": "10%", "sortable": false, "targets": 0}, {"type": "num", "targets": 5}]
     });
});




$(document).on('click', '#tab_utenti td.action_col i.editIcon', function(){

     var id_utente = $(this).closest('tr').attr('id_utente');
     location.href='?pagina=utenti_edit&id_utente='+id_utente;
});


$(document).on('click', ' .add_new ', function(){
     location.href='?pagina=utenti_new';
});

