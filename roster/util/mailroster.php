<?php

ini_set('include_path', ini_get('include_path').':/home/virtual/site5/fst/usr/share/roster3/include:/home/aashley/php/roster/include');

include_once('roster.inc');
include_once('util/zip.lib.php');
include_once('Mail.php');
include_once('Mail/mime.php');

$roster = new Roster();

$divcats = $roster->GetDivisionCategories();

$csv = "\"BHG Roster Backup\",\"".date('d M Y, H:i:s T')."\"\r\n";

foreach ($divcats as $divcat) {

  $csv .= "\r\n";

  $divisions = $divcat->GetDivisions();

  foreach ($divisions as $division) {

    if ($division->GetID() == 16) {

      continue;

    }

    $csv .= "\r\n"
      .$division->GetName()."\r\n"
      .'"Position","Rank","Name","Email Address","Rank Credits","Account Balance","Full ID Line"'."\r\n";

    $members = $division->GetMembers();

    foreach ($members as $member) {

      $position = $member->GetPosition();
      $rank = $member->GetRank();

      $csv .= '"'.$position->GetName().'","'.$rank->GetName().'","'.str_replace('"', '""', $member->GetName()).'","'.$member->GetEmail().'",'.$member->GetRankCredits().','.$member->GetAccountBalance().',"'.str_replace('"', '""', $member->IDLine())."\"\r\n";

    }

    unset($members);

  }

  unset($divisions);

}

unset($divcats);

$zip = new zipfile();

$zip->addFile($csv, 'BHGBackup-'.date('Ymd-Hi').'.csv', time());

$zipout = $zip->file();

/*$now = gmdate('D, d M Y H:i:s') . ' GMT';

Header('Content-Type: application/x-zip');
Header('Content-Length: '.strlen($zipout));
Header('Expires: ' . $now);

print $zipout;*/

print 'Mime Encoding message...<br>';
flush();

$text = 'BHG Roster backup for '.date('d M Y, H:i:s').'.';
$hdrs = array('From' => 'roster@thebhg.org',
              'Subject' => $text);

$mime = new Mail_mime();

$mime->SetTXTBody($text);
$mime->addAttachment($zipout, 'application/x-zip', 'BHGBackup.zip', false);

$body = $mime->get();
$hdrs = $mime->headers($hdrs);

$mail =& Mail::factory('mail');
$mail->send('underlord@thebhg.org, xo@emperorshammer.org', $hdrs, $body);

flush();
print 'Mail Successfully Sent.<BR>'
  .'<PRE>';

print_r($hdrs);
print($body);

print '</PRE>';

flush();
?>
