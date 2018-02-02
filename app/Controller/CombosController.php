<?php
App::uses('AppController', 'Controller');
/**
 * Clientes Controller
 *
 * @property Cliente $Cliente
 * @property PaginatorComponent $Paginator
 */
class CombosController extends AppController {

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
			$modelo = 'Combo';
	        $campos = array(
					'id',
					'nombre',
					'cantidad_personas',
					'descripcion',
					);
	        $contiene = [
			];
	        $columnas = [
				'Combo.id',
	        	'Combo.nombre',
	        	'Combo.cantidad_personas',
				'Combo.descripcion',
			];
	        $columnasBusqueda = [
				'Combo.id',
				'Combo.nombre',
				'Combo.cantidad_personas',
				'Combo.descripcion',
			];
	        
        	$condiciones=null;
	   
	        $output = $this->Funciones->dtDataTable($query,$modelo,$campos,$contiene,$columnas,$condiciones,$columnasBusqueda);
			$resultado['sEcho'] = $output['sEcho'];
	        $resultado['iTotalRecords'] = $output['iTotalRecords'];
	        $resultado['iTotalDisplayRecords'] = $output['iTotalDisplayRecords'];
			$resultado['data']=[];
			$view = new View($this);
	        $html = $view->loadHelper('Html','Form');

