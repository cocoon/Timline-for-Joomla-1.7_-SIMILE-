<?php
// Datei wird korrekt von Mambo/Joomla aufgerufen oder eben nicht und dann beendet 
defined('_JEXEC') or die('Restricted access');

class menutimeline 
  {

    function menu_set() 
      {
        JToolBarHelper::title( JText::_( 'Timeline' ) .': <small[ Config ]</small>', 'generic.png' );
        //mosMenuBar::startTable();
        // Neu-Icon 
        //mosMenuBar::addNew('new');
         JToolBarHelper::addNew('new'); 
        //mosMenuBar::save(save); /* Dieser Parameter wird mittels task übergeben */
        //mosMenuBar::spacer();
		    //mosMenuBar::editList();
		    JToolBarHelper::editList();
        // Löschen-Icon 
        //mosMenuBar::deleteList(' ', 'delete', 'Delete' );
        JToolBarHelper::deleteList(' ', 'delete', 'Delete' );
        //mosMenuBar::back(back);
        JToolBarHelper::back(back);
        //mosMenuBar::spacer();
        JToolBarHelper::spacer();
        //mosMenuBar::help('screen.polls.edit');
        //mosMenuBar::endTable();
      }
    
    function menu_show() 
      {
        JToolBarHelper::title( JText::_( 'Timeline' ) .': <small[ Show ]</small>', 'generic.png' );
        //mosMenuBar::startTable();
        //mosMenuBar::save(saveset); /*saveset wird über task an das admin.timeline.php geschickt */
        //mosMenuBar::spacer();
        JToolBarHelper::spacer();
        //mosMenuBar::back(back); /* Das wäre eine retour Taste... wir verwenden sie derweilen nicht */
        //mosMenuBar::spacer();
        //mosMenuBar::help( 'screen.polls.edit' );
        //mosMenuBar::endTable();
      }

  	function menu_edit() {
  		JToolBarHelper::title( JText::_( 'Timeline' ) .': <small[ Edit ]</small>', 'generic.png' );
      //mosMenuBar::startTable();
  		//mosMenuBar::save();
  		//mosMenuBar::cancel();
  		// Speichern-Icon 
         JToolBarHelper::save(); 
      // Abbrechen-Icon 
         JToolBarHelper::cancel(); 
  		//mosMenuBar::spacer();
  		JToolBarHelper::spacer();
  		//mosMenuBar::endTable();  
  	}
  	
  	function menu_back() {
  	   JToolBarHelper::title( JText::_( 'Timeline' ) .': <small[ Back ]</small>', 'generic.png' );
  		//mosMenuBar::startTable();
      //mosMenuBar::spacer();
  		//mosMenuBar::back(back);
  		JToolBarHelper::back(back);
      //mosMenuBar::spacer();
      JToolBarHelper::spacer();
  		//mosMenuBar::endTable();  
  	}

  }
?>
