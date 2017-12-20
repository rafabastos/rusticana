<?php
$this->Html->addCrumb('Clientes', array('controller' => 'clientes', 'action' => 'index'));

$this->start('pageRelatedPlugins');
	echo $this->Html->script('plugin/datatables/jquery.dataTables.min');
	echo $this->Html->script('plugin/datatables/dataTables.colVis.min');
	echo $this->Html->script('plugin/datatables/dataTables.tableTools.min');
	echo $this->Html->script('plugin/datatables/dataTables.bootstrap.min');
	echo $this->Html->script('plugin/datatable-responsive/datatables.responsive.min');
$this->end();

$this->Js->buffer($this->element('Js/Productos/indexJs'));
?>
<h1><i class="fa fa-lg fa-fw fa-group"></i><?php echo __('Clientes'); echo ' ' . $this->html->link('Nuevo',array('controller'=>'clientes','action'=>'nuevo'),array('class'=>'btn btn-primary')); ?></h1>
<div class="well" style="overflow-x:scroll;">
	<table id="dt_clientes" class="table table-striped table-bordered table-hover" style="overflow-x: scroll">

	<thead>
	<tr>
			<th>CI/RUC</th>
			<th>Razon Social</th>
			<th>Contacto</th>
			<th>Dirección</th>
			<th>Teléfono Celular</th>
			<th>Teléfono</th>
			<th>Tipo Persona</th>
			<th>Creado por</th>
			<th>Editado por</th>
			<th>Acciones</th>
	</tr>
	</thead>
	<tbody>

	</tbody>
	</table>
</div>