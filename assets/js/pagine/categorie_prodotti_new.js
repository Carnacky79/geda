

$(document).ready(function(){


});


function salva_valori() {


     var valori = raccogli_valori();
     valori = toJSON(valori);


     ajax_call('categorie_prodotti','saveRecord',true,true,true,
     { valori:valori },
     function() {
          location.href = '?pagina=categorie_prodotti_list';
     });

}