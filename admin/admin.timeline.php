<?php
defined('_JEXEC') or die('Restricted access'); /* Überprüft ob ein Direktzugriff erfolgte */

global $database, $app, $my, $mosConfig_absolute_path, $limitstart, $limit, $total, $rows_per_page, $pages_in_list, $acl;

$app = JFactory::getApplication();
$database =& JFactory::getDBO();
$my =& JFactory::getUser();
$myGroups = JAccess::getGroupsByUser($my->get('id'));

/* Joomla 1.7 GetPath and Redirect
JApplicationHelper::getPath( 'class' )
$app->redirect();
*/

$acl =& JFactory::getACL();

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

//$mosConfig_absolute_path = $mainframe->getCfg( 'absolute_path' )
$mosConfig_absolute_path = JPATH_ROOT;
//$mosConfig_live_site = $mainframe->getCfg( 'live_site' );
$mosConfig_live_site = JURI::base();

$mosConfig_lang =& JFactory::getLanguage(); 
//$mosConfig_lang = $mosConfig_lang->getBackwardLang();

 /* Überprüft ob der Benutzer die entsprechende Berechtigung besitzt */
/*
if (!($acl->acl_check( 'administration', 'edit', 'users', $my->usertype, 'components', 'all' ) || $acl->acl_check( 'administration', 'edit', 'users', $my->usertype, 'components', 'com_banners' ))) {
  $myacl = $my->authorize('com_content', 'edit', 'content', 'all'); 
  $mainframe->redirect( 'index2.php', 'Missing rights! '.$myacl );
}
*/

/*
if (strtolower($my->usertype) != 'super administrator' && strtolower($my->usertype) != 'administrator')
{
  //mosNotAuth();
  //echo "<p>You need to be at least administrator!</p>";
	$app->redirect( 'index.php', 'Missing rights! <p>You need to be at least administrator!</p>');
  //return;
}
*/

if (!JFactory::getUser()->authorise('core.admin')) 
{
	return JError::raiseWarning(404, JText::_('JERROR_ALERTNOAUTHOR'));
}



require_once( JApplicationHelper::getPath( 'class' ) ); /* Bindet die "timeline.class.php" ein */
require_once( JApplicationHelper::getPath( 'admin_html' ) ); /* Bindet die "admin.timeline.html.php" ein */

include (JPATH_ADMINISTRATOR."/components/com_timeline/timeline.conf.php"); /* Nun wird unsere Konfiguration eingebunden */

//$task = mosGetParam( $_REQUEST, 'task' ); /* Holt sich die in der Adressleiste übergebene task - Variable */
//$option = mosGetParam( $_REQUEST, 'option' ); /* Holt sich die in der Adressleiste übergebene option - Variable */

//$limitstart = intval( mosGetParam( $_REQUEST, 'limitstart', 0 ) );
//$limit 		= intval( mosGetParam( $_REQUEST, 'limit', '' ) );

//$cid = mosGetParam( $_REQUEST, 'cid', array(0) );

//$task	= mosGetParam( $_REQUEST, 'task', array(0) );
//$id		= mosGetParam($_REQUEST,"id",null);


//JRequest::getVar('

$task = JRequest::getVar('task' ); /* Holt sich die in der Adressleiste übergebene task - Variable */
$option = JRequest::getVar('option' ); /* Holt sich die in der Adressleiste übergebene option - Variable */

$limitstart = intval( JRequest::getVar('limitstart', 0 ) );
$limit 		= intval( JRequest::getVar('limit', '' ) );

$cid = JRequest::getVar('cid', array(0) );
if (!is_array( $cid )) {
	$cid = array(0);
}

$task	= JRequest::getVar('task', array(0) );
$id		= JRequest::getVar('id',null);



switch ($task) 
  {
    case 'set':
    showSet ($option, $limitstart, $limit, $total);
    break;

    case "new" :
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
    
    case "faq":
    showFAQ();
    break;

    case "about":
    showAbout();
    break;

    default:
    //showHello ($option);
    showSet ($option, $limitstart, $limit, $total);
    break;
  }

function showHello($option)
  {
    timeline::showHello($option);
  }

function showFAQ()
  {
  global $mosConfig_absolute_path;
  include(JPATH_ROOT."/components/com_timeline/doc/faq.html");
  }

