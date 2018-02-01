<?php
//breadCrumbs
	$this->Html->addCrumb('Combos', array('controller' => 'combos', 'action' => 'index'));
	$this->Html->addCrumb('Detalle de combo',array('controller'=>'combos','action'=>'detalles',$combo['Combo']['id']));

$this->start('pageRelatedPlugins');
	echo $this->Html->script('plugin/datatables/jquery.dataTables.min');
	echo $this->Html->script('plugin/datatables/dataTables.colVis.min');
	echo $this->Html->script('plugin/datatables/dataTables.tableTools.min');
	echo $this->Html->script('plugin/datatables/dataTables.bootstrap.min');
	echo $this->Html->script('plugin/datatable-responsive/datatables.responsive.min');
$this->end();

$this->Js->buffer($this->element('Js/Combos/detallesJs'));

	$this->start('pageScripts');

	$this->end();
?>

<div class="row">
	<div class="col-xs-12 col-sm-7 col-md-7 col-lg-4">
		<h1 class="page-title txt-color-blueDark"> 
			<i class="fa fa-list-alt fa-fw "></i>
			Detalles del Combo
		</h1>
	</div>
</div>

<?php
		echo $this->Form->create('Cantidad', array(
			'inputDefaults' => array(
				'label' => false,
				'div' => false
			),
			'id' => 'calculadora-form',
			'class' => 'smart-form',
			'novalidate' => 'novalidate'
			) 
		);
	?>
	<fieldset>
		<div class="row">
			<section class="col col-md-3">
				<label class = "label">Cantidad de Invidados:</label>
				<label class="input">
					<?php	echo $this->Form->input('cantidad',array('placeholder'=>'Informe aqui la cantidad','type'=>'number','id'=>'cantidad'));?>
				</label>
			</section>
			<section class="col col-md-2">
				<label class="label">&nbsp;</label>
				<?php echo $this->Form->button('<i class="fa fa-search fa-md"></i>&nbsp;&nbsp;CALCULAR',array('type'=>'submit','id'=>'buscarDocumentos', 'class'=>'btn btn-info btn-sm')); ?>
			</section>
		</div>
	</fieldset>
	
	<?php echo $this->form->end(); ?>	

