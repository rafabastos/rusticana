<?php
App::uses('AppController', 'Controller');
/**
 * Clientes Controller
 *
 * @property Cliente $Cliente
 * @property PaginatorComponent $Paginator
 */
class TipoProductosController extends AppController {

/**
 * Components
 *
 * @var array
 */
	public $helpers = array('Js');

/**
 * Components
 *
 * @var array
 */
	public $components = array('Paginator','Funciones');

/**
 * Muestra una lista de todos los compradores y vendedores
 *
 * @return void
 */
	public function index() {
		if($this->request->is(array('ajax'))) {
			$this->autoRender=false;
			$query=$this->request->query;
			$modelo = 'TipoProducto';
	        $campos = array(
					'TipoProducto.id',
					'TipoProducto.tipo',
					'TipoProducto.descripcion'
					);
	        $contiene = [
			];
	        $columnas = [
				'TipoProducto.id',
				'TipoProducto.tipo',
				'TipoProducto.descripcion'
			];
	        $columnasBusqueda = [
				'TipoProducto.id',
				'TipoProducto.tipo',
				'TipoProducto.descripcion'
			];
	        
        	$condiciones=null;
	   
	        $output = $this->Funciones->dtDataTable($query,$modelo,$campos,$contiene,$columnas,$condiciones,$columnasBusqueda);
			$resultado['sEcho'] = $output['sEcho'];
	        $resultado['iTotalRecords'] = $output['iTotalRecords'];
	        $resultado['iTotalDisplayRecords'] = $output['iTotalDisplayRecords'];
			$resultado['data']=[];
			$view = new View($this);
	        $html = $view->loadHelper('Html','Form');
	        $indice = 1;
			foreach ($output['aaData'][0] as $key => $cliente) {
				$resultado['data'][$key]['id']=$indice;
				$resultado['data'][$key]['tipo']=$cliente['TipoProducto']['tipo'];
				$resultado['data'][$key]['descripcion']=$cliente['TipoProducto']['descripcion'];
				$resultado['data'][$key]['acciones']= $view->Html->link(__('<i class="fa fa-trash-o"></i>'), array('action' => 'borrar', $cliente['TipoProducto']['id']),
						array('escape'=>false,'class'=>'btn btn-default btn-xs','id'=>'btn-borrar','rel'=>'tooltip', 'data-placement'=>'top', 'data-original-title'=>'Borrar Cliente' ));
				$indice++;
			}
		 return json_encode($resultado);
		}
	}

/**
 * add method
 *
 * @return void
 */
	public function nuevo() {
		
		if ($this->request->is('post')) {
			$this->TipoProducto->create();
			if ($this->TipoProducto->save($this->request->data)) {
				// $this->Session->setFlash('El tipo de producto ha sido agregado.','Flash/success');
				return $this->redirect(array('action' => 'index'));
			}
		}
	}

	public function editar($id = null) {
		if (!$this->Cliente->exists($id)) {
			throw new NotFoundException(__('Cliente a ser editado no existe'));
		}
		if ($this->request->is(array('post', 'put'))) {
			$this->request->data['Cliente']['users_edit'] = $this->Session->read('Auth.User.id');
			if ($this->Cliente->save($this->request->data)) {
				$this->Session->setFlash('Cliente editado.','Flash/success');
				return $this->redirect(array('action' => 'detalles',$this->request->data['Cliente']['id']));
			} else {
				$this->Session->setFlash('Los datos no pudieron ser guardados. Favor intente nuevamente.','Flash/error');
			}
		} else {
			$options = array('conditions' => array('Cliente.' . $this->Cliente->primaryKey => $id));
			$this->request->data = $this->Cliente->find('first', $options);
		}
		$tipoPersonas = $this->Cliente->TipoPersona->find('list');
		$tipoClientes = $this->Cliente->TipoCliente->find('list');
		$this->set(compact('tipoPersonas', 'tipoClientes'));
	}

// /**
//  * delete method
//  *
//  * @throws NotFoundException
//  * @param string $id
//  * @return void
//  */
	public function borrar($id = null) {
		$this->TipoProducto->id = $id;
		if (!$this->TipoProducto->exists()) {
			throw new NotFoundException(__('Invalid tipo producto'));
		}
		$this->TipoProducto->delete();
		return $this->redirect(array('action' => 'index'));

	}

}// END CLIENTES CONTROLLER