<?php if (!defined('TL_ROOT')) die('You cannot access this file directly!');

/**
 * The MetaModels extension allows the creation of multiple collections of custom items,
 * each with its own unique set of selectable attributes, with attribute extendability.
 * The Front-End modules allow you to build powerful listing and filtering of the
 * data in each collection.
 *
 * PHP version 5
 * @package	   MetaModels
 * @subpackage AttributeText
 * @author     Christian Schiffler <c.schiffler@cyberspectrum.de>
 * @copyright   CyberSpectrum, MEN AT WORK
 * @license    private
 * @filesource
 */

$GLOBALS['METAMODELS']['attributes']['checkbox'] = array
(
	'class' => 'MetaModelAttributeCheckbox',
	'image' => 'system/modules/metamodelsattribute_checkbox/html/checkbox.gif'
);

$GLOBALS['METAMODELS']['filters']['checkbox_published'] = array
(
	'class' => 'MetaModelFilterSettingPublishedCheckbox',
	'image' => 'system/themes/default/images/visible.gif',
	'info_callback' => array('MetaModelAttributeCheckboxBackendHelper', 'drawPublishedSetting'),
	'attr_filter' => array('checkbox')
);

?>