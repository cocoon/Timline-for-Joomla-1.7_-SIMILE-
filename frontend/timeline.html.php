<?php
defined('_JEXEC') or die('Restricted access'); /* Überprüft ob die Seite nicht direkt aufgerufen wurde */

class timeline
{
  function show($rows)
    { /* Hier nun unser Code */
      // <!-- Beenden wir mal den php - Code und geben das ganze als einfaches -->
      ?>
      <div style="background-color:<?php echo $rows[0]->bgColor; ?>; color:<?php echo $rows[0]->txtColor; ?>">
      <!-- Hier wurden nun die Übergebenen Variablen verwendet -->
      <?php include "components/com_timeline/content.html.php"; /* Nun wird unser Text eingebunden */ ?>
      </div>
      <?php
    }

 
   function showHello($option)
      {
        ?>
        <h1>timeline</h1>
        <a href="index.php?option=<?php echo $option; ?>&task=set&tmpl=component">Zu den Einstellungen</a> <!-- Linkt uns zu unserer Einstellungsseite -->
        <?php
      }

	function editEvent( &$row, $option ) {
		global $mosConfig_live_site, $mosConfig_absolute_path;
		
		jimport( 'joomla.html.tooltips' );
		
?>
	<link rel="stylesheet" type="text/css" media="all" href="<?php echo JURI::root(); ?>/includes/js/calendar/calendar-mos.css" title="green" />
	<!-- import the calendar script -->
	<script type="text/javascript" src="<?php echo JURI::root(); ?>/includes/js/calendar/calendar.js"></script>
	<!-- import the language module -->
	<script type="text/javascript" src="<?php echo JURI::root(); ?>/includes/js/calendar/lang/calendar-en.js"></script>
	<div id="overDiv" style="position:absolute; visibility:hidden; z-index:10000;"></div>
	<!-- does not exist in Joomla 1.5 <script language="Javascript" src="<?php echo JURI::base(); ?>/includes/js/overlib_mini.js"></script> -->
	<script language="javascript" src="<?php echo JURI::root(); ?>/includes/js/dhtml.js"></script>
	
  <script language="JavaScript" src="<?php echo JURI::root();?>/includes/js/JSCookMenu_mini.js" type="text/javascript"></script>
<script language="JavaScript" src="<?php echo JURI::root();?>/administrator/includes/js/ThemeOffice/theme.js" type="text/javascript"></script>
<script language="JavaScript" src="<?php echo JURI::root();?>/includes/js/joomla.javascript.js" type="text/javascript"></script>
  
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

 <div id="menu1" class="menu1">
    <!-- <input type="button" name="new" value="new" onclick="javascript:submitbutton('new')"> -->
    <!-- <input type="button" name="edit" value="edit" onclick="javascript:submitbutton('edit')"> -->
    <input type="button" name="save" value="save" onclick="javascript:submitbutton('save')">
    <!-- <input type="button" name="delete" value="delete" onclick="javascript:if (document.adminForm.boxchecked.value == 0){ alert('Please make a selection from the list to delete'); } else if (confirm('Are you sure you want to delete selected items?  ')){ submitbutton('delete');}"> -->
    <input type="button" name="cancel" value="cancel" onclick="javascript:if (confirm('Are you sure you want to cancel?  ')){ window.location = 'index.php?option=com_timeline';}">
  </div>

<div style="width:100%;height:300px;border:1px solid #840;overflow:auto;">

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
		$resim 		= JURI::base()."/components/com_timeline/images/1.png";
		$resimalt 	= _TL_isDuration;
	} else {
		$resim 		= JURI::base()."/components/com_timeline/images/0.png";
		$resimalt 	= _TL_isNotDuration;
	}
 //$checked 	= mosCommonHTML::CheckedOutProcessing( $row, $i );
 jimport('joomla.html.html.grid');                                                                                                
 echo JHTML::_('grid.checkedout', $row, $i);
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
</div>
<?php
	}


}
?>
