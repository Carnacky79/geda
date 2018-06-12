
var id_record = 0;
var id_fattura = 0;
var tipologia = 0;


$(document).on('click', '.form_header .close_this', function(){

     if(confirm("Forzare la chiusura del documento corrente?\nNon sarà più possibile apportare modifiche.")) {

          var valori = raccogli_valori();
          valori = toJSON(valori);

          var ajax_obj = {pag:'fatture', action:'closeRecord', redirect:true, wait:true, obj:{ valori:valori }, esegui:function(data) {
               location.href = '?pagina=fatture_list';
          }};
          ajax_call(ajax_obj);
     }
});


$(document).on('click', '.form_header .export_this', function(){

     var ajax_obj = {pag:'fatture', dataType:'none', action:'exportRecord', redirect:false, wait:true, obj:{ id_fattura:toJSON(id_fattura) }, esegui:function(data) {

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

     id_fattura = id_record = queryParameters.id_fattura;
     tipologia = queryParameters.type;


     if(tipologia==0) {
          $('#id_fornitore').attr('data-parsley-required',true).parents('.form-group').removeClass('hidden');
          $('.export_this').addClass('hidden');
     }
     if(tipologia==1) {
          $('#id_cliente').attr('data-parsley-required',true).parents('.form-group').removeClass('hidden');
     }


     semina_valori('fatture','getRecord',{id_fattura:id_record},false, function() {
          openKitListDialog();
          carica_oggetti();
     });

});




function salva_valori() {

     var valori = raccogli_valori();

     valori.anno = $('#data').val().split('/')[2];

     valori = toJSON(valori);

     var obj = {};
     obj.totale_imponibile = totale_imponibile;
     obj.totale_iva = totale_iva;
     obj.totale_esente = totale_esente;
     obj.totale_accessorie = totale_accessorie;
     obj.totale_totale = totale_totale;
     obj.obj_righe = obj_righe;

     if(errori_righe===false && !$.isEmptyObject(obj.obj_righe)) {

          var ajax_obj = {pag:'fatture', action:'updateRecord', redirect:true, wait:true, obj:{ valori:valori, obj:toJSON(obj) }, esegui:function(data) {
               location.href = '?pagina=fatture_list';
          }};
          ajax_call(ajax_obj);
     } else {
          attenzione('error--Attenzione, controllare i valori inseriti.');
     }
}


$(document).on('click', '.form_header .delete_this', function(){

     if(confirm('Confermare la cancellazione della fattura corrente?')) {

          var valori = raccogli_valori();
          valori = toJSON(valori);

          var ajax_obj = {pag:'fatture', action:'deleteRecord', redirect:true, wait:true, obj:{ valori:valori }, esegui:function(data) {
               location.href = '?pagina=fatture_list';
          }};
          ajax_call(ajax_obj);
     }
});


