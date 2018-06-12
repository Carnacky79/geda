<?php

class inizializzazione {

     public function __destruct() {
          ob_end_flush();
     }

     public function __construct() {
          ob_start();

          $this->db = db::singleton();
          $this->id_buyer = 100;

          $this->utenti = utenti::getUtentiInstance();

          $this->dati_utente = utility::dati_utente();

          $this->giacenze = giacenze::getGiacenzeInstance();
          $this->giornate = giornate::getGiornateInstance();
          $this->fornitori = fornitori::getFornitoriInstance();
          $this->clienti = clienti::getClientiInstance();
          $this->ddt = ddt::getDdtInstance();
          $this->fatture = fatture::getFattureInstance();
          $this->prodotti = prodotti::getProdottiInstance();
          $this->contatori = contatori::getContatoriInstance();
          $this->iva = iva::getIvaInstance();
          $this->metodi_pagamento = metodi_pagamento::getMetodiPagamentoInstance();
          $this->livelli = livelli::getLivelliInstance();
          $this->location = location::getLocationInstance();
          $this->categorie = categorie::getCategorieInstance();
          $this->categorie_tipologie = categorie_tipologie::getCategorieTipologieInstance();


          //CREA LA PAGINA
          $this->costruttore_pagina();
     }




     public function costruttore_pagina(){

          if(isset($_REQUEST['pagina'])){

               $pag = $_REQUEST['pagina'];


               if ( $pag=='login' ) {
                    $this->apri_pagina($pag, "Login");


               } else if ( $pag=='home' ) {
                    $this->apri_pagina($pag, "Dashboard");


               } else if ( $pag=='utenti_new' ) {
                    $this->record_livelli = $this->livelli->getRecords();
                    $this->record_location = $this->location->getRecords();
                    $this->apri_pagina($pag, "Nuovo utente");

               } else if ( $pag=='utenti_edit' ) {
                    $this->record_livelli = $this->livelli->getRecords();
                    $this->record_location = $this->location->getRecords();
                    $this->apri_pagina($pag, "Utente");

               } else if ( $pag=='utenti_list' ) {
                    $this->record_utenti = $this->utenti->getRecords();
                    $this->apri_pagina($pag, "Lista utenti");



               } else if ( $pag=='location_new' ) {
                    $this->record_categorie = $this->categorie->getRecords(3);
                    $this->record_clienti = $this->clienti->getRecords();
                    $this->apri_pagina($pag, "Nuova location");

               } else if ( $pag=='location_edit' ) {
                    $this->record_categorie = $this->categorie->getRecords(3);
                    $this->record_clienti = $this->clienti->getRecords();
                    $this->record_prodotti = $this->prodotti->getRecords();
                    $this->record_giacenze = $this->giacenze->getRecordsByLocation($_REQUEST['id_location']);
                    $this->apri_pagina($pag, "Location");

               } else if ( $pag=='location_list' ) {
                    $this->record_location = $this->location->getRecords();
                    $this->apri_pagina($pag, "Lista location");





               } else if ( $pag=='giornate_today' ) {
                    $this->giornata = $this->giornate->getDateRecords(date('Y-m-d'),false);
                    if($this->giornata===false) {
                         $id_giornata = $this->giornate->aggiungiOdierna();
                    } else {
                         $id_giornata = $this->giornata->id_giornata;
                    }
                    header('Location: ?pagina=giornate_edit&id_giornata='.$id_giornata);



               } else if ( $pag=='giornate_new' ) {

                    $id_giornata = $this->giornate->aggiungiOdierna(false);
                    header('Location: ?pagina=giornate_edit&id_giornata='.$id_giornata);


               } else if ( $pag=='giornate_edit' ) {
                    $id_giornata = $_REQUEST['id_giornata'];
                    $this->record = $this->giornate->getRecord($id_giornata);
                    $this->record_righe = $this->giornate->getRighe($id_giornata);

                    $this->record_metodi_pagamento = $this->metodi_pagamento->getRecords();
                    $this->json_metodi_pagamento = json_encode($this->record_metodi_pagamento);

                    $this->record_location = $this->location->getRecords();

                    $this->record_prodotti = $this->prodotti->getRecords();
                    $this->json_prodotti = json_encode($this->record_prodotti);


                    $this->apri_pagina($pag, "Giornata");

               } else if ( $pag=='giornate_list' ) {
                    $this->record_giornate = $this->giornate->getRecords();
                    $this->apri_pagina($pag, "Lista giornate");









               } else if ( $pag=='prodotti_new' ) {
                    $this->record_fornitori = $this->fornitori->getRecords();
                    $this->record_categorie = $this->categorie->getRecords(1);
                    $this->record_iva = $this->iva->getRecords();
                    $this->apri_pagina($pag, "Nuovo prodotto");


               } else if ( $pag=='prodotti_edit' || $pag=='prodotti_edit_limited' ) {
                    $this->id_record = $_REQUEST['id_prodotto'];
                    $this->record_giacenze = $this->giacenze->getRecord(utility::dati_utente()->id_location,$this->id_record);
                    $this->record_fornitori = $this->fornitori->getRecords();
                    $this->record_categorie = $this->categorie->getRecords(1);
                    $this->record_iva = $this->iva->getRecords();
                    $this->record_ddt = $this->ddt->getRigheProdottoAll($this->id_record);
                    $this->record_fatture = $this->fatture->getRigheProdottoAll($this->id_record);
                    $this->json_fornitori = json_encode($this->record_fornitori);
                    $this->record_location = $this->location->getRecords();
                    $this->apri_pagina($pag, "Prodotto");

               } else if ( $pag=='prodotti_list' ) {

                    $this->record_prodotti = $this->prodotti->getRecords();
                    $this->record_giacenze = $this->giacenze->getRecordsByLocation(utility::dati_utente()->id_location);
                    $this->apri_pagina($pag, "Lista prodotti");




               } else if ( $pag=='iva_new' ) {
                    $this->apri_pagina($pag, "Nuova aliquota");

               } else if ( $pag=='iva_edit' ) {
                    $this->apri_pagina($pag, "Aliquota");

               } else if ( $pag=='iva_list' ) {
                    $this->record_iva = $this->iva->getRecords();
                    $this->apri_pagina($pag, "Lista aliquote");





               } else if ( $pag=='fornitori_new' ) {
                    $this->apri_pagina($pag, "Nuovo fornitore");

               } else if ( $pag=='fornitori_edit' ) {
                    $id_fornitore = $_REQUEST['id_fornitore'];
                    $this->record_fatture = $this->fatture->getRecords_fornitore($id_fornitore);
                    $this->record_ddt = $this->ddt->getRecords_fornitore($id_fornitore);
                    $this->apri_pagina($pag, "Fornitore");

               } else if ( $pag=='fornitori_list' ) {
                    $this->record_fornitori = $this->fornitori->getRecords();
                    $this->apri_pagina($pag, "Lista fornitori");

               } else if ( $pag=='clienti_new' ) {
                    $this->apri_pagina($pag, "Nuovo cliente");

               } else if ( $pag=='clienti_edit' ) {
                    $id_cliente = $_REQUEST['id_cliente'];
                    $this->record_fatture = $this->fatture->getRecords_cliente($id_cliente);
                    $this->record_ddt = $this->ddt->getRecords_cliente($id_cliente);
                    $this->apri_pagina($pag, "Cliente");

               } else if ( $pag=='clienti_list' ) {
                    $this->record_clienti = $this->clienti->getRecords();
                    $this->apri_pagina($pag, "Lista clienti");




               } else if ( $pag=='fatture_new' ) {
                    $this->record_iva = $this->iva->getRecords();

                    $this->fattura_type = $_REQUEST['type'];
                    if($this->fattura_type==0) {
                         $this->record_fornitori = $this->fornitori->getRecords();
                         $this->record_prodotti = $this->prodotti->getRecords();
                    } else {
                         $this->record_clienti = $this->clienti->getRecords();
                         $this->record_prodotti = $this->prodotti->getRecords();
                    }

                    $this->json_oggetti = json_encode(utility::mergeObjects($this->record_prodotti));
                    $this->json_iva = json_encode($this->record_iva);
                    $this->json_fornitori_associati = json_encode($this->prodotti->getFornitoriAssociatiAll());

                    $this->apri_pagina($pag, "Nuova fattura");


               } else if ( $pag=='fatture_edit' || $pag=='fatture_edit_limited' ) {
                    $this->record_iva = $this->iva->getRecords();

                    $this->record = $this->fatture->getRecord($_REQUEST['id_fattura']);

                    $this->fattura_type = $_REQUEST['type'];
                    if($this->fattura_type==0) {
                         $this->record_fornitori = $this->fornitori->getRecords();
                         $this->record_prodotti = $this->prodotti->getRecords();
                    } else {
                         $this->record_clienti = $this->clienti->getRecords();
                         $this->record_prodotti = $this->prodotti->getRecords();
                    }

                    $this->json_oggetti = json_encode(utility::mergeObjects($this->record_prodotti));
                    $this->json_iva = json_encode($this->record_iva);
                    $this->json_fornitori_associati = json_encode($this->prodotti->getFornitoriAssociatiAll());

                    $this->apri_pagina($pag, "Fattura");

               } else if ( $pag=='fatture_list' ) {
                    $this->record_fatture = $this->fatture->getRecords();
                    $this->apri_pagina($pag, "Lista fatture");





               } else if ( $pag=='contatori_list' ) {
                    $this->contatori_type = $_REQUEST['type'];
                    $this->record_contatori = $this->contatori->getRecords($this->contatori_type);
                    $this->apri_pagina($pag, "Gestione numerazione");






               } else if ( $pag=='ddt_new' ) {
                    $this->record_iva = $this->iva->getRecords();

                    $this->ddt_type = $_REQUEST['type'];
                    if($this->ddt_type==0) {
                         $this->record_fornitori = $this->fornitori->getRecords();
                         $this->record_prodotti = $this->prodotti->getRecords();
                    } else {
                         $this->record_clienti = $this->clienti->getRecords();
                         $this->record_prodotti = $this->prodotti->getRecords();
                    }

                    $this->json_oggetti = json_encode(utility::mergeObjects($this->record_prodotti));
                    $this->json_iva = json_encode($this->record_iva);
                    $this->json_fornitori_associati = json_encode($this->prodotti->getFornitoriAssociatiAll());

                    $this->apri_pagina($pag, "Nuovo DDT");


               } else if ( $pag=='ddt_edit' || $pag=='ddt_edit_limited' ) {
                    $this->record_iva = $this->iva->getRecords();

                    $this->record = $this->ddt->getRecord($_REQUEST['id_ddt']);

                    $this->ddt_type = $_REQUEST['type'];
                    if($this->ddt_type==0) {
                         $this->record_fornitori = $this->fornitori->getRecords();
                         $this->record_prodotti = $this->prodotti->getRecords();
                    } else {
                         $this->record_clienti = $this->clienti->getRecords();
                         $this->record_prodotti = $this->prodotti->getRecords();
                    }

                    $this->json_oggetti = json_encode(utility::mergeObjects($this->record_prodotti));
                    $this->json_iva = json_encode($this->record_iva);
                    $this->json_fornitori_associati = json_encode($this->prodotti->getFornitoriAssociatiAll());

                    $this->apri_pagina($pag, "DDT");

               } else if ( $pag=='ddt_list' ) {
                    $this->record_ddt = $this->ddt->getRecords();
                    $this->apri_pagina($pag, "Lista DDT");





               } else if ( $pag=='categorie_new' ) {
                    $this->record_categorie_tipologie = $this->categorie_tipologie->getRecords();
                    $this->apri_pagina($pag, "Nuova categoria");

               } else if ( $pag=='categorie_edit' ) {
                    $id_categoria = $_REQUEST['id_categoria'];
                    $this->record_categorie_tipologie = $this->categorie_tipologie->getRecords();
                    $this->record_prodotti = $this->prodotti->getRecordsByCategoria($id_categoria);
                    $this->apri_pagina($pag, "Categoria");

               } else if ( $pag=='categorie_list' ) {
                    $this->record_categorie = $this->categorie->getRecords();
                    $this->apri_pagina($pag, "Lista categorie");



               } else if ( $pag=='profilo' ) {
                    $this->apri_pagina($pag, "Profilo");

               } else if ( $pag=='giacenze_edit' ) {
                   $this->apri_pagina($pag, "Lista Giacenze in Punto vendita");





               } else { $this->noResults(); }
          } else {
               $this->apri_pagina('login', "Login");
          }
     }