			foreach ($output['aaData'][0] as $key => $producto) {
				$resultado['data'][$key]['id']=$producto['Combo']['id'];
				$resultado['data'][$key]['nombre']=$producto['Combo']['nombre'];
				$resultado['data'][$key]['descripcion']=$producto['Combo']['cantidad_personas'];
				$resultado['data'][$key]['tipo']=$producto['Combo']['descripcion'];
				$resultado['data'][$key]['acciones']=$view->Html->link(__('<i class="fa fa-list-ol"></i>'), array('action' => 'detalles', $producto['Combo']['id']),array('escape'=>false, 'class'=>'btn btn-default btn-xs','rel'=>'tooltip', 'data-placement'=>'top', 'data-original-title'=>'Detalles')).
					$view->Html->link(__('<i class="fa fa-trash-o"></i>'), array('action' => 'borrar', $producto['Combo']['id']),
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
		if($this->request->is(array('ajax'))) {
			$this->autoRender=false;
			$query=$this->request->query;
	        $modelo = 'ProductoCombos';
	        $campos = array(
					'id',
					'cantidad_producto',
					'producto_id',
					'combo_id',
					);
	        $contiene = [
			];
	        $columnas = [
				'ProductoCombos.id',
	        	'ProductoCombos.cantidad_producto',
	        	'ProductoCombos.producto_id',
				'ProductoCombos.combo_id',
			];
	        $columnasBusqueda = [
				'ProductoCombos.id',
				'ProductoCombos.cantidad_producto',
				'ProductoCombos.producto_id',
				'ProductoCombos.combo_id',
			];
	        
        	$condiciones=null;
			$condiciones['ProductoCombos.combo_id'] = $id;

	        $output = $this->Funciones->dtDataTable($query,$modelo,$campos,$contiene,$columnas,$condiciones,$columnasBusqueda);
			
			$combo = $this->Combo->find('first',array(
				'conditions'=>array('id'=>$id),
				'fields'=>array('id','nombre','cantidad_personas','descripcion'),
				'recursive'=>-1
			));
			$cantidadInvitados = $combo['Combo']['cantidad_personas'];
			if ($query['Calculadora']['cantidad'] != ""){
				$cantidadInvitados = $query['Calculadora']['cantidad'];
			}

			$resultado['sEcho'] = $output['sEcho'];
	        $resultado['iTotalRecords'] = $output['iTotalRecords'];
	        $resultado['iTotalDisplayRecords'] = $output['iTotalDisplayRecords'];
			$resultado['data']=[];
			$view = new View($this);
	        $html = $view->loadHelper('Html','Form');
	        $i=0;
	        $this->loadModel('Productos');
			foreach ($output['aaData'][0] as $key => $producto) {
				$resultado['data'][$key]['id']=$i;

				$productoNombre = $this->Productos->find('first',array(
					'conditions'=>array('id'=>$producto['ProductoCombos']['producto_id']),
					'fields'=>'nombre',
					'recursive'=>-1
				));
				$resultado['data'][$key]['nombre']=$productoNombre['Productos']['nombre'];
				$resultado['data'][$key]['cantidad_invitados']=$cantidadInvitados;
				
				$totalNecesario = ($producto['ProductoCombos']['cantidad_producto']/$combo['Combo']['cantidad_personas'])*$cantidadInvitados;
				$resultado['data'][$key]['total_necesario']=$totalNecesario;


				$resultado['data'][$key]['tipo']='TOTAL';
				$i++;
			}
		 return json_encode($resultado);
		}


		if (!$this->Combo->exists($id)) {
			throw new NotFoundException(__('No encontrado'));
		}

		$combo = $this->Combo->find('first',array(
			'conditions'=>array('id'=>$id),
			'fields'=>array('id','nombre','cantidad_personas','descripcion'),
			'recursive'=>-1
		));

		$this->loadModel('Productos');
		$productos = $this->Productos->find('all');
		$comidas = array();
		$bebidas = array();
		foreach ($productos as $key => $producto) {
			if ($producto['Productos']['tipo_producto_id'] == 1){
				$bebidas[$producto['Productos']['id']] = $producto['Productos']['nombre'].' ('.$producto['Productos']['unidade_medida'].')';
			}
			if ($producto['Productos']['tipo_producto_id'] == 2){
				$comidas[$producto['Productos']['id']] = $producto['Productos']['nombre'].' ('.$producto['Productos']['unidade_medida'].')';
			}
		}

		$this->loadModel('ProductoCombos');
		$comidaCombo = $this->ProductoCombos->find('all',array(
			'conditions'=>array('combo_id'=>$id, 'tipo_producto_id'=>2),
			'recursive'=>-1
		));
		$bebidaCombo = $this->ProductoCombos->find('all',array(
			'conditions'=>array('combo_id'=>$id, 'tipo_producto_id'=>1),
			'recursive'=>-1
		));


		$this->set(compact('combo','comidas','bebidas','comidaCombo','bebidaCombo'));

	}

/**
 * add method
 *
 * @return void
 */
	public function nuevo() {
		
		if ($this->request->is('post')) {

			$this->Combo->create();
			if ($this->Combo->save($this->request->data)) {
				return $this->redirect(array('action' => 'index'));
			}
		}
	}



	public function ingredientesComboPDF($comboId = null,$cantidad=null) {

		$this->autoRender=false;
		
		$dir = TMP; 
        $fechaHoraActual = time();
        foreach (scandir($dir) as $archivo) {
            if ($archivo == '.' || $archivo == '..') continue;
            if(is_file($dir.$archivo)){
                if($fechaHoraActual - filemtime($dir.$archivo) >= 1){
                    unlink($dir.$archivo);
                }
            }
        }     
        $layoutTitle = 'Lista_ingredientes_combo';       
        $pathFileTex=$dir.'Lista_ingredientes_combo'.'combo'.'.tex';
        $pathFilePdf=$dir.'Lista_ingredientes_combo'.'combo'.'.pdf';

        //se busca los productos del combo
        $this->loadModel('ProductoCombo');
        $productos_combo = $this->ProductoCombo->find('all',array(
        	'conditions'=>array('combo_id'=>$comboId,'tipo_producto_id'=>2),
        	'fields'=>array('cantidad_producto','producto_id'),
        	'recursive'=>-1
        ));

        $this->loadModel('Producto');
        $this->loadModel('IngredienteProducto');
        $this->loadModel('Ingrediente');

        foreach ($productos_combo as $key => $value) {	
        	//se agrega informaciones del producto
        	$producto = $this->Producto->find('first',array(
        		'conditions'=>array('id'=>$value['ProductoCombo']['producto_id'])
        	));
        	$productos_combo[$key]['Producto'] = $producto['Producto'];

        	//se agrega informaciones del ingrediente
        	$ingrediente_producto = $this->IngredienteProducto->find('all',array(
        		'conditions'=>array('producto_id'=>$value['ProductoCombo']['producto_id'])
        	));
        	foreach ($ingrediente_producto as $key2 => $value2) {
        		$ingrediente = $this->Ingrediente->find('first',array(
        			'conditions'=>array('id'=>$value2['IngredienteProducto']['ingrediente_id'])
        		));
        		$ingrediente_producto[$key2] = $ingrediente['Ingrediente'];
        		$ingrediente_producto[$key2]['cantidad'] = $value2['IngredienteProducto']['cantidad'];
        	}
        	$productos_combo[$key]['Ingredientes'] = $ingrediente_producto;
        }

        //ajusta la cantidad caso la cantidad de personas no sea el pre-definido

        if ($cantidad != null){
        	$combo = $this->Combo->find('first',array(
        		'conditions'=>array('id'=>$comboId)
        	));
        	if ($cantidad != $combo['Combo']['cantidad_personas']){
        		foreach ($productos_combo as $key => $value) {
        			$totalNecesario = ($value['ProductoCombo']['cantidad_producto']/$combo['Combo']['cantidad_personas'])*$cantidad;
					$productos_combo[$key]['ProductoCombo']['cantidad_producto']=$totalNecesario;
        		}

        	}
        }
        
        // debug($productos_combo);
        // die;


    	/* Inicio del Documento */
        /*Armado de las Caracteristicas del pdf*/
 		$latexDocument=
            '            
            \documentclass[landscape, 12pt]{report}
            \textwidth = 740pt
            \textheight = 500pt
            \topmargin = -30pt
            \oddsidemargin = -50pt 
            \usepackage{pdflscape}
            \usepackage[utf8]{inputenc}
            \usepackage{longtable}
            \usepackage{tabu}
            \usepackage{xcolor,colortbl}
            \usepackage{fancyhdr}
            \pagestyle{fancy}
            \fancyhf{}
            \fancyhead[R]{\thepage}
            \fancyhead[L]{RUSTICANA JARDIM}
            \fancyhead[C]{Lista de Compras}
            \begin{document}
            \newcommand\tab[1][0.5cm]{\hspace*{#1}}
        ';
        /*Fin de Armado de las Caracteristicas del pdf*/
		
		$totales_ingredientes = array();	        

        foreach ($productos_combo as $key => $producto_combo) {        
	        $latexDocument.='
            	\scriptsize
            	Ingredientes para: '.$producto_combo['ProductoCombo']['cantidad_producto'].' '.$producto_combo['Producto']['nombre'].' ('.$producto_combo['Producto']['unidade_medida'].')
            	\tabulinesep=1.2mm 
            	\begin{longtabu} to \textwidth {|X[1,l]|X[1,l]|X[1,l]|X[3,l]|}
                \hline 
                \textbf{Ingrediente}& \textbf{Cantidad} & \textbf{Medida} & \textbf{Observación}\\
                \hline 
                \endfirsthead
                \hline
                \endhead
                \hline \multicolumn{4}{r}{\textit{Continua en la siguiente página}}
                \endfoot
                \endlastfoot
                 ';

                foreach ($producto_combo['Ingredientes'] as $key => $ingrediente) {
			        $latexDocument.=''.$ingrediente['nombre'].'&';
			        $latexDocument.=''.$producto_combo['ProductoCombo']['cantidad_producto']*$ingrediente['cantidad'].'&';
			        $latexDocument.=''.$ingrediente['unidade_medida'].'&';
			        $latexDocument.='\\\\ ';
			        $latexDocument.='\cline{1-4}';

			        //carga el array con el total de los ingredientes
			        if (!isset($totales_ingredientes[$ingrediente['id']])){
			        	$totales_ingredientes[$ingrediente['id']] = $ingrediente;
			        	$totales_ingredientes[$ingrediente['id']]['cantidad'] = $producto_combo['ProductoCombo']['cantidad_producto']*$ingrediente['cantidad'];
			        } else {
			        	$totales_ingredientes[$ingrediente['id']]['cantidad'] += $producto_combo['ProductoCombo']['cantidad_producto']*$ingrediente['cantidad'];
			        }
                }

			$latexDocument.='\hline';
			$latexDocument.= '\bottomrule\end{longtabu}';

		}

		

			        // debug($totales_ingredientes);
           //      	die;



	
       	$latexDocument.='
        	\end{document}
        ';



        $myfile = fopen($pathFileTex, "w") or die("Unable to open file!");
        fwrite($myfile,$latexDocument);
        fclose($myfile);
        
        exec ("pdflatex --interaction batchmode -output-directory=".TMP."  ".$pathFileTex);
        $this->response->file($pathFilePdf);

        return $this->response;

	        
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