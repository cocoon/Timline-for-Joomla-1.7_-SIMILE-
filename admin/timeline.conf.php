<?php
// Datei wird korrekt von Mambo/Joomla aufgerufen oder eben nicht und dann beendet 
defined('_JEXEC') or die('Restricted access');

global $app, $startdate;

//Secure include( $mainframe->getCfg( 'absolute_path' )."/components/com_$name/$name.php" );
//$mosConfig_absolute_path = $mainframe->getCfg( 'absolute_path' );
//$mosConfig_live_site = $mainframe->getCfg( 'live_site' );


$app = JFactory::getApplication();
$my =& JFactory::getUser();
$database =& JFactory::getDBO();

/* Joomla 1.7 GetPath and Redirect
JApplicationHelper::getPath( 'class' )
$app->redirect();
*/

//$mosConfig_absolute_path = $mainframe->getCfg( 'absolute_path' )
$mosConfig_absolute_path = JPATH_BASE;
//$mosConfig_live_site = $mainframe->getCfg( 'live_site' );
$mosConfig_live_site = JURI::base();

$mosConfig_lang =& JFactory::getLanguage(); 
//$mosConfig_lang = $mosConfig_lang->getBackwardLang();


$rows_per_page = 10;                    // set how many rows per page you want displayed
$pages_in_list = 5;                     // set how many pages you want displayed in the menu

/* Liest aus der Adressleiste den Übergabewert "option" */
$startday = JRequest::getVar('startday');
$startmonth = JRequest::getVar('startmonth');
$startdateday = JRequest::getVar('startdateday');
$startdateyear = JRequest::getVar('startdateyear');
$startdatetime = JRequest::getVar('startdatetime' );
$startdategmt = JRequest::getVar('startdategmt');

$startdate = $startday." ".$startmonth." ".$startdateday." ".$startdateyear." ".$startdatetime." ".$startdategmt;

$DecoratorStartLabel = JRequest::getVar('DecoratorStartLabel');
$DecoratorEndLabel = JRequest::getVar('DecoratorEndLabel');

if (empty($DecoratorStartLabel)) $DecoratorStartLabel = "My";
if (empty($DecoratorEndLabel)) $DecoratorEndLabel = "Timeline";

$DecoratorStartDate = $startday." ".$startmonth." ".$startdateday." ".$startdateyear." ".$startdatetime." ".$startdategmt;
$DecoratorEndDate = $DecoratorEndDay." ".$DecoratorEndMonth." ".$DecoratorEndDateDay." ".$DecoratorEndDateYear." ".$DecoratorEndDateTime." ".$DecoratorEndDateGMT;


DEFINE("_SM_FIRST_PAGE","First Page");
DEFINE("_SM_PREV_PAGE","Previous Page");
DEFINE("_SM_NEXT_PAGE","Next Page");
DEFINE("_SM_LAST_PAGE","Last Page");

DEFINE("_SM_RESULTS","Showing Events: ");
DEFINE("_SM_OF_TOTAL","From");

DEFINE("_TL_START","Start");
DEFINE("_TL_END","End");
DEFINE("_TL_isDURATION","isDURATION");
DEFINE("_TL_TITLE","Title");
DEFINE("_TL_IMAGE","Image");
DEFINE("_TL_DESCRIPTION","Description");
DEFINE("_TL_LINK","Link");

?>
