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
 * Fields
 */
$GLOBALS['TL_LANG']['tl_metamodel_filtersetting']['check_ignorepublished'] = array('Allow parameter override', 'If you check this, filter parameters may override this setting.');

/**
 * Reference
 */

$GLOBALS['TL_LANG']['tl_metamodel_filtersetting']['typenames']['checkbox_published'] = 'Published state';
$GLOBALS['TL_LANG']['tl_metamodel_filtersetting']['typedesc']['checkbox_published']  = '%s <strong>%s</strong><br /> on attribute <em>%s</em>';
?>