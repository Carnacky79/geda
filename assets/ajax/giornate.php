<?php

error_reporting(E_ALL & ~E_DEPRECATED & ~E_NOTICE & ~E_WARNING);


function carica_classi($class_name) {
     if (is_file('../../libs/lib.' . $class_name . '.php'))
     include '../../libs/lib.' . $class_name . '.php';

     if (is_file('../../libs/tcpdf/' . $class_name . '.php'))
     include '../../libs/tcpdf/' . $class_name . '.php';
}
spl_autoload_register('carica_classi');

session::start();
$giornate = giornate::getGiornateInstance();
$giornate_pdf = giornate_pdf::getGiornatePdfInstance();


switch ($_REQUEST['action']) {


     case 'exportRecord':
     if ( !isset($_REQUEST['id_giornata']) ) { die(json_encode(false)); }

     $id_giornata = json_decode($_REQUEST['id_giornata']);

     $operazione = $giornate_pdf->get($id_giornata);
     if($operazione===false) { die(json_encode(false)); }

     die(json_encode($operazione));
     break;





     case 'saveRecord':
     if ( !isset($_REQUEST['valori'],$_REQUEST['obj']) ) { die(json_encode(false)); }

     $valori = json_decode($_REQUEST['valori']);
     $obj = json_decode($_REQUEST['obj']);
     $id_giornata = $giornate->saveRecord($valori);
     if($id_giornata===false) { die(json_encode(false)); }


     $giacenze = giacenze::getGiacenzeInstance();
     $giornata_new = $giornate->getRecord($id_giornata);
     $righe_new = $giornate->getRighe($id_giornata);
     foreach ($righe_new as $riga) {
          $giacenze->addRecord($riga->id_prodotto,$riga->quantita,$giornata_new, true);
     }




     $operazione = $giornate->saveValori($id_giornata,$obj,$valori->type);
     if($operazione===false) { die(json_encode(false)); }

     die(json_encode($id_giornata));
     break;


     case 'getRighe':
     if ( !isset($_REQUEST['id_giornata']) ) { die(json_encode(false)); }

     $id_giornata = json_decode($_REQUEST['id_giornata']);

     $operazione = $giornate->getRighe($id_giornata);

     die(json_encode($operazione));
     break;


     case 'deleteRiga':
         if ( !isset($_REQUEST['id_riga']) ) { die(json_encode(false)); }
         if ( !isset($_REQUEST['id_location']) ) { die(json_encode(false)); }
         if ( !isset($_REQUEST['id_prodotto']) ) { die(json_encode(false)); }
         if ( !isset($_REQUEST['quantita']) ) { die(json_encode(false)); }

         $id_riga = json_decode($_REQUEST['id_riga']);
         $id_location = json_decode($_REQUEST['id_location']);
         $id_prodotto = json_decode($_REQUEST['id_prodotto']);
         $quantita = json_decode($_REQUEST['quantita']);

         $operazione = $giornate->delRiga($id_riga, $id_location, $id_prodotto, $quantita);
     break;



     case 'updateRecord':
     if ( !isset($_REQUEST['valori'],$_REQUEST['obj']) ) { die(json_encode(false)); }

     $valori = json_decode($_REQUEST['valori']);
     $obj = json_decode($_REQUEST['obj']);
     $id_giornata = $valori->id_giornata;



     $giacenze = giacenze::getGiacenzeInstance();
     $giornata_old = $giornate->getRecord($id_giornata);
     $righe_old = $giornate->getRighe($id_giornata);
     foreach ($righe_old as $riga) {
          $giacenze->addRecord($riga->id_prodotto,$riga->quantita,$giornata_old, false);
     }


     $operazione = $giornate->updateRecord($valori);
     if($operazione===false) { die(json_encode(false)); }


     $operazione = $giornate->deleteRighe($id_giornata);
     if($operazione===false) { die(json_encode(false)); }


     $operazione = $giornate->saveValori($id_giornata,$obj,$valori->type);
     if($operazione===false) { die(json_encode(false)); }



     $giornata_new = $giornate->getRecord($id_giornata);
     $righe_new = $giornate->getRighe($id_giornata);
     foreach ($righe_new as $riga) {
          $giacenze->addRecord($riga->id_prodotto,$riga->quantita,$giornata_new, true);
     }



     die(json_encode($operazione));
     break;


     case 'getC_U':
         if ( !isset($_REQUEST['id_prodotto']) ) { die(json_encode(false)); }
         $id_prodotto = json_decode($_REQUEST['id_prodotto']);

         $operazione = $giornate->getC_U($id_prodotto);

         die(json_encode($operazione));
     break;

     case 'getRecord':
     if ( !isset($_REQUEST['id_giornata']) ) { die(json_encode(false)); }

     $id_giornata = json_decode($_REQUEST['id_giornata']);

     $operazione = $giornate->getRecord($id_giornata);

     die(json_encode($operazione));
     break;


     case 'deleteRecord':
     if ( !isset($_REQUEST['valori']) ) { die(json_encode(false)); }

     $id_giornata = json_decode($_REQUEST['valori'])->id_giornata;


     $giacenze = giacenze::getGiacenzeInstance();
     $giornata_old = $giornate->getRecord($id_giornata);
     $righe_old = $giornate->getRighe($id_giornata);
     foreach ($righe_old as $riga) {
          $giacenze->addRecord($riga->id_prodotto,$riga->quantita,$giornata_old, false);
     }


     $operazione = $giornate->deleteRecord($id_giornata);

     die(json_encode($operazione));
     break;




     default:
     die(json_encode(false));
}
