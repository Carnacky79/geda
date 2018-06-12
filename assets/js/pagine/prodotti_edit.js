
var id_record;

$(document).ready(function(){

     id_record = queryParameters.id_prodotto;

     semina_valori('prodotti','getRecord',{id_prodotto:id_record},'?pagina=prodotti_list',function(){


          $('#image').filer({
               limit: 1,
               maxSize: 3,
               extensions: ['JPG', 'jpg', 'jpeg', 'png', 'PNG', 'JPEG'],
               changeInput: true,
               showThumbs: true,
               addMore: false,
               theme: "default",
               templates:{
                    box:'<ul class="jFiler-items-list jFiler-items-default"></ul>',item:'<li class="jFiler-item"><div class="jFiler-item-container"><div class="jFiler-item-inner"><div class="jFiler-item-icon pull-left">{{fi-icon}}</div><div class="jFiler-item-info pull-left"><div class="jFiler-item-title" title="{{fi-name}}">{{fi-name | limitTo:30}}</div><div class="jFiler-item-others"><div class="jFiler-item-status">{{fi-progressBar}}</div></div><div class="jFiler-item-assets"><ul class="list-inline"><li><a class="icon-jfi-trash jFiler-item-trash-action"></a></li></ul></div></div></div></div></li>',
                    itemAppend:'<li class="jFiler-item"><div class="jFiler-item-container"><div class="jFiler-item-inner"><div class="jFiler-item-icon pull-left">{{fi-icon}}</div><div class="jFiler-item-info pull-left"><div class="jFiler-item-title"><a href="uploads/prodotti/'+id_buyer+'/'+id_record+'/{{fi-name}}" download >{{fi-name | limitTo:35}}</a></div><div class="jFiler-item-assets"><ul class="list-inline"><li><a class="icon-jfi-trash jFiler-item-trash-action"></a></li></ul></div></div></div></div></li>',
                    progressBar:'<div class="bar"></div>',
                    itemAppendToEnd:!1,
                    removeConfirmation:!0,
                    _selectors:{
                         list:".jFiler-items-list",
                         item:".jFiler-item",
                         progressBar:".bar",
                         remove:".jFiler-item-trash-action"
                    }
               },
               uploadFile: {
                    url: "assets/ajax/prodotti.php?action=saveFile",
                    data: { id_prodotto:toJSON(id_record) },
                    type: 'POST',
                    enctype: 'multipart/form-data',
                    beforeSend: function(){},
                    success: function(data, el){
                         var parent = el.find(".jFiler-jProgressBar").parent();
                         el.find(".jFiler-jProgressBar").fadeOut("slow", function(){
                              $("<div class=\"jFiler-item-others text-success\"><i class=\"icon-jfi-check-circle\"></i> Caricato</div>").hide().appendTo(parent).fadeIn("slow");
                         });
                    },
                    error: function(el){
                         var parent = el.find(".jFiler-jProgressBar").parent();
                         el.find(".jFiler-jProgressBar").fadeOut("slow", function(){
                              $("<div class=\"jFiler-item-others text-error\"><i class=\"icon-jfi-minus-circle\"></i> Error</div>").hide().appendTo(parent).fadeIn("slow");
                         });
                    },
                    statusCode: {},
                    onProgress: function(){},
               },
               onRemove : function(e,parent){

                    var ajax_obj = {pag:'prodotti', action:'deleteFile', wait:false, obj:{ path:toJSON(parent.file) }};
                    ajax_call(ajax_obj);
               },
          });

          var ajax_obj = {pag:'prodotti', action:'getFile', redirect:true, wait:true, obj:{ id_prodotto:toJSON(id_record) }, esegui:function(data) {
               if(data.cnt>0) {
                    $('#image').trigger("filer.append", {files:[data.files[0]]});
               }
          }};
          ajax_call(ajax_obj);



          $('#tab_fatture_ddt_fornitori, #tab_fatture_ddt_clienti').DataTable({
               dom: 'ftip', lengthMenu: [[5,10,20], [5,10,20]], pageLength: 5, order: [[1, 'desc']], columnDefs: [{"width": "10%", "sortable": false, "targets": 0}]
          });


          openList();

     });
});



$(document).on('click', '#tab_fatture_ddt_fornitori td.action_col i.editIcon, #tab_fatture_ddt_clienti td.action_col i.editIcon', function(){

     var riga = $(this).closest('tr');
     var type = riga.attr('type');
     if(riga.attr('id_fattura')!==undefined) {
          var id_fattura = riga.attr('id_fattura');
          location.href='?pagina=fatture_edit&id_fattura='+id_fattura+'&type='+type;
     } else {
          var id_ddt = riga.attr('id_ddt');
          location.href='?pagina=ddt_edit&id_ddt='+id_ddt+'&type='+type;
     }
});


function salva_valori() {


     var valori = raccogli_valori();
     valori = toJSON(valori);

     var fornitori_associati = {};

     $('#tab_fornitori_associati tbody tr').each(function() {
          var id_fornitore = $(this).find('#id_fornitore').val();

          console.log(id_fornitore);

          var c_u = $(this).find('#c_u').val();
          fornitori_associati[id_fornitore] = c_u;
     });

     fornitori_associati = toJSON(fornitori_associati);


     var ajax_obj = {pag:'prodotti', action:'updateRecord', redirect:true, wait:true,
     obj:{ valori:valori, fornitori_associati:fornitori_associati },
     esegui:function(data) {
          if(data==='doppio') {
               attenzione('error--Attenzione, il codice prodotto è già presente.');
          } else {
               location.href = '?pagina=prodotti_list';
          }
     }};
     ajax_call(ajax_obj);

}


$(document).on('click', '.form_header .delete_this', function(){

     var valori = raccogli_valori();
     valori = toJSON(valori);

     var ajax_obj = {pag:'prodotti', action:'deleteRecord', redirect:true, wait:true, obj:{ valori:valori }, esegui:function(data) {
          location.href = '?pagina=prodotti_list';
     }};
     ajax_call(ajax_obj);
});



