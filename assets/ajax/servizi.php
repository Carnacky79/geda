<?php

error_reporting(E_ALL & ~E_DEPRECATED & ~E_NOTICE & ~E_WARNING);

function carica_classi($class_name) {
     if (is_file('../../libs/lib.' . $class_name . '.php'))
     include '../../libs/lib.' . $class_name . '.php';
}
spl_autoload_register('carica_classi');

session::start();
$servizi = servizi::getServiziInstance();

switch ($_REQUEST['action']) {

     case 'saveFile':
     if ( !isset($_REQUEST['id_servizio'],$_FILES) ) { die(json_encode(false)); }

     $id_servizio = json_decode($_REQUEST['id_servizio']);
     $file = $_FILES;

     $operazione = $servizi->saveFile($id_servizio,$file);

     die(json_encode($operazione));
     break;



     case 'saveRecord':
     if ( !isset($_REQUEST['valori']) ) { die(json_encode(false)); }

     $valori = json_decode($_REQUEST['valori']);

     $operazione = $servizi->saveRecord($valori);

     die(json_encode($operazione));
     break;

     case 'updateRecord':
     if ( !isset($_REQUEST['valori']) ) { die(json_encode(false)); }

     $valori = json_decode($_REQUEST['valori']);

     $operazione = $servizi->updateRecord($valori);

     die(json_encode($operazione));
     break;


     case 'getFile':
     if ( !isset($_REQUEST['id_servizio']) ) { die(json_encode(false)); }

     $id_servizio = json_decode($_REQUEST['id_servizio']);

     $operazione = $servizi->getFile($id_servizio);

     die(json_encode($operazione));
     break;



     case 'deleteFile':
     if ( !isset($_REQUEST['path']) ) { die(json_encode(false)); }

     $path = json_decode($_REQUEST['path']);

     $operazione = $servizi->deleteFile($path);

     die(json_encode($operazione));
     break;



     case 'getRecord':
     if ( !isset($_REQUEST['id_servizio']) ) { die(json_encode(false)); }

     $id_servizio = json_decode($_REQUEST['id_servizio']);

     $operazione = $servizi->getRecord($id_servizio);

     die(json_encode($operazione));
     break;


     case 'deleteRecord':
     if ( !isset($_REQUEST['valori']) ) { die(json_encode(false)); }

     $id_servizio = json_decode($_REQUEST['valori'])->id_servizio;

     $operazione = $servizi->deleteRecord($id_servizio);

     die(json_encode($operazione));
     break;




     default:
     die(json_encode(false));
}
