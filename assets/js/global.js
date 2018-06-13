
var queryParameters = {}, queryString = location.search.substring(1), re = /([^&=]+)=([^&]*)/g, m;
while (m = re.exec(queryString)) {
     queryParameters[decodeURIComponent(m[1])] = decodeURIComponent(m[2]);
}

$(this).on('touchmove', function (event) {
     if (event.originalEvent.scale !== 1) {
          event.preventDefault();
          event.stopPropagation();
     }
});

var id_buyer = $('#id_buyer').val();

$( document ).ready(function() {

     $( "#loading_layer" ).hide();

     $(document).on('keyup keydown keypress mousedown mouseup dblclick','.like-text',function(e){
          e.preventDefault();
          e.stopPropagation();
          return;
     });
});


function errorHandler() {
     location.href='?pagina=home';
}


$(document).on('click',' .save_this ',function () {
     $('.form_valori').submit();
});





function valida_form(elemento) {
     var tutto_corretto = true;
     elemento.find('input,select,textarea').each(function(){
          var richiede_controllo = false;
          $.each(this.attributes, function() {
               if(this.specified && this.name.indexOf('data-parsley')!='-1' ) {
                    richiede_controllo = true;
               }
          });
          if ( richiede_controllo ) {
               if ($(this).parsley({
                    errorsContainer: function (el) {
                         return el.$element.closest(".level4");
                    }
               }).validate() !== true) { tutto_corretto=false; }
          }
     });
     return tutto_corretto;
}

function reset_form_validation(elemento) {
     elemento.find('input,select,textarea').each(function(){
          var richiede_controllo = false;
          $.each(this.attributes, function() {
               if(this.specified && this.name.indexOf('data-parsley')!='-1' ) {
                    richiede_controllo = true;
               }
          });
          if ( richiede_controllo ) {
               $(this).parsley().reset();
          }
     });
}



if ( $('.form_valori').length>0 ) { $('.form_valori').parsley({
     errorsContainer: function (el) {
          return el.$element.closest(".level4");
     }
}); }


function timeToSeconds(time){

     if ( time==0 || time=='' ) { return 0; }

     time = time.split(':');

     if ( time[0]==undefined || time[1]==undefined ) { return 0; }

     var seconds = (+time[0]) * 60 * 60 + (+time[1]) * 60;

     return seconds;
}



$(document).on('keydown','[type="number"], [data-parsley-type="number"] ',function (event) {
     //console.log(event.which);
     if ( $.inArray(event.which,[96, 97, 98, 99, 100, 101, 102, 103, 104, 105, 110, 46])=='-1' ) {
          if ( ( $.inArray(event.which,[8,46,37,39,38,40])=='-1' && isNaN(String.fromCharCode(event.which)) && event.which!=190 ) || $.inArray(event.which,[ 69 ])!='-1' || event.key==':' ){
               event.preventDefault();
          }
     }
});

$(document).on('keydown','[data-parsley-type="integer"]',function (event) {
     //console.log(event.which);
     if ( $.inArray(event.which,[96, 97, 98, 99, 100, 101, 102, 103, 104, 105, 46])=='-1' ) {
          if ( ( $.inArray(event.which,[8,46,37,39,38,40])=='-1' && isNaN(String.fromCharCode(event.which)) ) || $.inArray(event.which,[ 69 ])!='-1' || event.key==':' ){
               event.preventDefault();
          }
     }
});

$(document).on('keydown','input[maxlength]',function (event) {
     //console.log(event.which);
     if ( $.inArray(event.which,[8,46,37,39,38,40])=='-1' ) {
          if ( $(this).val().length==$(this).attr('maxlength') ) { event.preventDefault(); }
     }
});
$(document).on('keydown','input[data-parsley-maxlength]',function (event) {
     //console.log(event.which);
     if ( $.inArray(event.which,[8,46,37,39,38,40])=='-1' ) {
          if ( $(this).val().length==$(this).attr('data-parsley-maxlength') ) { event.preventDefault(); }
     }
});



//////////////////////////////////////////////////////////////////////////////////////////////

$("input").bind("keypress", function(e) { if (e.keyCode == 13) { return false; } });


