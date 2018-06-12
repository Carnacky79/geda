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
$fatture = fatture::getFattureInstance();
$fatture_pdf = fatture_pdf::getFatturePdfInstance();
$prodotti = prodotti::getProdottiInstance();

switch ($_REQUEST['action']) {


     case 'exportRecord':
     if ( !isset($_REQUEST['id_fattura']) ) { die(json_encode(false)); }

     $id_fattura = json_decode($_REQUEST['id_fattura']);

     $operazione = $fatture_pdf->get($id_fattura);
     if($operazione===false) { die(json_encode(false)); }

     die(json_encode($operazione));
     break;


     case 'getUltimo_prezzo_and_iva':
     if ( !isset($_REQUEST['id_fattura'],
     $_REQUEST['id_categoria_tipologia'],
     $_REQUEST['id_prodotto_servizio'],
     $_REQUEST['id_fornitore'],
     $_REQUEST['id_cliente']) ) { die(json_encode(false)); }

     $id_fattura = json_decode($_REQUEST['id_fattura']);
     $id_categoria_tipologia = json_decode($_REQUEST['id_categoria_tipologia']);
     $id_prodotto_servizio = json_decode($_REQUEST['id_prodotto_servizio']);
     $id_fornitore = json_decode($_REQUEST['id_fornitore']);
     $id_cliente = json_decode($_REQUEST['id_cliente']);


     if($id_categoria_tipologia==1) {
          $righe_oggetto = $fatture->getRigheOggetto($id_fornitore, $id_cliente, $id_prodotto_servizio);
     } else {
          $righe_oggetto = $fatture->getRigheOggetto($id_fornitore, $id_cliente, 0,$id_prodotto_servizio);
     }

     $prezzo = 'non_trovato';

     foreach ($righe_oggetto as $riga) {
          if($riga->id_fattura!=$id_fattura) {
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

     $id_fattura = $fatture->saveRecord($valori);
     if($id_fattura===false) { die(json_encode(false)); }

     $operazione = $fatture->saveValori($id_fattura,$obj,$valori);
     if($operazione===false) { die(json_encode(false)); }

     $giacenze = giacenze::getGiacenzeInstance();
     $fattura_new = $fatture->getRecord($id_fattura);
     $righe_new = $fatture->getRighe($id_fattura);
     foreach ($righe_new as $riga) {
          $giacenze->addRecord($riga->id_prodotto,$riga->quantita,$fattura_new, false);
     }


     die(json_encode($id_fattura));
     break;


     case 'getRighe':
     if ( !isset($_REQUEST['id_fattura']) ) { die(json_encode(false)); }

     $id_fattura = json_decode($_REQUEST['id_fattura']);

     $operazione = $fatture->getRighe($id_fattura);

     die(json_encode($operazione));
     break;






     case 'updateRecord':
     if ( !isset($_REQUEST['valori'],$_REQUEST['obj']) ) { die(json_encode(false)); }

     $valori = json_decode($_REQUEST['valori']);
     $obj = json_decode($_REQUEST['obj']);
     $id_fattura = $valori->id_fattura;


     $giacenze = giacenze::getGiacenzeInstance();

     $fattura_old = $fatture->getRecord($id_fattura);
     $righe_old = $fatture->getRighe($id_fattura);
     foreach ($righe_old as $riga) {
          $giacenze->addRecord($riga->id_prodotto,$riga->quantita,$fattura_old, true);
     }


     $operazione = $fatture->updateRecord($valori);
     if($operazione===false) { die(json_encode(false)); }



     $operazione = $fatture->deleteRighe($id_fattura);
     if($operazione===false) { die(json_encode(false)); }


     $operazione = $fatture->saveValori($id_fattura,$obj,$valori);
     if($operazione===false) { die(json_encode(false)); }


     $fattura_new = $fatture->getRecord($id_fattura);
     $righe_new = $fatture->getRighe($id_fattura);
     foreach ($righe_new as $riga) {
          $giacenze->addRecord($riga->id_prodotto,$riga->quantita,$fattura_new, false);
     }


     die(json_encode($operazione));
     break;


     case 'getRecord':
     if ( !isset($_REQUEST['id_fattura']) ) { die(json_encode(false)); }

     $id_fattura = json_decode($_REQUEST['id_fattura']);

     $operazione = $fatture->getRecord($id_fattura);

     die(json_encode($operazione));
     break;


     case 'deleteRecord':
     if ( !isset($_REQUEST['valori']) ) { die(json_encode(false)); }

     $id_fattura = json_decode($_REQUEST['valori'])->id_fattura;


     $giacenze = giacenze::getGiacenzeInstance();

     $fattura_old = $fatture->getRecord($id_fattura);
     $righe_old = $fatture->getRighe($id_fattura);
     foreach ($righe_old as $riga) {
          $giacenze->addRecord($riga->id_prodotto,$riga->quantita,$fattura_old, true);
     }


     $operazione = $fatture->deleteRecord($id_fattura);

     die(json_encode($operazione));
     break;


     case 'closeRecord':
     if ( !isset($_REQUEST['valori']) ) { die(json_encode(false)); }

     $id_fattura = json_decode($_REQUEST['valori'])->id_fattura;

     $operazione = $fatture->closeRecord($id_fattura);

     die(json_encode($operazione));
     break;




     default:
     die(json_encode(false));
}
