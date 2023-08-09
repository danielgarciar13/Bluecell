jQuery(document).ready(function($){
	
	$("#formulario-alta").validate({
		rules: {
		  name : {
			required: true,
			minlength: 3
		  },
		  age: {
			required: true,
			number: true,
			min: 18
		  },
		  email: {
			required: true,
			email: true
		  },
		  weight: {
			required: {
			  depends: function(elem) {
				return $("#age").val() > 50
			  }
			},
			number: true,
			min: 0
		  }
		}
  });
  
  $('#formulario-alta').submit(function(){
		console.log($('#txtPoliticas').val());
		
		var url = mostrarFormularioAjax.url;
		$.ajax({
			data:{
				action: 'agregarFormulario',
				nonce: mostrarFormularioAjax.seguridad,
				nombre: $('#txtNombre').val(),
				email: $('#txtEmail').val(),
				telefono: $('#txtTelefono').val(),
				mensaje: $('#txtMensaje').val(),
				asunto: $('#txtAsunto').val(),
				politicas: $('#txtPoliticas').val()
			},
			type: "POST",
			url: url,
			success:function(){
				alert('Datos guardados');
			}
		});
	});
	
});