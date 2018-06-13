
var id_record;
var id_locat;

$(document).ready(function(){

     id_record = queryParameters.id_prodotto;
     id_locat = queryParameters.id_location;

//     semina_valori('giacenze','getRecord',{id_prodotto:id_record, id_location:id_location},'?pagina=giacenze_list',function(){ });
    semina_valori('giacenze','getRecordByLocation',{id_prodotto:id_record,id_location:id_locat});

});
//
//
//
// $(document).on('click', '#tab_fatture_ddt_fornitori td.action_col i.editIcon, #tab_fatture_ddt_clienti td.action_col i.editIcon', function(){
//
//      var riga = $(this).closest('tr');
//      var type = riga.attr('type');
//      if(riga.attr('id_fattura')!==undefined) {
//           var id_fattura = riga.attr('id_fattura');
//           location.href='?pagina=fatture_edit&id_fattura='+id_fattura+'&type='+type;
//      } else {
//           var id_ddt = riga.attr('id_ddt');
//           location.href='?pagina=ddt_edit&id_ddt='+id_ddt+'&type='+type;
//      }
// });
//
//
// function salva_valori() {
//
//
//      var valori = raccogli_valori();
//      valori = toJSON(valori);
//
//      var fornitori_associati = {};
//
//      $('#tab_fornitori_associati tbody tr').each(function() {
//           var id_fornitore = $(this).find('#id_fornitore').val();
//
//           console.log(id_fornitore);
//
//           var c_u = $(this).find('#c_u').val();
//           fornitori_associati[id_fornitore] = c_u;
//      });
//
//      fornitori_associati = toJSON(fornitori_associati);
//
//
//      var ajax_obj = {pag:'prodotti', action:'updateRecord', redirect:true, wait:true,
//      obj:{ valori:valori, fornitori_associati:fornitori_associati },
//      esegui:function(data) {
//           if(data==='doppio') {
//                attenzione('error--Attenzione, il codice prodotto è già presente.');
//           } else {
//                location.href = '?pagina=prodotti_list';
//           }
//      }};
//      ajax_call(ajax_obj);
//
// }
//
//
// $(document).on('click', '.form_header .delete_this', function(){
//
//      var valori = raccogli_valori();
//      valori = toJSON(valori);
//
//      var ajax_obj = {pag:'prodotti', action:'deleteRecord', redirect:true, wait:true, obj:{ valori:valori }, esegui:function(data) {
//           location.href = '?pagina=prodotti_list';
//      }};
//      ajax_call(ajax_obj);
// });
//
//
//
