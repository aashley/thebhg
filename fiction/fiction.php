<?php
include('layout/header.inc');
$search = new Search();

if ($search->IsFiction($id)) {
    $new = new Article($id);
} else {
    $new = $search->RandomFiction();
}

$date = $new->GetDate();
$person = $new->GetPoster();

$name = $person->GetName();
$id = $person->GetID();

echo "<table style=\"width: 100%; border: 1px solid #FFFFFF; border-collapse: collapse\">\n"
   . "  <tr>"
   . "    <td style=\"background-color: #00009C; text-align: center\">"
   . "      <p style=\"color: #FFFFFF; font-variant: small-caps\">" . $new->GetTitle() . "</p>"
   . "    </td>"
   . "  </tr>"
   . "  <tr>"
   . "    <td style=\"text-align: left;\">"
   . "      " . $new->GetFiction() . "<p style=\"text-align: right\">Posted By <a href=\"library.php?poster=" . $id . "\">" . $name . "</a> on " . $date['mon'] . "/" . $date['mday'] . "/" . $date['year'] . "</p>"
   . "    </td>"
   . "  </tr>"
   . "</table>";

include('layout/footer.inc');
?>