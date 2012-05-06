<?php
defined('_JEXEC') or die('Restricted access');

global $app, $database, $my;

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

function com_install() 
  { /* Diese Funktion wird am Ende der Installation ausgeführt */

?>
<style type="text/css" media="screen">@import "<?php echo $mosConfig_live_site;?>/components/com_timeline/css/timeline.css";</style>

<div id="menu1" class="menu1">
  <a class="menu2" href="index.php?option=com_timeline&task=set" class="button">Manage Events</a>
  <a class="menu2" href="index.php?option=com_timeline&task=faq" class="button">FAQ</a>
  <a class="menu2" href="index.php?option=com_timeline&task=about" class="button">About</a>
</div>
<?php    
    echo "<br><h2>Komponente erfolgreich installiert.</h2>"; /* Eine schöne Meldung am Ende der Installationo */
    echo "<br><br><a href='index.php?option=com_timeline&task=about'><IMG SRC='".JURI::root()."/components/com_timeline/images/timeline.png' NAME='Grafik2' ALIGN=CENTER BORDER=0></a><br><br>";
  }
?>
