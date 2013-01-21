<?php
/**
 * PHP version 5
 * @package	MetaModelsGeoportection
 * @copyright	MEN AT WORK
 * @license	private
 * @filesource
 */
if (!defined('TL_ROOT'))
{
	die('You cannot access this file directly!');
}

/**
 * Table tl_metamodel_attribute
 */
$GLOBALS['TL_DCA']['tl_metamodel_filtersetting']['metapalettes']['geoprotection extends default'] = array(
    '+config' => array('gp_attr_id')
);

$GLOBALS['TL_DCA']['tl_metamodel_filtersetting']['fields']['gp_attr_id'] = array
		(
			'label'                   => &$GLOBALS['TL_LANG']['tl_metamodel_filtersetting']['attr_id'],
			'exclude'                 => true,
			'inputType'               => 'select',
			'options_callback'        => array('TableMetaModelFilterSettingGeoprotection', 'getAttributeNames'),
			'eval'                    => array(
				'doNotSaveEmpty'      => true,
				'alwaysSave'          => true,
				'submitOnChange'      => true,
				'includeBlankOption'  => true,
				'mandatory'           => true,
                'tl_class'            => 'w50',
			),
			'load_callback'           => array(array('TableMetaModelFilterSetting', 'attrIdToName')),
			'save_callback'           => array(array('TableMetaModelFilterSetting', 'nameToAttrId')),
		);

?>