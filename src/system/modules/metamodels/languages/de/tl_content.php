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
 * Legends
 */
$GLOBALS['TL_LANG']['tl_content']['mm_config_legend']				= 'MetaModel-Konfiguration';
$GLOBALS['TL_LANG']['tl_content']['mm_filter_legend']				= 'MetaModel-Filter';
$GLOBALS['TL_LANG']['tl_content']['mm_rendering']					= 'MetaModel-Rendering';

/**
 * Selects
 */
$GLOBALS['TL_LANG']['tl_content']['ASC']							= 'Aufsteigend';
$GLOBALS['TL_LANG']['tl_content']['DESC']							= 'Absteigend';

/**
 * Fields
 */
$GLOBALS['TL_LANG']['tl_content']['metamodel']						= array('MetaModel', 'Das MetaModel, das in diesem Listing angezeigt werden soll.');
$GLOBALS['TL_LANG']['tl_content']['metamodel_use_limit']			= array('Offset und Beschränkung', 'Anwählen, wenn die Menge der anzuzeigenden Items beschränkt werden soll. Diese Einstellung ist nützlich, um beispielsweise nur die 500 ersten Items oder alle bis auf die ersten 10 Items anzuzeigen und dabei eine korrekte Paginierung beizubehalten.');
$GLOBALS['TL_LANG']['tl_content']['metamodel_offset']				= array('Offset', 'Bitte den Offset-Wert angeben (z.B. 10 um die ersten 10 Items zu überspringen).');
$GLOBALS['TL_LANG']['tl_content']['metamodel_limit']				= array('Maximale Anzahl an Items', 'Bitte die maximale Anzahl an anzuzeigenden Items angeben. Bitte 0 angeben, um alle Items anzuzeigen und die Paginierung auszuschalten.');

$GLOBALS['TL_LANG']['tl_content']['metamodel_sortby']				= array('Sortieren nach', 'Bitte die Sortierreihenfolge auswählen.');
$GLOBALS['TL_LANG']['tl_content']['metamodel_sortby_direction']		= array('Sortierrichtung', 'Aufsteigende oder absteigende Reihenfolge.');
$GLOBALS['TL_LANG']['tl_content']['metamodel_filtering']			= array('Anzuwendende Filtereinstellungen', 'Die Filtereinstellungen auswählen, die bei der Ausgabe der Liste angewandt werden soll.');
$GLOBALS['TL_LANG']['tl_content']['metamodel_layout']				= array('Eigenes Template benutzen', 'Das Template auswählen, das für das ausgewählte Atrribut benutzt werden soll. Gültige Dateinamen für Templates beginnen mit &quot;ce_metamodel&quot;.');
$GLOBALS['TL_LANG']['tl_content']['metamodel_rendersettings']		= array('Anzuwendende Rendereinstellungen', 'Die Rendereinstellung auswählen, die für die Erzeugung des Outputs benutzt werden soll. Falls keine Auswahl getroffen wird werden die Standardeinstellungen benutzt. Falls keine Standardeinstellung vorhanden ist werden Rohdaten ausgegeben.');
$GLOBALS['TL_LANG']['tl_content']['metamodel_noparsing']			= array('Keine Ausgabe', 'Wenn aktiviert wird das Modul keine Items ausgeben. Nur die entsprechenden Objekte sind dann im Template verfügbar.');
$GLOBALS['TL_LANG']['tl_content']['metamodel_filterparams']			= array('Filtereinstellungen überschreiben');

$GLOBALS['TL_LANG']['tl_content']['metamodel_filterparams_use_get'] = array('GET-Parameter benutzen', '');

/**
 * Wizards
 */

$GLOBALS['TL_LANG']['tl_content']['editmetamodel']					= array('MetaModel bearbeiten', 'Das MetaModel mit der ID %s bearbeiten.');
$GLOBALS['TL_LANG']['tl_content']['editrendersetting']				= array('Rendereinstellung bearbeiten', 'Die Rendereinstellung ID %s bearbeiten.');
$GLOBALS['TL_LANG']['tl_content']['editfiltersetting']        = array('Filtereinstellung bearbeiten', 'Die Filtereinstellung mit der ID %s bearbeiten.');


?>