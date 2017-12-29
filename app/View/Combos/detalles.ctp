<?php
//breadCrumbs
	$this->Html->addCrumb('Combos', array('controller' => 'combos', 'action' => 'index'));
	$this->Html->addCrumb('Detalle de combo',array('controller'=>'combos','action'=>'detalles',$combo['Combo']['id']));

$this->start('pageRelatedPlugins');
	echo $this->Html->script('plugin/datatables/jquery.dataTables.min');
	echo $this->Html->script('plugin/datatables/dataTables.bootstrap.min');
	echo $this->Html->script('plugin/datatable-responsive/datatables.responsive.min');
$this->end();

	$this->start('pageScripts');

echo <<<EOT

		// function borrarMessageBox(btn, titulo,contenido) {
		// 	$.SmartMessageBox({
		// 		title : titulo,
		// 		sound: false,
		// 		content : contenido,
		// 		buttons : "[No][Sí]"
		// 	}, function(ButtonPressed) {
		// 		if (ButtonPressed === "Sí") {
		// 			window.location = btn.attr('href');
		// 		}	

		// 	});
		// }



		// $("a#btn-borrarComision").click(function(e) {
		// 	borrarMessageBox($(this),"<i class='fa fa-warning fa-lg txt-color-yellow'></i> ¡ATENCIÓN! <br>¿Esta seguro que desea borrar la comisión: <strong>"+$(this).attr("datos")+"</strong>?","(Esta acción no podrá ser revertida)");
		// 	e.preventDefault();
		// });

		// $("a#btn-borrarEstablecimiento").click(function(e) {
		// 	borrarMessageBox($(this),"<i class='fa fa-warning fa-lg txt-color-yellow'></i> <strong>¡ATENCIÓN!</strong> <br>¿Esta seguro que desea borrar el establecimiento: <strong>"+$(this).attr("datos")+"</strong>?","(Esta acción no podrá ser revertida)");
		// 	e.preventDefault();
		// });



EOT;


echo <<<EOT
		
		/* DATATABLES ;*/
			var responsiveHelper_dt_basic = undefined;
			
			var breakpointDefinition = {
				tablet : 1024,
				phone : 480
			};

			$('#dt_bebidas').dataTable({
				"oLanguage": {
					"sUrl": "{$this->html->url('/js/plugin/datatables/Spanish.json')}",
	 			},
				"sDom": "<'dt-toolbar'<'col-xs-12 col-sm-6'f><'col-sm-6 col-xs-12 hidden-xs'l>r>"+
					"t"+
					"<'dt-toolbar-footer'<'col-sm-6 col-xs-12 hidden-xs'i><'col-xs-12 col-sm-6'p>>",
				"autoWidth" : true,
				"preDrawCallback" : function() {
					// Initialize the responsive datatables helper once.
					if (!responsiveHelper_dt_basic) {
						responsiveHelper_dt_basic = new ResponsiveDatatablesHelper($('#dt_bebidas'), breakpointDefinition);
					}
				},
				"rowCallback" : function(nRow) {
					responsiveHelper_dt_basic.createExpandIcon(nRow);
				},
				"drawCallback" : function(oSettings) {
					responsiveHelper_dt_basic.respond();
				}
			});

			$('#dt_comidas').dataTable({
				"oLanguage": {
					"sUrl": "{$this->html->url('/js/plugin/datatables/Spanish.json')}",
	 			},
				"sDom": "<'dt-toolbar'<'col-xs-12 col-sm-6'f><'col-sm-6 col-xs-12 hidden-xs'l>r>"+
					"t"+
					"<'dt-toolbar-footer'<'col-sm-6 col-xs-12 hidden-xs'i><'col-xs-12 col-sm-6'p>>",
				"autoWidth" : true,
				"preDrawCallback" : function() {
					// Initialize the responsive datatables helper once.
					if (!responsiveHelper_dt_basic) {
						responsiveHelper_dt_basic = new ResponsiveDatatablesHelper($('#dt_comidas'), breakpointDefinition);
					}
				},
				"rowCallback" : function(nRow) {
					responsiveHelper_dt_basic.createExpandIcon(nRow);
				},
				"drawCallback" : function(oSettings) {
					responsiveHelper_dt_basic.respond();
				}
			});

		/* END DATATABLES */
