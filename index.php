<?php
session_start();

define('const_css', './css/');
define('const_js', './js/');

define('const_bdd', './../bdd/');
define('const_incl', './template/include/');
define('const_pages', './template/pages/');

define('const_global', './../template/include/');

require_once(const_bdd . 'model.php');

$page = const_pages . $_GET['page'] . '.php';

if (isset($_GET['page'])) {

	if (file_exists($page)) {
	    require_once($page); 
	} else {
	    require_once(const_global . '404.php'); 
	}

} else {
	require_once(const_pages . 'home.php');
}



?>

				


