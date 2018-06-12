
var record_oggetti = [];
var record_iva = fromJSON($('#record_iva').html());

var progressivo_riga = 0;
var riga_da_eliminare = {};
var columnDefs = [
     {"width": "6%", "targets": 0},
     {"width": "10%", "targets": 2},
     {"width": "10%", "targets": 3},
     {"width": "10%", "targets": 4},
     {"width": "13%", "targets": 5},
     {"width": "13%", "targets": 6},
     {"width": "13%", "targets": 7}
];


function carica_oggetti() {

     if(tipologia==0) {
          var id = $('#id_fornitore').val();
     } else {
          var id = 0; //propri
     }

     record_oggetti = [];
     var associati = fromJSON($('#record_fornitori_associati').html());

     $.each( fromJSON($('#record_oggetti').html()), function(key,val) {
          if(
               (
                    associati[id]!=undefined
                    &&
                    associati[id][val.id_oggetto]!=undefined
               )
               || id==0
          ) {
               if(tipologia==0 && (
                    associati[id]!=undefined
                    &&
                    associati[id][val.id_oggetto]!=undefined
               )) {
                    val.c_u = associati[id][val.id_oggetto].c_u;
               }
               record_oggetti.push(val);
          }
     });
}


$(document).on('change', ' #id_fornitore, #id_cliente ', function(){

     if( ($(this).attr('id')=='id_fornitore' && $(this).val()>0 ) || $(this).attr('id')=='id_cliente' ) {
          $('.add_new').removeClass('hidden');
     } else {
          $('.add_new').addClass('hidden');
     }

     obj_righe = {};

     carica_oggetti();

     var righe =  $('#tab_fattura_righe tbody tr');

     righe.each(function() {

          if($(this).find('.dataTables_empty').length>0) { return true; }

          var id_riga = $(this).attr('id_riga');

          if ( id_riga.indexOf('progressivo')=='-1' ) {
               var riga = {};
               riga.id_riga = id_riga;
               riga.id_fattura = id_fattura;

               riga_da_eliminare[id_riga]=riga;
          }

          var table = $('#tab_fattura_righe').DataTable();
          table.row( $('#tab_fattura_righe tbody tr[id_riga="'+id_riga+'"]') ).remove().draw();
     });


     calcola();
});


function search_record_oggetti(id_categoria_tipologia,id_oggetto) {
     var nodo = false;

     $.each(record_oggetti, function(key,val) {

          if(val.id_categoria_tipologia==id_categoria_tipologia && val.id_oggetto==id_oggetto) {
               nodo = key;
          }
     });

     return nodo;
}



$(document).on('change', ' [name="id_oggetto"] ', function(){
     var id_oggetto = $(this).val();

     var elemento = $(this);

     if(id_oggetto.split('_').length==2) {

          var oggetto = record_oggetti[search_record_oggetti(id_oggetto.split('_')[0],id_oggetto.split('_')[1])];

          var ajax_obj = {pag:'fatture', action:'getUltimo_prezzo_and_iva', redirect:false, wait:false, obj:{ id_fattura:toJSON(id_fattura), id_categoria_tipologia:toJSON(id_oggetto.split('_')[0]), id_prodotto_servizio:toJSON(id_oggetto.split('_')[1]), id_fornitore:toJSON($('#id_fornitore').val()), id_cliente:toJSON($('#id_cliente').val()) }, esegui:function(data) {

               var data_prezzo = data.prezzo;
               var data_iva = data.iva;

               if(data_prezzo!='non_trovato') {
                    var c_u = data_prezzo;
               } else {
                    var c_u = oggetto.c_u;
               }

               if(data_iva>0) {
                    elemento.parents('tr').find('[name="id_iva"]').val(data_iva);
               }

               elemento.parents('tr').find('[name="prezzo_unitario"]').val(parseFloat(c_u).toFixed(3)).change();
               if(tipologia==1) {
                    //elemento.parents('tr').find('[name="quantita"]').attr('max',oggetto.qta_residua).val(0);
                    elemento.parents('tr').find('[name="quantita"]').val(0);
               }
          }};
          ajax_call(ajax_obj);
     }
});



$(document).on('change', ' [name="quantita"] ', function(){
     var max = $(this).attr('max');
     if(max!=undefined && $(this).val()>max) {
          attenzione("warning--Attenzione, il oggetto non è disponibile nella quantità inserita.");
          $(this).val(0);
     }
});




