<?php

error_reporting(E_ALL & ~E_DEPRECATED & ~E_NOTICE & ~E_WARNING);

function carica_classi($class_name) {
     if (is_file('../../libs/lib.' . $class_name . '.php'))
     include '../../libs/lib.' . $class_name . '.php';
}
spl_autoload_register('carica_classi');

session::start();
$iva = iva::getIvaInstance();

switch ($_REQUEST['action']) {


     case 'saveRecord':
     if ( !isset($_REQUEST['valori']) ) { die(json_encode(false)); }

     $valori = json_decode($_REQUEST['valori']);

     $operazione = $iva->saveRecord($valori);

     die(json_encode($operazione));
     break;

     case 'updateRecord':
     if ( !isset($_REQUEST['valori']) ) { die(json_encode(false)); }

     $valori = json_decode($_REQUEST['valori']);

     $operazione = $iva->updateRecord($valori);

     die(json_encode($operazione));
     break;


     case 'getRecord':
     if ( !isset($_REQUEST['id_iva']) ) { die(json_encode(false)); }

     $id_iva = json_decode($_REQUEST['id_iva']);

     $operazione = $iva->getRecord($id_iva);

     die(json_encode($operazione));
     break;


     case 'deleteRecord':
     if ( !isset($_REQUEST['valori']) ) { die(json_encode(false)); }

     $id_iva = json_decode($_REQUEST['valori'])->id_iva;

     $operazione = $iva->deleteRecord($id_iva);

     die(json_encode($operazione));
     break;




     default:
     die(json_encode(false));
}
