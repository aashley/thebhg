<?php

ini_set('include_path', ini_get('include_path').':/home/virtual/site5/fst/usr/share/roster3/include:/home/aashley/php/roster/include');

include_once('roster.inc');
$roster = new Roster('citadel-38learn');

$citadel = $roster->getWing(18);

$members = $citadel->getMembers();

foreach ($members as $member) {

  print 'Name: '.$member->getName().'<br>';

  $member->UpdateRank();

  print '<br>';

}

?>
