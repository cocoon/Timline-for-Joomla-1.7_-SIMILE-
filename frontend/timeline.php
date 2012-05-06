<?php
defined('_JEXEC') or die('Restricted access'); /* Überprüft ob die Seite nicht direkt aufgerufen wurde */
global $app, $document, $database, $my, $mosConfig_absolute_path, $limitstart, $limit, $total, $rows_per_page, $pages_in_list;
//check if user is super admin
// if you want to lower the usertype change 'super administrator' to the following
//usertypes: super administrator / administrator / manager
//if (strtolower($my->usertype) != 'manager' OR strtolower($my->usertype) != 'administrator' OR strtolower($my->usertype) != 'super administrator')


//Secure include( $mainframe->getCfg( 'absolute_path' )."/components/com_$name/$name.php" );
//$mosConfig_absolute_path = $mainframe->getCfg( 'absolute_path' );
//$mosConfig_live_site = $mainframe->getCfg( 'live_site' );

$app = JFactory::getApplication();
$database =& JFactory::getDBO();
$document=& JFactory::getDocument();
$my =& JFactory::getUser();
$myGroups = JAccess::getGroupsByUser($my->get('id'));
if (!JFactory::getUser()->authorise('core.manager')) 
{
	return JError::raiseWarning(404, JText::_('JERROR_ALERTNOAUTHOR'));
}

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



require_once( JApplicationHelper::getPath( 'front_html' ) ); /* Inkludiert unsere timeline.html.php Hier sieht man schon das erste mal das die Namensgebung wichtig ist */
require_once( JApplicationHelper::getPath( 'class' ) ); /* Bindet die "timeline.class.php" ein */

include ($mosConfig_absolute_path."/administrator/components/com_timeline/timeline.conf.php"); /* Nun wird unsere Konfiguration eingebunden */

$document->setTitle( "timeline Komponente " ); /* Setzt den Seitentitel */

/*
	if (file_exists($mosConfig_absolute_path.'/includes/joomla.php')) {
		require_once($mosConfig_absolute_path."/includes/joomla.php");
		} else {
		  if (file_exists($mosConfig_absolute_path.'/includes/joomla.php')) {
      require_once($mosConfig_absolute_path."/includes/mambo.php");
      }
		}
*/
//include($mosConfig_absolute_path."/includes/sef.php");




//$task = mosGetParam( $_REQUEST, "task" ); /* Liest aus der Adressleiste den Übergabewert "task" */
//$option = mosGetParam( $_REQUEST, 'option' ); /* Holt sich die in der Adressleiste übergebene option - Variable */

//$id		= mosGetParam($_REQUEST,"id",null);

//$limitstart = intval( mosGetParam( $_REQUEST, 'limitstart', 0 ) );
//$limit 		= intval( mosGetParam( $_REQUEST, 'limit', '' ) );

//$cid = mosGetParam( $_REQUEST, 'cid', array(0) );


// JRequest::getVar('address');
$task = JRequest::getVar('task' ); /* Liest aus der Adressleiste den Übergabewert "task" */
$option = JRequest::getVar('option' ); /* Holt sich die in der Adressleiste übergebene option - Variable */

$id		= JRequest::getVar('id',null);

$limitstart = intval( JRequest::getVar('limitstart', 0 ) );
$limit 		= intval( JRequest::getVar('limit', '' ) );

$cid = JRequest::getVar('cid', array(0) );
if (!is_array( $cid )) {
	$cid = array(0);
}







switch($task){ /*Falls man mehrere Seiten anzeigen will übergibt man am Besten diese via task=befehl und bindet diese mittels case ein */

  case 'xml':
  createXML();
  break;
  
  case 'xls':
  createXLS();
  break;
  
  case 'content':
  createContent();
  break;

  case 'contentZoom':
  createContentZoom();
  break;

  case 'data':
  showData ($option, $rows, $limitstart, $limit, $total, $task);
  break;
  
  case 'new' :
  $database =& JFactory::getDBO();
  $database->setQuery("SELECT MAX(id) AS maxid FROM #__timeline");
  $maxid = $database->loadResult();
  $newid = $maxid + 1; 
  echo "Last ID was: ".$maxid." - New ID is: ".$newid."<br>";
  $id = $newid;
  store( $option, $id);
  break;

  case 'edit':
  editEvent($option, $cid[0]);
  break;

  case 'save':
  saveEvent($option);
  //showHello ($option);
  break;

  case "delete" :
    del($option, $cid);
  break;

  default:
  showtimeline();
  break;
  }

function showHello($option)
  {
    timeline::showHello($option);
  }

###################################################
# Function showtimeline (use &no_html=1)          #
# shows 2 timelines in 2 iframes                  #
###################################################