<div class="well">
	
	<div class = "row">
		<section class="col col-md-3">
		<h1>Nombre:
			<strong><?php echo h($combo['Combo']['nombre']); ?></strong>
		</h1>
		</section>
		<section class="col col-md-7">
		<h1>Cantidad de Clientes:
			<strong><?php echo h($combo['Combo']['cantidad_personas']); ?></strong>
		</h1>
		</section>		
	</div>

	<div class ="row">
		<section class="col col-md-10">
		<h3>Descripción:
			<strong><?php echo h($combo['Combo']['descripcion']); ?></strong>
		</h3>
		</section>
	</div>

	<hr class="simple">
	<h2><i class="fa fa-lg fa-fw fa-th"></i><?php echo __('Calculadora');  ?></h2>
	<div class="well" style="overflow-x:scroll;">
		<table id="dt_combos" class="table table-striped table-bordered table-hover" style="overflow-x: scroll">
			<thead>
				<tr>
					<th>#</th>
					<th>Nombre</th>
					<th>Cantidad Personas</th>
					<th>Total Necesario</th>
				</tr>
			</thead>
			<tbody>
			</tbody>
		</table>
	</div>
	<div class = "row">
		<!-- widget grid -->
		<section id="widget-grid">
			<!-- NEW WIDGET START -->
			<article class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
				<!-- Widget ID (each widget will need unique ID)-->
				<div class="jarviswidget jarviswidget-color-green" id="nuevaComidaComboJarvis" data-widget-editbutton="false" data-widget-colorbutton="false" data-widget-fullscreenbutton="false" data-widget-deletebutton="false" data-widget-sortable="false">
					<header>
						<span class="widget-icon"> <i class="fa fa-cutlery"></i> </span>
						<h2 class="font-md">Comidas</h2>
						<div class="widget-toolbar">
							<button class="btn btn-sm btn-default" data-toggle="modal" data-target="#nuevaComidaCombo" id="btn-nuevaComidaCombo" data-backdrop="static">
								<i class="fa fa-plus">
									Agregar comida al combo
								</i>
							</button>
						</div>					
					</header>
					<!-- widget div-->
					<div>
						<!-- widget content -->
						<div class="widget-body no-padding">
							<table id="dt_comidas" class="table table-striped table-bordered table-hover">
								<thead>
									<tr>
										<th width="50px">#</th>
										<th>Nombre</th>
										<th>Cantidad</th>
										<th width="150" class="text-right">Acciones</th>
									</tr>
								</thead>
								<tbody>
									<?php foreach ($comidaCombo as $key => $comida) {
											echo '<tr><td>'.$key.'</td>';
											echo '<td>'.$comidas[$comida['ProductoCombos']['producto_id']].'</td>';
											echo '<td>'.$comida['ProductoCombos']['cantidad_producto'].'</td>';
											echo '<td class="text-right">'.$this->Html->link('<i class="fa fa-trash-o"></i> Borrar',array('controller'=>'productoCombos','action'=>'borrar',$comida['ProductoCombos']['id'],$combo['Combo']['id']),array('id'=>'btn-borrarBebida','class'=>'btn btn-default btn-xs','escape'=>false)).'</td>';
										}
									?>
								</tbody>
							</table>
						</div>

						<!-- end widget content -->
					</div>
					<!-- end widget div -->
				</div>
				<!-- end widget -->
			</article>
			<!-- WIDGET END -->
			
			<!-- NEW WIDGET START -->
			<article class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
				<!-- Widget ID (each widget will need unique ID)-->
				<div class="jarviswidget jarviswidget-color-green" id="nuevaBebidaComboJarvis" data-widget-editbutton="false"  data-widget-colorbutton="false"  data-widget-fullscreenbutton="false" data-widget-deletebutton="false" data-widget-sortable="false">
					<header>
						<span class="widget-icon"> <i class="fa fa-glass"></i> </span>
						<h2 class="font-md">Bebidas</h2>
						<div class="widget-toolbar">
							<button class="btn btn-sm btn-default" data-toggle="modal" data-target="#nuevaBebidaCombo" id="btn-nuevaBebidaCombo" id="btn-nuevaBebidaCombo" data-backdrop="static">
								<i class="fa fa-plus">
									Agregar bebida al combo
								</i>
							</button>
						</div>					
					</header>
					<!-- widget div-->
					<div>
						<!-- widget content -->
						<div class="widget-body no-padding">
							<table id="dt_bebidas" class="table table-striped table-bordered table-hover">
								<thead>
									<tr>
										<th width="50px">#</th>
										<th>Nombre</th>
										<th>Cantidad</th>
										<th width="150" class="text-right">Acciones</th>
									</tr>
								</thead>
								<tbody>
									<?php foreach ($bebidaCombo as $key => $bebida) {
											echo '<tr><td>'.$key.'</td>';
											echo '<td>'.$bebidas[$bebida['ProductoCombos']['producto_id']].'</td>';
											echo '<td>'.$bebida['ProductoCombos']['cantidad_producto'].'</td>';
											echo '<td class="text-right">'.$this->Html->link('<i class="fa fa-trash-o"></i> Borrar',array('controller'=>'productoCombos','action'=>'borrar',$bebida['ProductoCombos']['id'],$combo['Combo']['id']),array('id'=>'btn-borrarBebida','class'=>'btn btn-default btn-xs','escape'=>false)).'</td>';
										}
									?>
								</tbody>
							</table>
						</div>
						<!-- end widget content -->
					</div>
					<!-- end widget div -->
				</div>
				<!-- end widget -->
			</article>
			<!-- WIDGET END -->
		</section>
		<!-- end widget grid -->
	</div>

</div>
	
<!-- end well -->
<?php //MODALES ?>
<?php echo '<div>'.$this->element('Modals/modalNuevaComidaCombo').'</div>';  ?>
<?php echo '<div>'.$this->element('Modals/modalNuevaBebidaCombo').'</div>';  ?>
<?php echo '<div>'.$this->element('Modals/modalCalculadoraCombo').'</div>'; ?>
<?php //echo '<div>'.$this->element('Modals/modalNuevaComision').'</div>'; ?>
<?php //echo '<div>'.$this->element('Modals/modalNuevoCredito').'</div>'; ?>
<?php //echo '<div>'.$this->element('Modals/modalEditarCredito').'</div>'; ?>
<?php //echo '<div>'.$this->element('Modals/modalEditarComision').'</div>'; ?>
<?php //END MODALES ?>
