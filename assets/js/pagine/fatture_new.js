
var tipologia;
var id_fattura = 0;

$(document).ready(function(){

     tipologia = queryParameters.type;

     if(tipologia==0) {
          $('#id_fornitore').attr('data-parsley-required',true).parents('.form-group').removeClass('hidden');
          $('.export_this').addClass('hidden');
     }
     if(tipologia==1) {
          $('#id_cliente').attr('data-parsley-required',true).parents('.form-group').removeClass('hidden');
     }

     $('#type').val(tipologia);
     calcolaContatore();
});


function calcolaContatore() {

     if(tipologia==1) {

          var anno = $('#data').val().split('/')[2];

          if(anno!=undefined) {

               var ajax_obj = {pag:'contatori', action:'getRecord', redirect:false, wait:false, obj:{ nome:toJSON('fattura_'+tipologia), anno:toJSON(anno) }, esegui:function(data) {
                    $('#codice').val(data);
               }};
               ajax_call(ajax_obj);

          } else {
               $('#codice').val('');
          }
     }
}

$(document).on('change', '#data', function(){
     calcolaContatore();
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

     console.log(valori);

     if(errori_righe===false && !$.isEmptyObject(obj.obj_righe)) {

          var ajax_obj = {pag:'fatture', action:'saveRecord', redirect:true, wait:true, obj:{ valori:valori, obj:toJSON(obj) }, esegui:function(data) {
               location.href = '?pagina=fatture_edit&id_fattura='+data+'&type='+tipologia;
          }};
          ajax_call(ajax_obj);
     } else {
         attenzione('error--Attenzione, controllare i valori inseriti.');
     }

}