function showtimeline()
  {
    global $mosConfig_live_site, $my, $DecoratorStartLabel, $DecoratorEndLabel;
?>
<style type="text/css" media="screen">@import "<?php echo JURI::root();?>/components/com_timeline/css/timeline.css";</style>

<script language="javascript" type="text/javascript">
<!--
function QuickJump(Formular)
{
    var Element = Formular.Events.selectedIndex;

    if (Formular.Events.options[Element].value == '2006-03-05')
    {
     ContentFrame.location.href = 'index.php?option=com_timeline&tmpl=component&task=content&startday=Mon&startmonth=Mar&startdateday=05&startdateyear=2006&startdatetime=15:00:00&startdategmt=GMT-0600&no_html=1'; 
     ContentFrameZoom.location.href = 'index.php?option=com_timeline&tmpl=component&task=contentZoom&startday=Mon&startmonth=Mar&startdateday=05&startdateyear=2006&startdatetime=15:00:00&startdategmt=GMT-0600&no_html=1';
    }
    if (Formular.Events.options[Element].value == '2006-08-28')
    {
     ContentFrame.location.href = 'index.php?option=com_timeline&tmpl=component&task=content&startday=Mon&startmonth=Aug&startdateday=28&startdateyear=2006&startdatetime=15:00:00&startdategmt=GMT-0600&no_html=1'; 
     ContentFrameZoom.location.href = 'index.php?option=com_timeline&tmpl=component&task=contentZoom&startday=Mon&startmonth=Aug&startdateday=28&startdateyear=2006&startdatetime=15:00:00&startdategmt=GMT-0600&no_html=1';
    }
    if (Formular.Events.options[Element].value == '2007-08-28')
    {
     ContentFrame.location.href = 'index.php?option=com_timeline&tmpl=component&task=content&startday=Mon&startmonth=Aug&startdateday=28&startdateyear=2007&startdatetime=15:00:00&startdategmt=GMT-0600&no_html=1'; 
     ContentFrameZoom.location.href = 'index.php?option=com_timeline&tmpl=component&task=contentZoom&startday=Mon&startmonth=Aug&startdateday=28&startdateyear=2007&startdatetime=15:00:00&startdategmt=GMT-0600&no_html=1';
    }
    if (Formular.Events.options[Element].value == '2008-08-28')
    {
     ContentFrame.location.href = 'index.php?option=com_timeline&tmpl=component&task=content&startday=Mon&startmonth=Aug&startdateday=28&startdateyear=2008&startdatetime=15:00:00&startdategmt=GMT-0600&no_html=1'; 
     ContentFrameZoom.location.href = 'index.php?option=com_timeline&tmpl=component&task=contentZoom&startday=Mon&startmonth=Aug&startdateday=28&startdateyear=2008&startdatetime=15:00:00&startdategmt=GMT-0600&no_html=1';
    }
    if (Formular.Events.options[Element].value == '2009-08-28')
    {
     ContentFrame.location.href = 'index.php?option=com_timeline&tmpl=component&task=content&startday=Mon&startmonth=Aug&startdateday=28&startdateyear=2009&startdatetime=15:00:00&startdategmt=GMT-0600&no_html=1'; 
     ContentFrameZoom.location.href = 'index.php?option=com_timeline&tmpl=component&task=contentZoom&startday=Mon&startmonth=Aug&startdateday=28&startdateyear=2009&startdatetime=15:00:00&startdategmt=GMT-0600&no_html=1';
    }
    if (Formular.Events.options[Element].value == '2010-08-28')
    {
     ContentFrame.location.href = 'index.php?option=com_timeline&tmpl=component&task=content&startday=Mon&startmonth=Aug&startdateday=28&startdateyear=2010&startdatetime=15:00:00&startdategmt=GMT-0600&no_html=1'; 
     ContentFrameZoom.location.href = 'index.php?option=com_timeline&tmpl=component&task=contentZoom&startday=Mon&startmonth=Aug&startdateday=28&startdateyear=2010&startdatetime=15:00:00&startdategmt=GMT-0600&no_html=1';
    }
    if (Formular.Events.options[Element].value == '2011-08-28')
    {
     ContentFrame.location.href = 'index.php?option=com_timeline&tmpl=component&task=content&startday=Mon&startmonth=Aug&startdateday=28&startdateyear=2011&startdatetime=15:00:00&startdategmt=GMT-0600&no_html=1'; 
     ContentFrameZoom.location.href = 'index.php?option=com_timeline&tmpl=component&task=contentZoom&startday=Mon&startmonth=Aug&startdateday=28&startdateyear=2011&startdatetime=15:00:00&startdategmt=GMT-0600&no_html=1';
    }
    if (Formular.Events.options[Element].value == '2012-08-28')
    {
     ContentFrame.location.href = 'index.php?option=com_timeline&tmpl=component&task=content&startday=Mon&startmonth=Aug&startdateday=28&startdateyear=2012&startdatetime=15:00:00&startdategmt=GMT-0600&no_html=1'; 
     ContentFrameZoom.location.href = 'index.php?option=com_timeline&tmpl=component&task=contentZoom&startday=Mon&startmonth=Aug&startdateday=28&startdateyear=2012&startdatetime=15:00:00&startdategmt=GMT-0600&no_html=1';
    }
    
    if (Formular.Events.options[Element].value == '<?php echo date("Y-m-d");?>')
    {
     ContentFrame.location.href = 'index.php?option=com_timeline&tmpl=component&task=content&startday=Mon&startmonth=Aug&startdateday=<?php echo date("d");?>&startdateyear=<?php echo date("Y");?>&startdatetime=15:00:00&startdategmt=GMT-0600&no_html=1'; 
     ContentFrameZoom.location.href = 'index.php?option=com_timeline&tmpl=component&task=contentZoom&startday=Mon&startmonth=Aug&startdateday=<?php echo date("d");?>&startdateyear=<?php echo date("Y");?>&startdatetime=15:00:00&startdategmt=GMT-0600&no_html=1';
    }

}
//-->
</script>

<!-- Menu 1 -->
<div id="menu1" class="menu1">

  <form action="index.php" method="post" name="adminForm" id="adminForm" style="float:left;">
    <select name="Events" onchange="QuickJump(this.form);">Quickjump:
      <option value="2006-03-05">05.03.2006</option>
      <option value="2006-08-28">28.08.2006</option>
      <option value="2007-08-28">28.08.2007</option>
      <option value="2008-08-28">28.08.2008</option>
      <option value="2009-08-28" selected="selected">28.08.2009</option>
      <option value="2010-08-28">28.08.2010</option>
      <option value="2011-08-28">28.08.2011</option>
      <option value="2012-08-28">28.08.2012</option>      
      <option value="<?php echo date('Y-m-d');?>"><?php echo date('d.m.Y');?></option>
    </select>
  </form>

<?php
//check if user is special user
if (JFactory::getUser()->authorise('core.manager')) 
{
?>
<a class="menu2" href="index.php?option=com_timeline" class="button">Normal Screen</a>
<a class="menu2" href="index.php?option=com_timeline&tmpl=component" class="button">Fullscreen</a>
<a class="menu2" href="index.php?option=com_timeline&tmpl=component&task=data" class="button">Edit in Fullscreen</a>
<a class="menu2" href="index.php?option=com_timeline&task=data" class="button">Edit here</a>
<a class="menu2" href="index.php?option=com_timeline&tmpl=component&task=xls&no_html=1" class="button">Export to XLS</a>
<a class="menu2" href="index.php?option=com_timeline&tmpl=component&task=xml&no_html=1" class="button">Export to XML</a>
<?php
}
?>



<!-- open date in second timeline (zoomed)
<a class="menu3" href="index.php?option=com_timeline&tmpl=component&task=contentZoom&startday=Mon&startmonth=Aug&startdateday=28&startdateyear=2006&startdatetime=15:00:00&startdategmt=GMT-0600&no_html=1" target="ContentFrameZoom" class="button">28. August 2006</a>
-->
</div>


<hr />



<iframe name="ContentFrame" id="ContentFrame" class="iframe1" frameborder="no" scrolling="no" src="index.php?option=com_timeline&tmpl=component&task=content&startday=Mon&startmonth=Aug&startdateday=28&startdateyear=2006&startdatetime=10:00:00&startdategmt=GMT-0600&DecoratorStartLabel=<?php echo $DecoratorStartLabel;?>&DecoratorEndLabel=<?php echo $DecoratorEndLabel;?>&no_html=1" width="100%" height="310">
</iframe>


<iframe name="ContentFrameZoom" id="ContentFrameZoom" class="iframe2" frameborder="no" scrolling="no" src="index.php?option=com_timeline&tmpl=component&task=contentZoom&startday=Mon&startmonth=Aug&startdateday=28&startdateyear=2006&startdatetime=02:00:00&startdategmt=GMT-0600&DecoratorStartLabel=<?php echo $DecoratorStartLabel;?>&DecoratorEndLabel=<?php echo $DecoratorEndLabel;?>&no_html=1" width="100%" height="310">
</iframe>

<?php
/* Menue

<!-- Menu 1 -->
<ul class="pro8">
<li><a href="index.php?option=com_timeline&tmpl=component&task=content&startday=Mon&startmonth=Aug&startdateday=28&startdateyear=2006&startdatetime=15:00:00&startdategmt=GMT-0600&no_html=1" target="ContentFrame" class="button">28. August 2006</a></li>
<li><a href="index.php?option=com_timeline&tmpl=component&task=content&startday=Fri&startmonth=Jul&startdateday=10&startdateyear=2006&startdatetime=15:00:00&startdategmt=GMT-0600&no_html=1" target="ContentFrame" class="button">10. Juli 2006</a></li>
<li><a href="index.php?option=com_timeline&tmpl=component&task=content&startday=Fri&startmonth=Aug&startdateday=10&startdateyear=2006&startdatetime=15:00:00&startdategmt=GMT-0600&no_html=1" target="ContentFrame" class="button">10. August 2006</a></li>
</ul>
<br><br>
<ul class="pro8">
<li><a href="index.php?option=com_timeline&tmpl=component&task=content&startday=Fri&startmonth=Sep&startdateday=10&startdateyear=2006&startdatetime=15:00:00&startdategmt=GMT-0600&no_html=1" target="ContentFrame" class="button">10. September 2006</a></li>
<li><a href="index.php?option=com_timeline&tmpl=component&task=content&startday=Fri&startmonth=Oct&startdateday=10&startdateyear=2006&startdatetime=15:00:00&startdategmt=GMT-0600&no_html=1" target="ContentFrame" class="button">10. Oktober 2006</a></li>
</ul>

<br><br>

<!-- Menu 2 -->
<ul class="pro8">
<li><a href="index.php?option=com_timeline&tmpl=component&task=data" class="button">edit big windows</a></li>
<li><a href="index.php?option=com_timeline&task=data" class="button">edit here</a></li>
<li><a href="index.php?option=com_timeline&tmpl=component&task=xls&no_html=1" class="button">Export to XLS</a></li>
</ul>
<br><br>
<ul class="pro8">
<li><a href="index.php?option=com_timeline&tmpl=component&task=xml&no_html=1" class="button">Export to XML</a></li>
</ul>
<br>
<br>

*/
?>


<?php
//include "components/com_timeline/content.html.php"; /* Nun wird unser Text eingebunden */
    //global $database; /* Dies ist eine Globale Variable von Joomla die den Datenbankzugriff handelt. Für nähere Informationen über diese Funktion schaut euch die Datei "includes/database.php" an. Dort wird die Funktion deklariert. */
    //$database->setQuery("SELECT * FROM #__timeline WHERE id = 1 "); /* Setzt einmal als erstes denn SQL Befehl */
    //$rows = $database->loadObjectList(); /* Übergibt nun das Ergebnis der Variable $rows */
    //timeline::show($rows); /* Diese Klasse wird anschließend in der Datei "timeline.html.php" angelegt */
  }


