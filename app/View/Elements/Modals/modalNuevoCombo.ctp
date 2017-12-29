<?php

$this->Js->buffer($this->element('Js/Combos/nuevoJs'));

?>

<div class="modal fade" id="modalNuevoCombo"  role="dialog" aria-labelledby="lblCombo" aria-hidden="true" data-backdrop="static" data-keyboard="false">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">
					&times;
				</button>
				<h3 class="modal-title" id="lblCombo"><i class="fa fa-bar-chart-o fa-lg"></i> Clasificación de tipo de animales</h3>
			</div>
			<div class="modal-body">
					<?php
						echo $this->Form->create('Combo', array(
						    'inputDefaults' => array(
						        'label' => false,
						        'div' => false
						    ),
						    'id' => 'nuevoCombo-form',
						    'class' => 'smart-form',
						    'novalidate' => 'novalidate',
						    'url'=> 'nuevoCombo'
						));
					?>
					<fieldset>
						<div class="row">
	                        <section class="col col-md-12">
	                            <?php echo $this->Form->button('<i class="fa fa-plus"></i> Agregar animal',array('type'=>'button','class'=>'btn btn-default btn-xs','id' => 'agregarAnimales')); ?>
	                        </section>
	                    </div>
						<div class="row">
							<section class="col col-md-12">
								<table id="tablaCombo" class="table table-striped table-bordered table-hover">
									<thead>
										<tr>
											<th width="250px">Animal</th>
											<th>Cantidad</th>
											<th></th>
										</tr>
									</thead>
									<tbody>
									</tbody>
								</table>
							</section>
						</div>
					</fieldset>
			</div><!-- /.modal-body -->	
			<div class="modal-footer">
				<button type="button" class="btn btn-default btn-lg" data-dismiss="modal">
					Cancelar
				</button>
				<?php echo $this->form->button('Clasificar', array('class'=>'btn btn-primary btn-lg')); ?>
				<?php echo $this->form->end(); ?>
			</div><!-- /.modal-footer -->
		</div><!-- /.modal-content -->
		<!-- Modal Footer -->
	</div><!-- /.modal-dialog -->
</div><!-- /.modal -->