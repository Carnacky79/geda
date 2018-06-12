

$(document).ready(function(){

});


function salva_valori() {


     var valori = raccogli_valori();
     valori = toJSON(valori);


     var ajax_obj = {pag:'location', action:'saveRecord', redirect:true, wait:true, obj:{ valori:valori }, esegui:function(data) {
               // location.href = '?pagina=location_edit&id_location='+data;
               location.href = '?pagina=location_list';
     }};
     ajax_call(ajax_obj);

}