<?php

ini_set('include_path', ini_get('include_path').':/home/virtual/site5/fst/usr/share/roster3/include');

include_once('roster.inc');

$roster = new Roster();

$positions = $roster->GetPositions();

foreach ($positions as $position) {

  if ($position->IsEmailAlias()) {

    $person = $roster->SearchPosition($position->GetID());

    if (   is_array($person) 
        && isset($person[0]) 
        && is_object($person[0])
        && get_class($person[0]) == 'person') {

      print strtolower(str_replace(' ', '', $position->GetName())).": "
        .$person[0]->GetEmail()."\n"
        .strtolower($position->GetAbbrev()).": "
        .strtolower(str_replace(' ', '', $position->GetName()))."\n";

    }

  }

}

unset($positions);

$kabals = $roster->GetKabals();

foreach ($kabals as $kabal) {

  $chief = $kabal->GetChief();

  if (   is_object($chief)
      && get_class($chief) == 'person') {

    print "ch-".strtolower(str_replace(' ', '', $kabal->GetName())).": "
      .$chief->GetEmail()."\n";

  }

  unset($chief);

  $cra = $kabal->GetCRA();

  if (   is_object($cra)
      && get_class($cra) == 'person') {

    print "cra-".strtolower(str_replace(' ', '', $kabal->GetName())).": "
      .$cra->GetEmail()."\n";

  }

  unset($chief);

}

unset($kabals);

$wings = $roster->GetWings();

foreach ($wings as $wing) {

  $ward = $wing->GetWarden();

  if (   is_object($ward)
      && get_class($ward) == 'person') {

    print "ward-".strtolower(str_replace(' ', '', $wing->GetName())).": "
      .$ward->GetEmail()."\n";

  }

  unset($ward);

}

?>