function showAbout()
  {
  global $mosConfig_absolute_path;
  include(JPATH_ROOT."/components/com_timeline/doc/about.html");
  }


function showSet($option, $limitstart, $limit, $total)
  {
    global $database, $mosConfig_absolute_path, $limitstart, $limit, $total, $rows_per_page, $pages_in_list;
    require_once(JPATH_ADMINISTRATOR."/components/com_timeline/admin.timeline.navigation.php");

  	$database =& JFactory::getDBO();
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
    timeline::showSet($option, $rows, $limitstart, $limit, $total, $task); /* Ruft nun die entsprechende Ausgabe auf */
  }

function updateSet()
  {
    global $database,$option;
    $database =& JFactory::getDBO();
?>
      <h1>timeline</h1>
      <a href="index.php?option=<?php echo $option; ?>&task=set">Zurück zur Timeline</a> <!-- Linkt uns zu unserer Einstellungsseite -->


      <h1>Event-Data:</h1>
      <div style="margin-left:5px;width:100%;height:500px;border:1px solid #840;overflow:auto;">
<?php
//List all elements from $_POST
    foreach($_POST as $key=>$element)
      {
        echo $key." = ".$element."<br>";
        
        
        
        $id = substr($key, -1);
//        echo "<br>id: ".$id."<br>";
        $field = substr($key, 0, -1);
        //$field = substr($field, 3);
//        echo "field: ".$field."<br><br>";
        $value = mosGetParam($_POST, $key);
//        echo "value: ".$value."<br><br>";



        
        if (
            //$field == 'START'
           //OR $field == 'END'
           $field == 'StartDay'
           OR $field == 'StartMonth'
           OR $field == 'StartDateDay'
           OR $field == 'StartDateYear'
           OR $field == 'StartDateTime'
           OR $field == 'StartDateGMT'

           OR $field == 'EndMonth'
           OR $field == 'EndDateDay'
           OR $field == 'EndDateYear'
           OR $field == 'EndDateTime'
           OR $field == 'EndDateGMT'

           OR $field == 'isDuration'
           OR $field == 'title'
           OR $field == 'image'
           OR $field == 'description'
           OR $field == 'link'
           )
            {
                    
                    echo "<br>id: ".$id."<br>";
                    echo "field: ".$field."<br>";
                    echo "value: ".$value."<br>";

                      $database->setQuery("UPDATE #__timeline SET
                      ".$field." = '".$value."'
                      WHERE id = '".$id."'
                       ;");
                      
                      if($database->query()) /*Datensatz wird nun aktualisiert und gleichzeitig der Erfolg/Mißerfolg angezeigt */
                      echo "<h3>Aktualisierung erfolgreich<br></h3>";
                      else
                      echo "<h3>Aktualisierung fehlgeschlagen<br></h3>";
              
                         if ($database->getErrorNum()) 
                    {
              		    echo $database->stderr();
              		    return false;
              		  }
            
            }
        
      }
      ?>
      </div>
      <?php
  }

###################################################
# Function del                                    #
# delete conf                                     #
###################################################


function del($option, $cid) {

global $database, $app;
$database =& JFactory::getDBO();

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
  $app->redirect("index.php?option=$option&task=set");
}


/*
function del($option, $cid) {
	global $database;
	if (count( $cid )) {
		$cids = implode( ',', $cid );
		$database->setQuery( "DELETE FROM #__timeline WHERE id IN ($cids)" );
		if (!$database->query()) {
			echo "<script> alert('".$database->getErrorMsg()."'); window.history.go(-1); </script>\n";
		}
	}
	mosRedirect( "index2.php?option=$option&task=set" );
}
*/


function editEvent( $option, $cid ) {
	global $database, $my;
  $database =& JFactory::getDBO();

	$row = new timelineclass($database);
	$row->load($cid);
  echo "loading ".$cid."<br>";
	//die();
  $database -> setQuery("SELECT * FROM #__timeline WHERE id=$cid");
	$usersTemp = $database->loadObjectList();
  echo "Launching timeline::editEvent<br>";
	timeline::editEvent( $row, $option );
}



function saveEvent( $option )
{
	global $database, $app;

  $database =& JFactory::getDBO();

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

function store($option, $id) {
global $database, $app, $id;

$database =& JFactory::getDBO();

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
$app->redirect("index.php?option=$option&amp;task=set", "<br>Stored: ".$id."<br>");
}


?>
