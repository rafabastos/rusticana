var spanishURL = <?php echo "'{$this->html->url('/js/plugin/datatables/Spanish.json')}';" ?>
var getTipoProductosUrl= <?php echo "'{$this->html->url(array('controller'=>'tipoProductos','action'=>'index'))}';" ?>;

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

 tablaClientes = $('#dt_productos').DataTable({
   	"bProcessing": true,
    "bServerSide": true,
    "sAjaxSource": getTipoProductosUrl,
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
    "order": [[ 0, "asc" ]],
	"oLanguage": {
		"sUrl": spanishURL,
		},
	"bDeferRender": true,
	"aoColumnDefs": [
        { "sClass": "text-right", "aTargets": [ 3 ] }
    ],
	"aoColumns":[
		{'data':'id'},
		{"data":"tipo"},
		{"data":"descripcion"},
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
			responsiveHelper_dt_basic = new ResponsiveDatatablesHelper($('#dt_productos'), breakpointDefinition);
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

