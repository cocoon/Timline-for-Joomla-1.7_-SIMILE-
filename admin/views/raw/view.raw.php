<?php
/* Hagen Graf - cocoate.com - Nov. 2007 */
jimport( 'joomla.application.component.view');
/**
 * HTML View class for the auto Component
 */
class timelineViewRaw extends JView
{
	function display($tpl = null)
	{
/*
    $model	  = &$this->getModel();
  	$id = JRequest::getVar('id');
  	$row     = $model->getMessage(array("id" =>$id));
  	$row     = sitemessengerViewMessage::preparemsg($row);
    $toname = $row->fromname;
    $this->assignRef('row'  , $row);
    //ComHeader($msg, $toname);
*/
		parent::display($tpl);
	}	

}//End class timelineViewRaw extends JView
?>
