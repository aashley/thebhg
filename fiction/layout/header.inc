<?php include('objects/include.inc');
$fic = new Fiction();
$search = new Search();
echo '<?xml version="1.0" encoding="iso-8859-1"?>'."\n";
?>
<!DOCTYPE html
     PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
     "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
    <head>
        <title>BHG Fiction Archive</title>
        <link rel="stylesheet" href="main.css" type="text/css" />
    </head>
    <body>
        <img src="images/banner.jpg" width="100%" alt="banner" /><br />
        <table style="width: 98%; border: 0 none inherit; text-align: center" cellpadding="0" cellspacing="0">
            <tr>
                <td style="width: 18%; text-align: center; vertical-align: top">

    <table style="width: 90%; border: 1px solid #777777; border-collapse: collapse">
    <tr><td style="background-color: #00009C; text-align: center">
    <p style="color: #FFFFFF; font-variant: small-caps; text-decoration: underline">Navigation</p>
        </td></tr>
    <tr><td style="background-color: #AAAAAA; text-align: center">
    <p style="color: #000000; font-variant: small-caps">
        <a href="index.php">Home</a><br />
        <a href="admin.php">Administration</a><br />
<?php
if ($_COOKIE['BHGLogin_id']) {
    echo "<a href=\"library.php?poster=" . $_COOKIE['BHGLogin_id'] . "\">Personal Library</a><br />";
}
?>
        <a href="library.php">Library</a><br />
        <a href="fiction.php">Random Fiction</a><br />
        <a href="competition.php">Fiction Competitions</a><br />
        <a href="old/index.htm">Old Fiction Site</a>
    </p></td></tr>
    </table><br /><br />

    <table style="width: 90%; border: 1px solid #777777; border-collapse: collapse">
    <tr><td style="background-color: #00009C; text-align: center">
    <p style="color: #FFFFFF; font-variant: small-caps; text-decoration: underline">Posters</p>
        </td></tr>
    <tr><td style="text-align: center; background-color: #AAAAAA">
    <p style="color: #000000; font-variant: small-caps">
        <?php $agg = $search->AllPosters();
$i = 0;
$count = count($agg);
$base = array();
$num = array();
include_once 'roster.inc';
$roster = new Roster();
while ($i < $count) {
    $person = new Person($agg[$i]);
    $var[$person->GetName()][] = $person->GetID();
    $i++;
}

ksort($var);
$count = count($var);
$keys = array_keys($var);
$i = 0;

while ($i < $count) {
    $name = $keys[$i];
    $base = $var[$name];
    echo "<a href=\"library.php?poster=" . $base[0] . "\">" . $name . "</a><br />";
    $i++;
}
$fic = new Fiction();
?>

        </p></td></tr>

    </table><br /><br />


    <table style="width: 90%; border: 1px solid #777777; border-collapse: collapse">
    <tr><td style="background-color: #00009C; text-align: center">
    <p style="color: #FFFFFF; font-variant: small-caps; text-decoration: underline">Archive Stats</p>
        </td></tr>
    <tr><td style="background-color: #AAAAAA; text-align: center">
    <p style="color: #000000; font-variant: small-caps">
        Total Fictions: <?php echo $fic->CountFictions();
?><br />
        Total Posters: <?php echo $fic->CountPosters();
?><br />
        Competition Submissions: <?php echo $fic->CountCompSubmit();
?><br />
        </p>
        </td></tr>

    </table>
        </td>
        <td style="width: 82%; text-align: center; vertical-align: top">