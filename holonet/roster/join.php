<?php
// Verboten words.
$verboten = array('4-lom', 'ig-88', 'jango', 'fett', 'boba', 'yoda', 'fuck', 'shit', 'cunt', 'jedi');

function check_email($email) {
	return ereg('^[-!#$%&\'*+\\./0-9=?A-Z^_`a-z{|}~]+'.'@'.'[-!#$%&\'*+\\/0-9=?A-Z^_`a-z{|}~]+\.'.'[-!#$%&\'*+\\./0-9=?A-Z^_`a-z{|}~]+$', $email);
}

function title() {
	return 'Join the BHG';
}

function output() {
	global $roster, $page, $verboten;

	roster_header();

	if (empty($_REQUEST['name'])) {
		echo 'So, hunter...if you can be called that yet. Some of you are hunters by your decree only- some of you are of the trade of the smuggler, or the pirate, or the mercenary. All of you share one interesting trait- you all believe you have what it takes to enlist with us.   Have you read the manual of The BHG, and do you believe that you understand the harsh system that you will be placed into?  You honestly believe that you can defend your Kabal against the others, and compete with some of the most ruthless beings in the galaxy in the name of your own advancement?  Fill out this form in it\'s entirety to join The Bounty Hunter\'s Guild, if you feel you can.  Perhaps someday you will become one of the leaders of this Guild.  Perhaps someday you will become one of the most famous hunters of all time.  Your future here depends on what choices you make for yourself along the way.  Choose wisely, and let me be the first to welcome you to this organization.<br><br>Specialist Emeritus Elliad Gavron<br><br>We welcome the applications of the hunters, smugglers, pirates, mercenaries, and all other various scum of the galaxy.';

		hr();

		$form = new Form($page);
		$form->AddTextBox('Preferred Name *:', 'name');
		$form->AddTextBox('E-Mail Address:', 'email');
		$form->AddPasswordBox('Password:', 'password');
		$form->AddPasswordBox('Confirm Password:', 'confirm');
		$form->AddCheckBox('Are you under 13? **', 'youngun', 'on');
		$form->AddTextBox('If so, **<br>Please enter a parent\'s e-mail address:', 'parent');
		$form->AddTextArea('Comments/Questions:', 'comments', '', 4, 40);
		$form->AddSubmitButton('', 'Join the BHG');
		$form->EndForm();

		hr();

		echo '* - This should be something original.  Do not use names such as Boba Fett, 4-LOM, IG-88, et al, as there are already a large number of people using those names.<br><br>** - Due to the Children\'s Online Privacy Protection Act of April 21st, 2000, anyone under the age of 13 needs parental consent before signing up for anything which requires the volunteering of personal information. If you are under 13 your join request will be held until we recieve a letter of consent for your parent.';
	}
	else {
		if ($_REQUEST['password'] != $_REQUEST['confirm']) {
			echo 'The passwords you have entered do not match.';
		}
		elseif ($_REQUEST['password'] == '') {
			echo 'You have not entered a password.';
		}
		elseif ($_REQUEST['name'] == '') {
			echo 'You have not entered a name.';
		}
		elseif (preg_match('/(' . implode(')|(', $verboten) . ')/', $_REQUEST['name'])) {
			echo 'Your name includes a prohibited word which you cannot use in your name. This is usually caused by either having a name, whether partial or complete, of a common Star Wars character, or by having an obscenity in your name.';
		}
		elseif (!check_email($_REQUEST['email'])) {
			echo 'The e-mail address you have entered is invalid.';
		}
		elseif ($_REQUEST['youngun'] && ($_REQUEST['parent'] || !check_email($_REQUEST['parent']))) {
			echo 'You have either not entered an e-mail address for your parent or guardian, or it is invalid.';
		}
		else {
			if (mysql_query('INSERT INTO roster_new_members (name, email, password, underage, parentemail, comments) VALUES ("' . addslashes($_REQUEST['name']) . '", "' . addslashes($_REQUEST['email']) . '", "' . addslashes($_REQUEST['password']) . '", ' . ($_REQUEST['youngun'] ? '1' : '0') . ', "' . addslashes($_REQUEST['parent']) . '", "' . addslashes($_REQUEST['comment']) . '")', $roster->roster_db)) {
				echo 'Thank you for applying to join the Bounty Hunter\'s Guild. ';
				if ($_REQUEST['youngun']) {
					echo 'Upon receiving permission from your parent or guardian, you will be added to the BHG Roster by the Underlord as soon as possible.';
					$email_message = "Dear Parent,\nYour child wishes to join a Star Wars fanclub called the Bounty Hunter's Guild. This group has many activities which include Chat room meetings, playing Star Wars video games, reading and writing Star Wars fiction and a few more Star Wars related games. The Bounty Hunter's Guild is itself a subgroup of the Emperor's Hammer, an online organization participated in by over five thousand people.\n\nThe reason for this email is because the Children's Online Privacy Protection Act of April 21st, 2000 states that all children under the age of 13 cannot sign up for anything which requires the volunteering of personal information without a letter of consent from one of the child's parents.";
					$cuddly = $roster->SearchPosition(1);
					$cuddly = $cuddly[0];
					$email_message = $email_message." Please respond to this email with your consent. If you have any reservations about the Bounty Hunters Guild, or if you wish to know more about what it is, please don't hesitate to e-mail its leader, ".$cuddly->GetName().", at ".$cuddly->GetEmail()." with your questions. Below are a few of the club's important links so you may view them and decide if this club is appropriate for your child.";
					$email_message = $email_message."\n\nThe Bounty Hunters Guild Webpage\nhttp://www.thebhg.org/\n\nThe Emperor's Hammer Webpage (The BHG's Parent Group)\nhttp://www.emperorshammer.org/\n\n";
					$email_message = $email_message."Your email address was provided by a person trying to join under the name, ".$_REQUEST['name'].", with an email address of ".$_REQUEST['email'].". If this message has reached you in error please accept our apologies.\n\n";
					$email_message = $email_message."Respectfully,\nThe Bounty Hunters Guild Commission";
					$underlord = $roster->SearchPosition(2);
					if ($underlord) {
						$email_headers = 'X-Sender: ' . $underlord->GetEmail() . "\nReturn-Path: " . $underlord->GetEmail() . "\nFrom: " . $underlord->GetEmail() . "\nReply-To: " . $underlord->GetEmail() . "\nX-Mailer: PHP/" . phpversion();
					}
					else {
						$underlord = $roster->GetPerson(94);
						$email_headers = 'X-Sender: ' . $underlord->GetEmail() . "\nReturn-Path: " . $underlord->GetEmail() . "\nFrom: " . $underlord->GetEmail() . "\nReply-To: " . $underlord->GetEmail() . "\nX-Mailer: PHP/" . phpversion();
					}
					mail($_REQUEST['parent'], "BHG: Your child has expressed interest in joining the Bounty Hunters Guild", $email_message, $email_headers);
				}
				else {
					echo 'Your application will be processed by the Underlord within the next two days. If you do not receive an e-mail welcoming you to the BHG in the next week, please feel free to contact the Underlord regarding your application.';
				}
			}
			else {
				echo 'An error occurred while attempting to add you to the database. Please contact the Underlord via e-mail with the details of your application.';
			}
		}
	}

	roster_footer();
}
?>
