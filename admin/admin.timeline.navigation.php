<?php
defined('_JEXEC') or die('Restricted access');

global $app, $limitstart, $limit, $total;

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


//include($mosConfig_absolute_path."/administrator/components/com_sitemessenger/sitemessenger.conf.php");

/**
* Page navigation support functions
*
* Input:
* $limitstart (int The record number to start dislpaying from)
* $limit (int Number of rows to display per page)
* $total (int Total number of rows)
*/

/**
* Writes the html links for pages, eg, previous 1 2 3 ... x next
*/
    function writePagesLinks($limitstart, $limit, $total) {
    global $pages_in_list, $Itemid, $limitstart, $limit, $total, $pages_in_list;
      
      $this_page = "";
        $displayed_pages = $pages_in_list;
        $total_pages = ceil( $total / $limit );
        $this_page = ceil( ($limitstart+1) / $limit );
      	$start_loop = (floor(($this_page-1)/$displayed_pages))*$displayed_pages+1;
      	if ($start_loop + $displayed_pages - 1 < $total_pages) {
      		$stop_loop = $start_loop + $displayed_pages - 1;
      	} else {
      		$stop_loop = $total_pages;
      	}

        
        if ($this_page > 1) {
            $page = ($this_page - 2) * $limit;
            echo "\n<a href=\"index2.php?option=com_timeline&amp;task=set&amp;Itemid=$Itemid&amp;limitstart=0\" title=\"". _SM_FIRST_PAGE ."\"><<</a>";
            echo "\n<a href=\"index2.php?option=com_timeline&amp;task=set&amp;Itemid=$Itemid&amp;limitstart=$page\" title=\"". _SM_PREV_PAGE ."\"><</a>";
        }

	for ($i=$start_loop; $i <= $stop_loop; $i++) {
		$page = ($i - 1) * $limit;
		if ($i == $this_page) {
			echo "\n <span class=\"pagenav\">$i</span> ";
		} else {
			echo "\n<a class=\"pagenav\" href=\"index2.php?option=com_timeline&amp;task=set&amp;Itemid=$Itemid&amp;limitstart=$page\"><strong>$i</strong></a>";
		}
	}

        if ($this_page < $total_pages) {
            $page = $this_page * $limit;
            $end_page = ($total_pages-1) * $limit;
            echo "\n<a href=\"index2.php?option=com_timeline&amp;task=set&amp;Itemid=$Itemid&amp;limitstart=$page\" title=\"". _SM_NEXT_PAGE ."\">></a>";
            echo "\n<a href=\"index2.php?option=com_timeline&amp;task=set&amp;Itemid=$Itemid&amp;limitstart=$end_page\" title=\"". _SM_LAST_PAGE ."\">>></a>";
        }
    }

/**
* Writes the html for the pages counter, eg, Results 1-10 of x
*/
    function writePagesCounter($limitstart, $limit, $total) {
       $from_result = $limitstart+1;
        if ($limitstart + $limit < $total) {
            $to_result = $limitstart + $limit;
        } else {
            $to_result = $total;
        }
 if ($total > 0) {
            echo _SM_RESULTS . " <b>" . $from_result . " - " . $to_result . "</b><br /> " . _SM_OF_TOTAL . ": <b>" . $total . "</b>";
        } else {
            echo _SM_NOMSG . ".";
        }
    }

?>
