<?php

	global $wpdb;
	$consulta = "SELECT * FROM {$wpdb->prefix}formularios";
	$listaFormularios = $wpdb->get_results($consulta,ARRAY_A);
	if(empty($listaFormularios)){
		$listaFormularios = array();
	}

?>

<div class="wrap">

	<?php
		echo "<h1>" . get_admin_page_title() . "</h1>";
	?>
	<br><br>

	<table class="wp-list-table widefat fixed striped pages">
		<thead>
			<th>Nombre</th>
			<th>Email</th>
			<th>Telefono</th>
			<th>Mensaje</th>
			<th>Asunto</th>
			<th>Aceptación de Políticas</th>
		</thead>
		<tbody id="the-list">
			<?php
				foreach($listaFormularios as $key => $value){
					$id = $value['id'];
					$nombre = $value['nombre'];
					$email = $value['email'];
					$telefono = $value['telefono'];
					$mensaje = $value['mensaje'];
					$asunto = $value['asunto'];
					$aceptacionPoliticas = $value['politicas'];
					echo "
					<tr>
						<td>$nombre</td>
						<td>$email</td>
						<td>$telefono</td>
						<td>$mensaje</td>
						<td>$asunto</td>
						<td>$aceptacionPoliticas</td>
						<td>
							<a data-id='$id' class='page-title-action' id='btnEliminar' name='btnEliminar'>Borrar</a>
						</td>
					</tr>";
				}
			?>
		</tbody>
	</table>
	
</div>