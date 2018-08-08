
var record_prodotti = fromJSON($('#record_prodotti').html());
var record_metodi_pagamento = fromJSON($('#record_metodi_pagamento').html());

var progressivo_riga = 0;
var riga_da_eliminare = {};
var columnDefs = [
     {"width": "6%", "targets": 0},
     {"width": "25%", "targets": 1},
     {"width": "10%", "targets": 2},
     {"width": "10%", "targets": 3},
     {"width": "20%", "targets": 4},
];



function search_record_prodotti(id_prodotto) {
     var nodo = false;

     $.each(record_prodotti, function(key,val) {

          if(val.id_prodotto==id_prodotto) {
               nodo = key;
          }
     });

     return nodo;
}


     function carica() {

     $('#tab_giornate_righe').DataTable().destroy();

     $('#tab_giornate_righe').DataTable({
          paging: false, autoWidth: false, columnDefs: columnDefs, dom: 't', ordering: false, pageLength: 50 });

          $('#dialog_riga_lista tbody :input').removeClass('textStyle');
     }



     function aggiungi() {

          var select_prodotti = '<div class="default text"></div><div class="menu">';
          var select_metodi_pagamento = '<option value="0" disabled ></option>';


          $.each(record_prodotti, function(key,val) {
               select_prodotti += '<div class="item" data-value="'+val.id_prodotto+'"><span class="description">'+val.barcode+'</span><span class="text" >'+val.nome+'</span></div>';
          });

          $.each(record_metodi_pagamento, function(key,val) {
               select_metodi_pagamento += '<option value="'+val.id_metodo_pagamento+'" >'+val.nome+'</option>';
          });

          var new_row = [
               '<i class="fa fa-times riga_delete" aria-hidden="true"></i>',

               '<div class="ui fluid search selection dropdown"><input type="hidden" id="id_prodotto" name="id_prodotto" ><i class="dropdown icon"></i>'+select_prodotti+'</div>',

               '<input type="number" class="form-control textStyle right-in" id="quantita" name="quantita" step="0.01"  />',

               '<input type="number" class="form-control textStyle right-in" id="c_u" name="c_u" step="0.01"  />',

               '<input type="number" class="form-control textStyle right-in" id="totale" name="totale" step="0.01"  />',

               '<select class="form-control" id="id_metodo_pagamento" name="id_metodo_pagamento" >'+
               select_metodi_pagamento+'</select>'
          ];

          if ($.fn.DataTable.isDataTable('#tab_giornate_righe')) {
               var table = $('#tab_giornate_righe').DataTable();
          } else {
               carica();
               table = $('#tab_giornate_righe').DataTable();
          }

          var added_row = table.row.add(new_row);
          added_row.draw(false);
          indice = added_row.index();


          $('#tab_giornate_righe tbody tr').each(function(){

               $(this).find('td').eq(0).addClass('action_col');
               $(this).find('td').eq(2).addClass('quantita right-in');
               $(this).find('td').eq(3).addClass('right-in');
               $(this).find('td').eq(4).addClass('totale right-in');
               $(this).find('td').eq(5).addClass('metodo_pagamento');
          });

          progressivo_riga++;

          table.rows(indice).nodes().to$().attr("id_riga", 'progressivo_'+progressivo_riga );

          $('.ui.dropdown').dropdown();
     }



$(document).on('change', '#id_prodotto', function(event) {
    //alert( $(this).closest('tr').attr('id_riga') );
    var riga_attuale = $(this).closest('tr').attr('id_riga');
    var id_prodotto = $('[id_riga = '+riga_attuale+']').find('div').children('#id_prodotto').val();

    semina_valori_2('giornate','getC_U',{id_prodotto:id_prodotto},riga_attuale,'',);
});

$(document).on('change', '#quantita', function(event) {
    //alert( $(this).closest('tr').attr('id_riga') );
    var riga_attuale = $(this).closest('tr').attr('id_riga');
    var totale = Math.trunc($(this).val()) * $('[id_riga = '+riga_attuale+']').find('td.right-in').children('input#c_u').val();
    $('[id_riga = '+riga_attuale+']').find('td.totale').children('input#totale').val(totale);

});

