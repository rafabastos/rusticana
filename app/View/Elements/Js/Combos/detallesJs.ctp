var spanishURL = <?php echo "'{$this->html->url('/js/plugin/datatables/Spanish.json')}';" ?>
var getCombosUrl= <?php echo "'{$this->html->url(array('controller'=>'combos','action'=>'detalles'))}';" ?>;
var comboId ="<?php echo $combo['Combo']['id'];?>";

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


 tablaClientes = $('#dt_combos').DataTable({
   	"bProcessing": true,
    "bServerSide": true,
    "bPaginate": false,
    "sAjaxSource": getCombosUrl+'/'+comboId,
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
        { "sClass": "text-center", "aTargets": [0,1,2,3,4] }
    ],
	"aoColumns":[
		{'data':'id'},
		{"data":"nombre"},
		{"data":"cantidad_invitados"},
		{"data":"total_necesario"},
		{"data":"tipo"},
	], 
	"oLanguage": {
		"sUrl": spanishURL,
	},
	"sDom": //"<'dt-toolbar'<'col-xs-12 col-sm-6'f><'col-sm-6 col-xs-12 hidden-xs'l>r>"+
	"t"+
	"<'dt-toolbar-footer'<'col-sm-6 col-xs-12 hidden-xs'i><'col-xs-12 col-sm-6'p>>",
	"preDrawCallback" : function() {
		// Initialize the responsive datatables helper once.
		if (!responsiveHelper_dt_basic) {
			responsiveHelper_dt_basic = new ResponsiveDatatablesHelper($('#dt_combos'), breakpointDefinition);
		}
	},
	"drawCallback" : function(oSettings) {
		responsiveHelper_dt_basic.respond();
		$('[rel="tooltip"]').tooltip();
		
	},
    "fnServerParams": function ( aoData ) {
		aoData.push( { "name": "Calculadora[cantidad]", "value": $("#cantidad").val()  } );
    },

});

