<?php
//BREADCRUMBS
$this->Html->addCrumb('Nuevo Cliente', array('controller' => 'clientes', 'action' => 'nuevo'));

//Scripts para que funcione la validación del formulario
	$this->start('pageScripts');

	echo <<<EOT
			jQuery.validator.addMethod("noSpace", function(value, element) { 
			  return value.indexOf(" ") < 0 && value != ""; 
			}, "El CI o RUC no debe de tener espacios en blanco");

			$("#cliente-form").validate({
			// Rules for form validation
				rules : {
					"data[Cliente][razon_social]" : {
						required : true
					},
					"data[Cliente][ci_ruc]" : {
						required : true,
						minlength: 6,
						maxlength: 10,
						noSpace: true
					},
					"data[TipoCliente][TipoCliente][]" : {
						required : true
					},
					/*"data[Cliente][telefono]" : {
						required : false
					},
					"data[Cliente][celular]" : {
						required : true
					},*/
					"data[Cliente][direccion]" : {
						required : true
					},
					/*"data[Cliente][e-mail]" : {
						email: true,
						required : false
					},*/
					"data[Cliente][persona_contacto]" : {
						required : true
					}
				},
				// Messages for form validation
				messages : {
					"data[Cliente][razon_social]" : {
						required : "Introduzca un nombre o razón social."
					},
					"data[Cliente][ci_ruc]" : {
						required : "Introduzca un número de CI o RUC.",
						minlength: "Debe de ingresar un CI o RUC mayor a 6 caracteres",
						maxlength: "Debe de ingresar un CI o RUC menor a 10 caracteres",
					},
					"data[TipoCliente][TipoCliente][]" : {
						required : "Seleccione al menos un tipo de cliente."
					},
					/*"data[Cliente][telefono]" : {
						required : "Introduzca un número de teléfono."
					},
					"data[Cliente][celular]" : {
						required : "Introduzca un número de celular."
					},*/
					"data[Cliente][direccion]" : {
						required : "Introduzca una dirección."
					},
					"data[Cliente][persona_contacto]" : {
						required : "El campo del contacto es obligatorio."
					},
					/*"data[Cliente][e-mail]" : {
						email: "Introduzca un correo electrónico válido.",
						required : "Introduzca un correo electrónico."
					}*/
				},
		
				// Do not change code below
				errorPlacement : function(error, element) {
					error.insertAfter(element.parent());
				}
			});
EOT;

	$this->end();
?>

<div class="row">
	<div class="col-xs-12 col-sm-7 col-md-7 col-lg-4">
		<h1 class="page-title txt-color-blueDark">
		<i class="fa fa-pencil-square-o fa-fw "></i>
		Nuevo Cliente
		</h1>
	</div>
</div>


<?php
echo $this->Form->create('Cliente', array(
    'inputDefaults' => array(
        'label' => false,
        'div' => false
    ),
    'id' => 'cliente-form',
    'class' => 'smart-form',
    'novalidate' => 'novalidate'
	) 
);
?>
<fieldset>
	<div class = "row">
		<section class= "col col-md-8">
			<label class="label">Nombre o Razón Social</label>
			<label class="input"> 
				<?php echo $this->Form->input('razon_social', array('placeholder'=>'Introduzca nombre o razón social'));?>
		    </label>
		</section> 
		
		 <section class="col col-md-4">
			<label class="label">Tipo de Persona</label>
			<label class="select">
				<?php echo $this->Form->input('tipo_persona_id');?>	
				<i></i>
			</label> 
		</section> 
	</div>

	<div class= "row">
		<section class= "col col-md-6">
			<label class="label">CI/RUC</label>
			<label class="input"> 
				<?php echo $this->Form->input('ci_ruc', array('placeholder'=>'Introduzca CI o RUC del cliente'));?>
		    </label>
		    <div class="note">
				<strong>Nota:</strong> el RUC o CI se utilizará como identificador único del cliente
			</div>
		</section>  
		<section class="col col-md-6">
			<label class= "label">Tipo de cliente </label>

			<!-- ********* IMPORTANTE ************
				Para los multiple select hay que colocar un span o div
				para que el mensaje de error no quede desalineado en caso de
				que se despliegue el mensaje de error de validación-->
			<span>
				<?php echo $this->Form->input('TipoCliente', array('class'=>'select2','multiple style'=>'width:100%','placeholder'=>'Comprador, Vendedor o Ambos'));?>	
			</span>
			<div class="note">
				<strong>Nota:</strong> En caso de que el cliente sea comprador y vendedor debe seleccionar ambos.
			</div>
		</section>
	</div> 

	<div class = "row">
		<section class= "col col-md-5">
			<label class="label">Dirección</label>
			<label class="textarea textarea-resizable">
				<?php echo $this->Form->input('direccion', array('rows'=>'3','class'=>'custom-scroll','placeholder'=>'Dirección del cliente'));?>
			</label>
		</section>
		<section class= "col col-md-3">
			<label class="label">Contacto</label>
			<label class="input"> 
			<?php echo $this->Form->input('persona_contacto', array('type'=>'text', 'placeholder'=>'Contacto'));?>
			</label>
		</section>
		<section class= "col col-md-2">
			<label class="label">Teléfono celular</label>
			<label class="input"> 
			<?php echo $this->Form->input('celular', array('type'=>'text', 'placeholder'=>'Teléfono celular'));?>
			</label>	
		</section>
		<section class= "col col-md-2">
			<label class="label">Teléfono</label>
			<label class="input"> 
			<?php echo $this->Form->input('telefono', array('type'=>'text', 'placeholder'=>'Teléfono'));?>
			</label>	
		</section>
	</div>
	<div class = "row">
		<section class= "col col-md-2">
			<label class="label">Fecha de nacimiento</label>
			<label class="input"> <i class="icon-append fa fa-calendar"></i>
					<?php echo $this->Form->input('fecha', array('type'=>'text', 'placeholder' =>"Seleccione la Fecha",'class'=>'datepicker', 'data-dateformat'=>'dd/mm/yy'));?>
				</label>
		</section>
		<section class= "col col-md-5">
			<label class="label">Correo electrónico</label>
			<label class="input"> 
			<?php echo $this->Form->input('e-mail', array('type'=>'text', 'placeholder'=>'Correo electrónico'));?>
			</label>
		</section>
		<section class= "col col-md-5">
			<label class="label">Página web</label>
			<label class="input"> 
			<?php echo $this->Form->input('pagina_web', array('type'=>'text', 'placeholder'=>'Página web'));?>
			</label>	
		</section>
	</div>
</fieldset>
<footer>
	<?php echo $this->Form->button('Guardar', array('type'=>'submit','class'=>'btn btn-primary'))?>
	<?php echo $this->Html->link('Cancelar',array('controller'=>'clientes','action'=>'index') ,array('class'=>'btn btn-default'))?>
</footer>

<?php echo  $this->Form->end(); ?>

