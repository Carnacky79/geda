
var id_record;

$(document).ready(function(){

    id_record = queryParameters.id_prodotto;

    semina_valori('prodotti','getRecordByLocation',{id_prodotto:id_record},'',);
});