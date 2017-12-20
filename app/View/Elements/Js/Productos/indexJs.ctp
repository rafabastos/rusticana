var spanishURL = <?php echo "'{$this->html->url('/js/plugin/datatables/Spanish.json')}';" ?>
var getClientesUrl= <?php echo "'{$this->html->url(array('controller'=>'productos','action'=>'index'))}';" ?>;

$("a#btn-borrar").click(function(e) {
	var btnBorrar = $(this);
	$.SmartMessageBox({
		title : "<i class=\'fa fa-warning fa-lg\'></i> ¡ATENCIÓN! <br>¿Esta seguro que desea borrar este estado?",
		content : "(Esta acción no podrá ser revertida)",
		buttons : "[No][Sí]"
	}, function(ButtonPressed) {
		if (ButtonPressed === "Sí") {
			window.location = btnBorrar.attr('href');
		}	

	});
	e.preventDefault();
});


/* DATATABLES ;*/

var responsiveHelper_dt_basic = undefined;

var breakpointDefinition = {
	tablet : 1024,
	phone : 480
};

 tablaClientes = $('#dt_clientes').DataTable({
   	"bProcessing": true,
    "bServerSide": true,
    "sAjaxSource": getClientesUrl,
	fnServerData : function ( sSource, aoData, fnCallback ) {
          // push parameter onto the aoData array.
          // send request to server, use default fnCallback to process returned JSON
          $.ajax( {
          	"dataType": 'json',
            "url": sSource,
            "data": aoData,
            "success": fnCallback
          } );
     },
    "order": [[ 2, "desc" ]],
	"oLanguage": {
		"sUrl": spanishURL,
		},
	"bDeferRender": true,
	"aoColumnDefs": [
        { "sClass": "text-right", "aTargets": [ 6 ] }
    ],
	"aoColumns":[
		{'data':'ciRuc'},
		{"data":"razonSocial"},
		{"data":"contacto"},
		{"data":"direccion"},
		{"data":"celular"},
		{"data":"telefono"},
		{"data":"tipoPersona"},
		{"data":"creado"},
		{"data":"editado"},
		{"data":"acciones","bSortable":false,'bSearchable':false}
	], 
	"oLanguage": {
		"sUrl": spanishURL,
	},
	"sDom": "<'dt-toolbar'<'col-xs-12 col-sm-6'f><'col-sm-6 col-xs-12 hidden-xs'l>r>"+
	"t"+
	"<'dt-toolbar-footer'<'col-sm-6 col-xs-12 hidden-xs'i><'col-xs-12 col-sm-6'p>>",
	"preDrawCallback" : function() {
		// Initialize the responsive datatables helper once.
		if (!responsiveHelper_dt_basic) {
			responsiveHelper_dt_basic = new ResponsiveDatatablesHelper($('#dt_clientes'), breakpointDefinition);
		}
	},
	"rowCallback" : function( nRow, aData, iDisplayIndex, iDisplayIndexFull ) {
		//responsiveHelper_dt_basic.createExpandIcon(nRow);
		// $(nRow).attr('id',aData.nroSis); 

		// console.log($('#dt_levantes_asignar tr:eq('+iDisplayIndex+')'));
		// console.log(aData);
	},
	"drawCallback" : function(oSettings) {
		responsiveHelper_dt_basic.respond();
		$('[rel="tooltip"]').tooltip();
		
	}

});