$(document).on('change', '#c_u', function(event) {
    //alert( $(this).closest('tr').attr('id_riga') );
    var riga_attuale = $(this).closest('tr').attr('id_riga');
    var totale = $(this).val() * $('[id_riga = '+riga_attuale+']').find('td.quantita').children('input#quantita').val();
    $('[id_riga = '+riga_attuale+']').find('td.totale').children('input#totale').val(totale);

});


     $(document).on('click', '.add_new', function(){
          aggiungi();
     });



     function genera_contenuto(data) {
          var disabled = '';
          if($('#stato').val()==0) {
               disabled = ' disabled ';
          }

          var righe_html = '';

          if(data!==undefined) {

               $.each(data, function(key,val) {

                    if(!$.isEmptyObject(val)) {

                         var select_prodotti = '<div class="default text"></div><div class="menu">';
                         var select_metodi_pagamento = '<option value="0" disabled selected></option>';

                         var oggetto_corrente = {};

                         righe_html += '<tr id_riga="'+val.id_giornata_riga+'" >';


                         righe_html += '<td class="action_col">';
                         if($('#stato').val()!=0) {
                              righe_html += '<i class="fa fa-times riga_delete" aria-hidden="true"></i></td>';
                         }

                         righe_html += '</td>';

                         var selected = '';
                         $.each(record_prodotti, function(key_1,val_1) {
                              if (val.id_prodotto==val_1.id_prodotto) {
                                   selected = val_1.id_prodotto;
                                   oggetto_corrente = record_prodotti[val_1.id_prodotto];
                              }
                              if(val_1.barcode==undefined || val_1.barcode=='') { var barcode=''; } else { var barcode ='('+val_1.barcode+')'; }
                              select_prodotti += '<div class="item" data-value="'+val_1.id_prodotto+'"><span class="description">'+barcode+'</span><span class="text" >'+val_1.nome+'</span></div>';
                         });
                         righe_html += '<td class="" ><div class="ui fluid search selection dropdown '+disabled+'"><input type="hidden" id="id_prodotto" name="id_prodotto" value="'+selected+'" '+disabled+' ><i class="dropdown icon"></i>';
                         righe_html += select_prodotti+'</div></td>';

                         righe_html += '<td class="quantita" ><input type="number" class="form-control textStyle right-in" id="quantita" name="quantita" value="'+val.quantita+'" step="0.01" '+disabled+' /></td>';

                         righe_html += '<td class="c_u" ><input type="number" class="form-control textStyle right-in" id="c_u" name="c_u" value="'+val.c_u+'" step="0.01" '+disabled+' /></td>';

                         righe_html += '<td class="totale right-in" ><input type="number" class="form-control textStyle right-in" id="totale" name="totale" value="'+val.totale+'" step="0.01" '+disabled+'  /></td>';



                         righe_html += '<td class="id_metodo_pagamento" ><select class="form-control textStyle" id="id_metodo_pagamento" name="id_metodo_pagamento" '+disabled+' >';
                         $.each(record_metodi_pagamento, function(key_1,val_1) {
                              var selected = '';
                              if ( val.id_metodo_pagamento == val_1.id_metodo_pagamento ) {
                                   selected = ' selected ';
                              }
                              select_metodi_pagamento += '<option value="'+val_1.id_metodo_pagamento+'" '+selected+' >'+val_1.nome+'</option>';
                         });
                         righe_html += select_metodi_pagamento+'</select></td>';


                         righe_html += '</tr>';
                    }
               });
          }

          if ($.fn.DataTable.isDataTable('#tab_giornate_righe')) {
               $('#tab_giornate_righe').DataTable().destroy();
          }

          $('#tab_giornate_righe tbody').html(righe_html);

          $('.ui.dropdown').dropdown();

          carica();
          calcola();
     }





     // Method to open KIT list dialog
     function openKitListDialog() {

          var ajax_obj = {pag:'giornate', action:'getRighe', redirect:true, wait:true, obj:{ id_giornata:toJSON(id_giornata) }, esegui:function(data) {
               genera_contenuto(data);
          }};
          ajax_call(ajax_obj);
     }






     $(document).on('click', '.riga_delete', function(){
          if (confirm('Confermare l\'eliminazione della riga?')) {
               var id_riga = $(this).closest('tr').attr('id_riga');

               if ( id_riga.indexOf('progressivo')=='-1' ) {
                   var id_location = $( "#id_location" ).val();
                   var id_prodotto = $('[id_riga = '+id_riga+']').find( "#id_prodotto" ).val();
                   var quantita = $('[id_riga = '+id_riga+']').find('td.quantita').children('input#quantita').val();

                   var ajax_obj = {pag:'giornate', action:'deleteRiga', obj:{ id_riga:id_riga, id_location:id_location, id_prodotto:id_prodotto, quantita:quantita}};
                   ajax_call(ajax_obj);

                    var riga = {};
                    riga.id_riga = id_riga;
                    riga.id_giornata = id_giornata;

                    riga_da_eliminare[id_riga]=riga;
               }


              console.log(ajax_obj);

               var table = $('#tab_giornate_righe').DataTable();
               table.row( $('#tab_giornate_righe tbody tr[id_riga="'+id_riga+'"]') ).remove().draw();

               calcola();
          }
     });


     $(document).on('change', '[name="c_u"], [name="quantita"], [name="totale"], [name="id_metodo_pagamento"]', function(){
         calcola();
     });

     $(document).on('change', '[name="c_u"], [name="quantita"]', function(){
         //$('form.form_valori').submit();
     });


     var totale_incasso = parseFloat(0);
     var totale_qta = parseFloat(0);
     var obj_righe = {};
     var errori_righe = false;



     function calcola() {

          totale_incasso = parseFloat(0);
          totale_qta = parseFloat(0);
          errori_righe = false;

          var cnt = 0;
          obj_righe = {};

          $('#tab_giornate_righe tbody tr').each(function() {

               if($(this).find('.dataTables_empty').length>0) { return true; }

               obj_righe[cnt] = {};

               $('#tab_giornate_tot_info tbody').removeClass('hidden');

               var id_prodotto = $(this).find('[name="id_prodotto"]').val();
               var quantita = $(this).find('[name="quantita"]').val();
               var totale = $(this).find('[name="totale"]').val();
               var id_metodo_pagamento = $(this).find('[name="id_metodo_pagamento"]').val();

               if(quantita=='') {
                    quantita = 0;
               }
               if(totale=='') {
                    totale = 0;
               }


               if(!id_prodotto>0 || !quantita>0 || !totale>0 || !id_metodo_pagamento>0) {
                    errori_righe = true;
               }


               obj_righe[cnt].id_prodotto = id_prodotto;
               obj_righe[cnt].quantita = parseFloat(quantita);
               obj_righe[cnt].totale = parseFloat(totale);
               obj_righe[cnt].id_metodo_pagamento = id_metodo_pagamento;


               totale_incasso = parseFloat(totale_incasso)+parseFloat(totale);
               totale_qta = parseFloat(totale_qta)+parseFloat(quantita);


               cnt++;
          });



          $('.totale_incasso').html('€ '+totale_incasso.toFixed(3));
          $('.totale_qta').html(totale_qta.toFixed(2));
     }




