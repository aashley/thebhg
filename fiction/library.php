<?php
require_once('layout/header.inc');
$search = new Search();

if ($search->IsPoster($poster)) {
    $new = $search->ByPerson($poster);
} else {
    $new = $search->RandomPoster();
    $base = $new[0];
    $person = $base->GetPoster();
    $poster = $person->GetID();
}

$rost = new Roster();
$person = new Person($poster);
$name = $person->GetName();
$fic = new Fiction();

echo '<table style="width: 90%; border-collapse: collapse; border: 1px solid #777777"><tr><td style="text-align: center; background-color: #00009C" colspan="2"><p style="color: #FFFFFF; font-variant: small-caps">Library Shelf for ' . $name . '</p></td></tr>';

$count = count($new);
$i = 0;

while ($i < $count) {
    $base = $new[$i];
    $date = $base->GetDate();

    echo "<tr><td style=\"text-align: center; width: 70%\"><a href=\"fiction.php?id=" . $base->GetID() . "\">" . $base->GetTitle() . "</a></td><td style=\"text-align: center\">" . $date['mon'] . "/" . $date['mday'] . "/" . $date['year']."</td></tr>";

    $i++;
}
echo "</table>";

require_once('layout/footer.inc');
?>