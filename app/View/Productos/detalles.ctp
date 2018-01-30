<?php
//breadCrumbs
	$this->Html->addCrumb('Productos', array('controller' => 'productos', 'action' => 'index'));
	$this->Html->addCrumb('Detalle de producto',array('controller'=>'productos','action'=>'detalles',$producto['Producto']['id']));

$this->start('pageRelatedPlugins');
	echo $this->Html->script('plugin/datatables/jquery.dataTables.min');
	echo $this->Html->script('plugin/datatables/dataTables.colVis.min');
	echo $this->Html->script('plugin/datatables/dataTables.tableTools.min');
	echo $this->Html->script('plugin/datatables/dataTables.bootstrap.min');
	echo $this->Html->script('plugin/datatable-responsive/datatables.responsive.min');
$this->end();

$this->Js->buffer($this->element('Js/Productos/detallesJs'));

	$this->start('pageScripts');

	$this->end();
?>

<div class="row">
	<div class="col-xs-12 col-sm-7 col-md-7 col-lg-4">
		<h1 class="page-title txt-color-blueDark"> 
			<i class="fa fa-list-alt fa-fw "></i>
			Detalles del Producto
		</h1>
	</div>
</div>

<div class="well">
	
	<div class = "row">
		<section class="col col-md-3">
		<h1>Nombre:
			<strong><?php echo h($producto['Producto']['nombre']); ?></strong>
		</h1>
		</section>
	</div>
	<div class ="row">
		<section class="col col-md-10">
		<h3>Descripción:
			<strong>
				<?php
					if(!empty($producto['Producto']['descripcion'])){
						echo ($producto['Producto']['descripcion']); 
					} else {
						echo 'Sin descripcion'; 
					}
				
				?>
			</strong>
		</h3>
		</section>
	</div>
	<div class = "row">
		<!-- widget grid -->
		<section id="widget-grid">
			<!-- NEW WIDGET START -->
			<article class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
				<!-- Widget ID (each widget will need unique ID)-->
				<div class="jarviswidget jarviswidget-color-green" id="nuevoIngredienteProductoJarvis" data-widget-editbutton="false" data-widget-colorbutton="false" data-widget-fullscreenbutton="false" data-widget-deletebutton="false" data-widget-sortable="false">
					<header>
						<span class="widget-icon"> <i class="fa fa-leaf"></i> </span>
						<h2 class="font-md">Ingredientes</h2>
						<div class="widget-toolbar">
							<button class="btn btn-sm btn-default" data-toggle="modal" data-target="#nuevoIngredienteProducto" id="btn-nuevoIngredienteProducto" data-backdrop="static">
								<i class="fa fa-plus">
									Agregar ingrediente
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
										<th width="80px">#</th>
										<th>Nombre</th>
										<th>Cantidad</th>
										<th>Medida</th>
										<th class="text-right">Acciones</th>
									</tr>
								</thead>
								<tbody>
									<?php 
										foreach ($ingredientes_productos as $key => $ingrediente) {
											echo '<tr><td>'.$key.'</td>';
											echo '<td>'.$ingrediente['Ingrediente']['Ingrediente']['nombre'].'</td>';
											echo '<td>'.$ingrediente['IngredienteProducto']['cantidad'].'</td>';
											echo '<td>'.$ingrediente['Ingrediente']['Ingrediente']['unidade_medida'].'</td>';
											echo '<td class="text-right">'.$this->Html->link('<i class="fa fa-trash-o"></i> Borrar',array('controller'=>'ingredienteProductos','action'=>'borrar',$ingrediente['IngredienteProducto']['id'], $producto['Producto']['id']),array('id'=>'btn-borrarIngrediente','class'=>'btn btn-default btn-xs','escape'=>false)).'</td>';
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
<?php echo '<div>'.$this->element('Modals/modalNuevoIngredienteProducto').'</div>';  ?>
<?php //END MODALES ?>
