<?php

  include "setup.php";
  if (!isset($other_month)) { $other_month = time(); } 
  $this_month = date ("n", $other_month);  
  $this_day = date ("j", $other_month);
  $this_year = date ("Y", $other_month); 
  $days_in_month = date ("t", $other_month);
  $first_day_timestamp = mktime (1, 1, 1, $this_month, 1, $this_year);
  $first_day = date ("w", $first_day_timestamp);
  $square_counter = 1 + $first_day;
  $day = 1;
  
  for ($k = 0; $k < $first_day; $k++) { $string .= "%blank%:"; }
  for ($i = (1 + $first_day); $i <= ($days_in_month + $first_day); $i++)
  {
    $string .= ($i - $first_day).":";
    if (($square_counter % 7) == 0) { $string .= ";"; }
    $square_counter++;
  }
  $extra = 8 - ($square_counter % 7);
  for ($k = 0; $k < $extra; $k++) { $string .= "%blank%:"; }
  $gui_obj->addContent ("<h2 align=\"center\">".date("F", $other_month)." ".date("Y", $other_month)."</h2>\r\n");
  $gui_obj->addContent ("<table border=\"1\" align=\"center\" bordercolor=\"black\" cellspacing=\"1\" cellpadding=\"3\"><tr bordercolor=\"#FFFFFF\"><td align=\"center\">Sun</td><td align=\"center\">Mon</td><td align=\"center\">Tue</td><td align=\"center\">Wed</td><td align=\"center\">Thur</td><td align=\"center\">Fri</td><td align=\"center\">Sat</td></tr><tr bordercolor=\"#FFFFFF\">\r\n");
  $cols_array = explode (";", $string);
  for ($i = 0; $i < sizeof ($cols_array); $i++)
  {
    $days_array = explode (":", $cols_array[$i]);
    for ($j = 0; $j < sizeof ($days_array); $j++)
    {
      $echo_str = $days_array[$j];
      $echo_str = eregi_replace ("%blank%", "&nbsp;", $echo_str);
      if (!strlen($echo_str) <= 0)
      {
        if (($echo_str == $this_day) && (date ("n", $other_month) == date ("n", time())))
        {
          $echo_str = "<font color=\"#000000\"><a class=\"today\">".$echo_str."</a></font>"; 
        }
        //if (racetoday)
        //{
        //   $gui_obj->addContent ("<td bgcolor=\"red\" width=\"50px\" height=\"50px\" valign=\"top\" align=\"right\">".$echo_str."</td>\r\n");
        //}
        $gui_obj->addContent ("<td width=\"50px\" height=\"50px\" valign=\"top\" align=\"right\">".$echo_str."</td>\r\n");
      }
    }
     $gui_obj->addContent ("</tr><tr bordercolor=\"#FFFFFF\">\r\n");
  }
  $last_month = mktime (0, 0, 0, $this_month - 1, $this_day, $this_year);
  $next_month = mktime (0, 0, 0, $this_month + 1, $this_day, $this_year);
  $gui_obj->addContent ("</tr></table>\r\n");
  $gui_obj->addContent ("<br><table align=\"center\" width=\"80%\"><tr><td align=\"left\"><a href=\"".$base_url."calender.php?other_month=".$last_month."\"><b><< ".date("F", $last_month)."</b></a></td><td align=\"right\"><a href=\"".$base_url."calender.php?other_month=".$next_month."\"><b>".date("F", $next_month)." >></b></a></td></tr></table>\r\n");
  $gui_obj->setTitle("Schedule");
  $gui_obj->outputGui();
?>