<?php

	//Scripts para que funcione la validación del formulario
	$this->start('pageScripts');

echo <<<EOT
			
			$('button#btn-nuevaComidaCombo').click(function() {
				//Se resetea el form para que los errores de validación anteriores
				//o los state error y success que cambian el color del formulario
				//desaparezcan
				$("#nuevaComidaCombo-form").validate().resetForm();
				$("label").removeClass('state-error').removeClass('state-success');
				$("#nuevaComidaCombo-form").trigger("reset");
			});


EOT;


			// echo 'var $establecimientoForm= $("#nuevaComidaCombo-form").validate({
			// // Rules for form validation
			// 	rules : {
			// 		"data[Establecimiento][nombre]" : {
			// 			required : true
			// 		},
			// 		"data[Establecimiento][codigo]" : {
			// 			required : true
			// 		},
			// 		"data[Establecimiento][direccion]" : {
			// 			required : true
			// 		},
			// 		"data[Establecimiento][localidad_id]" : {
			// 			required : false
			// 		},
			// 		"data[Establecimiento][ciudad_id]" : {
			// 			required : false
			// 		}
					
			// 	},
			// 	// Messages for form validation
			// 	messages : {
			// 		"data[Establecimiento][nombre]" : {
			// 			required : "Favor introduzca el nombre del establecimiento."
			// 		},
			// 		"data[Establecimiento][codigo]" : {
			// 			required : "Favor introduzca el código del establecimiento."
			// 		},
			// 		"data[Establecimiento][direccion]" : {
			// 			required : "Favor introduzca la dirección del establecimiento."
					
			// 		}	
			// 	},
		
			// 	// Do not change code below
			// 	errorPlacement : function(error, element) {
			// 		error.insertAfter(element.parent());
			// 	}
			// });';

	$this->end();
?>


<!-- Modal Agregar Establecimiento -->
<div class="modal fade" id="nuevaComidaCombo" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">
					&times;
				</button>
				<h3 class="modal-title" id="myModalLabel"><i class="fa fa-building fa-lg"></i> Agregar Comida a <?php echo $combo['Combo']['nombre'];?></h3>
			</div>
			<div class="modal-body">
				<div clas="row">
					<?php echo $this->Form->create('Comida', array(
							    'inputDefaults' => array(
							        'label' => false,
							        'div' => false
							    ),
							    'id' => 'nuevaComidaCombo-form',
							    'class' => 'smart-form',
							    'novalidate' => 'novalidate',
							    'url' => [
								    'controller' => 'productoCombos',
								    'action'=> 'nuevo'
							    ]
								) 
							);
					?>
					

					<fieldset>
						<?php echo $this->Form->hidden('combo_id', array('value'=> $combo['Combo']['id'])); ?>
						<?php echo $this->Form->hidden('tipo_producto_id', array('value'=>2)); ?>
						<div class="row">
							<section class="col col-md-12">
								<label class="label">Cantidad (de acuerdo a la cantidad de personas del combo)</label>
								<label class="input">
									<?php	echo $this->Form->input('proporcion',array('placeholder'=>'Proporción','type'=>'number'));?>
								</label>
							</section>
						</div>
						<div class="row">
							<section class="col col-md-12">
								<label class="label">Productos</label>
								<label class="select">
									<?php	echo $this->Form->input('comida',array('empty'=>'Seleccione una comida','class'=>'select2','selected'=>array('1'),'disabled' => array(''))); ?>
									<i></i> 
								</label>
							</section>
					</fieldset>
					
				</div>
			</div><!-- /.modal-body -->
			<div class="modal-footer">
				<button type="button" class="btn btn-default btn-lg" data-dismiss="modal">
					Cancelar
				</button>
				 <?php echo $this->form->button('Agregar', array('type'=>'submit','class'=>'btn btn-primary btn-lg')); ?>
				 <?php echo $this->form->end(); ?>
			</div><!-- /.modal-footer -->
		</div><!-- /.modal-content -->
		<!-- Modal Footer -->
		
	</div><!-- /.modal-dialog -->
</div><!-- /.modal -->





