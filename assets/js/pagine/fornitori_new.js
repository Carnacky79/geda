

$(document).ready(function(){


});


function salva_valori() {


     var valori = raccogli_valori();
     valori = toJSON(valori);


     var ajax_obj = {pag:'fornitori', action:'saveRecord', redirect:true, wait:true, obj:{ valori:valori }, esegui:function(data) {
          location.href = '?pagina=fornitori_list';
     }};
     ajax_call(ajax_obj);

}