<?php

/*
Plugin Name: Formulario Bluecell
Description: Este plugin te permite crear un formulario y enviarlo por Ajax
Version: 1.0
*/

include_once ('clases/MostrarFormulario.class.php');

define('PROJECT_ROOT_PATH', __DIR__);

function activar(){
	
	global $wpdb;
	
	$sql = "CREATE TABLE IF NOT EXISTS {$wpdb->prefix}formularios ( `id` INT(4) NOT NULL AUTO_INCREMENT ,
	`nombre` VARCHAR(20) NOT NULL , `email` VARCHAR(50) NOT NULL , 
	`telefono` INT(11) NOT NULL , `mensaje` TEXT NOT NULL , 
	`asunto` VARCHAR(20) NOT NULL , `politicas` BOOLEAN NOT NULL , 
	`fecha` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP , PRIMARY KEY (`id`));";
	
	$wpdb->query($sql);
	
}

function desactivar(){}

register_activation_hook(__FILE__,'activar');
register_deactivation_hook(__FILE__,'desactivar');


add_action('admin_menu','crearMenu');

function crearMenu(){
	
	add_menu_page('Bluecell','Bluecell','manage_options','bc_menu',null,plugin_dir_url(__FILE__).'admin/img/icon.png','13');
	add_submenu_page('bc_menu','Lista Formularios','Lista Formularios','manage_options',plugin_dir_path(__FILE__).'admin/listaFormularios.php',null);
	add_submenu_page('bc_menu','Nuevo Formulario','Nuevo Formulario','manage_options',plugin_dir_path(__FILE__).'admin/nuevoFormulario.php',null);
	remove_submenu_page('bc_menu','bc_menu');

}


function importarBootstrapJs($hook){
	
	if($hook != "FormularioBluecell/admin/listaFormularios.php"){
		return;
	}
	
	wp_enqueue_script('bootstrapJs',plugins_url('admin/bootstrap/js/bootstrap.min.js',__FILE__),array('jquery'));
	
}

add_action('admin_enqueue_scripts','importarBootstrapJs');

function importarBootstrapCss($hook){
	
	if($hook != "FormularioBluecell/admin/listaFormularios.php"){
		return;
	}
	
	wp_enqueue_style('bootstrapCss',plugins_url('admin/bootstrap/css/bootstrap.min.css',__FILE__),array('jquery'));
	
}

add_action('admin_enqueue_scripts','importarBootstrapCss');


function importarJs($hook){
	
	if($hook == "FormularioBluecell/admin/nuevoFormulario.php"){		
		wp_enqueue_script('mostrarFormulario',plugins_url('admin/js/mostrarFormulario.js',__FILE__),array('jquery'));
		wp_localize_script('mostrarFormulario','mostrarFormularioAjax',[
			'url' => admin_url('admin-ajax.php'),
			'seguridad' => wp_create_nonce('mostrarFormularioSeg')
		]);
		return;
	}
	elseif($hook == "FormularioBluecell/admin/listaFormularios.php"){		
		wp_enqueue_script('listaFormularios',plugins_url('admin/js/listaFormularios.js',__FILE__),array('jquery'));
		wp_localize_script('listaFormularios','listaFormulariosAjax',[
			'url' => admin_url('admin-ajax.php'),
			'seguridad' => wp_create_nonce('listaFormulariosSeg')
		]);
		return;
	}
	elseif($hook == "the_content"){		
		wp_enqueue_script('mostrarFormulario',plugins_url('admin/js/mostrarFormulario.js',__FILE__),array('jquery'));
		wp_localize_script('mostrarFormulario','mostrarFormularioAjax',[
			'url' => admin_url('admin-ajax.php'),
			'seguridad' => wp_create_nonce('mostrarFormularioSeg')
		]);
		return;
	}
	
}

add_action('admin_enqueue_scripts','importarJs');


function eliminarFormulario(){
	$nonce = $_POST['nonce'];
	if(!wp_verify_nonce($nonce,'listaFormulariosSeg')){
		die("No tienes permisos para ejecutar esta peticion Ajax");
	}
	
	$id = $_POST['id'];
	global $wpdb;
	$tablaFormularios = "{$wpdb->prefix}formularios";
	$wpdb -> delete($tablaFormularios,array(id => $id));
	wp_die();
}

add_action('wp_ajax_eliminarFormulario','eliminarFormulario');

function agregarFormulario(){
	$nonce = $_POST['nonce'];
	if(!wp_verify_nonce($nonce,'mostrarFormularioSeg')){
		die("No tienes permisos para ejecutar esta peticion Ajax");
	}
	
	$datos = array(
			'id' => null,
            'nombre' => $_POST['txtNombre'],
            'email' => $_POST['txtEmail'],
			'telefono' => $_POST['txtTelefono'],
			'mensaje' => $_POST['txtMensaje'],
			'asunto' => $_POST['txtAsunto'],
			'politicas' => $_POST['txtPoliticas'],
			'fecha' => "2023-06-06 12:10:15"
        );
	global $wpdb;
	$tablaFormularios = "{$wpdb->prefix}formularios";
	$wpdb -> insert($tablaFormularios,$datos);
	wp_die();
}
add_action('wp_ajax_agregarFormulario', 'agregarFormulario');
add_action('wp_ajax_nopriv_agregarFormulario', 'agregarFormulario');


function agregarEnSigle() {
		$contenido = get_the_content();
		if (is_single()) {
			$contenido .= " <br/><br/>" . MostrarFormulario::mostrarFormulario() . " <br/><script src='/wp-content/plugins/FormularioBluecell/admin/js/mostrarFormulario.js'></script>";
		}
		return $contenido;
	}

	add_filter('the_content', 'agregarEnSigle');

?>