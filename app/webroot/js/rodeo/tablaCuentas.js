/**
 * Clase utilizada para manejar tablas con selects y entradas del tipo autonumeric`
 * @param  {array} cuentas0                		cuentas que seran utilizadas en los selects
 * @param  {array} optionsForSelect0       		configuracion inicial para los selects
 * @param  {string} selectorAgregarAsiento0 	para seleccionar el boton de nuevo asiento de la tabla
 * @param  {string} tableSelector0          	selector del curpo de la tabla sobre la cual se está realizando la operación
 * @param  {string} totalHaberSelector0     	selector del total de HABER
 * @param  {string} totalDebeSelector0      	selector del total de DEBE
 * @param  {string} diferenciaSelector0     	selector de la DIFERENCIA entre los totales de debe y haber
 * @param  {string} detalleSelector0        	selector de la columna DETALLES
 * @param  {string} nombreDeInput0          	nombre que tendrá el input del formulario que se va a generar. Por ejemplo "data[Model]"
 * @param  {int} indiceBase0             		en el caso de que existan varios objetos de esta clase con el mismo nombreInput es importante 
 *                                         		diferenciarlos con un indice base desde el cual se greneran los inputs para que no exista solapamiento
 * @param {array} parametros)					son campos hidden que tiene los elementos en el formato [{nombre:'nombre_parametro',valor:999}]
 * @return {Object}                         	dependiendo del metodo utilizado.
 * 
 */

 var tablaCuentas=function(
 	cuentas0,
 	optionsForSelect0,
 	selectorAgregarAsiento0,
 	tableSelector0,
 	totalHaberSelector0,
 	totalDebeSelector0,
 	diferenciaSelector0,
 	detalleSelector0,
 	nombreDeInput0,
 	indiceBase0,
 	parametros0) {
 	var opcionesImpuestos = {aSep: '.', aDec: ',', mDec: '0', mRound: 'A', wEmpty: 'zero'};
 	var opcionesMontos = {aSep: '.', aDec: ',', mDec: '0' , mRound: 'A', lZero: 'deny'}; 
	//Funcion para mensaje de error
	function showError(titulo,contenido) {
		if(typeof contenido === 'undefined') contenido = '';
		$.smallBox({
			title : titulo,
			content : "<i>"+ contenido+"</i>",
			color : "#C46A69",
			iconSmall : "fa fa-exclamation-circle fadeInRight animated",
			timeout : 4000,
			sound: false
		});
	};
	//dedicados a controlar tabla
	var cuentas=cuentas0;
	var optionsForSelect=optionsForSelect0.slice();
	var cuentasGeneradas=[];
	var totalHaber=0;
	var totalDebe=0;
	var cantidadDeFilas=0;
	var selectorAgregarAsiento=selectorAgregarAsiento0;
	var tableSelector=tableSelector0;
	var totalHaberSelector=totalHaberSelector0;
	var totalDebeSelector=totalDebeSelector0;
	var diferenciaSelector=diferenciaSelector0;
	var detalleSelector=detalleSelector0;
	var nombreDeInput=nombreDeInput0;
	var indiceBase=indiceBase0;
	var parametros = parametros0;
	$('body '+ tableSelector).children().unbind();
	$('body '+ tableSelector).unbind();
	$('body '+ selectorAgregarAsiento).unbind();
	$('body '+ totalHaberSelector).unbind();
	$('body '+ totalDebeSelector).unbind();
	$('body '+ diferenciaSelector).unbind();
	$('body '+ detalleSelector).unbind();
	$('body '+	tableSelector+' select.cuenta').unbind();
	$(tableSelector).html('');
	$(totalDebeSelector).autoNumeric(opcionesMontos);
	$(totalHaberSelector).autoNumeric(opcionesMontos);
	$(diferenciaSelector).autoNumeric(opcionesMontos);
	$(detalleSelector).keyup(function() {
		$(tableSelector+" input#detalle").each(function() {
			$(this).val($(detalleSelector).val());
		});
	});

	$(selectorAgregarAsiento).click( function() {
		//buscar indice libre
		var indiceLibre=-1;
		for(var i=0;i<cuentasGeneradas.length;i++) {
			if(cuentasGeneradas[i].utilizado==false) {
				indiceLibre=i;
				break;
			}
		}
		if(indiceLibre==-1) {//no se encontro ningun indice libre se crea uno nuevo
			cuentasGeneradas.push({utilizado:true});
			indiceLibre=cuentasGeneradas.length-1;
		} else {//se econtro una  fila
			cuentasGeneradas[i].utilizado=true;
		}
		//se generan las filas
		var fila='<tr id="fila'+(indiceLibre)+'"  indice="'+indiceLibre+ '" class="context-menu-one box menu-1" style="border-color: #0000ff;">';
		fila+='<td   id="cuenta" colspan="2" style="padding:0;"><select class ="cuenta" id="selectFila'+indiceLibre+'" style="width:100%" >'+optionsForSelect+'</select></td>';
		fila+='<td   style="padding:0;"  ><label style="padding:0" class="input"><input class="text-right" id="detalle" name="data[Dummy][detalle]" style="width:100%;height:100%;" type="text" id="DummyDetalle"/></label></td>';
		fila+='<td   style="padding:0;"  ><label style="padding:0" class="input"><input class="text-right" id="debe" name="data[Dummy][monto]" style="width:100%;height:100%;" type="text" id="DummyMonto"/></label></td>';

		fila+='<td class="text-right" style="padding:0;" ><label class="input" name="data[Dummy][eliminar]"><input class="text-right" id="haber" name="data[Dummy][monto]" style="width:100%;height:100%" type="text" id="DummyMonto"/></label></td>';
		
		fila+='<td ><button type="button" class="btn btn-default btn-xs" id="btnQuitarAsiento" quitarAsiento="'+indiceLibre+'" rel="tooltip" data-placement="top" data-original-title="Borrar" ><i class="fa fa-trash-o"></i></button></td>';
		fila+='</tr>';
		$(tableSelector).append(fila);//se agregan las filas
		$(tableSelector+' tr[indice="'+indiceLibre+'"]').find('input#debe').autoNumeric(opcionesMontos);
		$(tableSelector+' tr[indice="'+indiceLibre+'"]').find('input#haber').autoNumeric(opcionesMontos);
		$(tableSelector+' tr[indice="'+indiceLibre+'"]').find('input').val('');

		$(tableSelector+' #selectFila'+indiceLibre).select2();//se convierte el select en select2
	});


	//cuando se desea eliminar un asiento
	$('body').off('click',tableSelector+' button#btnQuitarAsiento');
	$('body').on('click',tableSelector+' button#btnQuitarAsiento', function(event) {
		event.preventDefault();//se evita que se haga el submmit
		var filaABorrar=$(this).parent().parent();//se encuentra la fila a bcompiler_write_header(filehandle)
		var idRemovido=filaABorrar.attr('indice');// se encuentre el 'indice' de fila
		var cuentaBorrada=filaABorrar.find('select').val();//se encuentra la cuenta borrada
		var cuentaBorradaText=filaABorrar.find('option[value="'+cuentaBorrada+'"]').text();//el texto de la cuenta borrada
		cuentasGeneradas[parseInt(idRemovido)].utilizado=false;// se marca el 'indice' como  no utilizado

		// se agrega la posibiliad de seleccion de de la cuenta en los otros selects activos
		for(var i=0;i<cuentasGeneradas.length;i++) {
			if(cuentasGeneradas[i].utilizado==true) {
				if(cuentaBorrada!='') {
					$(tableSelector+' tr[indice="'+ i+'"]').find('select').append('<option value="'+cuentaBorrada +'" >'+cuentaBorradaText+ '</option>');
				}
			}
		}
		filaABorrar.remove();
		actualizarOpciones();
		calcularTotales();
	});
	var cuentasSeleccionadasAnt=[];// para aguardar las cuentas seleccionadas anteriores
		// cada vez que se selecciona una nueva cuenta se debe dar la posibilidad la cuenta anterio seleccionada en los otros select boxes.
	// ademas se debe inhabilitar la cuenta seleccionada para los otros selectboxes
	$('body').off('change',tableSelector+' .cuenta');
	$('body').on('change',tableSelector+' .cuenta',function() {

		var indiceFilaEnCuestion=$(this).parent().parent().attr('indice');
		//desahabilitar la opcion en otros select
		var cuentaAdeshab=$(tableSelector+' tr[indice="'+ indiceFilaEnCuestion+'"]').find('select').val();
		
		//buscar si tiene una seleccion anterior
		var tieneSeleccionAnterior=false;
		var datosCuentaAnterior;
		for(var i=0;i<cuentasSeleccionadasAnt.length;i++) {
			if(cuentasSeleccionadasAnt[i].indiceFila==indiceFilaEnCuestion&&cuentasSeleccionadasAnt[i].cuentaSeleccionada!='') {
				tieneSeleccionAnterior=true;
				datosCuentaAnterior=cuentasSeleccionadasAnt[i];
				break;
			}
		}
		
		for(var i=0;i<cuentasGeneradas.length;i++) {
			if(cuentasGeneradas[i].utilizado==true) {	
				if(i!=indiceFilaEnCuestion) {
					$(tableSelector+' tr[indice="'+ i+'"]').find('option[value="'+cuentaAdeshab+'"]').remove();
					if(tieneSeleccionAnterior) {
						$(tableSelector+' tr[indice="'+ i+'"]').find('select').append('<option value="'+datosCuentaAnterior.cuentaSeleccionada +'" >'+datosCuentaAnterior.cuentaSeleccionadaText+ '</option>');	
					}	
				}
			}
		}			
		
		for(var i=0;i<cuentasGeneradas.length;i++) {
			if(cuentasGeneradas[i].utilizado==true) {
				var cuentaDeSelec=$(tableSelector+' tr[indice="'+ i+'"]').find('select').val();
				var cuentaDeSelecText=$(tableSelector+' tr[indice="'+ i+'"]').find('option[value="'+cuentaDeSelec+'"]').text();
				
				var datoDeSeleccion={indiceFila:i,cuentaSeleccionada:cuentaDeSelec,cuentaSeleccionadaText:cuentaDeSelecText};
				if(!cuentasGeneradas[i]){
					cuentasSeleccionadasAnt.push(datoDeSeleccion);
				}else{
					cuentasSeleccionadasAnt[i]=datoDeSeleccion;
				}
			}
		}
		actualizarOpciones();
	});

	$('body').off('keyup input change',tableSelector+' input#debe');
	$('body').on('keyup input change',tableSelector+' input#debe',function() {

		var parent=$(this).parent().parent().parent();
		if($(this).val()!="") {
			parent.children().find('#haber').val('');
		}
		calcularTotales();
	});

	$('body').off('keyup input',tableSelector+' input#haber');
	$('body').on('keyup input',tableSelector+' input#haber',function() {

		var parent=$(this).parent().parent().parent();
		if($(this).val()!=""){
			parent.children().find('#debe').val('');
		}	
		calcularTotales();
	});


	function actualizarOpciones() {
		optionsForSelect='';
		optionsForSelect='<option value="">Seleccione una cuenta</option>';
		var yaExiste=false;
		for(var i=0;i<cuentas.length;i++) {
			yaExiste=false;
			for(var j=0;j<cuentasGeneradas.length;j++) {
				if(cuentasGeneradas[j].utilizado==true) {
					if(cuentas[i].id==$(tableSelector+' tr[indice="'+ j+'"]').find('select').val()) {
						yaExiste=true;
						break;
					}
				}
			}
			if(!yaExiste) {
				optionsForSelect+='<option value="'+cuentas[i].id +'">'+cuentas[i].desc+'</option>';
			}
		}
	};

	function calcularTotales() {
		totalHaber=0;
		totalDebe=0;
		$(tableSelector+" input#debe").each(function() {

			var valorEntero=parseInt($(this).autoNumeric('get'));

			if($(this).val()!=""){
				totalDebe+=valorEntero;
			}



		});
		$(tableSelector+" input#haber").each(function() {
			var valorEntero=parseInt($(this).autoNumeric('get'));
			if($(this).val()!=""){
				totalHaber+=valorEntero;
			}

		});
		$(totalDebeSelector).autoNumeric('set', totalDebe);
		$(totalHaberSelector).autoNumeric('set',totalHaber);
		$(diferenciaSelector).autoNumeric('set',Math.abs(totalDebe-totalHaber));
	};


	return {
		//Parametros hidden de las cuentas (en el caso de ser necesarios)
		setearParametros: function(parametros0) {
			var activo=false;

			//Hardcoding, para evitar que se activen de nuevo cuentas antes de la
			//apertura del 2016 (cambiar alguna vez)
			for (var i = 0; i < parametros0.length; i++) {
				if(parametros0[i].nombre=='fecha'){
					var fecha=parametros0[i].valor.split('-');
					if(parseInt(fecha[0])<2016){
						activo={'nombre':'activo','valor':0};	
					}
				
				}
			}
			if(activo){
				parametros0.push(activo);
			}
			parametros=parametros0;
		},
		//Agrega cuentas Precargadas en la tabla
		cargarEditables:function (cuentasPrecargadas) {

			for(i=0;i<cuentasPrecargadas.length;i++) {
				$( selectorAgregarAsiento ).trigger( "click" );
				var selector=$(tableSelector+ ' tr[indice="'+ i+'"]');
				selector.find('select').select2('val',cuentasPrecargadas[i].cuenta_contable_id);
				selector.find('select').trigger('change');
				if(cuentasPrecargadas[i].tipo_cuenta=='D') {
					selector.find('#debe').autoNumeric('set',cuentasPrecargadas[i].monto);
				} else {
					selector.find('#haber').autoNumeric('set',cuentasPrecargadas[i].monto);
				}
				selector.find('#detalle').val(cuentasPrecargadas[i].detalle);
				selector.attr('idCuentaBalance',cuentasPrecargadas[i].id);

			}
			calcularTotales();
		},
		borrarCuentas: function(){
			for(var i=0;i<cuentasGeneradas.length;i++) {
				if(cuentasGeneradas[i].utilizado) {
					$(tableSelector+' button[quitarAsiento="'+i+'"]').trigger('click');
				}
			}
		},
		editarFila: function (nroFila,cuentaId,monto,tipoCuenta,detalle){
			var selector=$(tableSelector+ ' tr[indice="'+ nroFila+'"]');
			selector.find('select').select2('val',cuentaId);
			selector.find('select').trigger('change');
			if(tipoCuenta=='D') {
				selector.find('#debe').autoNumeric('set',monto);
			} else {
				selector.find('#haber').autoNumeric('set',monto);
			}
			selector.find('#detalle').val(detalle);
		},
		//Realiza la validación de la tabla de cuentas
		validacionCuentas: function (totalSinDescuentos) {
			var errores=false;
			var cuentasID=[];
			var debeSet=[];
			var haberSet=[];
			var detalleSet=[];
			var inputs='';
			//juntar valores de cuenta debe y haber
			$(tableSelector+' td#cuenta').each( function() {
					var a=$(this);
					cuentasID.push(a.find('select').val());
					if(a.parent().find('#debe').autoNumeric('get')=="") {
						debeSet.push(0);
					} else {
						debeSet.push(parseInt(a.parent().find('#debe').autoNumeric('get')));
					}
					if(a.parent().find('#haber').autoNumeric('get')=="") {
						haberSet.push(0);
					} else {
						haberSet.push(parseInt(a.parent().find('#haber').autoNumeric('get')));
					}
					detalleSet.push(a.parent().find('#detalle').val());
			});
			
			//verificar si se usaron cuentas igualese o hay cuentas vacias	
			for(var i=0;i<cuentasID.length;i++) {
				if(cuentasID[i]=='') {
					errores=true;
					showError("<strong>¡Error!</strong>",'Hay cuentas sin  seleccionar');
					break;
				}
				if(haberSet[i]==0 && debeSet[i]==0) {
					errores=true;
					showError("<strong>¡Error!</strong>",'Hay cuentas que tienen cantidades Haber y Debe en cero ');
					break;
				}
				for(var j=i+1;j<cuentasID.length;j++) {
					if(cuentasID[i]==cuentasID[j]) {
						errores=true;
						showError("<strong>¡Error!</strong>",'Puede utilizar una cuenta una sola vez ');
						break;
					}
				}
			}

			// if(totalHaber!=totalDebe) {
			// 	errores=true;
			// 	showError("<strong>¡Error!</strong>",'La cantidad total en "Debe" tiene que ser igual a la cantidad total en "Haber" ');
			// }
			if(totalSinDescuentos!=undefined){
				if(totalHaber!=totalSinDescuentos||totalDebe!=totalSinDescuentos) {
					errores=true;
					showError("<strong>¡Error!</strong>",'El total en haber y el total en debe , deben ser iguales al total del monto de la operacion ');
				}
			}

			if(!errores) {
				$(tableSelector+' input#debe').prop('disabled',true);
				$(tableSelector+' input#haber').prop('disabled',true);
				$(tableSelector+' input#detalle').prop('disabled',true);
				$(tableSelector+' select.cuenta').prop('disabled',true);
				$(detalleSelector).prop('disabled',true);
				var j=0;
				for(var i=0;i<cuentasID.length;i++) {
					j=i+indiceBase;
					var input='<input hidden name="'+nombreDeInput+'['+j+ '][cuenta_contable_id]" style="width:100%;height:100%" type="text" value="'+cuentasID[i] +'" />' ;
					inputs+=input;;
					// //se anhade la fecha a las compras
					// var fecha= inputFecha.split('/');
					// var inputFechaFormateada=fecha[2]+'-' +fecha[1]+'-'+fecha[0];
					// inputFechaFormateada='<input hidden name="'+nombreDeInput+'['+j+ '][fecha]" style="width:100%;height:100%" type="text" value="'+inputFechaFormateada+'" />' ;
					// inputGrupo='<input hidden name="'+nombreDeInput+'['+j+ '][grupo]" style="width:100%;height:100%" type="text" value="V" />' ;//grupo venta de animales

					// inputs+=inputFechaFormateada;
					// inputs+=inputGrupo;
					var inputMonto;
					var inputTipoCuenta;
					var inputDetalle='<input hidden name="'+nombreDeInput+'['+j+ '][detalle]" style="width:100%;height:100%" type="text" value="'+detalleSet[i]+'" />' ;
					if(debeSet[i]!=0) {
						inputMonto='<input hidden name="'+nombreDeInput+'['+j+ '][monto]" style="width:100%;height:100%" type="text" value="'+debeSet[i]+'" />' ;
						inputTipoCuenta='<input hidden name="'+nombreDeInput+'['+j+ '][tipo_cuenta]" style="width:100%;height:100%" type="text" value="D" />' ;
					} else {
						inputMonto='<input hidden name="'+nombreDeInput+'['+j+ '][monto]" style="width:100%;height:100%" type="text" value="'+haberSet[i]+'" />' ;
						inputTipoCuenta='<input hidden name="'+nombreDeInput+'['+j+ '][tipo_cuenta]" style="width:100%;height:100%" type="text" value="H" />' ;
					}

					for(var i2=0;i2<parametros.length;i2++) {
						inputs+='<input hidden name="'+nombreDeInput+'['+j+ ']['+parametros[i2].nombre+']" style="width:100%;height:100%" type="text" value="'+parametros[i2].valor+'" />' ;
					}
					inputs+=inputDetalle;
					inputs+=inputMonto;
					inputs+=inputTipoCuenta;
				}
				return inputs;
			}
			return false;
		},

		eliminarNoUtilizados: function() {
			$(tableSelector+' input#debe').prop('disabled',true);
			$(tableSelector+' input#haber').prop('disabled',true);
			$(tableSelector+' select.cuenta').prop('disabled',true);
			$(detalleSelector).prop('disabled',true);
		},
		habilitarEdicion: function() {
			$(tableSelector+' input#debe').prop('disabled',false);
			$(tableSelector+' input#haber').prop('disabled',false);
			$(tableSelector+' select.cuenta').prop('disabled',false);
			$(detalleSelector).prop('disabled',false);
		}
	};
}; //END tablaCuentas