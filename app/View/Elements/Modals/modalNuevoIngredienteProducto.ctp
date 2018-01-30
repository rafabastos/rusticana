<?php

	//Scripts para que funcione la validación del formulario
	$this->start('pageScripts');

echo <<<EOT
			
			$('button#btn-nuevoIngredienteProducto').click(function() {
				//Se resetea el form para que los errores de validación anteriores
				//o los state error y success que cambian el color del formulario
				//desaparezcan
				$("#nuevoIngredienteProducto-form").validate().resetForm();
				$("label").removeClass('state-error').removeClass('state-success');
				$("#nuevoIngredienteProducto-form").trigger("reset");
			});


EOT;


		
	$this->end();
?>


<!-- Modal Agregar Establecimiento -->
<div class="modal fade" id="nuevoIngredienteProducto" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">
					&times;
				</button>
				<h3 class="modal-title" id="myModalLabel"><i class="fa fa-building fa-lg"></i> Agregar Ingrediente a <?php echo $producto['Producto']['nombre'];?></h3>
			</div>
			<div class="modal-body">
				<div clas="row">
					<?php echo $this->Form->create('IngredienteProducto', array(
							    'inputDefaults' => array(
							        'label' => false,
							        'div' => false
							    ),
							    'id' => 'nuevoIngredienteProducto-form',
							    'class' => 'smart-form',
							    'novalidate' => 'novalidate',
							    'url' => [
								    'controller' => 'ingredienteProductos',
								    'action'=> 'nuevo'
							    ]
								) 
							);
					?>
					

					<fieldset>
						<?php echo $this->Form->hidden('producto_id', array('value'=> $producto['Producto']['id'])); ?>
						<div class="row">
							<section class="col col-md-12">
								<label class="label">Cantidad (de acuerdo a la unidade de medida del ingrediente)</label>
								<label class="input">
									<?php	echo $this->Form->input('cantidad',array('placeholder'=>'Proporción','type'=>'number'));?>
								</label>
							</section>
						</div>
						<div class="row">
							<section class="col col-md-12">
								<label class="label">Ingrediente</label>
								<label class="select">
									<?php	echo $this->Form->input('ingrediente',array('empty'=>'Seleccione un ingrediente','class'=>'select2','selected'=>array('1'),'disabled' => array(''))); ?>
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





