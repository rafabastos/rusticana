function historialAsientos() {
	//DATATABLES
	var responsiveHelper_dt_basic = undefined;
	var breakpointDefinition = {
		tablet : 1024,
		phone : 480
	};
	$('[id*=dt_cobros]').dataTable({
		"paging": false,
		"oLanguage": {
			"sUrl": window.app.urlSpanishDatatables,
			"sDecimal": ','
			},
		"sDom": "<'dt-toolbar'r>"+
			"t"+
			"<'dt-toolbar-footer'>",
		"autoWidth" : true,
		"aaSorting": [[ 2, "desc" ]],
		"aoColumns": [{ "sWidth": "120px" }, { "sWidth": "350px" },{ "sWidth": "120px" }, { "sWidth": "120px" } ]
	});
	//END DATATABLES

	$('#datepicker1').datepicker({//configuracion de datepicker
		dateFormat: 'dd/mm/yy',
	   	language: 'es',
	   	dayNamesMin: ['Do', 'Lu', 'Ma', 'Mi', 'Ju', 'Vi', 'Sa'],
	    dayNamesShort: ['Dom', 'Lun', 'Mar', 'Mie', 'Jue', 'Vie', 'Sab'],
	   	dayNames: ['Domingo', 'Lunes', 'Martes', 'Miercoles', 'Jueves', 'Viernes', 'Sabado'],
	   	monthNames: ["Ene", "Feb", "Mar", "Abr", "May", "Jun", "Jul", "Ago", "Set", "Oct", "Nov", "Dic"],
	   	monthNames: ["Enero", "Febrero", "Marzo", "Abril", "Mayo", "Junio", "Julio", "Agosto", "Setiembre", "Octubre", "Noviembre", "Diciembre"],
	   	prevText: "<",
		nextText: ">",
		changeYear: true,
	   	yearRange: '1990:2050'
	});
	
	$('#datepicker2').datepicker({//configuracion de datepicker
		dateFormat: 'dd/mm/yy',
	   	language: 'es',
	   	dayNamesMin: ['Do', 'Lu', 'Ma', 'Mi', 'Ju', 'Vi', 'Sa'],
	    dayNamesShort: ['Dom', 'Lun', 'Mar', 'Mie', 'Jue', 'Vie', 'Sab'],
	   	dayNames: ['Domingo', 'Lunes', 'Martes', 'Miercoles', 'Jueves', 'Viernes', 'Sabado'],
	   	monthNames: ["Ene", "Feb", "Mar", "Abr", "May", "Jun", "Jul", "Ago", "Set", "Oct", "Nov", "Dic"],
	   	monthNames: ["Enero", "Febrero", "Marzo", "Abril", "Mayo", "Junio", "Julio", "Agosto", "Setiembre", "Octubre", "Noviembre", "Diciembre"],
	   	prevText: "<",
		nextText: ">",
		changeYear: true,
	   	yearRange: '1990:2050'
	});

	$("#datepicker1").change(function() {
		$("#btn-imprimirHistorial").hide();
	});

	$("#datepicker2").change(function() {
		$("#btn-imprimirHistorial").hide();
	});

	$(".select2#grupoId").change(function() {
		$("#btn-imprimirHistorial").hide();
	});

}