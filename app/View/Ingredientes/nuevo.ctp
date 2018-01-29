<?php
//BREADCRUMBS
$this->Html->addCrumb('Nuevo Tipo de Producto', array('controller' => 'tipoProductos', 'action' => 'nuevo'));

//Scripts para que funcione la validación del formulario
	$this->start('pageScripts');

	echo <<<EOT
			// jQuery.validator.addMethod("noSpace", function(value, element) { 
			//   return value.indexOf(" ") < 0 && value != ""; 
			// }, "El CI o RUC no debe de tener espacios en blanco");

			// $("#ingrediente-form").validate({
			// // Rules for form validation
			// 	rules : {
			// 		"data[Ingrediente][nombre]" : {
			// 			required : true
			// 		},
			// 		"data[Ingrediente][unidade_medida]" : {
			// 			required : true
			// 		}
			// 	},
			// 	// Messages for form validation
			// 	messages : {
			// 		"data[Ingrediente][nombre]" : {
			// 			required : "Introduzca un nombre o razón social."
			// 		},
			// 		"data[Ingrediente][unidade_medida]" : {
			// 			required : "Seleccione al menos un tipo de cliente."
			// 		}
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
		Nuevo Ingrediente
		</h1>
	</div>
</div>


<?php
echo $this->Form->create('Ingrediente', array(
    'inputDefaults' => array(
        'label' => false,
        'div' => false
    ),
    'id' => 'ingrediente-form',
    'class' => 'smart-form',
    'novalidate' => 'novalidate'
	) 
);
?>
<fieldset>
	<div class = "row">
		<section class= "col col-md-8">
			<label class="label">Nombre</label>
			<label class="input"> 
				<?php echo $this->Form->input('nombre', array('placeholder'=>'Introduzca el ingrediente'));?>
		    </label>
		</section> 
	</div>
	<div class = "row">
		<section class= "col col-md-8">
			<label class="label">Unidade de Medida</label>
			<label class="input">
				<?php echo $this->Form->input('unidade_medida', array('placeholder'=>'Descripcion del producto'));?>
			</label>
		</section>
	</div>
</fieldset>
<footer>
	<?php echo $this->Form->button('Guardar', array('type'=>'submit','class'=>'btn btn-primary'))?>
	<?php echo $this->Html->link('Cancelar',array('controller'=>'clientes','action'=>'index') ,array('class'=>'btn btn-default'))?>
</footer>

<?php echo  $this->Form->end(); ?>

