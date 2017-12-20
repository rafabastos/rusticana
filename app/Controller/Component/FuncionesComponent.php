<?php 
App::uses('Component', 'Controller');


class FuncionesComponent extends Component {


 public $components = array('Acl');
/**
 * nuevo method
 * @param $tipoCuota el tipo de cuota que se esta calculando
 * @param $fechaVencimiento  Fecha de vencimiento de la primera cuota en el formato DD/MM/AAAA
 * @param $cantidadCuotas cantidad de cuotas a ser calculadas
 * @param $importeTotal importe total a ser dividido en cuotas
 * @return 	array que contiene los siguientes índices 
 * 		  Array('fecha_vencimiento'=>'AAAA-mm-dd',
 *				'cuota'=> (int),
 *				'cobrada'=>false,
 *				'monto'=>(int)
 *		);
 */
    public function calcularCuotas($tipoCuota='M', $fechaVencimiento=null, $importeTotal=0, $cantidadCuotas=1) {

    	if($fechaVencimiento == null){
    		$fechaVencimiento = date('d/m/Y');
    	}

		$vencimiento = strtotime(str_replace('/', '-', $fechaVencimiento));
		$diaVencimiento = date('d',$vencimiento);
		$mesVencimiento = date('m',$vencimiento);
		$anhoVencimiento = date('Y',$vencimiento);
		//se generan las fechas de vencimiento
		$d = $m = $a = 0;
		switch ($tipoCuota) {
			case 'D': $d = 1;  break; //Diaria
			case 'X': $d = 7;  break; //Semanal
			case 'Q': $d = 14; break; //Quincenal
			case 'M': $d = 30;  break; //Mensual
			case 'T': $m = 3;  break; //Trimestral
			case 'S': $m = 6;  break; //Semestral
			case 'A': $a = 1;  break; //Anual
			default:  $m = 1;  break; //Default Mensual
		}
		//para calculo de importes
		$montoCuota = floor($importeTotal/ $cantidadCuotas); // se utiliza floor para dejar solamente la parte entera de la división y así poder sumar siempre la diferencia
		$diferencia = $importeTotal % $cantidadCuotas;
		for($i = 0; $i < $cantidadCuotas; $i++){
			// if ($tipoCuota == 'M') {
			// 	$diaVencimiento -= 1;
			// 	if ($diaVencimiento == 0){
			// 		switch ($mesVencimiento+($i*$m)) {
			// 			case 01:
			// 			case 03:
			// 			case 05:
			// 			case 07:
			// 			case 09:
			// 			case 11:
			// 			case 08:
			// 				$diaVencimiento = 31;
			// 				break;
			// 			case 04:
			// 			case 06:
			// 			case 10:
			// 			case 12:
			// 				$diaVencimiento = 30;
			// 				break;
			// 			case 02:
			// 				$diaVencimiento = 28;
			// 				break;
			// 		}
			// 	}
			// 	$data[$i]['fecha_vencimiento'] = date('Y-m-d',mktime(0, 0, 0,  $mesVencimiento+($i*$m) , $diaVencimiento+($i*$d), $anhoVencimiento+($i*$a)));
			// } else {
				$data[$i]['fecha_vencimiento'] = date('Y-m-d',mktime(0, 0, 0,  $mesVencimiento+($i*$m) , $diaVencimiento+($i*$d), $anhoVencimiento+($i*$a)));
			// }

			$data[$i]['cuota']=$i+1;
			$data[$i]['cobrada'] = false;
			if($i==0){//primera cuota ajustada con el monto del resto
				$data[$i]['monto']= $montoCuota+$diferencia;	
			}else{
				$data[$i]['monto']=$montoCuota;
			}
		}
		return $data;
    }
 