EOT;

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
		<section class="col col-md-2">
			<?php echo $this->html->link('Editar',array('controller'=>'combos','action'=>'editar',$combo['Combo']['id']),array('class'=>'btn btn-primary btn-lg'))?>
		</section>
	</div>

	<div class ="row">
		<section class="col col-md-7">
		<h3>Descripción:
			<strong><?php echo h($combo['Combo']['descripcion']); ?></strong>
		</h3>
		</section>
	</div>

	<hr class="simple">
	
	<div class = "row">


		<!-- widget grid -->
		<section id="widget-grid">
			<!-- NEW WIDGET START -->
			<article class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
				<!-- Widget ID (each widget will need unique ID)-->
				<div class="jarviswidget jarviswidget-color-green" id="nuevaComisionJarvis" data-widget-editbutton="false" data-widget-colorbutton="false" data-widget-fullscreenbutton="false" data-widget-deletebutton="false" data-widget-sortable="false">
					<header>
						<span class="widget-icon"> <i class="fa fa-bar-chart-o"></i> </span>
						<h2 class="font-md">Comidas</h2>
						<div class="widget-toolbar">
							<button class="btn btn-sm btn-default" data-toggle="modal" data-target="#nuevaComision" id="btn-nuevaComision" data-backdrop="static">
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
										<th>Tipo feria</th>
										<th>Tipo cliente</th>
										<th>Comision</th>
										<th>Acciones</th>
									</tr>
								</thead>
								<tbody>
									<!-- <?php foreach ($cliente['Comision'] as $key => $dato) {
											echo '<tr><td>'.$tipoFerias[$dato['tipo_feria_id']].'</td>';
											echo '<td>'.$tipoClientes[$dato['tipo_cliente_id']].'</td>';
											echo '<td>'.$dato['porcentaje_comision'].' %</td>';

											echo '<td>'.$this->Form->button('<i class="fa fa-edit"></i> Editar',
												array('type'=>'button', 'class'=>'btn btn-default btn-xs','escape'=>false,'data-toggle'=>'modal','data-target'=>'#editarComisionModal','backdrop'=>'static','id'=>'btn-editar','comision-id'=>$dato['id'],'tipo-feria'=>$tipoFerias[$dato['tipo_feria_id']],'tipo-cliente'=>$tipoClientes[$dato['tipo_cliente_id']],'porcentaje'=>$dato['porcentaje_comision'])).' ';

											//Datos para cargar en el mensaje de confirmación de borrado de una comisión
											$comisionDato = $tipoFerias[$dato['tipo_feria_id']].'-'.$tipoClientes[$dato['tipo_cliente_id']].': '.$dato['porcentaje_comision'].'%';
											echo ' '.$this->Html->link('<i class="fa fa-trash-o"></i> Borrar',array('controller'=>'comisiones','action'=>'borrar',$dato['id']),array('id'=>'btn-borrarComision','class'=>'btn btn-default btn-xs','escape'=>false, 'datos'=>$comisionDato)).'</td>';
										}
									?> -->
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
						<span class="widget-icon"> <i class="fa fa-building"></i> </span>
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
										<th>#</th>
										<th>Nombre</th>
										<th>Proporción</th>
										<th>Acciones</th>
									</tr>
								</thead>
								<tbody>
									<?php foreach ($bebidaCombo as $key => $bebida) {
											echo '<tr><td>'.$key.'</td>';
											echo '<td>'.$bebidas[$bebida['ProductoCombos']['producto_id']].'</td>';
											echo '<td>'.$bebida['ProductoCombos']['cantidad_producto'].'</td>';
											echo '<td>'.$this->Form->button('<i class="fa fa-edit"></i> Eliminar',
												array('type'=>'button', 'class'=>'btn btn-default btn-xs','escape'=>false,'data-toggle'=>'modal','data-target'=>'#editarEstablecimientoModal','backdrop'=>'static','id'=>'btn-editarEstablecimiento','establecimiento-id'=>$bebida['ProductoCombos']['id'])).' ';
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
<?php //echo '<div>'.$this->element('Modals/modalEditarEstablecimiento').'</div>'; ?>
<?php //echo '<div>'.$this->element('Modals/modalNuevaComision').'</div>'; ?>
<?php //echo '<div>'.$this->element('Modals/modalNuevoCredito').'</div>'; ?>
<?php //echo '<div>'.$this->element('Modals/modalEditarCredito').'</div>'; ?>
<?php //echo '<div>'.$this->element('Modals/modalEditarComision').'</div>'; ?>
<?php //END MODALES ?>
