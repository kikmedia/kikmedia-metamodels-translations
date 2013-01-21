<?php
/**
 * The MetaModels extension allows the creation of multiple collections of custom items,
 * each with its own unique set of selectable attributes, with attribute extendability.
 * The Front-End modules allow you to build powerful listing and filtering of the
 * data in each collection.
 *
 * PHP version 5
 * @package    MetaModels
 * @subpackage AttributeAlias
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
 * This is the MetaModelAttribute class for handling text fields.
 *
 * @package    MetaModels
 * @subpackage AttributeAlias
 * @author     Christian Schiffler <c.schiffler@cyberspectrum.de>
 */
class MetaModelAttributeAlias extends MetaModelAttributeSimple
{

	public function getSQLDataType()
	{
		return 'varchar(255) NOT NULL default \'\'';
	}

	public function getAttributeSettingNames()
	{
		return array_merge(parent::getAttributeSettingNames(), array('alias_fields', 'isunique', 'force_alias'));
	}

	public function getFieldDefinition()
	{
		$arrFieldDef = parent::getFieldDefinition();

		$arrFieldDef['inputType'] = 'text';

		return $arrFieldDef;
	}

	/**
	 * {@inheritdoc}
	 */
	public function modelSaved($objItem)
	{
		// alias already defined and no update forced, get out!
		if ($objItem->get($this->getColName()) && (!$this->get('force_alias')))
		{
			return;
		}

		$arrAlias = '';
		foreach (deserialize($this->get('alias_fields')) as $strAttribute)
		{
			$arrValues = $objItem->parseAttribute($strAttribute['field_attribute'], 'text', null);
			$arrAlias[] = $arrValues['text'];
		}

		// implode with '-'
		$strAlias  = standardize(implode('-', $arrAlias));

		// we need to fetch the attribute values for all attribs in the alias_fields and update the database and the model accordingly.
		if ($this->get('isunique'))
		{
			$intCount = 1;
			// ensure uniqueness.
			while (count($this->searchFor($strAlias . '-' . (++$intCount))) > 0){}
			$strAlias = $strAlias . '-' . $intCount;
		}

		$this->setDataFor(array($objItem->get('id') => $strAlias));
		$objItem->set($this->getColName(), $strAlias);
	}
}

?>