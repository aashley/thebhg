<?php
/* A quick and dirty e-mailing script for the KA web site. Uses the HTTP
 * referer for security. Probably not the smartest idea, all things considered,
 * but it'll work on enough browsers that I don't really give a shit.
 *
 * (C) Jernai Teifsel 2002
 */

// Fill out the variables based on what we receive from the form.
$subject = $HTTP_POST_VARS['subject'];
$recipient = $HTTP_POST_VARS['recipient'];
$redirect = $HTTP_POST_VARS['redirect'];


$headers = <<<EOMH
From: KA Hunts Centre <ka@thebhg.org>
Reply-To: $email
EOMH;

$msg = "Message sent from IP address $REMOTE_ADDR.\n\n";

foreach ($HTTP_POST_VARS as $key=>$var) {
	if ($var != 'subject' && $var != 'recipient' && $var != 'redirect') {
		$msg .= "$key: $var\n";
	}
}

mail($recipient, $subject, $msg, $headers);

echo "Your form has been sent off. Thank you. Please <A HREF=\"$redirect\">click here</A> to continue.";

?>
