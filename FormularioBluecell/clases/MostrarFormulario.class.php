<?php

class MostrarFormulario{
	
	function __construct() {
	}

    public static function mostrarFormulario(){
		global $wpdb;
	
		$tablaFormularios = "{$wpdb->prefix}formularios";
		
		if(isset($_POST['btnGuardar'])){
			$nombre = $_POST['txtNombre'];
			$email = $_POST['txtEmail'];
			$telefono = $_POST['txtTelefono'];
			$mensaje = $_POST['txtMensaje'];
			$asunto = $_POST['txtAsunto'];
			$politicas = $_POST['txtPoliticas'];
			
			$datos = [
				'id' => null,
				'nombre' => $nombre,
				'email' => $email,
				'telefono' => $telefono,
				'mensaje' => $mensaje,
				'asunto' => $asunto,
				'politicas' => $politicas
			];
			$wpdb->insert($tablaFormularios,$datos);
		}
		
		return '
			<div class="wrap">

				<form id="formulario-alta" method="post">
					<div class="form-group">
						<label>Nombre</label>
						<input type="text" id="txtNombre" name="txtNombre" required></input>
						<br/>
						<label>Email</label>
						<input type="email" id="txtEmail" name="txtEmail" required></input>
						<br/>
						<label>Telefono</label>
						<input type="tel" id="txtTelefono" name="txtTelefono" required></input>
						<br/>
						<label>Mensaje</label>
						<input type="text" id="txtMensaje" name="txtMensaje" required></input>
						<br/>
						<label>Asunto</label>
						<input type="text" id="txtAsunto" name="txtAsunto" required></input>
						<br/>
						<label>Aceptar politicas</label>
						<input type="checkbox" id="txtPoliticas" name="txtPoliticas" required></input>			
					</div>
					<div class="form-group">
						<button id="btnGuardar" name="btnGuardar" class="btn">Enviar</button>		
					</div>
				</form>
				<script src="https://ajax.aspnetcdn.com/ajax/jquery.validate/1.11.1/jquery.validate.min.js"></script>
				
			</div>
		';
	}

}

?>