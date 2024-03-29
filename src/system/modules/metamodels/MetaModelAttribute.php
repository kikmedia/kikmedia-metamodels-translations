<?php
/**
 * The MetaModels extension allows the creation of multiple collections of custom items,
 * each with its own unique set of selectable attributes, with attribute extendability.
 * The Front-End modules allow you to build powerful listing and filtering of the
 * data in each collection.
 *
 * PHP version 5
 * @package	   MetaModels
 * @subpackage Core
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
 * This is the main MetaModels-attribute base class.
 * To create a MetaModelAttribute instance, use the {@link MetaModelAttributeFactory}
 * This class is the reference implementation for {@link IMetaModelAttribute}.
 *
 * @package	   MetaModels
 * @subpackage Core
 * @author     Christian Schiffler <c.schiffler@cyberspectrum.de>
 */
abstract class MetaModelAttribute implements IMetaModelAttribute
{

	/**
	 * Name of the MetaModel instance this object belongs to.
	 *
	 * @var string
	 */
	private $strMetaModel = '';

	/**
	 * The meta information of this attribute.
	 *
	 * @var array
	 */
	protected $arrData=array();

	/**
	 * instantiate an metamodel attribute.
	 * Note that you should not use this directly but use the factory classes to instantiate attributes.
	 *
	 * @param IMetaModel $objMetaModel the IMetaModel instance this attribute belongs to.
	 *
	 * @param array $arrData the information array, for attribute information, refer to documentation of table tl_metamodel_attribute
	 *                       and documentation of the certain attribute classes for information what values are understood.
	 */
	public function __construct(IMetaModel $objMetaModel, $arrData = array())
	{
		// meta information
		foreach($this->getAttributeSettingNames() as $strSettingName)
		{
			if(isset($arrData[$strSettingName]))
			{
				$this->set($strSettingName, $arrData[$strSettingName]);
			}
		}
		$this->strMetaModel = $objMetaModel->getTableName();
	}

	/**
	 * Retrieve the human readable name (or title) from the attribute.
	 *
	 * If the MetaModel is translated, the currently active language is used,
	 * with properly falling back to the defined fallback language.
	 *
	 * @return string the human readable name
	 */
	public function getName()
	{
		if (is_array($this->arrData['name']))
		{
			return $this->getLangValue($this->get('name'));
		}
		return $this->arrData['name'];
	}

	/**
	 * This extracts the value for the given language from the given language array.
	 *
	 * If the language is not contained within the value array, the fallback language from the parenting {@link IMetaModel}
	 * instance is tried as well.
	 *
	 * @param array  $arrValues the array holding all language values in the form array('langcode' => $varValue)
	 *
	 * @param string $strLangCode The language code of the language to fetch. Optional, if not given, $GLOBALS['TL_LANGUAGE'] is used.
	 *
	 * @return mixed|null the value for the given language or the fallback language, NULL if neither is present.
	 */
	protected function getLangValue($arrValues, $strLangCode = NULL)
	{
		if (!($this->getMetaModel()->isTranslated() && is_array($arrValues)))
		{
			return $arrValues;
		}

		if ($strLangCode === NULL)
		{
			return $this->getLangValue($arrValues, $GLOBALS['TL_LANGUAGE']);
		}

		if (array_key_exists($strLangCode, $arrValues))
		{
			return $arrValues[$strLangCode];
		} else {
			// lang code not set, use fallback.
			return $arrValues[$this->getMetaModel()->getFallbackLanguage()];
		}
	}

	// TODO: still a rough idea of how additional "external" formats can get supported, maybe we need more params.
	public function hookAdditionalFormatters($arrBaseFormatted, $arrRowData, $strOutputFormat, $objSettings)
	{
		$arrResult = $arrBaseFormatted;

		if (isset($GLOBALS['METAMODEL_HOOKS']['parseValue']) && is_array($GLOBALS['METAMODEL_HOOKS']['parseValue']))
		{
			foreach ($GLOBALS['METAMODEL_HOOKS']['parseValue'] as $callback)
			{
				list($strClass, $strMethod) = $callback;
				$objCallback = (in_array('getInstance', get_class_methods($strClass)))
					? call_user_func(array($strClass, 'getInstance'))
					: new $strClass();

				$arrResult = $objCallback->$strMethod($this, $arrBaseFormatted, $arrRowData, $strOutputFormat, $objSettings);
			}
		}

		return $arrResult;
	}

	/**
	 * when rendered via a template, this returns the values to be stored in the template.
	 */
	protected function prepareTemplate(MetaModelTemplate $objTemplate, $arrRowData, $objSettings = null)
	{
		$objTemplate->attribute = $this;
		$objTemplate->settings  = $objSettings;
		$objTemplate->row       = $arrRowData;
		$objTemplate->raw       = $arrRowData[$this->getColName()];
	}

	/////////////////////////////////////////////////////////////////
	// interface IMetaModelAttribute
	/////////////////////////////////////////////////////////////////