 /**
  * Funcion que recibe una fecha en formaqto Y-m-d y la convierte a formato (en castellano) D, d de m del A.
  * Ej: 
  * 	Entrada: 2015-12-31   
  * 	Salida: Jueves, 31 de Diciembre de 2015
  * @param date $fecha fecha a ser convertida
  * @return string cadena de caracteres con la fecha
  */
 	function fechaLarga($fecha) {
 		$dias = array("Domingo","Lunes","Martes","Miércoles","Jueves","Viernes","Sábado");
		$meses = array("Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto","Septiembre","Octubre","Noviembre","Diciembre");
		return $dias[date('w',strtotime($fecha))].", ".date('d',strtotime($fecha))." de ".$meses[date('n',strtotime($fecha))-1]. " del ".date('Y',strtotime($fecha)) ;
 	}

 /**
  * Funcion que transforma numeros en letras para impresion de recibos, facturas etc.
  * @param   $xcifra monto a transformar
  * @return string cadena de caracteres con el monto en letras.
  */
	 function numerosLetras($xcifra) {
	    $xarray = array(0 => "Cero",
	        1 => "UN", "DOS", "TRES", "CUATRO", "CINCO", "SEIS", "SIETE", "OCHO", "NUEVE",
	        "DIEZ", "ONCE", "DOCE", "TRECE", "CATORCE", "QUINCE", "DIECISEIS", "DIECISIETE", "DIECIOCHO", "DIECINUEVE",
	        "VEINTI", 30 => "TREINTA", 40 => "CUARENTA", 50 => "CINCUENTA", 60 => "SESENTA", 70 => "SETENTA", 80 => "OCHENTA", 90 => "NOVENTA",
	        100 => "CIENTO", 200 => "DOSCIENTOS", 300 => "TRESCIENTOS", 400 => "CUATROCIENTOS", 500 => "QUINIENTOS", 600 => "SEISCIENTOS", 700 => "SETECIENTOS", 800 => "OCHOCIENTOS", 900 => "NOVECIENTOS"
	    );
	//
	    $xcifra = trim($xcifra);
	    $xlength = strlen($xcifra);
	    $xpos_punto = strpos($xcifra, ".");
	    $xaux_int = $xcifra;
	    $xdecimales = "00";
	    if (!($xpos_punto === false)) {
	        if ($xpos_punto == 0) {
	            $xcifra = "0" . $xcifra;
	            $xpos_punto = strpos($xcifra, ".");
	        }
	        $xaux_int = substr($xcifra, 0, $xpos_punto); // obtengo el entero de la cifra a covertir
	        $xdecimales = substr($xcifra . "00", $xpos_punto + 1, 2); // obtengo los valores decimales
	    }
	 
	    $XAUX = str_pad($xaux_int, 18, " ", STR_PAD_LEFT); // ajusto la longitud de la cifra, para que sea divisible por centenas de miles (grupos de 6)
	    $xcadena = "";
	    for ($xz = 0; $xz < 3; $xz++) {
	        $xaux = substr($XAUX, $xz * 6, 6);
	        $xi = 0;
	        $xlimite = 6; // inicializo el contador de centenas xi y establezco el límite a 6 dígitos en la parte entera
	        $xexit = true; // bandera para controlar el ciclo del While
	        while ($xexit) {
	            if ($xi == $xlimite) { // si ya llegó al límite máximo de enteros
	                break; // termina el ciclo
	            }
	 
	            $x3digitos = ($xlimite - $xi) * -1; // comienzo con los tres primeros digitos de la cifra, comenzando por la izquierda
	            $xaux = substr($xaux, $x3digitos, abs($x3digitos)); // obtengo la centena (los tres dígitos)
	            for ($xy = 1; $xy < 4; $xy++) { // ciclo para revisar centenas, decenas y unidades, en ese orden
	                switch ($xy) {
	                    case 1: // checa las centenas
	                        if (substr($xaux, 0, 3) < 100) { // si el grupo de tres dígitos es menor a una centena ( < 99) no hace nada y pasa a revisar las decenas
	                             
	                        } else {
	                            $key = (int) substr($xaux, 0, 3);
	                            if (TRUE === array_key_exists($key, $xarray)){  // busco si la centena es número redondo (100, 200, 300, 400, etc..)
	                                $xseek = $xarray[$key];
	                                $xsub = $this->subfijo($xaux); // devuelve el subfijo correspondiente (Millón, Millones, Mil o nada)
	                                if (substr($xaux, 0, 3) == 100)
	                                    $xcadena = " " . $xcadena . " CIEN " . $xsub;
	                                else
	                                    $xcadena = " " . $xcadena . " " . $xseek . " " . $xsub;
	                                $xy = 3; // la centena fue redonda, entonces termino el ciclo del for y ya no reviso decenas ni unidades
	                            }
	                            else { // entra aquí si la centena no fue numero redondo (101, 253, 120, 980, etc.)
	                                $key = (int) substr($xaux, 0, 1) * 100;
	                                $xseek = $xarray[$key]; // toma el primer caracter de la centena y lo multiplica por cien y lo busca en el arreglo (para que busque 100,200,300, etc)
	                                $xcadena = " " . $xcadena . " " . $xseek;
	                            } // ENDIF ($xseek)
	                        } // ENDIF (substr($xaux, 0, 3) < 100)
	                        break;
	                    case 2: // checa las decenas (con la misma lógica que las centenas)
	                        if (substr($xaux, 1, 2) < 10) {
	                             
	                        } else {
	                            $key = (int) substr($xaux, 1, 2);
	                            if (TRUE === array_key_exists($key, $xarray)) {
	                                $xseek = $xarray[$key];
	                                $xsub = $this->subfijo($xaux);
	                                if (substr($xaux, 1, 2) == 20)
	                                    $xcadena = " " . $xcadena . " VEINTE " . $xsub;
	                                else
	                                    $xcadena = " " . $xcadena . " " . $xseek . " " . $xsub;
	                                $xy = 3;
	                            }
	                            else {
	                                $key = (int) substr($xaux, 1, 1) * 10;
	                                $xseek = $xarray[$key];
	                                if (20 == substr($xaux, 1, 1) * 10)
	                                    $xcadena = " " . $xcadena . " " . $xseek;
	                                else
	                                    $xcadena = " " . $xcadena . " " . $xseek . " Y ";
	                            } // ENDIF ($xseek)
	                        } // ENDIF (substr($xaux, 1, 2) < 10)
	                        break;
	                    case 3: // checa las unidades
	                        if (substr($xaux, 2, 1) < 1) { // si la unidad es cero, ya no hace nada
	                             
	                        } else {
	                            $key = (int) substr($xaux, 2, 1);
	                            $xseek = $xarray[$key]; // obtengo directamente el valor de la unidad (del uno al nueve)
	                            $xsub = $this->subfijo($xaux);
	                            $xcadena = " " . $xcadena . " " . $xseek . " " . $xsub;
	                        } // ENDIF (substr($xaux, 2, 1) < 1)
	                        break;
	                } // END SWITCH
	            } // END FOR
	            $xi = $xi + 3;
	        } // ENDDO
	 
	        // if (substr(trim($xcadena), -5, 5) == "ILLON") // si la cadena obtenida termina en MILLON o BILLON, entonces le agrega al final la conjuncion DE
	        //     $xcadena.= "";
	 
	        // if (substr(trim($xcadena), -7, 7) == "ILLONES") // si la cadena obtenida en MILLONES o BILLONES, entoncea le agrega al final la conjuncion DE
	        //     $xcadena.= "";
	 
	        // ----------- esta línea la puedes cambiar de acuerdo a tus necesidades o a tu país -------
	        if (trim($xaux) != "") {
	            switch ($xz) {
	                case 0:
	                    if (trim(substr($XAUX, $xz * 6, 6)) == "1")
	                        $xcadena.= "UN BILLON ";
	                    else
	                        $xcadena.= " BILLONES ";
	                    break;
	                case 1:
	                    if (trim(substr($XAUX, $xz * 6, 6)) == "1")
	                        $xcadena.= "UN MILLON ";
	                    else
	                        $xcadena.= " MILLONES ";
	                    break;
	                case 2:
	                    if ($xcifra < 1) {
	                        $xcadena = "CERO";
	                    }
	                    if ($xcifra >= 1 && $xcifra < 2) {
	                        $xcadena = "UNO";
	                    }
	                    if ($xcifra >= 2) {
	                        $xcadena.= ""; //
	                    }
	                    break;
	            } // endswitch ($xz)
	        } // ENDIF (trim($xaux) != "")
	        // ------------------      en este caso, para México se usa esta leyenda     ----------------
	        $xcadena = str_replace("VEINTI ", "VEINTI", $xcadena); // quito el espacio para el VEINTI, para que quede: VEINTICUATRO, VEINTIUN, VEINTIDOS, etc
	        $xcadena = str_replace("  ", " ", $xcadena); // quito espacios dobles
	        $xcadena = str_replace("UN UN", "UN", $xcadena); // quito la duplicidad
	        $xcadena = str_replace("  ", " ", $xcadena); // quito espacios dobles
	        $xcadena = str_replace("BILLON MILLONES", "BILLON", $xcadena); // corrijo la leyenda
	        $xcadena = str_replace("BILLONES MILLONES", "BILLONES", $xcadena); // corrijo la leyenda
	        $xcadena = str_replace("DE UN", "UNO", $xcadena); // corrijo la leyenda

	    } // ENDFOR ($xz)

	    if ($this->endsWith(trim($xcadena),"UN")) { //SI TERMINA EN UN agregarle el UNO.
		    $xcadena = trim($xcadena)."O";
		}
	    return trim($xcadena);
	}
	 
