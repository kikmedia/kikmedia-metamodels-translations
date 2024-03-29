<?php
/**
 * The MetaModels extension allows the creation of multiple collections of custom items,
 * each with its own unique set of selectable attributes, with attribute extendability.
 * The Front-End modules allow you to build powerful listing and filtering of the
 * data in each collection.
 *
 * PHP version 5
 * @package	   MetaModels
 * @subpackage AttributeSelect
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
 * This is the MetaModelFilterRule class for handling select fields.
 *
 * @package	   MetaModels
 * @subpackage AttributeSelect
 * @author     Christian Schiffler <c.schiffler@cyberspectrum.de>
 */
class MetaModelFilterRuleSelect extends MetaModelFilterRule
{
	/**
	 * The attribute this rule applies to.
	 * @var IMetaModelAttribute
	 */
	protected $objAttribute = NULL;

	public function __construct(MetaModelAttributeSelect $objAttribute, $strValue)
	{
		parent::__construct();
		$this->objAttribute = $objAttribute;
		$this->value = $strValue;
	}

	public function sanitizeValue()
	{
		$strTableNameId = $this->objAttribute->get('select_table');
		$strColNameId = $this->objAttribute->get('select_id');
		$strColNameAlias = $this->objAttribute->get('select_alias');

		$arrValues = explode(',', $this->value);

		$objDB = Database::getInstance();

		if ($strColNameAlias)
		{
			$arrLookup = array_map('mysql_real_escape_string', $arrValues);
			$objSelectIds = $objDB->execute('SELECT ' . $strColNameId . ' FROM ' . $strTableNameId . ' WHERE ' . $strColNameAlias . ' IN (\'' . implode('\',\'', $arrLookup) . '\')');

			$arrValues = $objSelectIds->fetchEach($strColNameId);
		} else {
			$arrValues = array_map('intval', $arrValues);
		}
		return $arrValues;
	}

	/**
	 * {@inheritdoc}
	 */
	public function getMatchingIds()
	{
		$arrValues = $this->sanitizeValue();
		if (!$arrValues)
		{
			return array();
		}
		$objDB = Database::getInstance();
		$objMatches = $objDB->execute('SELECT id FROM ' . $this->objAttribute->getMetaModel()->getTableName() . ' WHERE ' . $this->objAttribute->getColName() . ' IN (' . implode(',', $arrValues) . ')');

		return $objMatches->fetchEach('id');
	}
}

?>