<?
include('template.inc');
include('variables.inc');

function parse($event) {
str_replace("%title%", "die", $event);

str_replace("%date%", $date, $event);

str_replace("%elapsed%", $elapsed, $event);

str_replace("%event%", $text, $event);

str_replace("%jump%", $jump, $event);

str_replace("%unix%", $unix, $event);

str_replace("%id% ", $event_id, $event);

str_replace("%refine% ", $refine, $event);

return $event;

}

?>