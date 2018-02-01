<?php
$this->Html->addCrumb('Productos', array('controller' => 'productos', 'action' => 'index'));

$this->start('pageRelatedPlugins');
	echo $this->Html->script('plugin/datatables/jquery.dataTables.min');
	echo $this->Html->script('plugin/datatables/dataTables.colVis.min');
	echo $this->Html->script('plugin/datatables/dataTables.tableTools.min');
	echo $this->Html->script('plugin/datatables/dataTables.bootstrap.min');
	echo $this->Html->script('plugin/datatable-responsive/datatables.responsive.min');
$this->end();

$this->Js->buffer($this->element('Js/Productos/indexJs'));
?>
<h1><i class="fa fa-lg fa-fw fa-cutlery"></i><?php echo __('Productos'); echo ' ' . $this->html->link('Nuevo',array('controller'=>'productos','action'=>'nuevo'),array('class'=>'btn btn-primary')); ?></h1>
<div class="well" style="overflow-x:scroll;">
	<table id="dt_productos" class="table table-striped table-bordered table-hover" style="overflow-x: scroll">

	<thead>
	<tr>
			<th width="40px">#</th>
			<th>Nombre</th>
			<th>Medida</th>
			<th>Descripcion</th>
			<th>Tipo</th>
			<th width="80px">Acciones</th>
	</tr>
	</thead>
	<tbody>

	</tbody>
	</table>
</div>