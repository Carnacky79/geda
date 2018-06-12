
var id_record = 0;
var id_giornata = 0;


$(document).on('click', '.form_header .export_this', function(){

     var ajax_obj = {pag:'giornate', dataType:'none', action:'exportRecord', redirect:false, wait:true, obj:{ id_giornata:toJSON(id_giornata) }, esegui:function(data) {

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



$(document).ready(function(){

     id_giornata = id_record = queryParameters.id_giornata;
     semina_valori('giornate','getRecord',{id_giornata:id_record},false, function() {
          openKitListDialog();

          if($('#stato').val()==0) {
               $('.save_this').remove();
          }
     });
});




function salva_valori() {
     update(false);
}


$(document).on('click', '.form_header .delete_this', function(){

     if(confirm('Confermare la cancellazione della giornata corrente?')) {

          var valori = raccogli_valori();
          valori = toJSON(valori);

          var ajax_obj = {pag:'giornate', action:'deleteRecord', redirect:true, wait:true, obj:{ valori:valori }, esegui:function(data) {
               location.href = '?pagina=giornate_list';
          }};
          ajax_call(ajax_obj);
     }
});



$(document).on('click', '.form_header .close_this', function(){

     if(confirm('Confermare la chiusura della giornata corrente?')) {

          $('#stato').val('0');
          update();
     }
});


$(document).on('click', '.form_header .open_this', function(){

     if(confirm('Confermare lo sblocco della giornata corrente?')) {

          $('#stato').val('1');
          update(false);
     }
});



function update(redirect) {

     var valori = raccogli_valori();
     valori = toJSON(valori);

     var obj = {};
     obj.obj_righe = obj_righe;

     if(errori_righe===false && !$.isEmptyObject(obj.obj_righe)) {

          var ajax_obj = {pag:'giornate', action:'updateRecord', redirect:true, wait:true, obj:{ valori:valori, obj:toJSON(obj) }, esegui:function(data) {
               if(redirect!==false) {
                    location.href = '?pagina=giornate_list';
               } else {
                    location.reload();
               }
          }};
          ajax_call(ajax_obj);

     } else {
          attenzione('error--Attenzione, controllare i valori inseriti.');
     }

}