###################################################
# Function createXML (use &no_html=1)             #
# XML output of events from DB                    #
###################################################
  
function createXML()
  {
    global $database;
    $database =& JFactory::getDBO();
    

/*
CREATE TABLE IF NOT EXISTS `#__eventlist_events` (
`id` int(11) unsigned NOT NULL auto_increment,
`locid` int(11) unsigned NOT NULL default '0',
`catsid` int(11) unsigned NOT NULL default '0',
`dates` date NOT NULL default '0000-00-00',
`enddates` date NULL default NULL,
`times` time NULL default NULL,
`endtimes` time NULL default NULL,
`title` varchar(100) NOT NULL default '',
`alias` varchar(100) NOT NULL default '',
`created_by` int(11) unsigned NOT NULL default '0',
`modified` datetime NOT NULL,
`modified_by` int(11) unsigned NOT NULL default '0',
`author_ip` varchar(15) NOT NULL default '',
`created` datetime NOT NULL,
`datdescription` mediumtext NOT NULL,
`meta_keywords` varchar(200) NOT NULL default '',
`meta_description` varchar(255) NOT NULL default '',
`recurrence_number` int(2) NOT NULL default '0',
`recurrence_type` int(2) NOT NULL default '0',
`recurrence_counter` date NOT NULL default '0000-00-00',
`datimage` varchar(100) NOT NULL default '',
`checked_out` int(11) NOT NULL default '0',
`checked_out_time` datetime NOT NULL default '0000-00-00 00:00:00',
`registra` tinyint(1) NOT NULL default '0',
`unregistra` tinyint(1) NOT NULL default '0',
`published` tinyint(1) NOT NULL default '0',
PRIMARY KEY  (`id`)
) TYPE=MyISAM CHARACTER SET `utf8` COLLATE `utf8_general_ci`;


CREATE TABLE IF NOT EXISTS `#__timeline` (
`id` int(11) NOT NULL auto_increment,
`StartDay` VARCHAR(3) NOT NULL DEFAULT 'Mon',
`StartMonth` VARCHAR(3) NOT NULL DEFAULT 'Jan',
`StartDateDay` int(2) NOT NULL DEFAULT '01',
`StartDateYear` int(4) NOT NULL DEFAULT '2007',
`StartDateTime` VARCHAR(8) NOT NULL DEFAULT '09:00:00',
`StartDateGMT` VARCHAR(40) NOT NULL DEFAULT 'GMT',
`EndDay` VARCHAR(3) NOT NULL DEFAULT 'Sun',
`EndMonth` VARCHAR(3) NOT NULL DEFAULT 'Dec',
`EndDateDay` int(2) DEFAULT '31',
`EndDateYear` int(4) NOT NULL DEFAULT '2007',
`EndDateTime` VARCHAR(8) NOT NULL DEFAULT '10:00:00',
`EndDateGMT` VARCHAR(40) NOT NULL DEFAULT 'GMT',
`isDuration` VARCHAR(40) NOT NULL,
`title` VARCHAR(40) NOT NULL DEFAULT 'EVENT',
`image` text NOT NULL,
`description` text NOT NULL,
`link` text NOT NULL,
PRIMARY KEY (id)
);


*/

// CONFIG: STANDARD-DB (0) or use Eventlist-Component-DB (1)
$timelinedb = 0;


switch($timelinedb){ /* generate XML using configured source-db */

  case '0':
  $database->setQuery("SELECT * FROM #__timeline;"); /* Holt die Variablen aus der Datenbank */
  $eventrows = $database->loadObjectList(); /* Führt die Abfrage aus */

  $doc =& JFactory::getDocument();
  $doc->setMimeEncoding('text/xml'); 
  
  //header("Content-Type: text/xml; charset=utf-8");
  header("Expires: Mon, 26 Jul 1997 05:00:00 GMT");
  header("Cache-Control: no-store, no-cache, must-revalidate");
  header("Cache-Control: post-check=0, pre-check=0", false);
  header("Pragma: no-cache");
  
  echo '<?xml version="1.0" encoding="UTF-8" standalone="yes"?>';
  echo '<data>';

  foreach ($eventrows as $event) 
  {
  $startdate = $event->StartDay." ".$event->StartMonth." ".$event->StartDateDay." ".$event->StartDateYear." ".$event->StartDateTime." ".$event->StartDateGMT;
  $enddate = $event->EndDay." ".$event->EndMonth." ".$event->EndDateDay." ".$event->EndDateYear." ".$event->EndDateTime." ".$event->EndDateGMT;
  $eventdesc = $event->description;

   // Escaping illegal characters
   /*
   $eventdesc = str_replace("&", " und ", $eventdesc);
   $eventdesc = str_replace("<", "<", $eventdesc);
   $eventdesc = str_replace(">", "&gt;", $eventdesc);
   $eventdesc = str_replace("\"", "&quot;", $eventdesc);
   $eventdesc = str_replace("+", "und", $eventdesc);
   $eventdesc = str_replace("\0","",$eventdesc);
   */ 
?>
<event 
            start="<?php echo $startdate;?>"
            end="<?php echo $enddate;?>"
            isDuration="<?php echo $event->isDuration;?>"
            title="<?php echo $event->title;?>"
            link="<?php echo $event->link;?>"
            image="<?php echo $event->image;?>"
>
<?php //echo $eventdesc;?>
<?php echo "<![CDATA[".$eventdesc."]]>";?>
<?php //echo iconv("UTF-8","UTF-8//IGNORE",$eventdesc);?>
</event>
<?php
  }
  echo '</data>';
  break;
  
  case '1':
  $database->setQuery("SELECT * FROM #__eventlist_events;"); /* Holt die Variablen aus der Datenbank */
  $eventrows = $database->loadObjectList(); /* Führt die Abfrage aus */

  $doc =& JFactory::getDocument();
  $doc->setMimeEncoding('text/xml'); 
  
  //header("Content-Type: text/xml; charset=utf-8");
  header("Expires: Mon, 26 Jul 1997 05:00:00 GMT");
  header("Cache-Control: no-store, no-cache, must-revalidate");
  header("Cache-Control: post-check=0, pre-check=0", false);
  header("Pragma: no-cache");

  echo '<?xml version="1.0" encoding="UTF-8" standalone="yes"?>';
  echo '<data>';
  
  foreach ($eventrows as $event) 
  {
  $startdate = strftime("%a",strtotime($event->dates))." ".strftime("%b",strtotime($event->dates))." ".strftime("%d",strtotime($event->dates))." ".strftime("%Y",strtotime($event->dates))." ".$event->times." "."GMT";
  $enddate = strftime("%a",strtotime($event->enddates))." ".strftime("%b",strtotime($event->enddates))." ".strftime("%d",strtotime($event->enddates))." ".strftime("%Y",strtotime($event->enddates))." ".$event->endtimes." "."GMT";
  $eventdesc = $event->datdescription;

    // Escaping illegal characters
    $eventdesc = str_replace("&", " und ", $eventdesc);
    $eventdesc = str_replace("<", "<", $eventdesc);
    $eventdesc = str_replace(">", "&gt;", $eventdesc);
    $eventdesc = str_replace("\"", "&quot;", $eventdesc);
    $eventdesc = str_replace("+", "und", $eventdesc);
    $eventdesc=str_replace("\0","",$eventdesc); 
?>
<event 
            start="<?php echo $startdate;?>"
            end="<?php echo $enddate;?>"
            isDuration="true"
            title="<?php echo $event->title;?>"
            link="event->link"
            image="images/eventlist/events/<?php echo $event->datimage;?>"
>
<?php echo $eventdesc;?>
<?php //echo "<![CDATA[".$eventdesc."]]>";?>
<?php //echo iconv("UTF-8","UTF-8//IGNORE",$eventdesc);?>
</event>
<?php
            
        }
  echo '</data>';
  break;

  default:
  break;
  }

}