function clickIE() {if (document.all) {return ''; return false;}}
function clickNS(e) {
     if (document.layers||(document.getElementById&&!document.all)) {
          if (e.which==2||e.which==3) {return ''; return false;}
     }
}
if (document.layers) {
     document.captureEvents(Event.MOUSEDOWN);document.onmousedown=clickNS;
}
else{
     document.onmouseup=clickNS;document.oncontextmenu=clickIE;
}



/*
*
*   JAVASCRIPT.PHP
*
*/

var key_interval;
var code_arr = [ 34,92 ];
$(document).keypress(function(e) {  var code = e.keyCode || e.which;  if ( $.inArray( code, code_arr )!='-1' ) { return false; } });

















function raccogli_valori(elemento) {

     if ( elemento==undefined || elemento=='' || elemento==null ) {
          elemento = '.form_valori';
     }

     var obj = {};

     $(elemento+' input[type="text"]').each(function() {
          var key = $(this).attr('name');
          var val = $(this).val();

          if ( $(this).hasClass('datepicker') || $(this).hasClass('date') ) {
               var array = val.split(' ');
               val = array[0].split('/');
               if ( val.length==3 ) {
                    val = val[2]+'-'+val[1]+'-'+val[0];
                    if (array[1]!=undefined) {
                         val = val+' '+array[1];
                    }
               }
               else {
                    val = '';
               }
          }
          obj[key] = val;
     });

     $(elemento+' input[type="number"]').each(function() {
          var key = $(this).attr('name');
          var val = $(this).val();
          obj[key] = val;
     });

     $(elemento+' input[type="hidden"]').each(function() {
          var key = $(this).attr('name');
          var val = $(this).val();
          obj[key] = val;
     });

     $(elemento+' input[type="email"]').each(function() {
          var key = $(this).attr('name');
          var val = $(this).val();
          obj[key] = val;
     });

     $(elemento+' input[type="password"]').each(function() {
          var key = $(this).attr('name');
          var val = $(this).val();
          obj[key] = val;
     });

     $(elemento+' input[type="date"]').each(function() {
          var key = $(this).attr('name');
          var val = $(this).val();
          obj[key] = val;
     });

     $(elemento+' input[type="checkbox"]').each(function() {
          var key = $(this).attr('name');
          var val = 0;
          if ( $(this).prop('checked')==true ) { val=1; } else { val=0; }
          obj[key] = val;
     });

     $(elemento+' input[type="radio"]').each(function() {
          var key = $(this).attr('name');
          if ( $(elemento+' input[type="radio"][name="'+key+'"]:checked') ) {
               var val = $(elemento+' input[type="radio"][name="'+key+'"]:checked').val();
               obj[key] = val;
          }
     });

     $(elemento+' textarea').each(function() {
          var key = $(this).attr('name');
          var val = $(this).val();
          obj[key] = val;
     });

     $(elemento+' select').each(function() {
          var key = $(this).attr('name');
          var val = $(this).val();
          obj[key] = val;
     });

     return obj;
}


function semina_valori(pag,action,obj,back,callback) {

     var valori = {};

     var ajax_obj = {pag:pag, action:action, wait:false, backError:false, obj:obj, esegui:function(data) {
          $.each(data,function(key,val){
               if( $('.form_valori #'+key+':input:not([type="radio"]):not([type="checkbox"])').length>0) {

                    var input = $('.form_valori #'+key+':input');

                    if(input.hasClass('date')) {
                         val = val.split('-').reverse().join('/');
                    }

                    if(val==undefined || val===false) {
                         return true;
                    }

                    input.val(val);

               } else if( $('.form_valori #'+key+':input[type="radio"]').length>0) {

                    $('.form_valori #'+key+':input[type="radio"][value="'+val+'"]').prop('checked',true);

               } else if( $('.form_valori #'+key+'[type="checkbox"]').length>0) {

                    if(val==1) {
                         $('.form_valori #'+key+':input[type="checkbox"]').prop('checked',true);
                    } else {
                         $('.form_valori #'+key+':input[type="checkbox"]').prop('checked',false);
                    }
               }
          });

          if(callback!=undefined && callback!=false) {
               callback();
          }
     }};
     ajax_call(ajax_obj);
}




