<?php
/**
 * The MetaModels extension allows the creation of multiple collections of custom items,
 * each with its own unique set of selectable attributes, with attribute extendability.
 * The Front-End modules allow you to build powerful listing and filtering of the
 * data in each collection.
 *
 * PHP version 5
 * @package	   MetaModels
 * @subpackage AttributeTags
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
 * Supplementary class for handling DCA information for select attributes.
 *
 * @package	   MetaModels
 * @subpackage AttributeTags
 * @author     Christian Schiffler <c.schiffler@cyberspectrum.de>
 */
class TableMetaModelsAttributeTags extends TableMetaModelAttribute
{
	/**
	 * @var TableMetaModelRenderSetting
	 */
	protected static $objInstance = null;

	/**
	 * Get the static instance.
	 *
	 * @static
	 * @return MetaPalettes
	 */
	public static function getInstance()
	{
		if (self::$objInstance == null) {
			self::$objInstance = new TableMetaModelsAttributeTags();
		}
		return self::$objInstance;
	}

	public function getTableNames()
	{
		$objDB = Database::getInstance();
		return $objDB->listTables();
	}

	public function getColumnNames(DataContainer $objDC)
	{
		$arrFields = array();

		$objTable = $this->Database->prepare('SELECT tag_table FROM tl_metamodel_attribute WHERE id=?')
				->limit(1)
				->execute($objDC->id);
		if (($objTable->numRows > 0)
		    && $this->Database->tableExists($objTable->tag_table))
		{
			foreach ($this->Database->listFields($objTable->tag_table) as $arrInfo)
			{
				if ($arrInfo['type'] != 'index')
				{
					$arrFields[$arrInfo['name']] = $arrInfo['name'];
				}
			}
		}

		return $arrFields;
	}

	public function getIntColumnNames(DataContainer $objDC)
	{
		$arrFields = array();

		$objTable = $this->Database->prepare('SELECT tag_table FROM tl_metamodel_attribute WHERE id=?')
				->limit(1)
				->execute($objDC->id);
		if (($objTable->numRows > 0)
		    && $this->Database->tableExists($objTable->tag_table))
		{
			foreach ($this->Database->listFields($objTable->tag_table) as $arrInfo)
			{
				if ($arrInfo['type'] != 'index' && $arrInfo['type'] == 'int')
				{
					$arrFields[$arrInfo['name']] = $arrInfo['name'];
				}
			}
		}

		return $arrFields;
	}
}

?>