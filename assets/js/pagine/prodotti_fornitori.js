
var record_fornitori = fromJSON($('#record_fornitori').html());
var columnDefs = [
     {"width": "6%", "targets": 0},
     {"width": "10%", "targets": 2},
];

function aggiungi() {

     console.log(record_fornitori);

     var select_fornitori = '<div class="default text"></div><div class="menu">';

     $.each(record_fornitori, function(key,val) {
          select_fornitori += '<div class="item" data-value="'+val.id_fornitore+'"><span class="text" >'+val.nome+'</span></div>';
     });

     var new_row = [
          '<i class="fa fa-times riga_delete" aria-hidden="true"></i>',

          '<div class="ui fluid search selection dropdown"><input type="hidden" id="id_fornitore" name="id_fornitore" ><i class="dropdown icon"></i>'+
          select_fornitori+'</div>',
          '<input type="number" class="form-control" id="c_u" name="c_u" />'
     ];

     if ($.fn.DataTable.isDataTable('#tab_fornitori_associati')) {
          var table = $('#tab_fornitori_associati').DataTable();
     } else {
          carica();
          table = $('#tab_fornitori_associati').DataTable();
     }

     var added_row = table.row.add(new_row);
     added_row.draw(false);
     indice = added_row.index();


     $('#tab_fornitori_associati tbody tr').each(function(){
          $(this).find('td').eq(0).addClass('action_col');
          $(this).find('td').eq(2).addClass('c_u');
     });

     $('.ui.dropdown').dropdown();
}



$(document).on('click', '.add_new', function(){
     aggiungi();
});


function carica() {

     $('#tab_fornitori_associati').DataTable().destroy();

     $('#tab_fornitori_associati').DataTable({
          paging: false, autoWidth: false, columnDefs: columnDefs, dom: 't', ordering: false, pageLength: 50
     });
}



function genera_contenuto(data) {

     var righe_html = '';

     if(data!==undefined) {

          $.each(data, function(key,val) {

               if(!$.isEmptyObject(val)) {

                    var select_fornitori = '<div class="default text"></div><div class="menu">';

                    righe_html += '<tr>';
                    righe_html += '<td class="action_col"><i class="fa fa-times riga_delete" aria-hidden="true"></i></td>';


                    var selected = '';

                    $.each(record_fornitori, function(key_1,val_1) {
                         if ( val.id_fornitore==val_1.id_fornitore ) {
                              selected = val_1.id_fornitore;
                         }
                         select_fornitori += '<div class="item" data-value="'+val_1.id_fornitore+'"><span class="text" >'+val_1.nome+'</span></div>';
                    });

                    righe_html += '<td class="" ><div class="ui fluid search selection dropdown"><input type="hidden" id="id_fornitore" name="id_fornitore" value="'+selected+'" ><i class="dropdown icon"></i>';
                    righe_html += select_fornitori+'</div></td>';

                    righe_html += '<td class="c_u" ><input type="number" class="form-control textStyle right-in" id="c_u" name="c_u" value="'+val.c_u+'" /></td>';

                    righe_html += '</tr>';
               }
          });
     }

     if ($.fn.DataTable.isDataTable('#tab_fornitori_associati')) {
          $('#tab_fornitori_associati').DataTable().destroy();
     }

     $('#tab_fornitori_associati tbody').html(righe_html);

     $('.ui.dropdown').dropdown();

     carica();
}


function openList() {

     var ajax_obj = {pag:'prodotti', action:'getFornitoriAssociati', redirect:false, wait:false, obj:{ id_prodotto:toJSON(id_record) }, esegui:function(data) {
          genera_contenuto(data);
     }};
     ajax_call(ajax_obj);
}



$(document).on('click', '.riga_delete', function(){

     if (confirm('Confermare l\'eliminazione della riga?')) {
          var riga = $(this).closest('tr');

          var table = $('#tab_fornitori_associati').DataTable();
          table.row( riga ).remove().draw();
     }
});


