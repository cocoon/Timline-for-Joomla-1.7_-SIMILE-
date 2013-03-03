<?php
// Datei wird korrekt von Mambo/Joomla aufgerufen oder eben nicht und dann beendet 
defined('_JEXEC') or die('Restricted access');


/*


JPATH_SITE is meant to represent the root path of the JSite application, just as JPATH_ADMINISTRATOR is mean to represent the root path of the JAdministrator application.

JPATH_BASE is the root path for the current requested application.... so if you are in the administrator application, JPATH_BASE == JPATH_ADMINISTRATOR... if you are in the site application JPATH_BASE == JPATH_SITE... if you are in the installation application JPATH_BASE == JPATH_INSTALLATION.

JPATH_ROOT is the root path for the Joomla install and does not depend upon any application.

if(JPATH_BASE == JPATH_ADMINISTRATOR) {
	$force_ssl = $config->getValue('config.force_ssl');
	if($force_ssl > 0){
	$base['prefix'] =
ereg_replace("http://","https://",$base['prefix']);
	}
       $base['path'] .= '/administrator';
}
*/

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



global $my, $option, $Itemid, $mosConfig_absolute_path, $mosConfig_live_site, $app, $pageNav;


	if (file_exists('../includes/joomla.php')) {
		require_once("../includes/joomla.php");
		}

//include($mosConfig_absolute_path."/includes/sef.php");


