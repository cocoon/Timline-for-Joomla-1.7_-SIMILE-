<?php
// Datei wird korrekt von Mambo/Joomla aufgerufen oder eben nicht und dann beendet 
defined('_JEXEC') or die('Restricted access');

global $app, $database, $document, $my, $startdate;

//Secure include( $mainframe->getCfg( 'absolute_path' )."/components/com_$name/$name.php" );
//$mosConfig_absolute_path = $mainframe->getCfg( 'absolute_path' );
//$mosConfig_live_site = $mainframe->getCfg( 'live_site' );


$app = JFactory::getApplication();
$database =& JFactory::getDBO();
$document=& JFactory::getDocument();
$my =& JFactory::getUser();

//$mosConfig_absolute_path = $mainframe->getCfg( 'absolute_path' )
$mosConfig_absolute_path = JPATH_BASE;
//$mosConfig_live_site = $mainframe->getCfg( 'live_site' );
$mosConfig_live_site = JURI::base();

$mosConfig_lang =& JFactory::getLanguage(); 
//$mosConfig_lang = $mosConfig_lang->getBackwardLang();

$document->setTitle( "timeline Komponente " ); /* Setzt den Seitentitel */

//$ctask = mosGetParam( $_REQUEST, "ctask" ); /* Liest aus der Adressleiste den Übergabewert "task" */
//$ctask = mosGetParam( $_REQUEST, "option" ); /* Liest aus der Adressleiste den Übergabewert "option" */

$ctask = JRequest::getVar('ctask' ); /* Liest aus der Adressleiste den Übergabewert "task" */
$ctask =JRequest::getVar('option' ); /* Liest aus der Adressleiste den Übergabewert "option" */



//require_once ("components/com_timeline/timeline.conf.php"); /* Nun wird unsere Konfiguration eingebunden */

switch($ctask){ /*Falls man mehrere Seiten anzeigen will übergibt man am Besten diese via task=befehl und bindet diese mittels case ein */

  case 'xyz':
  showContentZoom();
  break;

  default:
  showContentZoom();
  break;
  } 