function carica() {

     $('#tab_fattura_righe').DataTable().destroy();

     $('#tab_fattura_righe').DataTable({
          paging: false, autoWidth: false, columnDefs: columnDefs, dom: 't', ordering: false, pageLength: 50 });

          $('#dialog_riga_lista tbody :input').removeClass('textStyle');
     }



     function aggiungi() {

          var select_oggetti = '<div class="default text"></div><div class="menu">';
          var select_iva = '<option valore="0" disabled ></option>';


          $.each(record_oggetti, function(key,val) {
               if(val.barcode==undefined) {val.barcode='';}
               select_oggetti += '<div class="item" data-value="'+val.id_categoria_tipologia+'_'+val.id_oggetto+'"><span class="description">'+val.barcode+'</span><span class="text" >'+val.nome+'</span></div>';
          });

          $.each(record_iva, function(key,val) {
               if(val.valore=='22') { var selected = ' selected '; } else { var selected = ' '; }
               select_iva += '<option value="'+val.id_iva+'" valore="'+val.valore+'" '+selected+' >'+val.nome+'</option>';
          });



          var new_row = [
               '<i class="fa fa-times riga_delete" aria-hidden="true"></i>',

               '<div class="ui fluid search selection dropdown"><input type="hidden" id="id_oggetto" name="id_oggetto" ><i class="dropdown icon"></i>'+
               select_oggetti+'</div>',

               '<input type="number" class="form-control" id="quantita" name="quantita" step="0.01"  />',
               '<input type="number" class="form-control" id="prezzo_unitario" name="prezzo_unitario" />',
               '<input type="number" class="form-control" id="sconto" name="sconto" step="0.001"  />',

               '<input type="number" class="form-control" id="sub_totale" name="sub_totale" disabled />',

               '<select class="form-control" id="id_iva" name="id_iva" >'+
               select_iva+'</select>',


               '<input type="number" class="form-control" id="totale" name="totale" disabled />'
          ];

          if ($.fn.DataTable.isDataTable('#tab_fattura_righe')) {
               var table = $('#tab_fattura_righe').DataTable();
          } else {
               carica();
               table = $('#tab_fattura_righe').DataTable();
          }

          var added_row = table.row.add(new_row);
          added_row.draw(false);
          indice = added_row.index();


          $('#tab_fattura_righe tbody tr').each(function(){

               $(this).find('td').eq(0).addClass('action_col');
               // $(this).find('td').eq(1).addClass('ellipsis');
               $(this).find('td').eq(2).addClass('quantita');
               $(this).find('td').eq(3).addClass('prezzo_unitario');
               $(this).find('td').eq(4).addClass('sconto');
               $(this).find('td').eq(5).addClass('sub_totale');
               $(this).find('td').eq(6).addClass('id_iva');
               $(this).find('td').eq(7).addClass('totale');
          });

          progressivo_riga++;

          table.rows(indice).nodes().to$().attr("id_riga", 'progressivo_'+progressivo_riga );

          $('.ui.dropdown').dropdown();
     }



     $(document).on('click', '.add_new', function(){
          aggiungi();
     });



     function genera_contenuto(data) {

          var disabled = '';

          var righe_html = '';

          if(data!==undefined) {

               $.each(data, function(key,val) {

                    if(!$.isEmptyObject(val)) {

                         var select_oggetti = '<div class="default text"></div><div class="menu">';
                         var select_iva = '<option valore="0" disabled selected></option>';

                         var oggetto_corrente = {};

                         righe_html += '<tr id_riga="'+val.id_fattura_riga+'" >';

                         righe_html += '<td class="action_col">';

                         righe_html += '<i class="fa fa-times riga_delete" aria-hidden="true"></i></td>';


                         righe_html += '</td>';


                         var selected = '';

                         $.each(record_oggetti, function(key_1,val_1) {

                              if ( (val.id_servizio==val_1.id_oggetto && val_1.id_categoria_tipologia==2) || (val.id_prodotto==val_1.id_oggetto && val_1.id_categoria_tipologia==1) ) {
                                   selected = val_1.id_categoria_tipologia+'_'+val_1.id_oggetto;
                                   oggetto_corrente = record_oggetti[val_1.id_oggetto];
                              }
                              if(val_1.barcode==undefined || val_1.barcode=='') { var barcode=''; } else { var barcode ='('+val_1.barcode+')'; }
                              select_oggetti += '<div class="item" data-value="'+val_1.id_categoria_tipologia+'_'+val_1.id_oggetto+'"><span class="description">'+barcode+'</span><span class="text" >'+val_1.nome+'</span></div>';
                         });

                         righe_html += '<td class="" ><div class="ui fluid search selection dropdown '+disabled+' "><input type="hidden" id="id_oggetto" name="id_oggetto" value="'+selected+'" ><i class="dropdown icon"></i>';

                         righe_html += select_oggetti+'</div></td>';


                         if(tipologia==1) {
                              righe_html += '<td class="quantita" ><input type="number" class="form-control textStyle right-in" id="quantita" name="quantita" value="'+val.quantita+'" step="0.01" '+disabled+' /></td>';
                         } else {
                              righe_html += '<td class="quantita" ><input type="number" class="form-control textStyle right-in" id="quantita" name="quantita" value="'+val.quantita+'" step="0.01" '+disabled+' /></td>';
                         }




                         righe_html += '<td class="prezzo_unitario" ><input type="number" class="form-control textStyle right-in" id="prezzo_unitario" name="prezzo_unitario" value="'+val.prezzo_unitario+'" '+disabled+' /></td>';

                         righe_html += '<td class="sconto" ><input type="number" class="form-control textStyle right-in" id="sconto" name="sconto" value="'+val.sconto+'" step="0.001" '+disabled+' /></td>';


                         righe_html += '<td class="sub_totale" ><input type="number" class="form-control textStyle right-in" id="sub_totale" name="sub_totale" value="" disabled /></td>';


                         righe_html += '<td class="id_iva" ><select class="form-control textStyle" id="id_iva" name="id_iva" '+disabled+' >';
                         $.each(record_iva, function(key_1,val_1) {
                              var selected = '';
                              if ( val.id_iva == val_1.id_iva ) {
                                   selected = ' selected ';
                              }
                              select_iva += '<option value="'+val_1.id_iva+'" valore="'+val_1.valore+'" '+selected+' >'+val_1.nome+'</option>';
                         });
                         righe_html += select_iva+'</select></td>';


                         righe_html += '<td class="totale" ><input type="number" class="form-control textStyle right-in" id="totale" name="totale" value="'+val.totale+'" disabled /></td>';


                         righe_html += '</tr>';
                    }
               });
          }

          if ($.fn.DataTable.isDataTable('#tab_fattura_righe')) {
               $('#tab_fattura_righe').DataTable().destroy();
          }

          $('#tab_fattura_righe tbody').html(righe_html);

          $('.ui.dropdown').dropdown();

          carica();
          calcola();
     }





     // Method to open KIT list dialog
     function openKitListDialog() {

          var ajax_obj = {pag:'fatture', action:'getRighe', redirect:true, wait:true, obj:{ id_fattura:toJSON(id_fattura) }, esegui:function(data) {
               genera_contenuto(data);
          }};
          ajax_call(ajax_obj);
     }






     $(document).on('click', '.riga_delete', function(){

          if (confirm('Confermare l\'eliminazione della riga?')) {
               var id_riga = $(this).closest('tr').attr('id_riga');

               if ( id_riga.indexOf('progressivo')=='-1' ) {
                    var riga = {};
                    riga.id_riga = id_riga;
                    riga.id_fattura = id_fattura;

                    riga_da_eliminare[id_riga]=riga;
               }

               var table = $('#tab_fattura_righe').DataTable();
               table.row( $('#tab_fattura_righe tbody tr[id_riga="'+id_riga+'"]') ).remove().draw();

               calcola();
          }
     });





     $(document).on('change', '[name="quantita"], [name="prezzo_unitario"], [name="sconto"], [name="id_iva"], #spese_acc', function(){
          calcola();
     });




     var totale_imponibile = parseFloat(0);
     var totale_iva = parseFloat(0);
     var totale_esente = parseFloat(0);
     var totale_accessorie = parseFloat(0);
     var totale_totale = parseFloat(0);
     var obj_righe = {};
     var obj_iva = {};
     var errori_righe = false;



     function calcola() {

          totale_imponibile = parseFloat(0);
          totale_iva = parseFloat(0);
          totale_esente = parseFloat(0);
          totale_accessorie = parseFloat(0);
          totale_totale = parseFloat(0);
          errori_righe = false;

          var accessorie = $('#spese_acc').val();
          if (accessorie=='') { accessorie=0; }

          totale_accessorie = parseFloat(accessorie);

          var cnt = 0;
          obj_righe = {};
          obj_iva = {};

          $('#tab_fattura_righe tbody tr').each(function() {

               if($(this).find('.dataTables_empty').length>0) { return true; }

               obj_righe[cnt] = {};

               $('#tab_fattura_info tbody').removeClass('hidden');

               var id_oggetto = $(this).find('[name="id_oggetto"]').val();

               if(id_oggetto.split('_').length==2) {

                    var id_prodotto = 0;
                    var id_servizio = 0;
                    var quantita = $(this).find('[name="quantita"]').val();
                    var prezzo_unitario = $(this).find('[name="prezzo_unitario"]').val();
                    var sconto = $(this).find('[name="sconto"]').val();
                    var iva = $(this).find('[name="id_iva"] option:selected').attr('valore');
                    var id_iva = $(this).find('[name="id_iva"] option:selected').val();



                    if(id_oggetto.split('_')[0]==1) {
                         id_prodotto = id_oggetto.split('_')[1];
                    } else {
                         id_servizio = id_oggetto.split('_')[1];
                    }


                    obj_righe[cnt].id_prodotto = id_prodotto;
                    obj_righe[cnt].id_servizio = id_servizio;


                    if (quantita=='') { quantita=0; errori_righe = true; }
                    if (prezzo_unitario=='') { prezzo_unitario=0; }
                    if (sconto=='') { sconto=0; }
                    if (iva=='') { iva=0; }
                    if (id_iva=='') { id_iva=0; errori_righe = true; }

                    obj_righe[cnt].id_iva = id_iva;



                    quantita = parseFloat(quantita);
                    obj_righe[cnt].quantita = parseFloat(quantita);


                    prezzo_unitario = parseFloat(prezzo_unitario);
                    obj_righe[cnt].prezzo_unitario = parseFloat(prezzo_unitario);
                    $(this).find('[name="prezzo_unitario"]').val(prezzo_unitario.toFixed(3));


                    sconto = parseFloat(sconto);
                    obj_righe[cnt].sconto = parseFloat(sconto);
                    $(this).find('[name="sconto"]').val(sconto.toFixed(3));

                    var sub_totale = parseFloat((quantita*prezzo_unitario)-sconto).toFixed(3);
                    sub_totale = parseFloat(sub_totale);

                    obj_righe[cnt].sub_totale = parseFloat(sub_totale);
                    $(this).find('[name="sub_totale"]').val(sub_totale.toFixed(3));


                    iva = parseFloat(iva);

                    if(iva==0) {
                         var totale = parseFloat(sub_totale).toFixed(3);
                         totale_esente = parseFloat(totale_esente)+parseFloat(sub_totale);

                    } else {

                         totale_imponibile = parseFloat(totale_imponibile)+parseFloat(sub_totale);
                         iva = (sub_totale*iva/100).toFixed(3);
                         totale_iva = parseFloat(totale_iva)+parseFloat(iva);
                         var totale = (parseFloat(sub_totale) + parseFloat(iva)).toFixed(3);
                    }


                    var imp_iva_loop = {};
                    imp_iva_loop.imp = sub_totale;
                    imp_iva_loop.iva = iva;

                    if(id_iva>0) {
                         if(obj_iva[id_iva]==undefined) {
                              obj_iva[id_iva] = imp_iva_loop;
                         } else {
                              obj_iva[id_iva].imp = parseFloat(obj_iva[id_iva].imp) + parseFloat(sub_totale);
                              obj_iva[id_iva].iva = parseFloat(obj_iva[id_iva].iva) + parseFloat(iva);
                         }
                    }

                    obj_righe[cnt].iva = parseFloat(iva);

                    obj_righe[cnt].totale = parseFloat(totale);

                    $(this).find('[name="totale"]').val(totale);

                    cnt++;

               } else {
                    errori_righe = true;
               }
          });


          totale_totale = parseFloat(totale_imponibile)+parseFloat(totale_iva)+parseFloat(totale_esente)+parseFloat(totale_accessorie);

          $('.totale_imponibile').html('€ '+totale_imponibile.toFixed(3));
          $('.totale_iva').html('€ '+totale_iva.toFixed(3));
          $('.totale_esente').html('€ '+totale_esente.toFixed(3));
          $('.totale_accessorie').html('€ '+totale_accessorie.toFixed(3));
          $('.totale_totale').html('€ '+totale_totale.toFixed(3));
          $('.info_fattura').html('');

          $.each(obj_iva, function(key,val){
               $('.info_fattura').append("IVA "+record_iva[key].nome+": Imponibile € "+parseFloat(val.imp).toFixed(3)+" - IVA € "+parseFloat(val.iva).toFixed(3)+"<br/>");
          });
     }




