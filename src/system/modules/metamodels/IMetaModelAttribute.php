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
 * This is the main MetaModels attribute interface.
 * To create {@link MetaModelAttribute} instances, use a {@link IMetaModelAttributeFactory}
 * This interface handles all general purpose attribute management and interfacing.
 *
 * @package	   MetaModels
 * @subpackage Interfaces
 * @author     Christian Schiffler <c.schiffler@cyberspectrum.de>
 */
interface IMetaModelAttribute
{

	/**
	 * Queries the attribute for it's column name within it's MetaModel.
	 *
	 * @return string the attribute's column name.
	 */
	public function getColName();

	/**
	 * Queries the attribute for it's parent MetaModel instance.
	 *
	 * @return IMetaModel the MetaModel instance.
	 */
	public function getMetaModel();

	/**
	 * retrieve a meta information setting.
	 *
	 * @param string $strKey   the meta information name that shall be retrieved.
	 *
	 * @return mixed
	 */
	public function get($strKey);

	/**
	 * override a meta information setting.
	 * All changes to an attribute via set() are considered to be non persistent and therefore will not update any
	 * structural information or auxiliary properties that might be needed within the attribute type.
	 *
	 * For persistent updates, use {@link IMetaModelAttribute::handleMetaChange()} instead.
	 *
	 * @param string $strKey   the meta information name that shall be set.
	 *
	 * @param mixed  $varValue the value to set.
	 *
	 * @return IMetaModelAttribute instance of this attribute, for chaining support.
	 */
	public function set($strKey, $varValue);

	/**
	 * Updates the meta information of the attribute.
	 * This tells the attribute to perform any actions that must be done to correctly initialize the new value
	 * and to perform any action to undo the changes that had been done for the previous value.
	 * i.e.: when an attribute type needs columns in an an auxiliary table, these will have to be updated herein.
	 *
	 * This method may throw an exception, when the new value is invalid or any problems appear, the MetaModelAttribute
	 * will then keep the old meta value.
	 *
	 * @param string $strMetaName name of the meta information that shall be updated.
	 * @param mixed  $varNewValue the new value for this meta information.
	 *
	 * @return IMetaModelAttribute the instance of this attribute, to support chaining.
	 */
	public function handleMetaChange($strMetaName, $varNewValue);

	/**
	 * Delete all auxiliary data like a column in the metamodel table or references in another table etc.
	 *
	 * @return void
	 */
	public function destroyAUX();

	/**
	 * Create auxiliary data like a column in the metamodel table or references in another table etc.
	 *
	 * @return void@return void
	 */
	public function initializeAUX();

	/**
	 * Returns all valid settings for the attribute type.
	 *
	 * @return array all valid setting names, this reensembles the columns in tl_metamodel_attribute this attribute class understands.
	 */
	public function getAttributeSettingNames();

	/**
	 * This generates the field definition for use in a DCA.
	 * It also sets the proper language variables (if not already set per dcaconfig.php or similar).
	 *
	 * @return array the DCA array to use as $GLOBALS['tablename']['fields']['attribute-name]
	 */
	public function getFieldDefinition();

	/**
	 * This generates the field definition for use in a DCA.
	 *
	 * @link IMetaModelAttribute::getFieldDefinition() is used internally for generating the result.
	 *
	 * The result contains all relevant settings for this field in an DCA for the given table
	 * and MAY override anything like palettes, subpalettes, field definitions etc.
	 * Due to the fact that it calls getFieldDefinition() internally, the result at least contains
	 * the sub array 'fields' with the information of this field's settings.
	 *
	 * @return array the DCA array to use as $GLOBALS['tablename']
	 */
	public function getItemDCA();

	/**
	 * This is used for transferring a native attribute value to a value that the widget,
	 * generated from the information obtained via {@link IMetaModelAttribute::getFieldDefinition()}
	 * can handle.
	 *
	 * @param mixed $varValue the value to be transformed.
	 *
	 * @return mixed the resulting widget compatible value
	 */
	public function valueToWidget($varValue);

	/**
	 * This is used for transferring a value that has been retrieved from a widget into native attribute
	 * value.
	 *
	 * @param mixed $varValue the value to be transformed.
	 *
	 * @param int   $intId    the id of the item the value belongs to.
	 *
	 * @return mixed the resulting native value
	 */
	public function widgetToValue($varValue, $intId);

	/**
	 * This method is called to store the data for certain items to the database.
	 *
	 * @param mixed[int] $arrValues the values to be stored into database. Mapping is item id=>value
	 *
	 * @return void
	 */
	public function setDataFor($arrValues);

	/**
	 * Retrieve an instance containing the default render settings for an attribute of this type.
	 *
	 * @return object
	 */
	public function getDefaultRenderSettings();

	/**
	 * Transform a value into real data.
	 * The returned array at least transports an string in the key 'text' which SHOULD be
	 * useful when being echo'ed in a template and the raw value in the section 'raw'.
	 * Each attribute class MAY return as many other values in this array with custom keys as it wants.
	 *
	 * @param array  $arrRowData      the (native) row data from the MetaModel table.
	 *
	 * @param string $strOutputFormat the desired output format.
	 *
	 * @param object $objSettings     custom settings to be passed to the renderer.
	 *
	 * @return array an array with all the converted data.
	 */
	public function parseValue($arrRowData, $strOutputFormat = 'text', $objSettings = null);

	/**
	 * Sorts the given array list by field value in the given direction.
	 *
	 * @param int[]  $arrIds       a list of Ids from the MetaModel table.
	 *
	 * @param string $strDirection the direction for sorting. either 'ASC' or 'DESC', as in plain SQL.
	 *
	 * @return int[] the sorted integer array.
	 */
	public function sortIds($arrIds, $strDirection);

	/**
	 * Retrieve values for use in filter options, that will be understood by DC_ filter
	 * panels and frontend filter select boxes.
	 *
	 * @param array $arrIds optional the ids that the values shall be fetched from.
	 */
	public function getFilterOptions($arrIds = array());
	// TODO: this is a first draft, maybe we need some better approach here.

	/**
	 * search matches for the given expression.
	 *
	 * @param string $strPattern the text to search for. This may contain wildcards.
	 *
	 * @return int[] the ids of matching items.
	 */
	public function searchFor($strPattern);

	/**
	 * Called by the MetaModel after an item has been saved.
	 * Useful for alias fields, edit counters etc.
	 *
	 * @param IMetaModelItem the item that has just been saved.
	 *
	 * @return void
	 */
	public function modelSaved($objItem);
}

?>