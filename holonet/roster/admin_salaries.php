<?php
function title() {
	return 'Administration :: Add Salaries';
}

function auth($person) {
	global $auth_data, $pleb, $roster;

	$auth_data = get_auth_data($person);
	$pleb = $roster->GetPerson($person->GetID());
	return $auth_data['underlord'];
}

function output() {
	global $auth_data, $pleb, $page, $roster;

	roster_header();

	if ($_REQUEST['hunters']) {
		foreach ($_REQUEST['hunters'] as $rid=>$credits) {
			$person = $roster->GetPerson($rid);
			$person->AddCredits($credits, 'salary');
		}
	}
	elseif ($_REQUEST['submit']) {
		$startut = parse_date_box('start');
		$endut = parse_date_box('end') + 86399;

    $start = new Date();
    $start->setDate($startut, DATE_FORMAT_UNIXTIME);

    $end = new Date();
    $end->setDate($endut, DATE_FORMAT_UNIXTIME);

		// Basically, we iterate through the positions, take the ones
		// that have salaries, and go from there.
		$hunters = array();
		foreach ($roster->GetPositions() as $pos) {
			if ($pos->GetIncome() > 0) {

        // First Get the people that have held this position for the time
        // period

        $holder = $roster->SearchPositionBetween($pos, $start, $end);

        // Figure out how many credits to give each person

        foreach ($holder as $hunter) {

          $time = 0;
          $prev_start = $startut;
          $open = false;
          $history = $hunter->GetHistory();
          $history->Load($startut,
                         $endut, 
                         array(2));

          if ($history->Count()) {
            do {
              $item = $history->GetItem();
              if ($item->GetItem(2) == $pos->GetID()) {
                // Start of tenure
                $prev_start = $item->GetDate();
                $open = true;
              } elseif ($item->GetItem(1) == $pos->GetID()) {
                $time += ($item->GetDate() - $prev_start);
                $open = false;
              }
            } while ($history->Next());
            if ($open) {
              $time += ($endut - $prev_start);
            }
          } else {
            // Held pos all month
            $time = $endut - $startut;
          }

          $creds = round(($time / ($endut - $startut)) * $pos->GetIncome());

          if (isset($hunters[$hunter->GetID()])) {
            $hunters[$hunter->GetID()] += $creds;
          } else {
            $hunters[$hunter->GetID()] = $creds;
          }

        }

			}
      
		}

		$form = new Form($page);
		foreach ($hunters as $rid=>$credits) {
			$hunter = $roster->GetPerson($rid);
			$form->AddTextBox($hunter->GetName(), "hunters[$rid]", $credits);
		}
		$form->AddSubmitButton('submit', 'Add Salaries');
		$form->EndForm();
	}
	else {
		$last_month_start = mktime(0, 0, 0, date('m') - 1, 1, date('Y'));
		$last_month_end = mktime(0, 0, 0, date('m'), 0, date('Y'));
		
		$form = new Form($page);
		$form->AddDateBox('Start Date:', 'start', $last_month_start);
		$form->AddDateBox('End Date:', 'end', $last_month_end);
		$form->AddSubmitButton('submit', 'Calculate Salaries');
		$form->EndForm();
	}

	admin_footer($auth_data);
}
?>
