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
if (!defined('TL_ROOT')) {
	die('You cannot access this file directly!');
}

/**
 * This is the MetaModel filter interface.
 *
 * @package	   MetaModels
 * @subpackage Interfaces
 * @author     Christian Schiffler <c.schiffler@cyberspectrum.de>
 */
class MetaModelFilterRuleOR extends MetaModelFilterRule
{

	/**
	 * The static id list that shall be applied.
	 */
	protected $arrChildFilters = array();

	/**
	 * create a new FilterRule instance.
	 *
	 * @return MetaModelFilterRuleOR
	 */
	public function __construct()
	{
		parent::__construct();
	}

	/**
	 * adds a child filter to this rule that will get evaluated when this rule is evaluated.
	 *
	 * @param IMetaModelFilter $objFilter the filter to add as child
	 *
	 * @return void
	 */
	public function addChild(IMetaModelFilter $objFilter)
	{
		$this->arrChildFilters[] = $objFilter;
	}

	/**
	 * {@inheritdoc}
	 */
	public function getMatchingIds()
	{
		$arrIds = array();
		foreach ($this->arrChildFilters as $objChildFilter)
		{
			$arrChildMatches = $objChildFilter->getMatchingIds();
			// NULL => all items - for OR conditions, this can never be more than all so we are already satisfied here.
			if ($arrChildMatches === NULL)
			{
				return NULL;
			}

			if ($arrChildMatches)
			{
				$arrIds = array_merge($arrIds, $arrChildMatches);
			}
		}
		return $arrIds;
	}
}

?>