     private function noResults() {
          $this->apri_pagina('404', _('Attenzione! Si è verificato un errore!')); die();
     }


     private function apri_pagina($pagina, $titolo) {

          $livello_utente = 0;
          if(isset(utility::dati_utente()->id_livello)) {
               $livello_utente = intval(utility::dati_utente()->id_livello);
          }

          $this->btn_salva = '<button type="button" class="btn btn-info waves-effect waves-light save_this" aria-expanded="false"><span class="m-r-10"><i class="fa fa-floppy-o" aria-hidden="true"></i></span>Salva</button>';

          $this->btn_apri = '<button type="button" class="btn btn-warning waves-effect waves-light open_this" aria-expanded="false"><span class="m-r-10"><i class="fa fa-unlock" aria-hidden="true"></i></span>Sblocca</button>';

          $this->btn_chiudi = '<button type="button" class="btn btn-warning waves-effect waves-light close_this" aria-expanded="false"><span class="m-r-10"><i class="fa fa-lock" aria-hidden="true"></i></span>Chiudi</button>';

          $this->btn_elimina = '<button type="button" class="btn btn-danger waves-effect waves-light delete_this" aria-expanded="false"><span class="m-r-10"><i class="fa fa-trash-o" aria-hidden="true"></i></span>Elimina</button>';

          $this->btn_esporta = '<button type="button" class="btn btn-success waves-effect waves-light export_this" aria-expanded="false"><span class="m-r-10"><i class="fa fa-download" aria-hidden="true"></i></span>Esporta</button>';

          $this->btn_aggiungi = '<button type="button" class="btn btn-info waves-effect waves-light add_this" aria-expanded="false"><span class="m-r-10"><i class="fa fa-plus"></i></span>Aggiungi</button>';


          $this->form_start = '<div class="row">
          <div class="col-sm-12">
          <div class="card-box">
          <div class="row">
          <div class="col-lg-12">
          <form class="form-horizontal form_valori" role="form" action="javascript:salva_valori();" >';

          $this->form_end = '</div></div></div></div></div></form>';

          if($pagina=='login') {
               include 'assets/template/include/header_login.php';
               include "assets/template/$pagina.php";
               include 'assets/template/include/footer_login.php';
          } else {
               include 'assets/template/include/header.php';
               include "assets/template/$pagina.php";
               include 'assets/template/include/footer.php';
          }


     }
}
?>
