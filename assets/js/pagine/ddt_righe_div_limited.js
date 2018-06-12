
var record_oggetti = [];
var record_iva = fromJSON($('#record_iva').html());

var progressivo_riga = 0;
var riga_da_eliminare = {};
var columnDefs = [
     {"width": "6%", "targets": 0},
     {"width": "10%", "targets": 2}
];


function carica_oggetti() {

     if(tipologia==0) {
          var id = $('#id_fornitore').val();
     } else {
          var id = 0; //propri
     }

     record_oggetti = [];

     $.each( fromJSON($('#record_oggetti').html()), function(key,val) {
          if(val.id_fornitore==id || id==0) {
               record_oggetti.push(val);
          }
     });
}



function carica() {

     $('#tab_ddt_righe').DataTable().destroy();

     $('#tab_ddt_righe').DataTable({
          paging: false, autoWidth: false, columnDefs: columnDefs, dom: 't', ordering: false, pageLength: 50
     });

     $('#dialog_riga_lista tbody :input').removeClass('textStyle');
}



function genera_contenuto(data) {

     var righe_html = '';

     if(data!==undefined) {

          $.each(data, function(key,val) {

               if(!$.isEmptyObject(val)) {

                    var select_oggetti = '<div class="default text"></div><div class="menu">';
                    var select_iva = '<option valore="0" disabled selected></option>';

                    var oggetto_corrente = {};

                    righe_html += '<tr id_riga="'+val.id_ddt_riga+'" >';

                    righe_html += '<td class="action_col"></td>';


                    var selected = '';

                    $.each(record_oggetti, function(key_1,val_1) {

                         if ( (val.id_servizio==val_1.id_oggetto && val_1.id_categoria_tipologia==2) || (val.id_prodotto==val_1.id_oggetto && val_1.id_categoria_tipologia==1) ) {
                              selected = val_1.id_categoria_tipologia+'_'+val_1.id_oggetto;
                              oggetto_corrente = record_oggetti[val_1.id_oggetto];
                         }
                         if(val_1.barcode==undefined || val_1.barcode=='') {val_1.barcode='';} else { val_1.barcode='('+val_1.barcode+')'; }
                         select_oggetti += '<div class="item" data-value="'+val_1.id_categoria_tipologia+'_'+val_1.id_oggetto+'"><span class="description">'+val_1.barcode+'</span><span class="text" >'+val_1.nome+'</span></div>';
                    });

                    righe_html += '<td class="" ><div class="ui disabled fluid search selection dropdown"><input type="hidden" id="id_oggetto" name="id_oggetto" value="'+selected+'" ><i class="dropdown icon"></i>';

                    righe_html += select_oggetti+'</div></td>';


                    if(tipologia==1) {
                         righe_html += '<td class="quantita" ><input type="number" class="form-control textStyle right-in" id="quantita" name="quantita" value="'+val.quantita+'" step="0.01" disabled /></td>';
                    } else {
                         righe_html += '<td class="quantita" ><input type="number" class="form-control textStyle right-in" id="quantita" name="quantita" value="'+val.quantita+'" step="0.01" disabled /></td>';
                    }

                    righe_html += '</tr>';
               }
          });
     }

     if ($.fn.DataTable.isDataTable('#tab_ddt_righe')) {
          $('#tab_ddt_righe').DataTable().destroy();
     }

     $('#tab_ddt_righe tbody').html(righe_html);

     $('.ui.dropdown').dropdown();

     carica();
}




// Method to open KIT list dialog
function openKitListDialog() {

     var ajax_obj = {pag:'ddt', action:'getRighe', redirect:true, wait:true, obj:{ id_ddt:toJSON(id_ddt) }, esegui:function(data) {
          genera_contenuto(data);
     }};
     ajax_call(ajax_obj);
}