###################################################
# Function createXML (use &no_html=1)             #
# XLS (Excel) output of events from DB            #
###################################################

function createXLS()
  {
    global $database, $my;
    $database =& JFactory::getDBO();
    
    if ($my->gid != '2')
      {
        mosNotAuth();
        echo "<p>You need to be special user!</p>";
        echo "<p>You are ".strtolower($my->usertype)."</p>";
      	return;
      } 
    
    $database->setQuery("SELECT * FROM #__timeline;"); /* Holt die Variablen aus der Datenbank */
    $eventrows = $database->loadObjectList(); /* Führt die Abfrage aus */
   
    header("Content-type: application/vnd-ms-excel"); 
    header("Content-Disposition: attachment; filename=export.xls");

    echo "<table cellpadding='0' cellspacing='0' border='1'>";
    ?>
    <tr>
     <th><b>StartDay</b> </th>
     <th><b>StartMonth</b> </th>
     <th><b>StartDateDay</b> </th>
     <th><b>StartDateYear</b> </th>
     <th><b>StartDateTime</b> </th>
     <th><b>StartDateGMT</b> </th>
     
     <th><b>EndDay</b></th>
     <th><b>EndMonth</b></th>
     <th><b>EndDateDay</b></th>
     <th><b>EndDateYear</b></th>
     <th><b>EndDateTime</b></th>
     <th><b>EndDateGMT</b></th>
     
     <th><b>isDuration</b></th>
     <th><b>title</b></th>
     <th><b>link</b></th>
     <th><b>image</b></th>
     <th><b>description</b></th>
    </tr>


    <?php
    foreach ($eventrows as $event) 
        {
            ?>
            <tr> 
            <td><?php echo $event->StartDay;?></td>
            <td><?php echo $event->StartMonth;?></td>
            <td><?php echo $event->StartDateDay;?></td>
            <td><?php echo $event->StartDateYear;?></td>
            <td><?php echo $event->StartDateTime;?></td>
            <td><?php echo $event->StartDateGMT;?></td>
            
            <td><?php echo $event->EndDay;?></td>
            <td><?php echo $event->EndMonth;?></td>
            <td><?php echo $event->EndDateDay;?></td>
            <td><?php echo $event->EndDateYear;?></td>
            <td><?php echo $event->EndDateTime;?></td>
            <td><?php echo $event->EndDateGMT;?></td>
            
            <td><?php echo $event->isDuration;?></td>
            <td><?php echo $event->title;?></td>
            <td><?php echo $event->link;?></td>
            <td><?php echo $event->image;?></td>
            <td><?php echo $event->description;?></td>
            </tr>
            <?php
        }
    echo "</table>";
  }




