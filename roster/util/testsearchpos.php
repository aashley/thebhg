<?php

ini_set('include_path', ini_get('include_path').':/home/virtual/site5/fst/usr/share/roster3/include:/home/aashley/php/roster/include');

include_once 'Date.php';
include_once 'roster.inc';

$roster = new Roster('roster-69god');

$start = new Date(Date_Calc::beginOfMonth($_REQUEST['month'],
                                         $_REQUEST['year'],
                                         '%Y-%m-%d'));

$end = new Date(Date_Calc::beginOfNextMonth($start->getDay(),
                                            $start->getMonth(),
                                            $start->getYear(),
                                            '%Y-%m-%d'));

print 'Who was in each position from '.$start->getDate().' to '
  .$end->getDate().'<br><br>';
flush();

$positions = $roster->getPositions();

foreach ($positions as $position) {

  if ($position->getIncome() > 0) {

    print '<b>'.$position->GetName().'</b><br>';
    flush();

    $return = $roster->SearchPositionBetween($position, $start, $end);

    foreach ($return as $person) {

      print ' - '.$person->IDLine(0).'<br>';
      flush();

    }

    print '<br>';
    flush();

  }

}

?>
