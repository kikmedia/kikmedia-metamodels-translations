<?php

class MetaModelFilterSettingGeoprotection extends MetaModelFilterSetting {

	/**
	 * 
	 * @param IMetaModelFilter $objFilter
	 * @param type $arrFilterUrl
	 * @return type
	 */
	public function prepareRules(IMetaModelFilter $objFilter, $arrFilterUrl) 
	{
		$objAttribute = $this->getMetaModel()->getAttributeById($this->get('gp_attr_id'));
		if ($objAttribute) {
			$objGeo = Geolocation::getInstance();
			$strCountry = $objGeo->getUserGeolocation()->getCountryShort();
			//set 'no_country' if no country was found
			$strCountry = ($strCountry) ? '%'.$strCountry.'%' : '%xx%';
			
			$arrMyFilterUrl = array_slice($arrFilterUrl, 0);
			$objFilterRule = new MetaModelFilterRuleSimpleQuery(
					'SELECT item_id FROM tl_metamodel_geoprotection WHERE attr_id = ? AND 
						((mode = \'gp_show\' AND countries LIKE ?) OR  (mode = \'gp_hide\' AND countries NOT LIKE ?) )',
					array($this->get('gp_attr_id'), $strCountry, $strCountry),
					'item_id'
			);

			$objFilter->addFilterRule($objFilterRule);
					return;

		}
		//  no attribute found 
		$objFilter->addFilterRule(new MetaModelFilterRuleStaticIdList(array()));
	}

}

?>