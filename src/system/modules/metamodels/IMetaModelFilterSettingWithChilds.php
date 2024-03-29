<?php
/**
 * The MetaModels extension allows the creation of multiple collections of custom items,
 * each with its own unique set of selectable attributes, with attribute extendability.
 * The Front-End modules allow you to build powerful listing and filtering of the
 * data in each collection.
 *
 * PHP version 5
 * @package	   MetaModels
 * @subpackage Interfaces
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
 *
 * This interface handles filter setting abstraction for settings that can contain childs.
 *
 * @see
 * @package	   MetaModels
 * @subpackage Interfaces
 * @author     Christian Schiffler <c.schiffler@cyberspectrum.de>
 */
interface IMetaModelFilterSettingWithChilds extends IMetaModelFilterSetting
{
	/**
	 * Adds a child setting to this setting.
	 *
	 * @param IMetaModelFilterSetting $objFilterSetting the setting that shall be added as child.
	 * @return void
	 */
	public function addChild(IMetaModelFilterSetting $objFilterSetting);
}

?>