function showContentZoom()
{
global $startdate, $DecoratorStartLabel, $DecoratorEndLabel, $mosConfig_live_site;
?>
<html>
  <head>
  
  <base target="_blank">
  
<!-- <script src="http://simile.mit.edu/timeline/api/timeline-api.js" type="text/javascript"></script> -->
<script src="<?php echo JURI::root();?>/components/com_timeline/js/api/timeline-api.js" type="text/javascript"></script>
<script type="text/javascript">
       //fix for missing history file (__history__.html?0)
       /*
       No need to hack in the js file.
      Just add "SimileAjax.History.enabled = false;" inside a script tag after loading
      timeline-api.js and before creating the timeline.
      
      ######
      Alternatively, if you still want to use the history feature (I don't like it, I must
      say, because the implementation is rather intrusive), correct the path to the html
      file located in the timeline folder under
      
      timeline_2.3.0\timeline_ajax\content\history.html
      
      like the following after loading timeline-api.js:
      
      'SimileAjax.History.historyFile =
      "/{yourScriptFolder}/timeline_{version}/timeline_ajax/content/history.html";'
      
       */
       SimileAjax.History.enabled = false;

       
       var eventSource = new Timeline.DefaultEventSource();
       var tl;
        function onLoad() {
            var eventSource = new Timeline.DefaultEventSource();
            
            var zones = [
                {   start:    "Fri May 02 2006 00:00:00 GMT-0600",
                    end:      "Mon Nov 25 2006 00:00:00 GMT-0600",
                    magnify:  10,
                    unit:     Timeline.DateTime.DAY
                },
                {   start:    "Fri Nov 22 2006 09:00:00 GMT-0600",
                    end:      "Sun Nov 24 2006 00:00:00 GMT-0600",
                    magnify:  5,
                    unit:     Timeline.DateTime.HOUR
                },
                {   start:    "Fri Nov 22 2006 11:00:00 GMT-0600",
                    end:      "Sat Nov 23 2006 00:00:00 GMT-0600",
                    magnify:  5,
                    unit:     Timeline.DateTime.MINUTE,
                    multiple: 10
                },
                {   start:    "Fri Nov 22 2006 12:00:00 GMT-0600",
                    end:      "Fri Nov 22 2006 14:00:00 GMT-0600",
                    magnify:  3,
                    unit:     Timeline.DateTime.MINUTE,
                    multiple: 5
                }
            ];
            var zones2 = [
                {   start:    "Fri Nov 22 2006 00:00:00 GMT-0600",
                    end:      "Mon Nov 25 2006 00:00:00 GMT-0600",
                    magnify:  10,
                    unit:     Timeline.DateTime.WEEK
                },
                {   start:    "Fri Nov 22 2006 09:00:00 GMT-0600",
                    end:      "Sun Nov 24 2006 00:00:00 GMT-0600",
                    magnify:  5,
                    unit:     Timeline.DateTime.DAY
                },
                {   start:    "Fri Nov 22 2006 11:00:00 GMT-0600",
                    end:      "Sat Nov 23 2006 00:00:00 GMT-0600",
                    magnify:  5,
                    unit:     Timeline.DateTime.MINUTE,
                    multiple: 60
                },
                {   start:    "Fri Nov 22 2006 12:00:00 GMT-0600",
                    end:      "Fri Nov 22 2006 14:00:00 GMT-0600",
                    magnify:  3,
                    unit:     Timeline.DateTime.MINUTE,
                    multiple: 15
                }
            ];
            
            var theme = Timeline.ClassicTheme.create();
            theme.event.label.width = 250; // px
            theme.event.bubble.width = 250;
            theme.event.bubble.height = 200;
            
            //var date = "Fri May 08 2006 13:00:00 GMT-0600"
            var date = "<?php echo $startdate;?>"
            var bandInfos = [
                Timeline.createHotZoneBandInfo({
                    width:          "75%", 
                    intervalUnit:   Timeline.DateTime.WEEK, 
                    intervalPixels: 200,
                    zones:          zones,
                    eventSource:    eventSource,
                    date:           date,
                    timeZone:       -6,
                    theme:          theme
                }),
                Timeline.createHotZoneBandInfo({
                    width:          "25%", 
                    intervalUnit:   Timeline.DateTime.MONTH, 
                    intervalPixels: 200,
                    zones:          zones2, 
                    eventSource:    eventSource,
                    date:           date, 
                    timeZone:       -6,
                    showEventText:  false, 
                    trackHeight:    0.5,
                    trackGap:       0.2,
                    theme:          theme
                })
            ];
            bandInfos[1].syncWith = 0;
            bandInfos[1].highlight = true;
            
            //TIMELINE API v1.2
            //bandInfos[1].eventPainter.setLayout(bandInfos[0].eventPainter.getLayout());
            
            //TIMELINE API v2
            bandInfos[1].eventPainter.Layout=bandInfos[0].eventPainter.Layout;
            
            for (var i = 0; i < bandInfos.length; i++) {
                bandInfos[i].decorators = [
                    new Timeline.SpanHighlightDecorator({
                        startDate:  "Fri Nov 22 2006 12:30:00 GMT-0600",
                        endDate:    "Fri Nov 22 2006 13:00:00 GMT-0600",
                        color:      "#FFC080",
                        opacity:    50,
                        startLabel: "<?php echo $DecoratorStartLabel;?>",
                        endLabel:   "<?php echo $DecoratorEndLabel;?>",
                        theme:      theme
                    }),
                    new Timeline.PointHighlightDecorator({
                        date:       "Fri Nov 22 2006 14:38:00 GMT-0600",
                        color:      "#FFC080",
                        opacity:    50,
                        theme:      theme
                    }),
                    new Timeline.PointHighlightDecorator({
                        date:       "Sun Nov 24 2006 13:00:00 GMT-0600",
                        color:      "#FFC080",
                        opacity:    50,
                        theme:      theme
                    })
                ];
            }
            
            tl = Timeline.create(document.getElementById("my-timeline-zoom"), bandInfos, Timeline.HORIZONTAL);
            tl.loadXML("<?php echo JURI::root();?>/index.php?option=com_timeline&task=xml&no_html=1&tmpl=component", function(xml, url) { eventSource.loadXML(xml, url); });
        }
        
 var resizeTimerID = null;
 function onResize() {
     if (resizeTimerID == null) {
         resizeTimerID = window.setTimeout(function() {
             resizeTimerID = null;
             tl.layout();
         }, 500);
     }
 }
</script>

<script type="text/javascript">
/*
//document.body.className='smBody';

document.body.onLoad = function() {
  onLoad();
}

document.body.onresize = function() {
  onResize();
}
*/
</script>

  </head>
 <body onload="onLoad();" onresize="onResize();">

<div id="my-timeline-zoom" style="height: 300px; border: 1px solid #aaa"></div>

  </body>
</html>
<?php
}//End function showtimeline()
?>
