<?php
function title() {
	return 'Administration :: Upload New Kabal Logo';
}

function auth($person) {
	global $auth_data, $div;

	$auth_data = get_auth_data($person);
	$div = $person->GetDivision();
	return ($auth_data['underlord'] || $auth_data['chief']);
}

function output() {
	global $auth_data, $div, $roster, $page;
	roster_header();

	if ($_REQUEST['submit']) {
		$kabal = $roster->GetKabal($_REQUEST['division']);
		$destination = $roster->GetSetting('imagecache_dir');

		$finfo = finfo_open(FILEINFO_MIME);
		$mime = finfo_file($finfo, $_FILES['logo']['tmp_name']);
		finfo_close($finfo);

		switch ($mime) {
			case 'image/gif':
				$filename = strtolower($kabal->GetName()).'.gif';
				break;

			case 'image/jpeg':
				$filename = strtolower($kabal->GetName()).'.jpg';
				break;

			case 'image/png':
				$filename = strtolower($kabal->GetName()).'.png';

			default:
				$filename = strtolower($kabal->GetName());
				break;

		}

		$destination = $destination.'/'.$filename;

		if (move_uploaded_file($_FILES['logo']['tmp_name'], $destination)) {
			echo 'New Kabal logo saved.';
			$kabal->SetLogo($filename);
		}
		else {
			echo 'Error moving logo.';
		}
	}
	elseif ($_REQUEST['division'] || $div->IsKabal()) {
		if ($_REQUEST['division']) {
			$kabal = $roster->GetKabal($_REQUEST['division']);
		}
		else {
			$kabal = $roster->GetKabal($div->GetID());
		}

		$form = new Form($page, 'post', $page, 'multipart/form-data');
		$form->AddHidden('division', $kabal->GetID());
		$form->AddHidden('MAX_FILE_SIZE', 20480);
		$form->AddFile('New Logo:', 'logo');
		$form->AddSubmitButton('submit', 'Upload New Logo');
		$form->EndForm();

		hr();

		echo 'Note: The logo needs to be in PNG format, 64x64 pixels, less than 20k in size (hopefully much less), and ideally should have a transparent background.';
	}
	else {
		$form = new Form($page, 'get');
		$form->StartSelect('Select the Kabal to edit:', 'division');
		$kabals = $roster->GetKabals();
		foreach ($kabals as $kabal) {
			$form->AddOption($kabal->GetID(), $kabal->GetName());
		}
		$form->EndSelect();
		$form->AddSubmitButton('', 'Edit Kabal Details');
		$form->EndForm();
	}

	admin_footer($auth_data);
}
?>
