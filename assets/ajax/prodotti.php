<?php

error_reporting(E_ALL & ~E_DEPRECATED & ~E_NOTICE & ~E_WARNING);

function carica_classi($class_name) {
     if (is_file('../../libs/lib.' . $class_name . '.php'))
     include '../../libs/lib.' . $class_name . '.php';
}
spl_autoload_register('carica_classi');

session::start();
$prodotti = prodotti::getProdottiInstance();

switch ($_REQUEST['action']) {

     case 'saveFile':
     if ( !isset($_REQUEST['id_prodotto'],$_FILES) ) { die(json_encode(false)); }

     $id_prodotto = json_decode($_REQUEST['id_prodotto']);
     $file = $_FILES;

     $operazione = $prodotti->saveFile($id_prodotto,$file);

     die(json_encode($operazione));
     break;



     case 'saveRecord':
     if ( !isset($_REQUEST['valori']) ) { die(json_encode(false)); }

     $valori = json_decode($_REQUEST['valori']);

     $operazione = $prodotti->saveRecord($valori);

     die(json_encode($operazione));
     break;

     case 'updateRecord':
     if ( !isset($_REQUEST['valori'],$_REQUEST['fornitori_associati']) ) { die(json_encode(false)); }

     $valori = json_decode($_REQUEST['valori']);
     $fornitori_associati = json_decode($_REQUEST['fornitori_associati']);

     $operazione = $prodotti->updateRecord($valori);
     if($operazione===false) {die(json_encode(false));}

     $operazione = $prodotti->updateFornitoriAssociati($valori->id_prodotto, $fornitori_associati);

     die(json_encode($operazione));
     break;


     case 'getFile':
     if ( !isset($_REQUEST['id_prodotto']) ) { die(json_encode(false)); }

     $id_prodotto = json_decode($_REQUEST['id_prodotto']);

     $operazione = $prodotti->getFile($id_prodotto);

     die(json_encode($operazione));
     break;



     case 'deleteFile':
     if ( !isset($_REQUEST['path']) ) { die(json_encode(false)); }

     $path = json_decode($_REQUEST['path']);

     $operazione = $prodotti->deleteFile($path);

     die(json_encode($operazione));
     break;



     case 'getRecord':
     if ( !isset($_REQUEST['id_prodotto']) ) { die(json_encode(false)); }

     $id_prodotto = json_decode($_REQUEST['id_prodotto']);

     $operazione = $prodotti->getRecord($id_prodotto);

     die(json_encode($operazione));
     break;

     case 'getFornitoriAssociati':
     if ( !isset($_REQUEST['id_prodotto']) ) { die(json_encode(false)); }

     $id_prodotto = json_decode($_REQUEST['id_prodotto']);

     $operazione = $prodotti->getFornitoriAssociati($id_prodotto);

     die(json_encode($operazione));
     break;


     case 'deleteRecord':
     if ( !isset($_REQUEST['valori']) ) { die(json_encode(false)); }

     $id_prodotto = json_decode($_REQUEST['valori'])->id_prodotto;

     $operazione = $prodotti->deleteRecord($id_prodotto);

     die(json_encode($operazione));
     break;

    case 'getRecordByLocation':
        $dati_utente = session::getvalue('dati_utente');
        if ( !isset($_REQUEST['id_prodotto']) ) { die(json_encode(false)); }
        if ( !isset($dati_utente->id_location) ) { die(json_encode(false)); }

        $id_prodotto = json_decode($_REQUEST['id_prodotto']);
        $id_location = $dati_utente->id_location;

        $operazione = $prodotti->getRecordByLocation( $id_prodotto, $id_location);

        die(json_encode($operazione));
    break;



     default:
     die(json_encode(false));
}
