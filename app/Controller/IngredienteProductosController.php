<?php
App::uses('AppController', 'Controller');
/**
 * Clientes Controller
 *
 * @property Cliente $Cliente
 * @property PaginatorComponent $Paginator
 */
class IngredienteProductosController extends AppController {

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
 * add method
 *
 * @return void
 */
	public function nuevo() {
		if ($this->request->is('post')) {
			$this->request->data['IngredienteProducto']['ingrediente_id'] = $this->request->data['IngredienteProducto']['ingrediente'];
			unset($this->request->data['IngredienteProducto']['ingrediente']);
			$this->IngredienteProducto->create();
			if ($this->IngredienteProducto->save($this->request->data)) {
				return $this->redirect(array('controller' => 'productos','action' => 'detalles',$this->request->data['IngredienteProducto']['producto_id']));
			}
		}
	}


// /**
//  * delete method
//  *
//  * @throws NotFoundException
//  * @param string $id
//  * @return void
//  */
	public function borrar($id = null, $productoId = null) {
		$this->IngredienteProducto->id = $id;
		$this->IngredienteProducto->delete();
		return $this->redirect(array('controller' => 'productos','action' => 'detalles',$productoId));
	}

}// END CLIENTES CONTROLLER