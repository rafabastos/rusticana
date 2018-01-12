//clase utilizada para manejar los valores de los inputs del tipo de clase "inputMoneda" que utilizan la librería autoNumeric
var autoNumericManager=function(selector,valorInicial,minValue0,maxValue0){
	var selector=selector;
	var minValue;
	var maxValue;

	if(minValue0==undefined){
		minValue=-999999999.99;
	}else{
		minValue=minValue0;
	}
	if(maxValue0==undefined){
		maxValue=999999999999.99;
	}else{
		maxValue=maxValue0;
	}
	var opcionesMontos = {aSep: '.', aDec: ',', mDec: '0' , mRound: 'A', wEmpty: 'empty', lZero: 'deny',vMin:minValue,vMax:maxValue};
	$(selector).autoNumeric('init',opcionesMontos);
	if(valorInicial!=undefined)
		$(selector).autoNumeric('set',valorInicial);
	return{
		selector:selector,
		read: function(){ number=parseFloat($(selector).autoNumeric('get'));
						if(isNaN(number)){
							return 0;
						}else{
							return number;
						}
						},
		write: function( value){
			if(value>=minValue&&value<=maxValue){
				$(selector).autoNumeric('set',value);
			}
		}
	}
	
};
//*****************************


$('#gravadas5ID').change(function() {
  console.log($("#gravadas5ID").val());
});


var timbradoX = 0;
IDcobro=new autoNumericManager("#cobroID");
gravadas10=new autoNumericManager("#gravadas10ID");
gravadas5=new autoNumericManager("#gravadas5ID");
exentas=new autoNumericManager("#exentasID");
totalCobro= new autoNumericManager("#totalID");
descuentoRemate=new autoNumericManager("#descuentoRemateID");
descuentoComprador= new autoNumericManager('#descuentoCompradorID');
descuentoPagoContado=new autoNumericManager('#descuentoContadoID');

var feriaId=0;
var clienteId=0;
var direccionamientoComprador;
var tipoId;
// Funcion para poder resetear y llenar el formulario
$("button#btn-nuevoCobro").click(function(){
	feriaId=$(this).attr('idFeria');
	clienteId=$(this).attr('idComprador');
	direccionamientoComprador=$(this).attr('direccionamiento');
	tipoId = $(this).attr('tipo');
	if(tipoId == "contado"){
		$("#tipoPago").text('Contado'); 
		$('input:radio[value="1"][name="data[Cobro][tipo_pago_id]"]').attr('checked', 'checked');
	}else{
		$("#tipoPago").text('Crédito');
		$('input:radio[value="2"][name="data[Cobro][tipo_pago_id]"]').attr('checked', 'checked');
		$("input[type=radio]").trigger('change');
	}
	initForm(this);	
	actualizarCamposDeCobro(clienteId,feriaId,direccionamientoComprador,1,tipoId);

	$("#cobroID").prop('disabled',true);
	// $("#nuevoCobro-form").attr('action',urlNuevoCobro);

});


// function actualizarCamposDeCobro(clienteId,feriaId,direccionamientoComprador,descuento,tipoId){
// 	$.getJSON(urlCalculoResumen+'/'+clienteId+'/'+feriaId+'/'+direccionamientoComprador+'/'+descuento, function(data) {
// 		console.log(data);
// 		var total = 0;
// 		if(data.tipo_feria_id == 5 || data.tipo_feria_id == 3) {
// 			if(tipoId == "contado") {
// 				gravadas10.write(data.comision);
// 				gravadas5.write(data.montoContado - data.comision);
// 				total = data.montoContado;
// 			} else if (tipoId == "credito") {
// 				gravadas10.write(0);
// 				gravadas5.write(data.montoCredito);
// 				total = data.montoCredito;
// 			}
// 			exentas.write();
// 			totalCobro= new autoNumericManager("#totalID");
// 			totalCobro.write(total);//el descuento en remate ya está incluído
// 			descuentoRemate.write(data.descuentosVarios);
// 			descuentoPagoContado.write(data.totalDescuentoContado);
// 		} else {
// 			if(tipoId == 'contado'){
// 				gravadas10.write(data.montoAl10Contado);
// 				gravadas5.write(data.montoAl5Credito);
// 				exentas.write();
// 				totalCobro.write(gravadas10.read()+gravadas5.read()+exentas.read()-descuentoComprador.read());//el descuento en remate ya está incluído
// 				descuentoRemate.write(data.descuentosVarios);
// 				descuentoPagoContado.write(data.totalDescuentoContado);
// 			}else{
// 				gravadas10.write(data.montoAl10Credito);
// 				gravadas5.write(data.montoAl5Credito);
// 				exentas.write();
// 				totalCobro.write(gravadas10.read()+gravadas5.read()+exentas.read()-descuentoComprador.read());//el descuento en remate ya está incluído
// 				descuentoRemate.write(data.descuentosVarios);
// 				descuentoPagoContado.write(data.totalDescuentoContado);
// 			}
// 		}
// 	});
// }

function inputNumerosCobro(){
	return ( isNaN(parseInt($("#montoFleteEdit").autoNumeric('get'))) && isNaN(parseInt($("#montoOtrosEdit").autoNumeric('get'))) );
}
function inputOtroMontoEdit() {
	return !$.isEmptyObject($("#montoOtrosEdit").val());
}

$("#nuevoCobro-form").submit(function(){
	$('#guardar').attr("disabled", false);
	$('input.inputMoneda').each(function(){
			 $(this).val(($(this).autoNumeric('get')=='')?0:$(this).autoNumeric('get'));
	});
	$("#numeroFacturaID").val($("#numeroFacturaID").val().replace("_",""));
		if(	$("#radioTipoPago"+1).prop('checked')==true){
			$("#cantidadCuotasID").val(1);
		}
});