class timeline 
  {
    function showHello($option)
      {
        ?>
        <h1>Timeline</h1>
        <a href="index.php?option=<?php echo $option; ?>&task=set">Zu den Events</a> <!-- Linkt uns zu unserer Einstellungsseite -->
        <?php
      }


 
 function showSet($option, $rows, $limitstart, $limit, $total, $task) 
  {
    global $database, $mosConfig_live_site, $mosConfig_absolute_path, $app, $my;
    global $task, $option, $limit, $rows_per_page, $pages_in_list;
    //mosCommonHTML::loadOverlib();
    jimport( 'joomla.html.tooltips' );
		?>
<style type="text/css" media="screen">@import "<?php echo JURI::root();?>/components/com_timeline/css/timeline.css";</style>

<div id="menu1" class="menu1">
  <a class="menu2" href="index.php?option=com_timeline&task=set" class="button">Manage Events</a>
  <a class="menu2" href="index.php?option=com_timeline&task=faq" class="button">FAQ</a>
  <a class="menu2" href="index.php?option=com_timeline&task=about" class="button">About</a>
</div>
<div align="center" class="menu1" style="height:50px">
<?php writePagesCounter($limitstart, $limit, $total); ?>
<br />
<?php writePagesLinks($limitstart, $limit, $total); ?>
</div>

<h1>Event-Data:</h1>

<br>

  <div style="width:100%;height:500px;border:1px solid #840;overflow:auto;">


<style type="text/css" media="screen">@import "<?php echo JURI::root();?>/components/com_timeline/css/timeline.css";</style>

<form action="index.php" method="post" name="adminForm" id="adminForm">

<input type="hidden" name="option" value="<?php echo $option; ?>" />
<input type="hidden" name="task" value="" />
<input type="hidden" name="boxchecked" value="0" />
<input type="hidden" name="Itemid" value="<?php echo $Itemid;?>" />

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

  $imageurl = "";
  $imageurl = $imageurl.$row->image;
  
  if (!strncmp($imageurl, "images/", strlen("images/")))
  {
    $imageurl = "../".$imageurl;
  }

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
  $checked 	=  JHTML::_('grid.checkedout', $row, $i);
  
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
    <td><img src="<?php echo $imageurl;?>" width="50" height="50" alt="::"></td>
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

<!--<input type="submit" name="submit" value="<?php echo $task;?>" class="button" /> -->

</form>
</div>
<?php
}



    
	function editEvent( &$row, $option ) {
		global $mosConfig_live_site, $mosConfig_absolute_path;
		//mosMakeHtmlSafe( $row, ENT_QUOTES );
		//echo "JFilter<br>";
    JFilterOutput::objectHTMLSafe( $row, ENT_QUOTES );
?>
	<link rel="stylesheet" type="text/css" media="all" href="<?php echo $mosConfig_live_site; ?>/includes/js/calendar/calendar-mos.css" title="green" />
	<!-- import the calendar script -->
	<script type="text/javascript" src="<?php echo JURI::root(); ?>/includes/js/calendar/calendar.js"></script>
	<!-- import the language module -->
	<script type="text/javascript" src="<?php echo JURI::root(); ?>/includes/js/calendar/lang/calendar-en.js"></script>
	<div id="overDiv" style="position:absolute; visibility:hidden; z-index:10000;"></div>
	<script language="Javascript" src="<?php echo JURI::root(); ?>/includes/js/overlib_mini.js"></script>
	<script language="javascript" src="<?php echo JURI::root(); ?>/includes/js/dhtml.js"></script>
	
  
  <script language="javascript">
	<!--
		function submitbutton(pressbutton) {
			var form = document.adminForm;
			if (pressbutton == 'cancel') {
				submitform( pressbutton );
				return;
			}
			// do field validation
			if ( getSelectedValue('adminForm','title') == '' || (getSelectedValue('adminForm','title') == '0' && form.name.value == '') ){
				alert( "You must provide a title." );
			} else if (form.description.value == "") {
				alert( "You must enter a description." );
			}
			else {
				submitform( pressbutton );
			}
		}		
	//-->
	</script>
	
<style type="text/css" media="screen">@import "<?php echo JURI::root();?>/components/com_timeline/css/timeline.css";</style>

<form action="index.php" method="post" name="adminForm" id="adminForm">	

	<input type="hidden" name="option" value="<?php echo $option; ?>">
	<input type="hidden" name="id" value="<?php echo $row->id; ?>">
  <input type="hidden" name="boxchecked" value="0">
  <input type="hidden" name="task" value="save">

<table width="100%" border="0" class="adminheading">
  <tr>
    <td>eID</td>
    <td width="100"><strong><?php echo _TL_START;?></strong></td>
    <td width="100"><strong><?php echo _TL_END;?></strong></td>
    <td width="100"><strong><?php echo _TL_isDURATION;?></strong></td>
    <td width="150"><strong><?php echo _TL_TITLE;?></strong></td>
    <td width="150"><strong><?php echo _TL_IMAGE;?></strong></td>
    <td width="150"><strong><?php echo _TL_DESCRIPTION;?></strong></td>
    <td width="150"><strong><?php echo _TL_LINK;?></strong></td>
  </tr>


<?php

	if ($row->isDuration == 'true') {
		$resim 		= JURI::root()."/components/com_timeline/images/1.png";
		$resimalt 	= _TL_isDuration;
	} else {
		$resim 		= JURI::root()."/components/com_timeline/images/0.png";
		$resimalt 	= _TL_isNotDuration;
	}
 //$checked 	= mosCommonHTML::CheckedOutProcessing( $row, $i );
 jimport('joomla.html.html.grid');
  $checked = JHTML::_('grid.checkedout', $row, $i);
?>
<tr class="" style="height:120px; border-bottom:1px solid black;border-top:1px solid black;">
    
    <td><?php echo $row->id;?></td>
    <td><?php include(JPATH_ROOT."/components/com_timeline/startdate.inc.php");?></td>
    <td><?php include(JPATH_ROOT."/components/com_timeline/enddate.inc.php");?></td>

    <td>
       <input type="radio" id="isDuration" name="isDuration" value="true" <?php if ($row->isDuration == "true") { echo "checked";}?>> yes
      <br>
      <input type="radio" id="isDuration" name="isDuration" value="false" <?php if ($row->isDuration != "true") { echo "checked";}?>> no
      <br>
      <img src="<?php echo $resim;?>" alt="<?php echo $resimalt;?>" />
    </td>

    <td><input type="textfield" id="title" name="title" value="<?php echo $row->title;?>"  /></td>
    <td><input type="textfield" id="image" name="image" value="<?php echo $row->image;?>"  /></td>
    <td><textarea id="description" name="description" style="width:280px;height:70px;border:1px solid #840;overflow:auto;" rows=3 cols=35 ><?php echo $row->description;?></textarea></td>
    <td><input type="textfield" id="link" name="link" value="<?php echo $row->link;?>"  /></td>
  </tr>

<tr>
<td colspan="8">
<hr />
</td>
</tr>
</table>


	</form>
<?php
	}

  }
?>
