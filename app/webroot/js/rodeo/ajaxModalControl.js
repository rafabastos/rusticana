	/*
	Esta porción de codigo evita que algún modal(muestra un mensaje de Cargando) se abra si existen peticiones Json pendientes
	*/	
	var CantidadDePeticionesAjaxActuales=0;//cantidad de peticiones ajax actuales
	var selector;
	 var peticionDeMostrarModal=false;
	 var cargando=false;
	$( document ).ajaxStart(function() {//cuando se inicia una peticion ajax
  		CantidadDePeticionesAjaxActuales++;
	});
	$( document ).ajaxStop(function() {//cuando termina una peticion ajax
		CantidadDePeticionesAjaxActuales--;
		if(CantidadDePeticionesAjaxActuales==0&&cargando==true){
			cargando=false;
			$('#mensajeDeCargando').remove();
			$(selector).find('div[class="modal-body"]').children().show();
		}
	});

	//al mostra algun modal
	$('.modal').on('show.bs.modal', function (e) {//cuando se muestra algún modal
		selector=this;
		
		if(CantidadDePeticionesAjaxActuales>0&&cargando==false){
			cargando=true;
			$(selector).find('div[class="modal-body"]').children().hide();
			$(selector).find('div[class="modal-body"]').append('<div id="mensajeDeCargando"> <p  align="center">Cargando..</p><p  align="center"><i  class="fa fa-spinner faa-spin animated fa-5x"></i></p></div>');
		}

  		return true;
	});
/*
No habrá conflicto si en alguna vista existe otro codigo  que maneje el 'shown.bs.modal'(testeado)
*/