
var id_record = 0;
var id_ddt = 0;
var tipologia = 0;


$(document).on('click', '.form_header .close_this', function(){

     if(confirm("Confermare la chiusura del documento corrente?")) {

          var valori = raccogli_valori();
          valori = toJSON(valori);

          var ajax_obj = {pag:'ddt', action:'closeRecord', redirect:true, wait:true, obj:{ valori:valori }, esegui:function(data) {
               location.href = '?pagina=ddt_list';
          }};
          ajax_call(ajax_obj);
     }
});


$(document).on('click', '.form_header .export_this', function(){

     var ajax_obj = {pag:'ddt', dataType:'none', action:'exportRecord', redirect:false, wait:true, obj:{ id_ddt:toJSON(id_ddt) }, esegui:function(data) {

          data = fromJSON(data);
          var nome_file = data.nome;
          var dati_file = data.file;

          var dlnk = document.getElementById('exportA');

          var res = dati_file.split('"')[dati_file.split('"').length-1];
          res = res.replace(/(\r\n|\n|\r)/gm,"");

          dlnk.href = 'data:application/pdf;base64,'+res;
          dlnk.download = nome_file;
          dlnk.click();

     }, headers:{
          Accept: 'application/octet-stream',
     }};
     ajax_call(ajax_obj);
});



$(document).ready(function(){

     id_ddt = id_record = queryParameters.id_ddt;
     tipologia = queryParameters.type;


     if(tipologia==0) {
          $('#id_fornitore').attr('data-parsley-required',true).parents('.form-group').removeClass('hidden');
          $('.export_this').addClass('hidden');
     }
     if(tipologia==1) {
          $('#id_cliente').attr('data-parsley-required',true).parents('.form-group').removeClass('hidden');
     }


     semina_valori('ddt','getRecord',{id_ddt:id_record},false, function() {
          openKitListDialog();
          carica_oggetti();
     });

});