###################################################
# Function createContent                          #
# shows normal timeline                           #
###################################################

function createContent()
  {
    global $mosConfig_absolute_path;
    require_once( JPATH_ROOT."/components/com_timeline/content.html.php");
  }

###################################################
# Function createContentZoom                      #
# shows zommed timeline                           #
###################################################

function createContentZoom()
  {
    global $mosConfig_absolute_path;
    require_once( JPATH_ROOT."/components/com_timeline/content.zoom.html.php");
  }




###################################################
# Function store                                  #
# stores new empty event in DB                    #
###################################################

function store($option, $id) {
global $database, $id, $my, $app;
$database =& JFactory::getDBO();

      if ($my->gid != '2')
      {
        mosNotAuth();
        echo "<p>You need to be special user!</p>";
        echo "<p>You are ".strtolower($my->usertype)."</p>";
      	return;
      } 

$row = new timelineclass($database);
	if (!$row->bind( $_POST )) {
		echo "<script> alert('".$row->getError()."'); window.history.go(-1); </script>n";
		exit();
}
if (!$row->store()) {
	echo "<script> alert('".$row->getError()."'); window.history.go(-1); </script>n";
	exit();
}
   echo "<br>Stored: ".$id."<br>";

sleep(15);
$app->redirect("index.php?option=$option&amp;task=data", "<br>Stored: ".$id."<br>");
}





