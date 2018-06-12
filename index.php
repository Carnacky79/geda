<?php

header('Cache-Control: no-cache, no-store, must-revalidate');
header('Pragma: no-cache');
header('Expires: 0');

error_reporting(E_ALL & ~E_DEPRECATED & ~E_NOTICE & ~E_WARNING);
//error_reporting(E_ALL);
//ini_set('display_errors', '1');


function carica_classi($class_name) {
     if (is_file('libs/lib.' . $class_name . '.php'))
     include 'libs/lib.' . $class_name . '.php';
}
spl_autoload_register('carica_classi');


session::start();
$inizializzazione = NEW inizializzazione();

?>