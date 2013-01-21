<?php

class MetaModelFilterSettingPublishedCheckbox extends MetaModelFilterSetting
{
	public function prepareRules(IMetaModelFilter $objFilter, $arrFilterUrl)
	{
		if ($this->get('check_ignorepublished') && $arrFilterUrl['ignore_published' . $this->get('id')])
		{
			return;
		}
		$objAttribute = $this->getMetaModel()->getAttributeById($this->get('attr_id'));
		if ($objAttribute)
		{
			$objFilterRule = new MetaModelFilterRuleSimpleQuery(sprintf(
				'SELECT id FROM %s WHERE %s=?',
				$this->getMetaModel()->getTableName(),
				$objAttribute->getColName()
			), array(1));
			$objFilter->addFilterRule($objFilterRule);
			return;
		}
		// no attribute found, do not return anyting.
		$objFilter->addFilterRule(new MetaModelFilterRuleStaticIdList(array()));
	}

	/**
	 * {@inheritdoc}
	 */
	public function getParameters()
	{
		return ($this->get('check_ignorepublished')) ? array('ignore_published' . $this->get('id')) : array();
	}

	/**
	 * {@inheritdoc}
	 */
	public function getParameterDCA()
	{
		if (!$this->get('check_ignorepublished'))
		{
			return array();
		}

		$objAttribute = $this->getMetaModel()->getAttributeById($this->get('attr_id'));

		$arrLabel = array();
		foreach ($GLOBALS['TL_LANG']['MSC']['metamodel_filtersetting']['ignore_published'] as $strLabel)
		{
			$arrLabel[] = sprintf($strLabel, $objAttribute->getName());
		}

		return array(
			'ignore_published' . $this->get('id') => array
			(
				'label'   => $arrLabel,
				'inputType'    => 'checkbox',
			)
		);
	}
}

?>