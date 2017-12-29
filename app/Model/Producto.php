<?php
App::uses('AppModel', 'Model');
/**
 * TipoProducto Model
 */
class Producto extends AppModel {

/**
 * Validation rules
 *
 * @var array
 */
	public $validate = array(
		'tipo' => array(
			'notBlank' => array(
				'rule' => array('notBlank'),
				//'message' => 'Your custom message here',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
	);

	public $belongsTo = array(
		'TipoProducto' => array(
			'className' => 'TipoProducto',
			'foreignKey' => 'tipo_producto_id',
			'conditions' => '',
			'fields' => 'tipo',
			'order' => ''
		),
	);

	
	public $hasMany = array(
		'ProductoCombo' => array(
			'className' => 'ProductoCombo',
			// 'foreignKey' => 'combo_id',
			// 'dependent' => false,
			'conditions' => '',
			'fields' => '',
			'order' => '',
			'limit' => '',
			'offset' => '',
			'exclusive' => '',
			'finderQuery' => '',
			'counterQuery' => ''
		),
	);

}