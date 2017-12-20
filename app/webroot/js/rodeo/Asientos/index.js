function index() {
	var opcionesMontos ={aSep: '.', aDec: ',', vMin:'-999999999', mDec: '0' , mRound: 'B', wEmpty: 'zero', lZero: 'deny'};
	$(".importe").autoNumeric(opcionesMontos);

	/* DATATABLES ;*/
	var responsiveHelper_dt_basic = undefined;
	
	var breakpointDefinition = {
		tablet : 1024,
		phone : 480
	};

	$('#detallesAsiento').dataTable({
		"oLanguage": {
			"sUrl": window.app.urlSpanishDatatables,
			},
		"sDom": "<'dt-toolbar'<'col-xs-12 col-sm-6'f><'col-sm-6 col-xs-12 hidden-xs'l>r>"+
			"t"+
			"<'dt-toolbar-footer'<'col-sm-6 col-xs-12 hidden-xs'i><'col-xs-12 col-sm-6'p>>",
		"autoWidth" : true,
		"aaSorting": [[ 1, "asc" ]],
		"aoColumns": [ 
			null,
			{ "sType": "date-eu" }, 
			null, 
			null, 
		],
		"preDrawCallback" : function() {
			// Initialize the responsive datatables helper once.
			if (!responsiveHelper_dt_basic) {
				responsiveHelper_dt_basic = new ResponsiveDatatablesHelper($('#detallesAsiento'), breakpointDefinition);
			}
		},
		"rowCallback" : function(nRow) {
			responsiveHelper_dt_basic.createExpandIcon(nRow);
		},
		"drawCallback" : function(oSettings) {
			responsiveHelper_dt_basic.respond();
		}
	});
	/* END DATATABLES */
}