###################################################
# Function showData                               #
# shows Events                                    #
###################################################

function showData($option, $rows, $limitstart, $limit, $total, $task) 
  {
    global $database, $mosConfig_live_site, $mosConfig_absolute_path, $app, $my;
    global $task, $rows_per_page, $pages_in_list, $limitstart, $limit, $total;
    
    $database =& JFactory::getDBO();

      if ($my->gid != '2')
      {
        //mosNotAuth();
        echo "<p>You need to be special user!</p>";
        echo "<p>You are ".strtolower($my->usertype)."</p>";
      	return;
      } 

    require_once(JPATH_ROOT."/components/com_timeline/timeline.navigation.php");
    //require_once($mosConfig_absolute_path."/administrator/components/com_timeline/toolbar.timeline.php");
    //require_once($mosConfig_absolute_path."/administrator/components/com_timeline/toolbar.timeline.html.php");

  	$database->setQuery("SELECT count(*) FROM #__timeline");
  	$total = $database->loadResult();
  	echo $database->getErrorMsg();


    	if (empty($limitstart)) $limitstart = 0;
	    $limit = $rows_per_page;
	    if ($limit > $total) 
        {
		      $limitstart = 0;
	      }
    
    $database->setQuery("SELECT * FROM #__timeline ORDER BY id LIMIT $limitstart, $limit;"); /* Holt die Variablen aus der Datenbank */
    $rows = $database->loadObjectList(); /* Führt die Abfrage aus */

    //mosCommonHTML::loadOverlib();
    jimport( 'joomla.html.tooltips' );
    //JHTML::_('behavior.tooltip');
    
		?>


<h1>Event-Data:</h1>
  <div id="menu1" class="menu1">
    <input type="button" name="new" value="new" title="Add new event" onclick="javascript:submitbutton('new')">
    <input type="button" name="edit" value="edit" title="Edit selected event" onclick="javascript:submitbutton('edit')">
    <!-- <input type="button" name="save" value="save" onclick="javascript:submitbutton('save')"> -->
    <input type="button" name="delete" value="delete" title="Delete selected events" onclick="javascript:if (document.adminForm.boxchecked.value == 0){ alert('Please make a selection from the list to delete'); } else if (confirm('Are you sure you want to delete selected items?  ')){ submitbutton('delete');}">
    <input type="button" name="cancel" value="cancel" title="Cancel / Back to Timeline" onclick="javascript:if (confirm('Are you sure you want to cancel?  ')){ window.location = 'index.php?option=com_timeline';}">
  </div>
<div align="center" class="menu1" style="height:50px">
<?php writePagesCounter($limitstart, $limit, $total); ?>
<br />
<?php writePagesLinks($limitstart, $limit, $total); ?>
</div>
<br>

  <div style="width:100%;height:500px;border:1px solid #840;overflow:auto;">

<script language="JavaScript" src="<?php echo JURI::root();?>/includes/js/JSCookMenu_mini.js" type="text/javascript"></script>
<script language="JavaScript" src="<?php echo JURI::root();?>/administrator/includes/js/ThemeOffice/theme.js" type="text/javascript"></script>
<script language="JavaScript" src="<?php echo JURI::root();?>/includes/js/joomla.javascript.js" type="text/javascript"></script>

<style type="text/css" media="screen">@import "<?php echo JURI::root();?>/components/com_timeline/css/timeline.css";</style>


<form action="index.php" method="post" name="adminForm" id="adminForm">

<table width="100%" border="0" class="adminheading">
  <tr>
    <td width="10">#<input type="checkbox" name="toggle" value="" onClick="checkAll(<?php echo count( $rows ); ?>);" /></td>
    <td>eID</td>
    <td width="100"><strong><?php echo _TL_START;?></strong></td>
    <td width="100"><strong><?php echo _TL_END;?></strong></td>
    <td><strong><?php echo _TL_isDURATION;?></strong></td>
    <td><strong><?php echo _TL_TITLE;?></strong></td>
    <td><strong><?php echo _TL_IMAGE;?></strong></td>
    <td><strong><?php echo _TL_DESCRIPTION;?></strong></td>
    <td><strong><?php echo _TL_LINK;?></strong></td>
  </tr>


<?php
$k = 0;
for($i=0; $i < count( $rows ); $i++) {
$row = $rows[$i];
	if ($row->isDuration == 'true') {
		$resim 		= JURI::root()."/components/com_timeline/images/1.png";
		$resimalt 	= _TL_isDuration;
	} else {
		$resim 		= JURI::root()."/components/com_timeline/images/0.png";
		$resimalt 	= _TL_isNotDuration;
	}
	$link = JRoute::_( 'index.php?option=com_sitemessenger&amp;task=read&amp;id='. $row->id .'&amp;Itemid='. $Itemid );
  //$checked 	= mosCommonHTML::CheckedOutProcessing( $row, $i );
  jimport('joomla.html.html.grid');
  $checked 	= JHTML::_('grid.checkedout', $row, $i);
  
  
/* Liest die Zeit des Events aus der DB */
$startday = $row->StartDay;
$startmonth = $row->StartMonth;
$startdateday = $row->StartDateDay;
$startdateyear = $row->StartDateYear;
$startdatetime = $row->StartDateTime;
$startdategmt = $row->StartDateGMT;

$startdate = $startday." ".$startmonth." ".$startdateday." ".$startdateyear." ".$startdatetime." ".$startdategmt;

/* Liest die Zeit des Events aus der DB */
$endday = $row->EndDay;
$endmonth = $row->EndMonth;
$enddateday = $row->EndDateDay;
$enddateyear = $row->EndDateYear;
$enddatetime = $row->EndDateTime;
$enddategmt = $row->EndDateGMT;

$enddate = $endday." ".$endmonth." ".$enddateday." ".$enddateyear." ".$enddatetime." ".$enddategmt;
?>
<tr class="" style="height:120px; border-bottom:1px solid black;border-top:1px solid black;">
    
    <td width="5"><input type="checkbox" id="cb<?php echo $i;?>" name="cid[]" value="<?php echo $row->id; ?>" onClick="isChecked(this.checked);" /></td>

    <td><?php echo $row->id;?></td>
    <td><?php echo $startdate;?></td>
    <td><?php echo $enddate;?></td>
  
    <td><img src="<?php echo $resim;?>" alt="<?php echo $resimalt;?>" /></td>
    <td><?php echo $row->title;?></td>
    <td><img src="<?php echo $row->image;?>" width="50" height="50" alt="::"></td>
    <td><div style="width:280px; height:70px; border:1px solid #840;overflow:auto;" id="description<?php echo $row->id; ?>" name="description<?php echo $row->id; ?>" rows=3 cols=35 ><?php echo $row->description;?></div></td>
    <td><a href="<?php echo $row->link;?>">Link</a></td>
  </tr>

<?php
$k = 1 - $k; 
}
?>

<tr>
<td colspan="8">
<hr />

</td>
</tr>
</table>
<input type="hidden" name="option" value="<?php echo $option; ?>" />
<input type="hidden" name="task" value="save" />
<input type="hidden" name="boxchecked" value="0" />
<input type="hidden" name="Itemid" value="<?php echo $Itemid;?>" />
<!--<input type="submit" name="submit" value="<?php echo $task;?>" class="button" /> -->

</form>
</div>



<?php
}



