<?

ini_set('include_path', ini_get('include_path').':../include');
include_once('roster.inc');

$roster = new Roster();

$divisions = $roster->GetDivisions();

foreach ($divisions as $division) {
  print $division->GetName()."<br>";
}

?>
