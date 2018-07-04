<div class="left side-menu">
     <div class="sidebar-inner slimscrollleft">
          <!--- Divider -->
          <div id="sidebar-menu">
               <ul>

                    <li class="text-muted menu-title">Menu</li>

                    <li class="has_sub">
                         <a href="?pagina=home" class="waves-effect"><i class="zmdi zmdi-view-dashboard"></i> <span>Dashboard</span> </a>
                    </li>

                    <li class="has_sub">
                         <a class="waves-effect"><i class="zmdi zmdi-coffee"></i> <span>Prodotti</span> <span class="menu-arrow"></span> </a>
                         <ul class="list-unstyled">
                              <?php if($livello_utente===1) { ?>
                                   <li><a page_link="prodotti_new" href="?pagina=prodotti_new">Aggiungi</a></li>
                              <?php } ?>
                              <li><a page_link="prodotti_list" href="?pagina=prodotti_list">Lista</a></li>
                         </ul>
                    </li>

                    <?php if($livello_utente===1) { ?>

                         <li class="has_sub">
                              <a class="waves-effect"><i class="zmdi zmdi-device-hub"></i> <span>Categorie</span> <span class="menu-arrow"></span> </a>
                              <ul class="list-unstyled">
                                   <li><a page_link="categorie_new" href="?pagina=categorie_new">Aggiungi</a></li>
                                   <li><a page_link="categorie_list" href="?pagina=categorie_list">Lista</a></li>
                              </ul>
                         </li>


                         <li class="has_sub">
                              <a class="waves-effect"><i class="zmdi zmdi-accounts-alt"></i> <span>Fornitori</span> <span class="menu-arrow"></span> </a>
                              <ul class="list-unstyled">
                                   <li><a page_link="fornitori_new" href="?pagina=fornitori_new">Aggiungi</a></li>
                                   <li><a page_link="fornitori_list" href="?pagina=fornitori_list">Lista</a></li>
                              </ul>
                         </li>

                         <li class="has_sub">
                              <a class="waves-effect"><i class="zmdi zmdi-accounts-alt"></i> <span>Clienti</span> <span class="menu-arrow"></span> </a>
                              <ul class="list-unstyled">
                                   <li><a page_link="clienti_new" href="?pagina=clienti_new">Aggiungi</a></li>
                                   <li><a page_link="clienti_list" href="?pagina=clienti_list">Lista</a></li>
                              </ul>
                         </li>
                    <?php } ?>

                    <li class="has_sub">
                         <a class="waves-effect"><i class="zmdi zmdi-file-text"></i> <span>Fatture</span> <span class="menu-arrow"></span> </a>
                         <ul class="list-unstyled">
                              <?php if($livello_utente===1) { ?>
                                   <li><a page_link="fatture_new_0" href="?pagina=fatture_new&type=0">Aggiungi - in entrata</a></li>
                                   <li><a page_link="fatture_new_1" href="?pagina=fatture_new&type=1">Aggiungi - in uscita</a></li>
                              <?php } ?>
                              <li><a page_link="fatture_list" href="?pagina=fatture_list">Lista</a></li>
                              <?php if($livello_utente===1) { ?>
                                   <li><a page_link="contatori_list_fattura" href="?pagina=contatori_list&type=fattura">Gestici numerazione</a></li>
                              <?php } ?>
                         </ul>
                    </li>

                    <li class="has_sub">
                         <a class="waves-effect"><i class="zmdi zmdi-file-text"></i> <span>DDT</span> <span class="menu-arrow"></span> </a>
                         <ul class="list-unstyled">
                              <?php if($livello_utente===1) { ?>
                              <li><a page_link="ddt_new_0" href="?pagina=ddt_new&type=0">Aggiungi - in entrata</a></li>
                              <li><a page_link="ddt_new_1" href="?pagina=ddt_new&type=1">Aggiungi - in uscita</a></li>
                         <?php } ?>
                         <li><a page_link="ddt_list" href="?pagina=ddt_list">Lista</a></li>
                         <?php if($livello_utente===1) { ?>
                              <li><a page_link="contatori_list_ddt" href="?pagina=contatori_list&type=ddt">Gestici numerazione</a></li>
                         <?php } ?>
                    </ul>
               </li>

               <?php if($livello_utente===1) { ?>
                    <li class="has_sub">
                         <a class="waves-effect"><i class="zmdi zmdi-file-text"></i> <span>Aliquote IVA</span> <span class="menu-arrow"></span> </a>
                         <ul class="list-unstyled">
                              <li><a page_link="iva_new" href="?pagina=iva_new">Aggiungi</a></li>
                              <li><a page_link="iva_list" href="?pagina=iva_list">Lista</a></li>
                         </ul>
                    </li>


                    <li class="has_sub">
                         <a class="waves-effect"><i class="zmdi zmdi-file-text"></i> <span>Punti vendita</span> <span class="menu-arrow"></span> </a>
                         <ul class="list-unstyled">
                              <li><a page_link="location_new" href="?pagina=location_new">Aggiungi</a></li>
                              <li><a page_link="location_list" href="?pagina=location_list">Lista</a></li>
                         </ul>
                    </li>

                    <li class="has_sub">
                         <a class="waves-effect"><i class="zmdi zmdi-file-text"></i> <span>Utenze</span> <span class="menu-arrow"></span> </a>
                         <ul class="list-unstyled">
                              <li><a page_link="utenti_new" href="?pagina=utenti_new">Aggiungi</a></li>
                              <li><a page_link="utenti_list" href="?pagina=utenti_list">Lista</a></li>
                         </ul>
                    </li>
               <?php } ?>
               <li class="has_sub">
                    <a class="waves-effect"><i class="zmdi zmdi-file-text"></i> <span>Vendite giornaliere</span> <span class="menu-arrow"></span> </a>
                    <ul class="list-unstyled">
                         <li><a page_link="giornate_today" href="?pagina=giornate_today">Data odierna</a></li>
                         <li><a page_link="giornate_list" href="?pagina=giornate_list">Lista giornate</a></li>
                    </ul>
               </li>

               <?php if($livello_utente!==1) { ?>
               <li class="has_sub">
                   <a class="waves-effect"><i class="zmdi zmdi-file-text"></i> <span>Lista esaurimento</span> <span class="menu-arrow"></span> </a>
                   <ul class="list-unstyled">
                       <li><a page_link="giacenze_sotto" href="?pagina=giacenze_sotto">Prodotti sotto Giacenza</a></li>
                       <li><a page_link="giacenze_limite" href="?pagina=giacenze_limite">Prodotti prossimi al limite</a></li>
                   </ul>
               </li>
               <?php } else { ?>



               <?php } ?>
          </ul>
          <div class="clearfix"></div>
     </div>
     <div class="clearfix"></div>

</div>
</div>