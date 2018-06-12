

$(document).ready(function(){

     $('#tab_contatori').DataTable({
          stateSave: true, dom: 'Rtri', lengthMenu: [[5,10,20], [5,10,20]], pageLength: 20, order: [[1, 'asc']],
          columnDefs: [{"width": "10%", "sortable": false, "targets": 0}, {"width": "10%", "sortable": false, "targets": 2}]
     });
});


$(document).on('click', '#tab_contatori td.action_col i.plusIcon', function(){

     var id_contatore = $(this).closest('tr').attr('id_contatore');

     var ajax_obj = {pag:'contatori', action:'plusRecord', redirect:true, wait:true, obj:{ id_contatore:toJSON(id_contatore) }, esegui:function(data) {
          location.reload();
     }};
     ajax_call(ajax_obj);
});


$(document).on('click', '#tab_contatori td.action_col i.minusIcon', function(){

     var id_contatore = $(this).closest('tr').attr('id_contatore');

     var ajax_obj = {pag:'contatori', action:'minusRecord', redirect:true, wait:true, obj:{ id_contatore:toJSON(id_contatore) }, esegui:function(data) {
          location.reload();
     }};
     ajax_call(ajax_obj);
});
