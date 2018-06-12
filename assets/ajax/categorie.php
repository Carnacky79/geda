<?php

error_reporting(E_ALL & ~E_DEPRECATED & ~E_NOTICE & ~E_WARNING);

function carica_classi($class_name) {
     if (is_file('../../libs/lib.' . $class_name . '.php'))
     include '../../libs/lib.' . $class_name . '.php';
}
spl_autoload_register('carica_classi');

session::start();
$categorie = categorie::getCategorieInstance();

switch ($_REQUEST['action']) {



     case 'saveRecord':
     if ( !isset($_REQUEST['valori']) ) { die(json_encode(false)); }

     $valori = json_decode($_REQUEST['valori']);

     $operazione = $categorie->saveRecord($valori);

     die(json_encode($operazione));
     break;

     case 'updateRecord':
     if ( !isset($_REQUEST['valori']) ) { die(json_encode(false)); }

     $valori = json_decode($_REQUEST['valori']);

     $operazione = $categorie->updateRecord($valori);

     die(json_encode($operazione));
     break;


     case 'getRecord':
     if ( !isset($_REQUEST['id_categoria']) ) { die(json_encode(false)); }

     $id_categoria = json_decode($_REQUEST['id_categoria']);

     $operazione = $categorie->getRecord($id_categoria);

     die(json_encode($operazione));
     break;


     case 'deleteRecord':
     if ( !isset($_REQUEST['valori']) ) { die(json_encode(false)); }

     $id_categoria = json_decode($_REQUEST['valori'])->id_categoria;

     $operazione = $categorie->deleteRecord($id_categoria);

     die(json_encode($operazione));
     break;


     default:
     die(json_encode(false));
}
