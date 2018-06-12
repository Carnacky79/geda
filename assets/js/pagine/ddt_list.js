

$(document).ready(function(){

     $('#tab_ddt_0, #tab_ddt_1').DataTable({
          stateSave: true, dom: 'ftip', lengthMenu: [[5,10,20], [5,10,20]], pageLength: 20, order: [[1, 'asc']], columnDefs: [{"width": "10%", "sortable": false, "targets": 0}, {"type": "num", "targets": 4}]
     });
});


$(document).on('click', '#tab_ddt_0 td.action_col i.editIcon, #tab_ddt_1 td.action_col i.editIcon', function(){

     var id_ddt = $(this).closest('tr').attr('id_ddt');
     var type = $(this).closest('tr').attr('type');
     if(Number($('#livello_utente').val())===1) {
          location.href='?pagina=ddt_edit&id_ddt='+id_ddt+'&type='+type;
     } else {
          location.href='?pagina=ddt_edit_limited&id_ddt='+id_ddt+'&type='+type;
     }
});


$(document).on('click', ' .add_new ', function(){
     if($(this).hasClass('entrata')) {
          location.href='?pagina=ddt_new&type=0';
     } else {
          location.href='?pagina=ddt_new&type=1';
     }
});


$(document).on('click', '#tab_ddt_1 td.action_col i.downIcon', function(){

     var id_ddt = $(this).closest('tr').attr('id_ddt');

     var ajax_obj = {pag:'ddt', dataType:'none', action:'exportRecord', redirect:false, wait:true, obj:{ id_ddt:toJSON(id_ddt) }, esegui:function(data) {

          data = fromJSON(data);
          var nome_file = data.nome;
          var dati_file = data.file;

          var dlnk = document.getElementById('exportA');

          var res = dati_file.split('"')[dati_file.split('"').length-1];
          res = res.replace(/(\r\n|\n|\r)/gm,"");

          dlnk.href = 'data:application/pdf;base64,'+res;
          dlnk.download = nome_file;
          dlnk.click();

     }, headers:{
          Accept: 'application/octet-stream',
     }};
     ajax_call(ajax_obj);
});