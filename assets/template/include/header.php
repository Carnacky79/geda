<!DOCTYPE html>
<html>


<head>
     <meta charset="utf-8">
     <meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=1, maximum-scale=1.0, user-scalable=no, target-densitydpi=device-dpi" />
     <meta name="HandheldFriendly" content="true" />
     <meta name="description" content="Stock management">
     <meta name="author" content="Coderthemes">

     <meta http-equiv="Cache-Control" content="no-cache, no-store, must-revalidate" />
     <meta http-equiv="Pragma" content="no-cache" />
     <meta http-equiv="Expires" content="-1" />

     <link rel="shortcut icon" href="assets/images/favicon.ico">

     <title>Stocker</title>


     <!-- Jquery filer css -->
     <link href="assets/js/plugins/jquery.filer/css/jquery.filer.css" rel="stylesheet" />
     <link href="assets/js/plugins/jquery.filer/css/themes/jquery.filer-dragdropbox-theme.css" rel="stylesheet" />


     <!--Morris Chart CSS -->
     <link rel="stylesheet" href="assets/js/plugins/morris/morris.css">

     <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta.2/css/bootstrap.min.css" integrity="sha384-PsH8R72JQ3SOdhVi3uxftmaW6Vc51MKb0q5P2rRUpPvrszuE4W1povHYgTpBfshb" crossorigin="anonymous">



     <link href="assets/css/menu.css" rel="stylesheet" type="text/css" />
     <link href="assets/css/core.css" rel="stylesheet" type="text/css" />
     <link href="assets/css/components.css" rel="stylesheet" type="text/css" />
     <link href="assets/css/icons.css" rel="stylesheet" type="text/css" />
     <link href="assets/css/pages.css" rel="stylesheet" type="text/css" />
     <link href="assets/css/responsive.css" rel="stylesheet" type="text/css" />
     <script src="assets/js/default/modernizr.min.js"></script>



     <!-- dropdown.min.css -->
     <link href="assets/css/custom/transition.min.css" rel="stylesheet" type="text/css" />
     <link href="assets/css/custom/dropdown.min.css" rel="stylesheet" type="text/css" />




     <!-- DataTables -->
     <link rel="stylesheet" type="text/css" href="assets/css/datatables.min.css"/>



     <?php $version = 'v=0.0.0.17'; ?>

     <link href="assets/css/style.min.css?<?=$version;?>" rel="stylesheet" type="text/css" />


</head>

<body class="fixed-left">

     <div id="loading_layer" ><i class="fa fa-spinner fa-pulse fa-3x fa-fw"></i></div>
     <div id="messaggi_popup">
          <div id="messaggi_wrapper"></div>
     </div>

     <!-- Begin page -->
     <div id="wrapper">


          <?php include('assets/template/include/topbar.php'); ?>
          <?php include('assets/template/include/sidebar.php'); ?>

          <!-- ============================================================== -->
          <!-- Start right Content here -->
          <!-- ============================================================== -->
          <div class="content-page">
               <div class="content">

                    <input type="hidden" id="id_buyer" name="id_buyer" value="<?=$this->id_buyer;?>" >
                    <input type="hidden" id="livello_utente" name="livello_utente" value="<?=$livello_utente;?>" >
