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
			$modelo = 'Cliente';
	        $campos = array(
					'id',
					'ci_ruc',
					'razon_social',
					'persona_contacto',
					'direccion',
					'celular',
					'telefono',
					'users_created',
					'users_edit'
					);
	        $contiene = [
				'TipoPersona'=>[
					'tipo_persona',
				],
				'UserCreated.username',
				'UserEdit.username',
			];
	        $columnas = [
				'Cliente.ci_ruc',
	        	'Cliente.razon_social',
	        	'Cliente.persona_contacto',
	        	'Cliente.direccion',
				'Cliente.celular',
				'Cliente.telefono',
				'TipoPersona.tipo_persona',
			];
	        $columnasBusqueda = [
				'Cliente.ci_ruc',
	        	'Cliente.razon_social',
	        	'Cliente.persona_contacto',
	        	'Cliente.direccion',
				'Cliente.celular',
				'Cliente.telefono',
				'TipoPersona.tipo_persona',
			];
	        
        	$condiciones=null;
	   
	        $output = $this->Funciones->dtDataTable($query,$modelo,$campos,$contiene,$columnas,$condiciones,$columnasBusqueda);
			$resultado['sEcho'] = $output['sEcho'];
	        $resultado['iTotalRecords'] = $output['iTotalRecords'];
	        $resultado['iTotalDisplayRecords'] = $output['iTotalDisplayRecords'];
			$resultado['data']=[];
			$view = new View($this);
	        $html = $view->loadHelper('Html','Form');

			foreach ($output['aaData'][0] as $key => $cliente) {
				$resultado['data'][$key]['ciRuc']=$cliente['Cliente']['ci_ruc'];
				$resultado['data'][$key]['razonSocial']=$cliente['Cliente']['razon_social'];
				$resultado['data'][$key]['contacto']=$cliente['Cliente']['persona_contacto'];
				$resultado['data'][$key]['direccion']=$cliente['Cliente']['direccion'];
				$resultado['data'][$key]['celular']=$cliente['Cliente']['celular'];
				$resultado['data'][$key]['telefono']=$cliente['Cliente']['telefono'];
				$resultado['data'][$key]['tipoPersona']=$cliente['TipoPersona']['tipo_persona'];
				$resultado['data'][$key]['creado']=$cliente['UserCreated']['username'];
				$resultado['data'][$key]['editado']=$cliente['UserEdit']['username'];

				$resultado['data'][$key]['acciones']=$view->Html->link(__('<i class="fa fa-list-ol"></i>'), array('action' => 'detalles', $cliente['Cliente']['id']),
					array('escape'=>false, 'class'=>'btn btn-default btn-xs','rel'=>'tooltip', 'data-placement'=>'top', 'data-original-title'=>'Detalles')).
					$view->Html->link(__('<i class="fa fa-edit"></i>'), array('action' => 'editar', $cliente['Cliente']['id']),
						array('escape'=>false, 'class'=>'btn btn-default btn-xs','rel'=>'tooltip', 'data-placement'=>'top', 'data-original-title'=>'Editar Cliente' )).
					$view->Html->link(__('<i class="fa fa-trash-o"></i>'), array('action' => 'borrar', $cliente['Cliente']['id']),
						array('escape'=>false,'class'=>'btn btn-default btn-xs','id'=>'btn-borrar','rel'=>'tooltip', 'data-placement'=>'top', 'data-original-title'=>'Borrar Cliente' ));
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
		if (!$this->Cliente->exists($id)) {
			throw new NotFoundException(__('No encontrado'));
		}

		$options = array('conditions' => array('Cliente.' . $this->Cliente->primaryKey => $id));
		$cliente = $this->Cliente->find('first', $options);
		
		$this->loadModel('Credito');
		$creditos = $this->Credito->find('all',array(
			'conditions'=>array(
				'Credito.cliente_id'=>$id,
			),
			'recursive' => -1
		));	

		// $cliente = $this->Cliente->id=$id;

		// $facturas=$this->Factura->find('all',array('conditions'=>'Factura.cliente_id= $cliente'));

		//Para que el formulario de ESTABLECIMIENTOS sea publado con las opciones
		//correctas se debe extraer los datos relacionados al cliente
		$clientes = array($cliente['Cliente']['id'] => $cliente['Cliente']['razon_social']);
		$paises = $this->Cliente->Establecimiento->Pais->find('list');
		$cdepartamentos = $this->Cliente->Establecimiento->Departamento->find('list');
		$cciudades = $this->Cliente->Establecimiento->Ciudad->find('list');
		$clocalidades = $this->Cliente->Establecimiento->Localidad->find('list');
		$tipoFerias = $this->Cliente->Comision->TipoFeria->find('list');
		$tiposDeCliente = array();
		foreach ($cliente['TipoCliente'] as $value) {
			if($value['id'] != PROVEEDOR) // Se restringe la comisión solamente al tipo COMPRADOR Y VENDEDOR
				$tiposDeCliente[] = $value['id'];
		}

		$tipoClientes = $this->Cliente->Comision->TipoCliente->find('list',array('conditions'=>array('TipoCliente.id'=>$tiposDeCliente)));
		$this->set(compact('cliente','creditos','clientes', 'paises', 'cdepartamentos', 'cciudades', 'clocalidades','tipoFerias','tipoClientes'));

	}

