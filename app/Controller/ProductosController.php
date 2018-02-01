<?php
App::uses('AppController', 'Controller');
/**
 * Clientes Controller
 *
 * @property Cliente $Cliente
 * @property PaginatorComponent $Paginator
 */
class ProductosController extends AppController {

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
			$modelo = 'Producto';
	        $campos = array(
					'id',
					'nombre',
					'descripcion',
					'tipo_producto_id',
					'unidade_medida'
					);
	        $contiene = [
			];
	        $columnas = [
				'Producto.id',
	        	'Producto.nombre',
	        	'Producto.descripcion',
	        	'Producto.tipo_producto_id',
	        	'Producto.unidade_medida'
			];
	        $columnasBusqueda = [
				'Producto.id',
				'Producto.nombre',
				'Producto.descripcion',
				'Producto.tipo_producto_id',
				'Producto.unidade_medida'
			];
	        
        	$condiciones=null;
	   
	        $output = $this->Funciones->dtDataTable($query,$modelo,$campos,$contiene,$columnas,$condiciones,$columnasBusqueda);
			$resultado['sEcho'] = $output['sEcho'];
	        $resultado['iTotalRecords'] = $output['iTotalRecords'];
	        $resultado['iTotalDisplayRecords'] = $output['iTotalDisplayRecords'];
			$resultado['data']=[];
			$view = new View($this);
	        $html = $view->loadHelper('Html','Form');
	        $this->loadModel('TipoProducto');
	        $indice = 1;
			foreach ($output['aaData'][0] as $key => $producto) {
				$resultado['data'][$key]['id']=$indice;
				$resultado['data'][$key]['nombre']=$producto['Producto']['nombre'];
				$resultado['data'][$key]['unidade_medida']=$producto['Producto']['unidade_medida'];
				$resultado['data'][$key]['descripcion']=$producto['Producto']['descripcion'];

				$tipoProducto = $this->TipoProducto->find('first',array(
					'conditions'=>array('id'=>$producto['Producto']['tipo_producto_id']),
					'fields'=>'tipo',
					'recursive'=>-1
				));
				$resultado['data'][$key]['tipo']=$tipoProducto['TipoProducto']['tipo'];

				$resultado['data'][$key]['acciones']= $view->Html->link(__('<i class="fa fa-list-ol"></i>'), array('action' => 'detalles', $producto['Producto']['id']), array('escape'=>false, 'class'=>'btn btn-default btn-xs','rel'=>'tooltip', 'data-placement'=>'top', 'data-original-title'=>'Detalles')).
				$view->Html->link('<i class="fa fa-trash-o fa-lg"></i>',['controller'=>'productos','action'=>'borrar',$producto['Producto']['id']],['class'=>"btn btn-default btn-xs",'rel'=>"tooltip",'data-placement'=>"top",'data-original-title'=>"Borrar Cliente",'escape'=>false]);
				$indice++;
			}
		 return json_encode($resultado);
		}
	}

/**
 * view method
 *
 * @throws NotFoundException
 * @param string $id cliente
 * @return void
 */
	public function detalles($id = null) {
		if (!$this->Producto->exists($id)) {
			throw new NotFoundException(__('No encontrado'));
		}

		$producto = $this->Producto->find('first',array(
			'conditions'=>array('id'=>$id),
			'fields'=>array('id','nombre','tipo_producto_id','descripcion','unidade_medida'),
			'recursive'=>-1
		));

		$this->loadModel('Ingrediente');
		$lista_ingredientes = $this->Ingrediente->find('all');
		$ingredientes = array();

		//se genera el listado de ingredientes para seleccion en el modal
		foreach ($lista_ingredientes as $key => $value) {
			$ingredientes[$value['Ingrediente']['id']] = $value['Ingrediente']['nombre'].' ('.$value['Ingrediente']['unidade_medida'].')';
		}

		$this->loadModel('IngredienteProducto');
		$ingredientes_productos = $this->IngredienteProducto->find('all');

		//genera el array con los datos de los ingredientes ya cargados en el producto
		foreach ($ingredientes_productos as $key => $value) {
			$ingredientes_productos[$key]['Ingrediente'] = $this->Ingrediente->find('first',array(
				'conditions'=>array('id'=>$value['IngredienteProducto']['ingrediente_id']),
				'recursive'=>-1
			));
		}

		$this->set(compact('producto','ingredientes','ingredientes_productos'));


	}

/**
 * add method
 *
 * @return void
 */
	public function nuevo() {
		
		if ($this->request->is('post')) {

			$this->Producto->create();
			if ($this->Producto->save($this->request->data)) {
				return $this->redirect(array('action' => 'index'));
			}
		}

		$this->loadModel('TipoProducto');
		$tipoProductos = $this->TipoProducto->find('list');
		foreach ($tipoProductos as $key => $value) {
			$tipo = $this->TipoProducto->find('first',array(
				'conditions'=>array('id'=>$key),
				'fields'=>'tipo',
				'recursive'=>-1
			));
			$tipoProductos[$key] = $tipo['TipoProducto']['tipo'];
		}
		$this->set(compact('tipoProductos'));

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

/**
 * delete method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function borrar($id = null) {
		$this->Producto->id = $id;
		$this->Producto->delete();
		return $this->redirect(array('action' => 'index'));
	}

}// END CLIENTES CONTROLLER