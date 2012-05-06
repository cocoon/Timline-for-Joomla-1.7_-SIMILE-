<?php
defined('_JEXEC') or die ('Direct Access is not allowed');

global $app;

//Secure include( $mainframe->getCfg( 'absolute_path' )."/components/com_$name/$name.php" );
//$mosConfig_absolute_path = $mainframe->getCfg( 'absolute_path' );
//$mosConfig_live_site = $mainframe->getCfg( 'live_site' );

$app = JFactory::getApplication();
$my =& JFactory::getUser();
$database =& JFactory::getDBO();

//$mosConfig_absolute_path = $mainframe->getCfg( 'absolute_path' )
$mosConfig_absolute_path = JPATH_BASE;
//$mosConfig_live_site = $mainframe->getCfg( 'live_site' );
$mosConfig_live_site = JURI::base();

$mosConfig_lang =& JFactory::getLanguage(); 

//include($mosConfig_absolute_path.'/configuration.php');

function com_uninstall() 
  { /* Diese Funktion wird am Ende der Installation ausgeführt */
    echo "<h1>Timeline was successfully deinstalled.</h1>"; /* Eine schöne Meldung am Ende der Installation */
  }
?>