function toJSON(variabile){
     return JSON.stringify(variabile);
}

function fromJSON(variabile){
     return JSON.parse(variabile);
}

function is_true(valore){
     if ( valore!==undefined && valore!==null && valore!==false && valore.toString().indexOf('false')=='-1' ) { return true; } else { return false; }
}



function ajax_call(oggetto) {

     if(
          (oggetto.pag!=undefined && oggetto.pag!='' && oggetto.pag!=null)
          &&
          (oggetto.action!=undefined && oggetto.action!='' && oggetto.action!=null)
          &&
          (oggetto.obj!=undefined && oggetto.obj!=null && $.isPlainObject(oggetto.obj) && $.isEmptyObject(oggetto.obj)===false)
     ) {

          if(oggetto.headers=='' || oggetto.headers==undefined || oggetto.headers==null || oggetto.headers==false) { oggetto.headers={}; }

          if(oggetto.dataType=='' || oggetto.dataType==undefined || oggetto.dataType==null || oggetto.dataType==false) { oggetto.dataType='json'; }




          if(oggetto.log=='' || oggetto.log==undefined || oggetto.log==null) { oggetto.log=false; }
          if(oggetto.wait=='' || oggetto.wait==undefined || oggetto.wait==null) { oggetto.wait=true; }
          if(oggetto.redirect=='' || oggetto.redirect==undefined || oggetto.redirect==null) { oggetto.redirect=false; }
          if(oggetto.backError=='' || oggetto.backError==undefined || oggetto.backError==null) { oggetto.backError=false; }
          if(oggetto.esegui=='' || oggetto.esegui==undefined || oggetto.esegui==null || oggetto.esegui==false) { oggetto.esegui=function(){}; }


          if(oggetto.dataType=='none') {

               $.ajax ({
                    beforeSend: function() { if(oggetto.wait===true) { spinner('start'); beforeSave(); } },
                    complete: function() {
                         if(oggetto.wait===true) { afterSave(); } if(oggetto.redirect===false) { spinner('stop'); } },
                         type: 'POST',
                         headers: oggetto.headers,
                         url: 'assets/ajax/'+oggetto.pag+'.php?action='+oggetto.action,
                         data: oggetto.obj,
                         success:function(data){ if(oggetto.log===true) { console.log(data); }

                         if(is_true(data))
                         {
                              oggetto.esegui(data);
                         }
                         else { if(oggetto.log===true) { console.log(data); } attenzione(); if(oggetto.backError===true) { errorHandler(); } }
                    },
                    error:function(error){ if(oggetto.log===true) { console.log(error); } attenzione(); if(oggetto.backError===true) { errorHandler(); } }
               });

          } else {

               $.ajax ({
                    beforeSend: function() { if(oggetto.wait===true) { spinner('start'); beforeSave(); } },
                    complete: function() {
                         if(oggetto.wait===true) { afterSave(); } if(oggetto.redirect===false) { spinner('stop'); } },
                         type: 'POST',
                         dataType: oggetto.dataType,
                         headers: oggetto.headers,
                         url: 'assets/ajax/'+oggetto.pag+'.php?action='+oggetto.action,
                         data: oggetto.obj,
                         success:function(data){ if(oggetto.log===true) { console.log(data); }

                         if(is_true(data))
                         {
                              oggetto.esegui(data);
                         }
                         else { if(oggetto.log===true) { console.log(data); } attenzione(); if(oggetto.backError===true) { errorHandler(); } }
                    },
                    error:function(error){ if(oggetto.log===true) { console.log(error); } attenzione(); if(oggetto.backError===true) { errorHandler(); } }
               });

          }
     }
}




function beforeSave() {
     $('body').css('pointer-events','none');
}
function afterSave() {
     $('body').css('pointer-events','auto');
}

function getParameterByName(name, url) {
    if (!url) url = window.location.href;
    name = name.replace(/[\[\]]/g, "\\$&");
    var regex = new RegExp("[?&]" + name + "(=([^&#]*)|&|#|$)"),
        results = regex.exec(url);
    if (!results) return null;
    if (!results[2]) return '';
    return decodeURIComponent(results[2].replace(/\+/g, " "));
}




