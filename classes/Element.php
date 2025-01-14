<?php

/**
 * The abstract class for an office element
 * @author Shawn Contant <shawnc366@gmail.com>
 * 
 */

date_default_timezone_set('America/Mexico_City');
abstract class Element {
     protected $name;
     protected $season;
     protected $day;
     protected $dayOfWeek;
     protected $office;
     
     // Must be defined by every element class
     abstract function display();
     
     // Lecturn says
     function lecho($msg){
          echo '<div class="lector"><b>L:</b> ' . $msg . '<br /></div>';
     }
     
     // Congregation says
     function cecho($msg){
          echo '<div class="congregation"><b>C:</b> ' . $msg . '</div>';
     }
     
     // Grabs the audio and generates the HTML
     function getAudio($office,$name){
          echo '<audio controls>';
          echo '  <source src="../' . $office . '-audio/' . $name . '.ogg" />';
          echo '  <source src="../' . $office . '-audio/' . $name . '.mp3" />';
          echo '</audio><br />';          
     }
     
     // Displays element name
     function showName(){
          echo '<div class="name"><b>' . $this->name . '</b></div>';
     }     
     
    
     public function getSeason(){
          $now = time();
          $year = date('Y');
          $output = array(
               'season' => '',
               'week' => '',
               'day' => (int)date('w')
          );

          // Identify the seasonal ranges
          $yearStart = strtotime('January 1, ' . $year);
          $easterStart = easter_date($year);
          $epiphany = strtotime('January 6, ' . $year);
          $lent = strtotime('-46 days', $easterStart);
          $easter = $easterStart;
          $ordinary = strtotime('+50 days', $easterStart);
          $advent = strtotime('+3 days', strtotime('last Thursday of November ' . $year));
          $christmas = strtotime('December 25, ' . $year);
          $nextYear = strtotime('January 1, ' . ($year+1));
          $names = array('christmas', 'epiphany', 'lent', 'easter', 'ordinary', 'advent', 'christmas', 'next year');
          $starts = array($yearStart, $epiphany, $lent, $easter, $ordinary, $advent, $christmas, $nextYear);
          for($i = 0; $i < count($starts) - 1; $i++){
               if($now >= $starts[$i] && $now <= $starts[$i+1]){
                    $output['season'] = $names[$i];
                    $output['week'] = ceil((($now / 86400) - ($starts[$i] / 86400)) / 7);
               }
          }
          return $output;
     }     
}
?>
