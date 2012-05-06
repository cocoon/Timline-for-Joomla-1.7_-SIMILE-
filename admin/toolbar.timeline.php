<?php
defined('_JEXEC') or die ('Direct Access is not allowed');
     
// include support libraries 

require_once( JApplicationHelper::getPath( 'toolbar_html' ) ); 
  
// Handling der Tasks 
//$task = mosGetParam( $_REQUEST, 'task', '' ); 
$task = JRequest::getVar('task');

switch($task)
  {
    case 'set':
    menutimeline::MENU_set();
    break;
    
    case 'new':
    menutimeline::MENU_set();
    break;
    
    case 'edit':
    menutimeline::MENU_edit();
    break;

    case 'about':
    menutimeline::MENU_back();
    break;
    
    case 'faq':
    menutimeline::MENU_back();
    break;

    default:
    menutimeline::MENU_set();
    break;
  }
?>