	/**
	 * {@inheritdoc}
	 */
	public function getColName()
	{
		return $this->arrData['colname'];
	}

	/**
	 * {@inheritdoc}
	 */
	public function getMetaModel()
	{
		return MetaModelFactory::byTableName($this->strMetaModel);
	}

	/**
	 * {@inheritdoc}
	 */
	public function get($strKey)
	{
		return $this->arrData[$strKey];
	}

	/**
	 * {@inheritdoc}
	 */
	public function set($strKey, $varValue)
	{
		if (in_array($strKey, $this->getAttributeSettingNames()))
			$this->arrData[$strKey] = deserialize($varValue);
		return $this;
	}

	/**
	 * {@inheritdoc}
	 */
	public function handleMetaChange($strMetaName, $varNewValue)
	{
		// by default we accept any change of meta information.
		$this->set($strMetaName, $varNewValue);

		return $this;
	}

	/**
	 * {@inheritdoc}
	 */
	public function destroyAUX()
	{
		// no-op
	}

	/**
	 * {@inheritdoc}
	 */
	public function initializeAUX()
	{
		// no-op
	}

	/**
	 * {@inheritdoc}
	 */
	public function getAttributeSettingNames()
	{
		return array('id', 'pid', 'sorting', 'tstamp', 'name', 'description', 'type', 'colname', 'isvariant');
	}

	/**
	 * {@inheritdoc}
	 */
	public function getFieldDefinition()
	{
		$strTableName = $this->getMetaModel()->getTableName();
		// only overwrite the language if not already set.
		if(!$GLOBALS['TL_LANG'][$strTableName][$this->getColName()])
		{
			$GLOBALS['TL_LANG'][$strTableName][$this->getColName()] = array
			(
				$this->getLangValue($this->get('name')),
				$this->getLangValue($this->get('description')),
			);
		}
		$arrFieldDef = array(
			'label' => &$GLOBALS['TL_LANG'][$strTableName][$this->getColName()],
			'eval'  => array()
		);

		$arrFieldDef['eval']['mandatory'] = $this->get('isunique') && in_array('isunique', $this->getAttributeSettingNames());

		// TODO: this is not used currently.
		$arrFieldDef['eval']['mandatory'] = $arrFieldDef['eval']['mandatory'] || ($this->get('mandatory') && in_array('mandatory', $this->getAttributeSettingNames()) ? true : false);
		return $arrFieldDef;
	}

	/**
	 * {@inheritdoc}
	 */
	public function getItemDCA()
	{
		return array('fields' => array_merge(
			array(
				$this->getColName() => $this->getFieldDefinition())
			),
			(array)$GLOBALS['TL_DCA'][$this->getMetaModel()->getTableName()]['fields'][$this->getColName()]
		);
	}

	/**
	 * {@inheritdoc}
	 */
	public function valueToWidget($varValue)
	{
		return $varValue;
	}

	/**
	 * {@inheritdoc}
	 */
	public function widgetToValue($varValue, $intId)
	{
		return $varValue;
	}

	/**
	 * {@inheritdoc}
	 */
	public function getDefaultRenderSettings()
	{
		$objSetting = (object)array
		(
			'template' => 'mm_attr_' . $this->get('type')
		);
		return $objSetting;
	}


	/**
	 * {@inheritdoc}
	 */
	public function parseValue($arrRowData, $strOutputFormat = 'text', $objSettings = null)
	{
		$arrResult = array(
			'raw' => $arrRowData[$this->getColName()],
		);

		if($objSettings && $objSettings->template)
		{
			$strTemplate = $objSettings->template;

			$objTemplate = new MetaModelTemplate($strTemplate);

			$this->prepareTemplate($objTemplate, $arrRowData, $objSettings);

			// text rendering is mandatory
			$arrResult['text'] = $objTemplate->parse('text', true);
			// now the desired format.

			if ($strValue = $objTemplate->parse($strOutputFormat, false))
			{
				$arrResult[$strOutputFormat] = $strValue;
			}
		}
		else {
			// text rendering is mandatory, therefore render using default render settings.
			$arrResult = $this->parseValue($arrRowData, 'text', $this->getDefaultRenderSettings());
		}

		// HOOK: apply additional formatters to attribute.
		$arrResult = $this->hookAdditionalFormatters($arrResult, $arrRowData, $strOutputFormat, $objSettings);

		return $arrResult;
	}

	/**
	 * {@inheritdoc}
	 */
	public function sortIds($arrIds, $strDirection)
	{
		// base implementation, do not perform any sorting.
		return $arrIds;
	}

	/**
	 * {@inheritdoc}
	 * Base implementation, do not perform any search;
	 */
	public function searchFor($strPattern)
	{
		return array();
	}

	/**
	 * {@inheritdoc}
	 * Base implementation, do not perform anything.
	 */
	public function modelSaved($objItem)
	{
		return;
	}
}

?>