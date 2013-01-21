<?php if (!defined('TL_ROOT')) die('You can not access this file directly!');


/**
 * Table tl_metamodel_attribute
 */

$GLOBALS['TL_DCA']['tl_metamodel_attribute']['metapalettes']['alias extends _simpleattribute_'] = array
(
	'+advanced' => array('force_alias'),
	'+display'  => array('alias_fields after description')
);


$GLOBALS['TL_DCA']['tl_metamodel_attribute']['fields']['alias_fields'] = array
(
	'label'                 => &$GLOBALS['TL_LANG']['tl_metamodel_attribute']['alias_fields'],
	'exclude'                 => true,
	'inputType'               => 'multiColumnWizard',
	'eval'                    => array
	(
		'columnFields' => array
		(
			'field_attribute' => array
			(
				'label'                 => &$GLOBALS['TL_LANG']['tl_metamodel_attribute']['field_attribute'],
				'exclude'               => true,
				'inputType'             => 'select',
				'options_callback'      => array('TableMetaModelsAttributeAlias','getAllAttributes'),
					'eval' => array
					(
					'style'             => 'width:600px',
					'chosen'            => 'true'
					)
			),
		),
	),
);

$GLOBALS['TL_DCA']['tl_metamodel_attribute']['fields']['force_alias'] = array
(
	'label'                   => &$GLOBALS['TL_LANG']['tl_metamodel_attribute']['force_alias'],
	'exclude'                 => true,
	'inputType'               => 'checkbox',
	'eval'                    => array
	(
		'tl_class'=>'cbx w50'
	),
);

?>