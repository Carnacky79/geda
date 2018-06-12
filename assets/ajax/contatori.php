<?php

error_reporting(E_ALL & ~E_DEPRECATED & ~E_NOTICE & ~E_WARNING);

function carica_classi($class_name) {
     if (is_file('../../libs/lib.' . $class_name . '.php'))
     include '../../libs/lib.' . $class_name . '.php';
}
spl_autoload_register('carica_classi');

session::start();
$contatori = contatori::getContatoriInstance();

switch ($_REQUEST['action']) {



     case 'getRecord':
     if ( !isset($_REQUEST['nome'],$_REQUEST['anno']) ) { die(json_encode(false)); }

     $nome = json_decode($_REQUEST['nome']);
     $anno = json_decode($_REQUEST['anno']);

     $operazione = $contatori->getRecord($nome,$anno);

     die(json_encode($operazione));
     break;


     case 'plusRecord':
     if ( !isset($_REQUEST['id_contatore']) ) { die(json_encode(false)); }
     $id_contatore = json_decode($_REQUEST['id_contatore']);
     $operazione = $contatori->plusRecord(false,false,$id_contatore);
     die(json_encode($operazione));
     break;


     case 'minusRecord':
     if ( !isset($_REQUEST['id_contatore']) ) { die(json_encode(false)); }
     $id_contatore = json_decode($_REQUEST['id_contatore']);
     $operazione = $contatori->minusRecord(false,false,$id_contatore);
     die(json_encode($operazione));
     break;





     default:
     die(json_encode(false));
}
