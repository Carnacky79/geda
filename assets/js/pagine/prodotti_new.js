

$(document).ready(function(){

     if(queryParameters.id_categoria!=undefined) {
          $('#id_categoria').val(queryParameters.id_categoria);
     }

});


function salva_valori() {


     var valori = raccogli_valori();
     valori = toJSON(valori);


     var ajax_obj = {pag:'prodotti', action:'saveRecord', redirect:true, wait:true, obj:{ valori:valori }, esegui:function(data) {
          if(data==='doppio') {
               attenzione('error--Attenzione, il codice prodotto è già presente.');
          } else {
               location.href = '?pagina=prodotti_edit&id_prodotto='+data;
          }
     }};
     ajax_call(ajax_obj);

}