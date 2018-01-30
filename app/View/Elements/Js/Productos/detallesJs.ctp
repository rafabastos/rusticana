var spanishURL = <?php echo "'{$this->html->url('/js/plugin/datatables/Spanish.json')}';" ?>
var getCombosUrl= <?php echo "'{$this->html->url(array('controller'=>'combos','action'=>'detalles'))}';" ?>;

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