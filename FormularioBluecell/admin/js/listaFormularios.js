jQuery(document).ready(function($){
	
	$(document).on('click',"a[data-id]",function(){
		var id = this.dataset.id;
		var url = listaFormulariosAjax.url;
		$.ajax({
			type: "POST",
			url: url,
			data:{
				action: "eliminarFormulario",
				nonce: listaFormulariosAjax.seguridad,
				id: id
			},
			success:function(){
				location.reload();
			}
		});
	});
	
});