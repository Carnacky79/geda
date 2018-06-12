
var id_record;

$(document).ready(function(){

     id_record = queryParameters.id_categoria_prodotto;
     semina_valori('categorie_prodotti','getRecord',{id_categoria_prodotto:id_record},'?pagina=categorie_prodotti_list');
});


function salva_valori() {


     var valori = raccogli_valori();
     valori = toJSON(valori);

     ajax_call('categorie_prodotti','updateRecord',true,true,true,
     { valori:valori },
     function() {
          location.href = '?pagina=categorie_prodotti_list';
     });

}


$(document).on('click', '.form_header .delete_this', function(){

     var valori = raccogli_valori();
     valori = toJSON(valori);

     ajax_call('categorie_prodotti','deleteRecord',true,true,true,
     { valori:valori },
     function() {
          location.href = '?pagina=categorie_prodotti_list';
     });
});