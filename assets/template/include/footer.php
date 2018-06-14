</div>

<footer class="footer">
     2017 © Stocker
</footer>

<?php

    echo '<div style="padding-left:20px; font-size:9px; padding-bottom:30px;">';
    echo '<a href="\gestionale\assets\template\include\storico_lavori_geda.txt'.'">Storico Lavori</a>';
    echo '</div>';
?>

</div>
<!-- ============================================================== -->
<!-- End Right content here -->
<!-- ============================================================== -->


</div>
<!-- END wrapper -->

<script>
var resizefunc = [];
</script>

<!-- jQuery  -->



<script
src="https://code.jquery.com/jquery-3.2.1.min.js"
integrity="sha256-hwg4gsxgFZhOsEEamdOYGBf13FyQuiTwlAQgxVSNgt4="
crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.3/umd/popper.min.js" integrity="sha384-vFJXuSJphROIrBnz7yo7oB41mKfc8JzQZiCq4NCceLEaO4IHwicKwpJf9c9IpFgh" crossorigin="anonymous"></script>

<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta.2/js/bootstrap.min.js" integrity="sha384-alpBpkh1PFOepccYVYDB4do5UnbKysX5WZXm3XxPqe5iKTfUKjNkCk9SaVuEZflJ" crossorigin="anonymous"></script>


<script src="assets/js/default/detect.js"></script>
<script src="assets/js/default/fastclick.js"></script>
<script src="assets/js/default/jquery.slimscroll.js"></script>
<script src="assets/js/default/jquery.blockUI.js"></script>
<script src="assets/js/default/waves.js"></script>
<script src="assets/js/default/wow.min.js"></script>
<script src="assets/js/default/jquery.nicescroll.js"></script>
<script src="assets/js/default/jquery.scrollTo.min.js"></script>



<script src="assets/js/plugins/bootstrap-inputmask/bootstrap-inputmask.min.js" type="text/javascript"></script>
<script src="assets/js/plugins/moment/moment.js"></script>



<!--Morris Chart-->
<script src="assets/js/plugins/morris/morris.min.js"></script>
<script src="assets/js/plugins/raphael/raphael-min.js"></script>

<!-- Counter Up  -->
<script src="assets/js/plugins/waypoints/lib/jquery.waypoints.js"></script>
<script src="assets/js/plugins/counterup/jquery.counterup.min.js"></script>


<!-- App js -->
<script src="assets/js/default/jquery.core.js"></script>
<script src="assets/js/default/jquery.app.js"></script>


<!-- Jquery filer js -->
<script src="assets/js/plugins/jquery.filer/js/jquery.filer.min.js"></script>


<!-- dropdown.min.js -->
<script src="assets/js/custom/transition.min.js"></script>
<script src="assets/js/custom/dropdown.js"></script>


<!-- Datatables-->
<script type="text/javascript" src="assets/js/default/datatables.min.js"></script>



<script type="text/javascript" src="assets/js/plugins/parsleyjs/dist/parsley.min.js"></script>




<script>

$(document).ready(function() {

     ['assets/js/messaggio.js?<?=$version?>',
     'assets/js/global.js?<?=$version?>',
     <?php
     if ( isset($pagina) && file_exists("assets/js/pagine/".$pagina.".js")) {
          echo ',"assets/js/pagine/'.$pagina.'.js?'.$version.'"';
     }
     if ( isset($includeJS) ) {
          foreach ($includeJS as $file) {
               if ( file_exists("assets/js/pagine/".$file.".js") ) {
                    echo ',"assets/js/pagine/'.$file.'.js?'.$version.'"';
               }
          }
     }
     ?>
].forEach(function(src) {
     var script = document.createElement('script');
     script.src = src;
     script.async = false;
     document.head.appendChild(script);
});

});

</script>


</body>

</html>