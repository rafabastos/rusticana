<?php
$this->Html->addCrumb('Combos', array('controller' => 'combos', 'action' => 'index'));

$this->start('pageRelatedPlugins');
	echo $this->Html->script('plugin/datatables/jquery.dataTables.min');
	echo $this->Html->script('plugin/datatables/dataTables.colVis.min');
	echo $this->Html->script('plugin/datatables/dataTables.tableTools.min');
	echo $this->Html->script('plugin/datatables/dataTables.bootstrap.min');
	echo $this->Html->script('plugin/datatable-responsive/datatables.responsive.min');
$this->end();

$this->Js->buffer($this->element('Js/Combos/indexJs'));
?>
<h1><i class="fa fa-lg fa-fw fa-cutlery"></i><?php echo __('Combos'); echo ' ' . $this->html->link('Nuevo',array('controller'=>'combos','action'=>'nuevo'),array('class'=>'btn btn-primary')); ?></h1>
<div class="well" style="overflow-x:scroll;">
	<table id="dt_combos" class="table table-striped table-bordered table-hover" style="overflow-x: scroll">

	<thead>
	<tr>
			<th>#</th>
			<th>Nombre</th>
			<th>Cantidad Personas</th>
			<th>Descripción</th>
			<th>Acciones</th>
	</tr>
	</thead>
	<tbody>

	</tbody>
	</table>
</div>