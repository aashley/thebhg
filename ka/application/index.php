<?php
include('functions.inc');
include('../Layout.inc');

include_once 'citadel.inc';

$citadel = new Citadel();

if ($_REQUEST['submit']) {
	$message = '';
	append_mail($message, 'Position Applied For: ' . $_POST['position']);
	append_mail($message, 'Requirements Met: ' . $_POST['yesno']);
	append_mail($message, 'Name: ' . $_POST['name']);
	append_mail($message, 'ID Line: ' . $_POST['idline']);
	append_mail($message, 'E-mail Address: ' . $_POST['email']);
	append_mail($message, 'IRC Nick(s): ' . $_POST['ircnick']);
	append_mail($message, 'Has he/she taken the Chief Test? ' . $_POST['chtest']);
	append_mail($message, 'If yes, the score was: ' . $_POST['score']);
	append_mail($message, 'Other Citadel or IWATS courses: ' . $_POST['citadel']);
	append_mail($message, 'Experience: ' . $_POST['experience']);
	append_mail($message, 'Other Skills: ' . $_POST['skills']);
	append_mail($message, 'Why you want this position: ' . $_POST['whyposition']);
	mail('reports@thebhg.org', $_POST['position'] . ' Application', $message, "From: unanswered@thebhg.org\r\nX-Mailer: PHP");

	echo 'Your application has been sent. Thank you for applying.';
}
else {
?>
			<div>
				<h2>KA Application Form</h2>
				<p><strong>Position Requirements</strong>:</p>
				<p><strong>Chief</strong>: Must be able to handle a large group of hunters (anywhere from 10-50), must be available at least five days a week, must be able to send out weekly reports, must be able to solve problems among hunters, and must possess a good working knowledge of HTML.</p>
				<form method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
					<label for="position">Position being applied for:</label>
					<select id="position" name="position">
						<option selected value="choose">Select One</option>
						<option value="Proctor">Proctor</option>
						<option value="Warden">Warden</option>
<?php foreach ($roster->GetKabals() as $kabal) { ?>
						<option value="<?php echo htmlspecialchars($kabal->GetName()); ?> Chief"><?php echo htmlspecialchars($kabal->GetName()); ?> Chief</option>
<?php } ?>
					</select><br />
					<label for="yesno">Do you meet all the above requirements?</label>
					<select id="yesno" name="yesno">
						<option selected value="choose">Select One</option>
						<option value="Yes">Yes</option>
						<option value="No">No</option>
						<option value="Some, but not all">Some, but not all</option>
					</select><br />
					<label for="name">Name:</label>
					<input type="text" id="name" name="name" size="30" /><br />
					<label for="email">E-mail Address:</label>
					<input type="text" id="email" name="email" size="30" /><br />
					<label for="ircnick">IRC Nick(s):</label>
					<input type="text" id="ircnick" name="ircnick" size="30" /><br />
					<label for="idline">ID Line:</label>
					<input type="text" id="idline" name="idline" size="30" /><br />
					<label for="sgid">Other Subgroup ID Lines:</label>
					<textarea id="sgid" name="sgid" rows="3" cols="60"></textarea><br />
					<label for="chtest">Have you taken the Chief course at the Citadel?</label>
					<select id="chtest" name="chtest">
						<option selected value="choose">Select One</option>
						<option value="Yes">Yes</option>
						<option value="No">No</option>
					</select><br />
					<label for="score">If yes, please enter your score:</label>
					<input type="text" id="score" name="score" value="00" size="2" /><br />
					<label for="citadel">List any other Citadel or IWATS courses below:</label>
					<textarea id="citadel" name="citadel" rows="3" cols="60">BHG Core, RPG, IWATS Core, etc.</textarea><br />
					<label for="experience">List any experience you may have:</label>
					<textarea id="experience" name="experience" rows="5" cols="60"></textarea><br />
					<label for="skills">What skills do you possess?</label>
					<textarea id="skills" name="skills" rows="5" cols="60">HTML, PHP, Graphic design, etc.</textarea><br />
					<label for="whyposition">Why do you want this position?</label>
					<textarea id="whyposition" name="whyposition" rows="5" cols="60"></textarea><br />
					<input type="submit" name="submit" value="Apply" />
					<input type="reset" name="reset" value="Start Over" />
				</form>
			</div>
<?php
}

ConstructLayout('KA Application Form');
?>
