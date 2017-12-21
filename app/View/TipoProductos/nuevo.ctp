<?php
//BREADCRUMBS
$this->Html->addCrumb('Nuevo Tipo de Producto', array('controller' => 'tipoProductos', 'action' => 'nuevo'));

//Scripts para que funcione la validación del formulario
	$this->start('pageScripts');

	echo <<<EOT
			jQuery.validator.addMethod("noSpace", function(value, element) { 
			  return value.indexOf(" ") < 0 && value != ""; 
			}, "El CI o RUC no debe de tener espacios en blanco");

			// $("#cliente-form").validate({
			// // Rules for form validation
			// 	rules : {
			// 		"data[Cliente][razon_social]" : {
			// 			required : true
			// 		},
			// 		"data[Cliente][ci_ruc]" : {
			// 			required : true,
			// 			minlength: 6,
			// 			maxlength: 10,
			// 			noSpace: true
			// 		},
			// 		"data[TipoCliente][TipoCliente][]" : {
			// 			required : true
			// 		},
			// 		/*"data[Cliente][telefono]" : {
			// 			required : false
			// 		},
			// 		"data[Cliente][celular]" : {
			// 			required : true
			// 		},*/
			// 		"data[Cliente][direccion]" : {
			// 			required : true
			// 		},
			// 		/*"data[Cliente][e-mail]" : {
			// 			email: true,
			// 			required : false
			// 		},*/
			// 		"data[Cliente][persona_contacto]" : {
			// 			required : true
			// 		}
			// 	},
			// 	// Messages for form validation
			// 	messages : {
			// 		"data[Cliente][razon_social]" : {
			// 			required : "Introduzca un nombre o razón social."
			// 		},
			// 		"data[Cliente][ci_ruc]" : {
			// 			required : "Introduzca un número de CI o RUC.",
			// 			minlength: "Debe de ingresar un CI o RUC mayor a 6 caracteres",
			// 			maxlength: "Debe de ingresar un CI o RUC menor a 10 caracteres",
			// 		},
			// 		"data[TipoCliente][TipoCliente][]" : {
			// 			required : "Seleccione al menos un tipo de cliente."
			// 		},
			// 		/*"data[Cliente][telefono]" : {
			// 			required : "Introduzca un número de teléfono."
			// 		},
			// 		"data[Cliente][celular]" : {
			// 			required : "Introduzca un número de celular."
			// 		},*/
			// 		"data[Cliente][direccion]" : {
			// 			required : "Introduzca una dirección."
			// 		},
			// 		"data[Cliente][persona_contacto]" : {
			// 			required : "El campo del contacto es obligatorio."
			// 		},
			// 		/*"data[Cliente][e-mail]" : {
			// 			email: "Introduzca un correo electrónico válido.",
			// 			required : "Introduzca un correo electrónico."
			// 		}*/
			// 	},
		
			// 	// Do not change code below
			// 	errorPlacement : function(error, element) {
			// 		error.insertAfter(element.parent());
			// 	}
			// });
EOT;

	$this->end();
?>

<div class="row">
	<div class="col-xs-12 col-sm-7 col-md-7 col-lg-4">
		<h1 class="page-title txt-color-blueDark">
		<i class="fa fa-pencil-square-o fa-fw "></i>
		Nuevo Tipo de Producto
		</h1>
	</div>
</div>


<?php
echo $this->Form->create('TipoProducto', array(
    'inputDefaults' => array(
        'label' => false,
        'div' => false
    ),
    'id' => 'tipoProducto-form',
    'class' => 'smart-form',
    'novalidate' => 'novalidate'
	) 
);
?>
<fieldset>
	<div class = "row">
		<section class= "col col-md-8">
			<label class="label">Tipo de Producto</label>
			<label class="input"> 
				<?php echo $this->Form->input('tipo', array('placeholder'=>'Introduzca el tipo del producto'));?>
		    </label>
		</section> 
	</div>
	<div class = "row">
		<section class= "col col-md-8">
			<label class="label">Descripcion</label>
			<label class="textarea textarea-resizable">
				<?php echo $this->Form->input('descripcion', array('rows'=>'3','class'=>'custom-scroll','placeholder'=>'Descripcion del producto'));?>
			</label>
		</section>
	</div>
</fieldset>
<footer>
	<?php echo $this->Form->button('Guardar', array('type'=>'submit','class'=>'btn btn-primary'))?>
	<?php echo $this->Html->link('Cancelar',array('controller'=>'clientes','action'=>'index') ,array('class'=>'btn btn-default'))?>
</footer>

<?php echo  $this->Form->end(); ?>

