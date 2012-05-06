<?php

defined('_JEXEC') or die('Restricted access'); /* Überprüft ob ein Direktzugriff erfolgte */

$my =& JFactory::getUser();
$database =& JFactory::getDBO();
$config =& JFactory::getConfig();
$mosConfig_dbprefix = $config->getValue('config.dbprefix');  


class timelineclass extends JTable {

	var $id = null; //` int(11) NOT NULL auto_increment,
	//var $start = null; // varchar(40) NOT NULL default '',
  //var $end = null; // varchar(40) NOT NULL default '',
  
  var $StartDay = null;
  var $StartMonth = null;
  var $StartDateDay = null;
  var $StartDateYear = null;
  var $StartDateTime = null;
  var $StartDateGMT = null;
  
  var $EndDay = null;
  var $EndMonth = null;
  var $EndDateDay = null;
  var $EndDateYear = null;
  var $EndDateTime = null;
  var $EndDateGMT = null;
  
	var $isDuration = null; // varchar(40) NOT NULL default '',
	var $title = null; // VARCHAR(40) NOT NULL default '',
	var $image = null; // text NOT NULL default '',
	var $description = null; // text NOT NULL default '',
	var $link = null; // text NOT NULL,


 	
function timelineclass( &$db ) 
      {
        //$this->mosDBTable( '#__timeline', 'id', $db );
        parent::__construct( '#__timeline', 'id', $db );
      }

}//END class messenger extends mosDBTable {

class timeline_conf extends JTable {

var $id = null; //` tinyint(2) NOT NULL auto_increment,
var $site_messenger_version = null;       // set Site Messenger Version String 
var $SM_AJAX  = null;                     // use AJAX Popups 1=yes/0=no - nA at the moment
var $rows_per_page = null;                // set how many rows per page you want displayed
var $pages_in_list = null;                // set how many pages you want displayed in the menu
var $order_inbox_by = null;               // set how to order messages in your inbox (date/id/fromname/toname/time/subject/msg/isread)
var $order_inbox_type = null;             // set in which order to display messages in your inbox (asc/desc)
var $autoclose_timer = null;              // Time in ms
var $SM_SHOW_FROMID = null;               // Show sender ID in messages 1=yes/0=no
var $SM_SHOW_AVATAR = null;               // Show sender AVATAR in messages 1=yes/0=no
var $SM_APPEND_OLDMSG = null;             // Append old message when replying 1=yes/0=no
var $SM_BUDDYLIST = null;                 // Use extended BuddyList 1=yes/0=no
  var $SM_SHOW_OFFLINE_BUDDYS = null;     // Show offline users as offline or don#t list offline users 1=yes/0=no
  var $SM_SHOW_BUDDYREQUESTS = null;      // Show list of users with open buddy requests
var $SM_BUDDYLIST_BUTTONS = null;         // Show buttons for add/remove/accept buddy 1=yes/0=no
var $SM_SHOW_SELF = null;                 // Show own user in userlist 1=yes/0=no
var $SM_CSS = null;                       // Use own css 1=yes/0=no
var $SM_MSGHEADER = null;                 // Switch way to display message header 1=formal/0=table
var $SM_REFRESHTIME = null;               // Set time in seconds for refreshing module window
var $SM_SMILEY = null;                    // Replace Text-Smiley with image? 1=yes/0=no
var $SM_BBCODE_IMAGECOUNT = null;         // Set how many images should be displayed in Messages
var $SM_SHOW_ALLUSERS = null;             // Set if you want to display all users online
var $SM_WORDWRAP = null;                  // Set if you want to use internal wordwrapping function 1=yes/0=no
var $SM_BLOWFISH_ENCRYPTION = null;       //Set if you want to display blowfish encryption fields
var $SM_POPUPSOUND = null;                // Set if you want to hear a sound play when a popup opens
var $SM_GZIP_COMPRESSION = null;          // Set if you want to use GZIP to compress Text/History in Database
var $SM_AUTOMARKASREAD = 1;                 //Set if you want to automatically mark messages as read
//var $SM_USERCONF = 1;
//var $SM_URL2LINK = 1;

function Timeline_Conf(&$db)
      {
        //$this->mosDBTable('#__timeline_conf', 'configid', $db);
         parent::__construct( '#__timeline_conf', 'configid', $db );

      }
}//END class TimelineConf extends mosDBTable {
?>
