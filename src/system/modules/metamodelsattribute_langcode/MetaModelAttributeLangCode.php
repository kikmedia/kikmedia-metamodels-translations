<?php
/**
 * The MetaModels extension allows the creation of multiple collections of custom items,
 * each with its own unique set of selectable attributes, with attribute extendability.
 * The Front-End modules allow you to build powerful listing and filtering of the
 * data in each collection.
 *
 * PHP version 5
 * @package	   MetaModels
 * @subpackage AttributeLangCode
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
 * @package	   MetaModels
 * @subpackage AttributeLangCode
 * @author     Christian Schiffler <c.schiffler@cyberspectrum.de>
 */
class MetaModelAttributeLangCode extends MetaModelAttributeSimple
{
	/**
	 * when rendered via a template, this returns the values to be stored in the template.
	 */
	protected function prepareTemplate(MetaModelTemplate $objTemplate, $arrRowData, $objSettings = null)
	{
		parent::prepareTemplate($objTemplate, $arrRowData, $objSettings);
		$objTemplate->value = $this->resolveValue($arrRowData[$this->getColName()]);
	}

	/////////////////////////////////////////////////////////////////
	// interface IMetaModelAttributeSimple
	/////////////////////////////////////////////////////////////////

	public function getSQLDataType()
	{
		return 'varchar(2) NOT NULL default \'\'';
	}

	public function getAttributeSettingNames()
	{
		return array_merge(parent::getAttributeSettingNames(), array(
			'langcodes'
		));
	}

	public function getFieldDefinition()
	{
		$arrFieldDef=parent::getFieldDefinition();
		$arrFieldDef['inputType'] = 'select';
		$arrFieldDef['options'] = $this->get('langcodes');
		return $arrFieldDef;
	}

	protected function resolveValue($strLangValue)
	{
		$strLangCode = $this->getMetaModel()->getActiveLanguage();

		// set the desired language.
		MetaModelController::getInstance()->loadLanguageFile('languages', $strLangCode, true);
		if (strlen($GLOBALS['TL_LANG']['LNG'][$strLangValue]))
		{
			$strResult = $GLOBALS['TL_LANG']['LNG'][$strLangValue];
		} else {
			$strLangCode = $this->getMetaModel()->getFallbackLanguage();
			// set the fallback language.
			MetaModelController::getInstance()->loadLanguageFile('languages', $strLangCode, true);
			if (strlen($GLOBALS['TL_LANG']['LNG'][$strLangValue]))
			{
				$strResult = $GLOBALS['TL_LANG']['LNG'][$strLangValue];
			} else {
				// use english as last resort.
				include(TL_ROOT . '/system/config/languages.php');
				$strResult = $languages[$strLangValue];
			}
		}
		// switch back to the original FE language to not disturb the frontend.
		if ($strLangCode != $GLOBALS['TL_LANGUAGE'])
		{
			MetaModelController::getInstance()->loadLanguageFile('languages', false, true);
		}
		return $strResult;
	}
}

?>