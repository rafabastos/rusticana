<?php
App::uses('AppController', 'Controller');
/**
 * Clientes Controller
 *
 * @property Cliente $Cliente
 * @property PaginatorComponent $Paginator
 */
class ProductoCombosController extends AppController {

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
			if(isset($this->request->data['Bebida'])) {
				$bebida = array(
					'ProductoCombo' => array(
						'combo_id' => $this->request->data['Bebida']['combo_id'],
						'cantidad_producto' => $this->request->data['Bebida']['proporcion'],
						'producto_id' => $this->request->data['Bebida']['bebida'],
						'tipo_producto_id' => $this->request->data['Bebida']['tipo_producto_id']
					)
				);
				$this->ProductoCombo->create();
				if ($this->ProductoCombo->save($bebida)) {
					return $this->redirect(array('controller' => 'combos','action' => 'detalles',$this->request->data['Bebida']['combo_id']));
				}
			}
			if(isset($this->request->data['Comida'])) {
				$bebida = array(
					'ProductoCombo' => array(
						'combo_id' => $this->request->data['Comida']['combo_id'],
						'cantidad_producto' => $this->request->data['Comida']['proporcion'],
						'producto_id' => $this->request->data['Comida']['comida'],
						'tipo_producto_id' => $this->request->data['Comida']['tipo_producto_id']
					)
				);
				$this->ProductoCombo->create();
				if ($this->ProductoCombo->save($bebida)) {
					return $this->redirect(array('controller' => 'combos','action' => 'detalles',$this->request->data['Comida']['combo_id']));
				}
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
	public function borrar($id = null, $comboId = null) {

		$this->ProductoCombo->id = $id;
		$this->ProductoCombo->delete();
		return $this->redirect(array('controller' => 'combos','action' => 'detalles',$comboId));
	}

}// END CLIENTES CONTROLLER