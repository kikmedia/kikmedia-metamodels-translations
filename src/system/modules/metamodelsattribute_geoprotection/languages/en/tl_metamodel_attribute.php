<?php
/**
 * The MetaModels extension allows the creation of multiple collections of custom items,
 * each with its own unique set of selectable attributes, with attribute extendability.
 * The Front-End modules allow you to build powerful listing and filtering of the
 * data in each collection.
 *
 * PHP version 5
 * @package	   MetaModels
 * @subpackage Backend
 * @author     Christian Schiffler <c.schiffler@cyberspectrum.de>
 * @copyright  CyberSpectrum
 * @license    private
 * @filesource
 */
if (!defined('TL_ROOT'))
{
	die('You cannot access this file directly!');
}

/**
 * Legends
 */
$GLOBALS['TL_LANG']['tl_metamodel_attribute']['display_legend']    = 'Display settings';

/**
 * Fields
 */
$GLOBALS['TL_LANG']['tl_metamodel_attribute']['typeOptions']['geoprotection']    = 'GeoProtection';
$GLOBALS['TL_LANG']['tl_metamodel_attribute']['geoprotection']                   = array('Countries', 'Choose the configurable countries for the editor.');

?>