function editEvent( $option, $cid ) {
	global $database, $my;

  $database =& JFactory::getDBO();

      if ($my->gid != '2')
      {
        //mosNotAuth();
        echo "<p>You need to be special user!</p>";
        echo "<p>You are ".strtolower($my->usertype)."</p>";
      	return;
      } 

	$row = new timelineclass($database);
	$row->load($cid);

	$database -> setQuery("SELECT * FROM #__timeline WHERE id=$cid");
	$usersTemp = $database -> loadObjectList();

	timeline::editEvent( $row, $option );
}



function saveEvent( $option )
{
	global $database, $my, $app;
	
	$database =& JFactory::getDBO();

      if ($my->gid != '2')
      {
        //mosNotAuth();
        echo "<p>You need to be special user!</p>";
        echo "<p>You are ".strtolower($my->usertype)."</p>";
      	return;
      } 

	$row = new timelineclass($database);

	if (!$row->bind( $_POST )) {
		echo "<script> alert('".$row->getError()."'); window.history.go(-1); </script>\n";
		exit();
	}

	if (!$row->store()) {
		echo "<script> alert('".$row->getError()."'); window.history.go(-1); </script>\n";
		exit();
	}

	$app->redirect( "index.php?option=$option&task=data" );
}



###################################################
# Function del                                    #
# delete conf                                     #
###################################################


function del($option, $cid) {

global $database, $my, $app;

$database =& JFactory::getDBO();

      if ($my->gid != '2')
      {
        //mosNotAuth();
        echo "<p>You need to be special user!</p>";
        echo "<p>You are ".strtolower($my->usertype)."</p>";
      	return;
      } 

  if (!is_array($cid) || count($cid) < 1) 
      {
        echo "<script> alert('Select an item to delete'); window.history.go(-1);</script>n";
        exit();
      }

  if (count($cid))
      {
        $ids = implode(',', $cid);
        $database->setQuery("DELETE FROM #__timeline WHERE id IN ($ids)");
      }

  if (!$database->query()) 
      {
        echo "<script> alert('"
        .$database -> getErrorMsg()
        ."'); window.history.go(-1); </script>n";
      }
$app->redirect("index.php?option=$option&task=data");
}

?>