	// END FUNCTION
	 
	function subfijo($xx) { // esta función regresa un subfijo para la cifra
	    $xx = trim($xx);
	    $xstrlen = strlen($xx);
	    if ($xstrlen == 1 || $xstrlen == 2 || $xstrlen == 3)
	        $xsub = "";
	    //
	    if ($xstrlen == 4 || $xstrlen == 5 || $xstrlen == 6)
	        $xsub = "MIL";
	    //
	    return $xsub;
	}

	function endsWith($string, $test) {
	    $strlen = strlen($string);
	    $testlen = strlen($test);
	    if ($testlen > $strlen) return false;
	    return substr_compare($string, $test, $strlen - $testlen, $testlen,TRUE) === 0;
	}


/**
 * funcion que procesa datos que capturara el dataTable con ajax utilizando paginacion
 * @param $query  la información dataTable que se envía al servidor para cada solicitud 
 * @param $modelo  el nombre del modelo sobre el cual se va a trabajar
 * @param $campos  los campos propios del modelo que deseamos visualizar
 * @param $contiene  los campos contenidos dentro del modelo que deseamos visualizar
 * @param $columnas  las columnas que vamos a visualizar finalmente
 * @param $condiciones  las condiciones de busqueda
 * @param $columnasBusquedas  las columnas que deseamos filtrar
 * @return JSON con los datos y parametros necesarios para leer y contruir	
 *			el dataTable utilizando ajax
 */

