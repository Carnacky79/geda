

function attenzione(str_messaggi,time,reload) {
     reload = typeof reload  === 'undefined' ? false : reload;

     if ( typeof time !== 'undefined' ) {
          var tim_alert = 3000;
     } else { var tim_alert = 1000; }

     if ( str_messaggi==undefined || str_messaggi==false ) {
          str_messaggi = "error--Attenzione, si è verificato un errore!";
     } else if ( str_messaggi==true ) {
          str_messaggi = "success--Operazione effettuata con successo!";
     }
     localStorage.setItem('str_messaggi',JSON.stringify(str_messaggi));
     localStorage.setItem('reload_messaggi',JSON.stringify(reload));
     crea_messaggi();
}

function crea_messaggi(when) {

     when = typeof when  === 'undefined' ? false : when;

     var str_messaggi = JSON.parse(localStorage.getItem('str_messaggi'));
     var reload_messaggi = JSON.parse(localStorage.getItem('reload_messaggi'));

     var timeout_corto = 4000;
     var timeout_lungo = 10000;

     if ( typeof tim_alert !== 'undefined' ) {
          timeout_corto = tim_alert;
          timeout_lungo = tim_alert;
     }

     var speed = 600;
     if ( when=='load' ) {
          timeout_messaggi = localStorage.getItem('timeout_messaggi');
          localStorage.removeItem('str_messaggi');
          localStorage.removeItem('timeout_messaggi');
          speed = 50;
     }

     var html="";
     var id_messaggio="";

     str_messaggi = str_messaggi.split('----');

     $('#messaggi_popup #messaggi_wrapper').html('');

     var cnr_msg = 0;
     $.each(str_messaggi, function(key, val) {

          cnr_msg++;

          var messaggio = val.split('--');

          if ( messaggio.length==2 ) {
               var tipo = messaggio[0];
               var testo = messaggio[1];

               html="";
               id_messaggio = "messaggio_"+cnr_msg;

               if ( tipo=='success' ) {
                    html = "<div id=\""+id_messaggio+"\" class=\"messaggio alert alert-success\" role=\"alert\">\
                    <i class=\"fa fa-check-circle\" aria-hidden=\"true\"></i><span>"+testo+"</span>\
                    </div>";
               } else if ( tipo=='info' ) {
                    html = "<div id=\""+id_messaggio+"\" class=\"messaggio alert alert-info\" role=\"alert\">\
                    <i class=\"fa fa-info-circle\" aria-hidden=\"true\"></i><span>"+testo+"</span>\
                    </div>";
               } else if ( tipo=='warning' ) {
                    html = "<div id=\""+id_messaggio+"\" class=\"messaggio alert alert-warning\" role=\"alert\">\
                    <i class=\"fa fa-exclamation-triangle\" aria-hidden=\"true\"></i><span>"+testo+"</span>\
                    </div>";
               } else if ( tipo=='reload' ) {
                    html = "<div id=\""+id_messaggio+"\" class=\"messaggio alert alert-warning\" role=\"alert\">\
                    <i class=\"fa fa-refresh fa-spin fa-3x fa-fw\" aria-hidden=\"true\"></i><span>"+testo+"</span>\
                    </div>";
               } else if ( tipo=='error' ) {
                    html = "<div id=\""+id_messaggio+"\" class=\"messaggio alert alert-danger\" role=\"alert\">\
                    <i class=\"fa fa-ban\" aria-hidden=\"true\"></i><span>"+testo+"</span>\
                    </div>";
               }

               if ( tipo=='error' && when!='load' ) {
                    localStorage.setItem('timeout_messaggi',timeout_lungo);
                    timeout_messaggi=timeout_lungo;
               } else if ( tipo!='error' && when!='load' ) {
                    localStorage.setItem('timeout_messaggi',timeout_corto);
                    timeout_messaggi=timeout_corto;
               }

               if ( reload_messaggi==false ) {
                    if ( when!='load' || ( when=='load' && tipo!='error') ) {
                         $('#messaggi_popup #messaggi_wrapper').append(html);
                         $('#messaggi_popup #'+id_messaggio).fadeIn();
                    }
               }
               messaggiSetTimeout(id_messaggio,timeout_messaggi,reload_messaggi);
               messaggiSetInterval(timeout_messaggi);
          }
     });

     if ( when!='load' ) {
          if ( reload_messaggi==true ) {
               localStorage.setItem('reload_messaggi',JSON.stringify(false));
               location.reload();
          } else if ( reload_messaggi!=false ) {
               localStorage.setItem('reload_messaggi',JSON.stringify(false));
               location.href=reload_messaggi;
          } else {
               spinner('stop');
          }
     }
}


function messaggiSetTimeout(id_messaggio,timeout_messaggi,reload_messaggi) {
     setTimeout(function() {
          $('#messaggi_popup #'+id_messaggio).fadeOut(function(){
               $('#messaggi_popup #'+id_messaggio).remove();
               localStorage.removeItem('str_messaggi');
          });
     }, timeout_messaggi);
}

function messaggiSetInterval(timeout_messaggi) {
     var timeout = timeout_messaggi;
     setInterval(function(){
          timeout = parseInt(timeout-1);
          localStorage.setItem('timeout_messaggi',timeout);
     },1000);
}


$( document ).on( 'click', '#messaggi_popup .messaggio', function () {
     $(this).fadeOut(function(){
          $(this).remove();
     });
});


if ( localStorage.getItem('str_messaggi')!=undefined ) {
     crea_messaggi('load');
}


function spinner(action){
     var action = action || '';
     if ( action=='start') {  $('#loading_layer').css('display','table'); }
     else if ( action=='stop') {  $('#loading_layer').css('display','none'); }
}

