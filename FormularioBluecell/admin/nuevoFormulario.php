<?php

	include_once (PROJECT_ROOT_PATH . '/clases/MostrarFormulario.class.php');

	global $wpdb;
	
	$tablaFormularios = "{$wpdb->prefix}formularios";
	
	echo "<div class='wrap'><h1>" . get_admin_page_title() . "</h1></div>";
	
	echo MostrarFormulario::mostrarFormulario();

?>


