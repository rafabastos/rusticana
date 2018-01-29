<?php
$this->Html->addCrumb('TipoProductos', array('controller' => 'tipoProductos', 'action' => 'index'));

$this->start('pageRelatedPlugins');
	echo $this->Html->script('plugin/datatables/jquery.dataTables.min');
	echo $this->Html->script('plugin/datatables/dataTables.colVis.min');
	echo $this->Html->script('plugin/datatables/dataTables.tableTools.min');
	echo $this->Html->script('plugin/datatables/dataTables.bootstrap.min');
	echo $this->Html->script('plugin/datatable-responsive/datatables.responsive.min');
$this->end();

$this->Js->buffer($this->element('Js/TipoProductos/indexJs'));
?>
<h1><i class="fa fa-lg fa-fw fa-cog"></i><?php echo __('Tipos de Productos'); echo ' ' . $this->html->link('Nuevo',array('controller'=>'tipoProductos','action'=>'nuevo'),array('class'=>'btn btn-primary')); ?></h1>
<div class="well" style="overflow-x:scroll;">
	<table id="dt_productos" class="table table-striped table-bordered table-hover" style="overflow-x: scroll">

	<thead>
	<tr>
			<th>#</th>
			<th>Tipo</th>
			<th>Descripción</th>
			<th>Acciones</th>
	</tr>
	</thead>
	<tbody>

	</tbody>
	</table>
</div>