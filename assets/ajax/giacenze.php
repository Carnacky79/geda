<?php

error_reporting(E_ALL & ~E_DEPRECATED & ~E_NOTICE & ~E_WARNING);

function carica_classi($class_name) {
     if (is_file('../../libs/lib.' . $class_name . '.php'))
     include '../../libs/lib.' . $class_name . '.php';
}
spl_autoload_register('carica_classi');

session::start();
$giacenze = giacenze::getGiacenzeInstance();

switch ($_REQUEST['action']) {


     case 'updateRecord':
     if ( !isset($_REQUEST['valori']) ) { die(json_encode(false)); }

     $valori = json_decode($_REQUEST['valori']);


     $operazione = $giacenze->editRecord($valori->id_prodotto,$valori->qta_residua);


     die(json_encode($operazione));
     break;



     default:
     die(json_encode(false));
}