	public function dtDataTable($query,$modelo,$campos,$contiene,$columnas,$condiciones=null,$columnasBusqueda) {
        //asignamos el valor del parametro $columnas a la variable $aColumns
        $aColumns = $columnas;
        //cargamos el modelo
        $Modelo = ClassRegistry::init($modelo);
        $sLimit = "";
        $offset = "";
        if(isset($query['iDisplayStart']) && $query['iDisplayLength'] != '-1'){
            $sLimit = intval($query['iDisplayLength']);//guardamos la cantidad de registros que se van a visualizar por cada pagina a la variable $sLimit
            $offset = intval($query['iDisplayStart']);//guardamos el numero a partir del cual se empiezan a contar los registros en la variable $offset
        }

        //Ordenar por...
        $sOrder = "";
        if (isset($query['iSortCol_0'])){
        	//recorremos todas las columnas del dataTable
            for ($i=0; $i<intval($query['iSortingCols']); $i++) {
            	//verificamos que la columna pueda filtrarse
                if ($query['bSortable_'.intval($query['iSortCol_'.$i])] == "true"){
                	//Guardamos el campo que deseamos filtar en forma ASC o DESC en la variable $sOrder 
                    $sOrder = $aColumns[intval($query['iSortCol_'.$i])].
                        ($query['sSortDir_'.$i]==="asc" ? " asc" : " desc") .", ";
                }
            }
            $sOrder = substr_replace( $sOrder, "", -2 );
        }

		$sWhere = array();


        if (isset($query['sSearch']) && $query['sSearch'] != ""){
            for ($i=0; $i<count($aColumns); $i++){
                if(in_array($aColumns[$i], $columnasBusqueda)){
                    $sWhere["{$aColumns[$i]} LIKE"] = "%{$query['sSearch']}%";
                } 
            }
        }
        $Modelo->Behaviors->load('Containable');

        //realizamos la consulta de acuerdo a los parametros previamente definidos
        if(isset($condiciones)){
	        $datos = $Modelo->find('all', array(
		        'limit' => $sLimit,
		        'offset' => $offset,
		        'fields' => $campos,
		        'contain' => $contiene,
		        'order' => $sOrder,
		        'conditions' => array($condiciones,'OR' => $sWhere)
		       ));

        }else{
	        $datos = $Modelo->find('all', array(
            'limit' => $sLimit,
            'offset' => $offset,
            'fields' => $campos,
            'contain' => $contiene,
            'order' => $sOrder,
            'conditions' => array('OR' => $sWhere)
            ));
        }

        //Guardamos el total de regitros en la variable $iTotal
        $iTotal = $Modelo->find('count');
        if(isset($condiciones)){
        	$iTotal = $Modelo->find('count', array(
				        'conditions' => array($condiciones)
			       ));
        }
        //Guardamos el total de registros filtrados en la variable $iTotalDisplay
        $iTotalDisplay = $Modelo->find('count', array(
        	'conditions' => array('OR' => $sWhere)
        	));
        if(isset($condiciones)){
        	$iTotalDisplay = $iTotal;
        }
        //Definimos los parametros que va a leer DataTable final
        $output = array(
                "sEcho" => intval(@$query['sEcho']),
                "iTotalRecords" => $iTotal,
                "iTotalDisplayRecords" => $iTotalDisplay,
                "aaData" => array()
        );
        $output['aaData'][] = $datos;                    
        return $output;
  }

/**
* Return an array of user Controllers and their methods.
* The function will exclude ApplicationController methods
* @return array
*/
    public function obtenerAcciones() {

        $aCtrlClasses = App::objects('controller');

        foreach ($aCtrlClasses as $controller) {
            if ($controller != 'AppController') {
                // Load the controller
                App::import('Controller', str_replace('Controller', '', $controller));

                // Load its methods / actions
                $aMethods = get_class_methods($controller);

                foreach ($aMethods as $idx => $method) {

                    if ($method[0] == '_') {
                        unset($aMethods[$idx]);
                    }
                }


                // Load the ApplicationController (if there is one)
                App::import('Controller', 'AppController');
                $parentActions = get_class_methods('AppController');

                $controllers[$controller] = array_diff($aMethods, $parentActions);
            }
        }

        return $controllers;
    }


    /**
* Return an array of user Controllers and their methods.
* The function will exclude ApplicationController methods
* @return array
*/
	public function getAccionesPath() {

		$controladores = $this->obtenerAcciones();
		$actionPaths = [];
		foreach ($controladores as $controlador => $acciones) {
			$controlador = str_replace('Controller', '', $controlador);
			foreach ($acciones as $accion) {
				$actionPaths[$controlador.'/'.$accion] = $controlador.'/'.$accion;
			}
		}

		return $actionPaths;
	}

	public function getAccesoUsuarios($usuarioId) {

		$controladores = $this->obtenerAcciones();
		$permisos = [];
		foreach ($controladores	as $controlador => $acciones) {
			$controlador = str_replace("Controller", "", $controlador);
			if($this->Acl->check(array('User' => array('id' => $usuarioId)),$controlador)) {
				$permisos[$controlador] = 'all';
			} else {
				foreach ($acciones as $accion) {
					if($this->Acl->check(array('User' => array('id' => $usuarioId)),$controlador.'/'.$accion)) {
						$permisos[$controlador][] = $accion;
					}
				}
			}
		}

		return $permisos;

	}



} //END COMPONENT
?>