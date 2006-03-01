<?php
include_once('header.php');

page_header('Edit Rank Fees');

if ($level == 3) {
	if ($_REQUEST['submit']) {
		foreach ($_REQUEST['rank'] as $rid=>$fee) {
			$rank =& $ka->GetRankFee($rid);
			if ($rank) {
				$rank->SetFee($fee);
			}
			else {
				$ka->AddRankFee($rid, $fee);
			}
		}
		echo 'Rank fees saved.';
	}
	else {
		$form = new Form($_SERVER['PHP_SELF']);
		foreach ($roster->GetRanks() as $rank) {
			$fee =& $ka->GetRankFee($rank);
			$form->AddTextBox($rank->GetName() . ':', 'rank[' . $rank->GetID() . ']', ($fee ? $fee->GetFee() : '0'), 10);
		}
		$form->AddSubmitButton('submit', 'Save Rank Fees');
		$form->EndForm();
	}
}
else {
	echo 'You are not authorised to view this page.';
}

page_footer();
?>
