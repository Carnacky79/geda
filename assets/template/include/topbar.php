<div class="topbar">
     <div class="navbar navbar-default" role="navigation">
          <div class="w100">
               <div class="pull-left">
                    <button class="button-menu-mobile open-left waves-effect waves-light">
                         <i class="zmdi zmdi-menu"></i>
                    </button>
                    <span class="clearfix"></span>
               </div>

               <ul class="nav navbar-nav navbar-right pull-right">

                   <li class="dropdown user-box">
                       <a href="#" class="dropdown-toggle waves-effect waves-light profile " data-toggle="dropdown" aria-expanded="true">
                           <div class="user-status online"><i class="zmdi zmdi-dot-circle"></i></div>
                       </a>

                       <ul class="dropdown-menu">
                            <li><a><i class="ti-user m-r-5"></i><?=$this->dati_utente->nome_cognome;?></a></li>
                           <li><a href="?pagina=profilo"><i class="ti-user m-r-5"></i> Profile</a></li>
                           <li><a href="?pagina=logout"><i class="ti-power-off m-r-5"></i> Logout</a></li>
                       </ul>
                   </li>
               </ul>


               <div>
                    <div class="text-center">
                         <a href="?pagina=home" class="logo">
                              <span><img src="assets/images/logo.png" alt="stocker"></span>
                         </a>
                    </div>
               </div>
          </div>
     </div>
</div>