/**
 * add method
 *
 * @return void
 */
	public function nuevo() {
		
		if ($this->request->is('post')) {

			if($this->Cliente->find('count',array('conditions'=>array('OR'=>array('Cliente.ci_ruc'=>$this->request->data['Cliente']['ci_ruc'], 'Cliente.razon_social'=>$this->request->data['Cliente']['razon_social'])))) > 0){
				$this->Session->setFlash('Cliente ya existe. No puede existir mas de un cliente con el mismo CI/RUC o la misma Razon Social.','Flash/error');
				$this->redirect(array('controller' => 'clientes','action' => 'index'));
			}
			$this->Cliente->create();
			$this->request->data['Cliente']['users_created'] = $this->Session->read('Auth.User.id');
			if ($this->Cliente->save($this->request->data)) {
				$this->Session->setFlash('El cliente ha sido agregado.','Flash/success');
				return $this->redirect(array('action' => 'detalles',$this->Cliente->getLastInsertId()));
			} else {
				$this->Session->setFlash('El cliente no se ha guardado. Favor intente de nuevo.','Flash/error');
			}
		}
		$tipoPersonas = $this->Cliente->TipoPersona->find('list');
		$tipoClientes = $this->Cliente->TipoCliente->find('list');
		$this->set(compact('tipoPersonas', 'tipoClientes'));

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
		$this->loadModel('Remate');
		$this->loadModel('Programacion');
		$this->loadModel('Establecimiento');
		$this->loadModel('Comision');
		$CausasParaNoBorrar=0;
		$this->Cliente->id = $id;
		if (!$this->Cliente->exists()) {
			throw new NotFoundException(__('Invalid cliente'));
		}
		/*Se verifica que el cliente a ser borrado no estÃ¡ asociado a algÃºn proceso  ya sea en programación o en 
			remate*/
		if($this->Programacion->find('count',array('conditions'=>array('Programacion.cliente_id'=>$id)))){
			$CausasParaNoBorrar=1;
		}else{
			if($this->Remate->find('count',array('conditions'=>array('Remate.comprador_id'=>$id)))){
			  $CausasParaNoBorrar=2;	
			}else{
				if($this->Establecimiento->find('count',array('conditions'=>array('Establecimiento.cliente_id'=>$id)))){
				  $CausasParaNoBorrar=3;
				}else{
					if($this->Comision->find('count',array('conditions'=>array('Comision.cliente_id'=>$id)))){
						$CausasParaNoBorrar=4;
					}
				}
			}
		 }
		

		if($CausasParaNoBorrar==0){

			if ($this->Cliente->delete()) {
				$this->Session->setFlash('Cliente borrado.','Flash/success');
			} else {
				$this->Session->setFlash('El cliente no se pudo borrar. Favor intentar de nuevo.','Flash/error');
			}
		}else{
			switch ($CausasParaNoBorrar) {
				case 1:
					$this->Session->setFlash('El cliente no se puede borrar porque tiene una programacion asociada','Flash/error');
					break;
				case 2:
					$this->Session->setFlash('El cliente no se puede borrar porque tiene un remate asociado','Flash/error');
					break;
				case 3:
					$this->Session->setFlash('El cliente no se puede borrar porque tiene un establecimiento asociado','Flash/error');
					break;
				case 4: 
					$this->Session->setFlash('El cliente no se puede borrar porque tiene una comisión asociada','Flash/error');
					break;				
				default:
					# code...
					break;
			}
			

		}
		return $this->redirect($this->referer());
	}

}// END CLIENTES CONTROLLER