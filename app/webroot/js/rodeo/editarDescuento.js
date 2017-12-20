	//autoNumeric init options
	var opcionesMontos = {aSep: '.', aDec: ',', mDec: '0' , mRound: 'B', wEmpty: 'empty', lZero: 'deny'};
	$("#montoFleteEdit").autoNumeric('init',opcionesMontos);
	$("#montoOtrosEdit").autoNumeric('init',opcionesMontos);

	// Funcion para poder resetear y llenar el formulario
	$("button#btn-editarDescuento").click(function(){
		//form reset
		$("#editarDescuento-form").validate().resetForm();
		$("#editarDescuento-form").trigger("reset");
		$("label").removeClass('state-error').removeClass('state-success');
		//data set
		$('#idVendedorEdit').val($(this).attr('idVendedor'));
		$('#nombreVendedorEdit').html($(this).attr('nombreVendedor'));
		$.getJSON('{$this->Html->url(array("controller"=>"DescuentoVendedores","action"=>"getDescuentoVendedorJson"))}/'+$(this).attr('idFeria')+'/'+$(this).attr('idVendedor')+'/'
			,function(data){
			$('#montoFleteEdit').autoNumeric('set',data.DescuentoVendedor.monto_flete);
			$('#montoOtrosEdit').autoNumeric('set',data.DescuentoVendedor.monto_otros);
			$('#conceptoDescuentoEdit').val(data.DescuentoVendedor.concepto);
			$('#idDireccionamientoEditar').val(data.DescuentoVendedor.direccionamiento_vendedor);
			var actionURL = $("#editarDescuento-form").attr("action");
			if (actionURL.search("editar/")== -1)
			{
				actionURL = actionURL+"/"; 
			}
			else 
			{
				var pos = actionURL.lastIndexOf("/")+1;
				actionURL=actionURL.substr(0,pos);
			}
			$("#editarDescuento-form").attr("action",actionURL+data.DescuentoVendedor.id);
		})
	});

	//funciones para la validacion
	function inputNumerosEdit(){
		return ( isNaN(parseInt($("#montoFleteEdit").autoNumeric('get'))) && isNaN(parseInt($("#montoOtrosEdit").autoNumeric('get'))) );
	}
	function inputOtroMontoEdit() {
		return !$.isEmptyObject($("#montoOtrosEdit").val());
	}

	//validacion del formulario
	$("#editarDescuento-form").validate({
		// Rules for form validation
		rules : {
			"data[DescuentoVendedor][monto_flete]" : {
				required : inputNumerosEdit
			},
			"data[DescuentoVendedor][monto_otros]" : {
				required : inputNumerosEdit
			},
			"data[DescuentoVendedor][concepto]" : {
				required : inputOtroMontoEdit
			}

		},
		// Messages for form validation
		messages : {
			"data[DescuentoVendedor][monto_flete]" : {
				required : "Favor inserte algún valor para el flete o descuento en otro concepto (IVA incluido)."
			},
			"data[DescuentoVendedor][monto_otros]" : {
				required : "Favor inserte algún valor para el flete o descuento en otro concepto (IVA incluido)."
			},
			"data[DescuentoVendedor][concepto]" : {
				required : "Favor inserte el concepto de descuento si no es flete."
			}
		},

		// Do not change code below
		errorPlacement : function(error, element) {
			error.insertAfter(element.parent());
		}
	});
	
	$("#editarDescuento-form").submit(function(){
		$("#montoFleteEdit").val($("#montoFleteEdit").autoNumeric('get'));
		$("#montoOtrosEdit").val($("#montoOtrosEdit").autoNumeric('get'));
	});
