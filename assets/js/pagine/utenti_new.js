

$(document).ready(function(){

});


function salva_valori() {


     var valori = raccogli_valori();
     valori = toJSON(valori);


     var ajax_obj = {pag:'utenti', action:'saveRecord', redirect:true, wait:true, obj:{ valori:valori }, esegui:function(data) {
          // location.href = '?pagina=utenti_edit&id_utente='+data;
          location.href = '?pagina=utenti_list';
     }};
     ajax_call(ajax_obj);

}

$(document).on('change','#id_livello',function(){
     var livello = $(this).val();
     if(livello==1) {
          $('#id_location').prop('disabled', true).val('').removeAttr('data-parsley-required').parsley().reset();
          $('#id_location').parent().removeAttr('required');
     } else {
          $('#id_location').prop('disabled', false).val('').attr('data-parsley-required', true);
          $('#id_location').parent().attr('required', true);
     }
});