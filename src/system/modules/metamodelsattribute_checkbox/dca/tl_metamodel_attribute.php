<?php if (!defined('TL_ROOT')) die('You can not access this file directly!');


/**
 * Table tl_metamodel_attribute 
 */

$GLOBALS['TL_DCA']['tl_metamodel_attribute']['metapalettes']['checkbox extends _simpleattribute_'] = array
(
	'+advanced' => array('check_publish')
);

$GLOBALS['TL_DCA']['tl_metamodel_attribute']['fields']['check_publish'] = array
(
	'label'                 => &$GLOBALS['TL_LANG']['tl_metamodel_attribute']['check_publish'],
	'exclude'               => true,
	'inputType'             => 'checkbox',
	'eval'                  => array
	(
        'tl_class'=>'clr'
	),
);

?>