<?php
/**
 * The MetaModels extension allows the creation of multiple collections of custom items,
 * each with its own unique set of selectable attributes, with attribute extendability.
 * The Front-End modules allow you to build powerful listing and filtering of the
 * data in each collection.
 *
 * PHP version 5
 * @package	   MetaModels
 * @subpackage AttributeTranslatedTags
 * @author     Christian Schiffler <c.schiffler@cyberspectrum.de>
 * @copyright  CyberSpectrum, MEN AT WORK
 * @license    private
 * @filesource
 */
if (!defined('TL_ROOT'))
{
	die('You cannot access this file directly!');
}

$GLOBALS['METAMODELS']['attributes']['translatedtags'] = array
(
	'class' => 'MetaModelAttributeTranslatedTags',
	'image' => 'system/modules/metamodelsattribute_translatedtags/html/translatedtags.gif'
);

?>