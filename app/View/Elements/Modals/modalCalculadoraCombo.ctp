<?php
$this->start('pageRelatedPlugins');
echo $this->Html->script('rodeo/autoNumeric');
$this->end();
$this->Js->buffer($this->element('Js/Combos/modalCalculadoraJs'));
?>

<div class="modal fade" id="modalCalculadoraCombo" role="dialog" aria-labelledby="modalCuentaLabel" aria-hidden="true" tabindex="-1"  backdrop="static" data-keyboard="false" >
	<div class="modal-dialog ">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">
					&times;
				</button>
				<h3 class="modal-title" id="modalCobrosLabel"> <i class="fa fa-th"></i>  Calculadora<span id="tipoPago"></span></h3>
			</div>
			<div class="modal-body">
				<div class = "row">
					<?php
					echo $this->Form->create('Cobro', array(
					    'inputDefaults' => array(
					        'label' => false,
					        'div' => false
					    ),
					    'id' => 'nuevoCobro-form',
					    'class' => 'smart-form',
					    'novalidate' => 'novalidate',
					    'url'=> 'nuevo',
						) 
					);
					?>
					 <fieldset>
						<div class="row">
							<section class="col col-md-5">
								<label class="label">Gravadas 5%: </label>
							</section>
							<section class="col col-md-7">
								<label class="input">
									<?php echo $this->Form->input('gravadas5',array('class'=>'inputMoneda','id'=>'gravadas5ID','type'=>'text')); ?>
								</label>
							</section>	
						</div>
						<div class="row">
							<section class="col col-md-5">
								<label class="label">Gravadas 10%: </label>
							</section>
							<section class="col col-md-7">
								<label class="input">
									<?php echo $this->Form->input('gravadas10',array('class'=>'inputMoneda','id'=>'gravadas10ID','type'=>'text')); ?>
								</label>
							</section>	
						</div>
						<div class="row">
							<section class="col col-md-5">
								<label class="label">Exentas: </label>
							</section>
							<section class="col col-md-7">
								<label class="input">
									<?php echo $this->Form->input('exentas',array('class'=>'inputMoneda','id'=>'exentasID','type'=>'text')); ?>
								</label>
							</section>	
						</div>
						<div class="row">
							<section class="col col-md-5">
								<label class="label">Descuento por pago contado: </label>
							</section>
							<section class="col col-md-7">
								<label class="input">

									<?php echo $this->Form->input('descuento_pago_contado',array('class'=>'inputMoneda','id'=>'descuentoContadoID','type'=>'text','readonly')); ?>
								</label>
							</section>	
						</div>
						<div class="row">
							<section class="col col-md-5">
								<label class="label">Descuentos en remates: </label>
							</section>
							<section class="col col-md-7">
								<label class="input">

									<?php echo $this->Form->input('descuento_remate',array('class'=>'inputMoneda','id'=>'descuentoRemateID','type'=>'text')); ?>
								</label>
							</section>	
						</div>
						<div class="row">
							<section class="col col-md-5">
								<label class="label">Otros descuentos: </label>
							</section>
							<section class="col col-md-7">
								<label class="input">

									<?php echo $this->Form->input('descuento_comprador',array('class'=>'inputMoneda','id'=>'descuentoCompradorID','type'=>'text')); ?>
								</label>
							</section>	
						</div>
						<div class="row">
							<section class="col col-md-5">
								<label class="label"><strong>Total:</strong> </label>
							</section>
							<section class="col col-md-7">
								<label class="input">
									<?php echo $this->Form->input('total_cobrar',array('id'=>'totalID','class'=>'inputMoneda','type'=>'text')); ?>
								</label>
							</section>	
						</div>
					</fieldset>
				</div>
			</div><!-- /.modal-body -->
			<div class="modal-footer">
				<button type="button" class="btn btn-default btn-lg" data-dismiss="modal">
					Cancelar
				</button>
				<?php echo $this->form->button('Guardar', array('class'=>'btn btn-primary btn-lg', 'id'=>'guardar')) ?>
				<?php echo $this->form->end(); ?>
			</div><!-- /.modal-footer -->
		</div><!-- /.modal-content -->
		<!-- Modal Footer -->
	</div><!-- /.modal-dialog -->
</div><!-- /.modal -->



