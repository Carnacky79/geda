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
$ddt = ddt::getDdtInstance();
$ddt_pdf = ddt_pdf::getDdtPdfInstance();
$prodotti = prodotti::getProdottiInstance();

switch ($_REQUEST['action']) {


     case 'exportRecord':
     if ( !isset($_REQUEST['id_ddt']) ) { die(json_encode(false)); }

     $id_ddt = json_decode($_REQUEST['id_ddt']);

     $operazione = $ddt_pdf->get($id_ddt);
     if($operazione===false) { die(json_encode(false)); }

     die(json_encode($operazione));
     break;


     case 'getUltimo_prezzo_and_iva':
     if ( !isset($_REQUEST['id_ddt'],
     $_REQUEST['id_categoria_tipologia'],
     $_REQUEST['id_prodotto_servizio'],
     $_REQUEST['id_fornitore'],
     $_REQUEST['id_cliente']) ) { die(json_encode(false)); }

     $id_ddt = json_decode($_REQUEST['id_ddt']);
     $id_categoria_tipologia = json_decode($_REQUEST['id_categoria_tipologia']);
     $id_prodotto_servizio = json_decode($_REQUEST['id_prodotto_servizio']);
     $id_fornitore = json_decode($_REQUEST['id_fornitore']);
     $id_cliente = json_decode($_REQUEST['id_cliente']);


     if($id_categoria_tipologia==1) {
          $righe_oggetto = $ddt->getRigheOggetto($id_fornitore, $id_cliente, $id_prodotto_servizio);
     } else {
          $righe_oggetto = $ddt->getRigheOggetto($id_fornitore, $id_cliente, 0,$id_prodotto_servizio);
     }

     $prezzo = 'non_trovato';

     foreach ($righe_oggetto as $riga) {
          if($riga->id_ddt!=$id_ddt) {
               if($riga->prezzo_unitario>0) {
                    $prezzo = $riga->prezzo_unitario;
                    break;
               }
          }
     }

     $prodotto = $prodotti->getRecord($id_prodotto_servizio);

     $operazione = (object)array('prezzo' => $prezzo, 'iva' =>$prodotto->id_iva);

     die(json_encode($operazione));
     break;





     case 'saveRecord':
     if ( !isset($_REQUEST['valori'],$_REQUEST['obj']) ) { die(json_encode(false)); }

     $valori = json_decode($_REQUEST['valori']);
     $obj = json_decode($_REQUEST['obj']);

     $id_ddt = $ddt->saveRecord($valori);
     if($id_ddt===false) { die(json_encode(false)); }

     $operazione = $ddt->saveValori($id_ddt,$obj,$valori);
     if($operazione===false) { die(json_encode(false)); }


     $giacenze = giacenze::getGiacenzeInstance();
     $ddt_new = $ddt->getRecord($id_ddt);
     $righe_new = $ddt->getRighe($id_ddt);
     foreach ($righe_new as $riga) {
          $giacenze->addRecord($riga->id_prodotto,$riga->quantita,$ddt_new, false);
     }

     die(json_encode($id_ddt));
     break;


     case 'getRighe':
     if ( !isset($_REQUEST['id_ddt']) ) { die(json_encode(false)); }

     $id_ddt = json_decode($_REQUEST['id_ddt']);

     $operazione = $ddt->getRighe($id_ddt);

     die(json_encode($operazione));
     break;






     case 'updateRecord':
     if ( !isset($_REQUEST['valori'],$_REQUEST['obj']) ) { die(json_encode(false)); }

     $valori = json_decode($_REQUEST['valori']);
     $obj = json_decode($_REQUEST['obj']);
     $id_ddt = $valori->id_ddt;


     $giacenze = giacenze::getGiacenzeInstance();
     $ddt_old = $ddt->getRecord($id_ddt);
     $righe_old = $ddt->getRighe($id_ddt);
     foreach ($righe_old as $riga) {
          $giacenze->addRecord($riga->id_prodotto,$riga->quantita,$ddt_old, true);
     }


     $operazione = $ddt->updateRecord($valori);
     if($operazione===false) { die(json_encode(false)); }



     $operazione = $ddt->deleteRighe($id_ddt);
     if($operazione===false) { die(json_encode(false)); }


     $operazione = $ddt->saveValori($id_ddt,$obj,$valori);
     if($operazione===false) { die(json_encode(false)); }


     $ddt_new = $ddt->getRecord($id_ddt);
     $righe_new = $ddt->getRighe($id_ddt);
     foreach ($righe_new as $riga) {
          $giacenze->addRecord($riga->id_prodotto,$riga->quantita,$ddt_new, false);
     }


     die(json_encode($operazione));
     break;


     case 'getRecord':
     if ( !isset($_REQUEST['id_ddt']) ) { die(json_encode(false)); }

     $id_ddt = json_decode($_REQUEST['id_ddt']);

     $operazione = $ddt->getRecord($id_ddt);

     die(json_encode($operazione));
     break;


     case 'deleteRecord':
     if ( !isset($_REQUEST['valori']) ) { die(json_encode(false)); }

     $id_ddt = json_decode($_REQUEST['valori'])->id_ddt;

     $giacenze = giacenze::getGiacenzeInstance();
     $ddt_old = $ddt->getRecord($id_ddt);
     $righe_old = $ddt->getRighe($id_ddt);
     foreach ($righe_old as $riga) {
          $giacenze->addRecord($riga->id_prodotto,$riga->quantita,$ddt_old, true);
     }

     $operazione = $ddt->deleteRecord($id_ddt);

     die(json_encode($operazione));
     break;


     case 'closeRecord':
     if ( !isset($_REQUEST['valori']) ) { die(json_encode(false)); }

     $id_ddt = json_decode($_REQUEST['valori'])->id_ddt;

     $operazione = $ddt->closeRecord($id_ddt);

     die(json_encode($operazione));
     break;




     default:
     die(json_encode(false));
}
