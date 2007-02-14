<?php
function title() {
  return 'Administration :: Chief Bonuses';
}

function auth($person) {
  global $auth_data, $pleb, $roster;

  $auth_data = get_auth_data($person);
  $pleb = $roster->getPerson($person->getID());
  return ($auth_data['judicator'] || $auth_data['underlord']);
}

function output() {
  global $auth_data, $roster, $page;

  roster_header();

  if (isset($_REQUEST['submit'])) {

    if ($_REQUEST['submit'] == 'Start Bonuses') {
      $startut = parse_date_box('start');
      $endut = parse_date_box('end') + 86399;

      $start = new Date();
      $start->setDate($startut, DATE_FORMAT_UNIXTIME);

      $end = new Date();
      $end->setDate($endut, DATE_FORMAT_UNIXTIME);

      $form = new Form($page);

      // {{{ Generate Kabal Listings

      $kabals = $roster->getKabals();

      foreach($kabals as $kabal) {

        $form->AddSectionTitle($kabal->GetName());

        $form->table->StartRow();

        $chiefs = $roster->SearchPositionBetween(new Position(11),
                                                 $start,
                                                 $end,
                                                 $kabal);
        
        $form->table->AddCell('Chief:', 
                              1, 
                              (count($chiefs) ? count($chiefs) : 1));

        if (count($chiefs) == 0) {

          $form->table->AddCell('N/A');
          $form->table->EndRow();

        } else {

          $first = true;
          foreach ($chiefs as $chief) {
            if ($first) {
              $first = false;
            } else {
              $form->table->StartRow();
            }
            $form->table->AddCell('<input type="checkbox" name="kabal['
                .$kabal->getID().'][chiefs][]" id="chief'.$kabal->getID()
                .$chief->getID().'" value="'.$chief->getID()
                .'" checked="checked">'
                .' <label for="chief'.$kabal->getID().$chief->getID().'">'
                .$chief->GetName().'</label>');
            $form->table->EndRow();
          }

        }

        $cras = $roster->SearchPositionBetween(new Position(12),
                                               $start,
                                               $end,
                                               $kabal);

        $form->table->StartRow();

        $form->table->AddCell('CRA:',
                              1,
                              (count($cras) ? count($cras) : 1));

        if (count($cras) == 0) {

          $form->table->AddCell('N/A');
          $form->table->EndRow();

        } else {
          
          $first = true;
          foreach ($cras as $cra) {
            if ($first) {
              $first = false;
            } else {
              $form->table->StartRow();
            }
            $form->table->AddCell('<input type="checkbox" name="kabal['
                .$kabal->getID().'][cras][]" id="cra'.$kabal->getID()
                .$cra->getID().'" value="'.$cra->getID().'" checked="checked">'
                .' <label for="cra'.$kabal->getID().$cra->getID().'">'
                .$cra->GetName().'</label>');
            $form->table->EndRow();
          }

        }

        $form->StartSelect('Web Site:',
                           'kabal['.$kabal->getID().'][web]');
				$form->AddOption(0, 'No website');
        $form->AddOption(1, 'Old Website');
        $form->AddOption(2, 'Broken Links');
        $form->AddOption(3, 'Out of Date');
        $form->AddOption(4, 'Updated');
        $form->AddOption(5, 'Revamped');
				$form->AddOption(6, 'New Layout');
        $form->EndSelect();

        $form->StartSelect('Report Quantity:',
                           'kabal['.$kabal->getID().'][report]');
        $form->AddOption(0, 'No Reports');
        $form->AddOption(1, '1 to 3 Reports');
        $form->AddOption(2, '4 to 5 Reports');
        $form->AddOption(3, '6+ Reports');
        $form->EndSelect();

				$form->StartSelect('Report Quality:',
													 'kabal['.$kabal->getID().'][repqual]');
				$form->AddOption(0, 'No reports');
				$form->AddOption(1, 'Lacking vital information');
				$form->AddOption(2, 'Sub-standard report');
				$form->AddOption(3, 'Basic report');
				$form->AddOption(4, 'Informative');
				$form->AddOption(5, 'Encyclopedia');
				$form->EndSelect();

        $form->StartSelect('Bounties:',
                           'kabal['.$kabal->getID().'][activity]');
				$form->AddOption(0, 'No Bounties');
        $form->AddOption(1, '1-6 Bounties');
        $form->AddOption(2, '7-16 Bounties');
        $form->AddOption(3, '17-27 Bounties');
        $form->AddOption(4, '28-39 Bounties');
        $form->AddOption(5, '40+ Bounties');
        $form->EndSelect();

        $form->StartSelect('Chief Activity:',
                           'kabal['.$kabal->getID().'][chiefother]');
				$form->AddOption(0, 'No activity');
        $form->AddOption(1, 'Sub-standard activity');
        $form->AddOption(2, 'Basic activity');
        $form->AddOption(3, 'Ok activity');
        $form->AddOption(4, 'Great activity');
        $form->AddOption(5, 'Excellent activity');
        $form->EndSelect();

        $form->StartSelect('CRA Activity:',
                           'kabal['.$kabal->getID().'][craother]');
				$form->AddOption(0, 'No activity');
        $form->AddOption(1, 'Sub-standard activity');
        $form->AddOption(2, 'Basic activity');
        $form->AddOption(3, 'Ok activity');
        $form->AddOption(4, 'Great activity');
        $form->AddOption(5, 'Excellent activity');
        $form->EndSelect();

      }

      // }}}
      // {{{ Generate Wing Listings

      $wings = $roster->GetWings();

      foreach($wings as $wing) {

        $form->AddSectionTitle($wing->GetName());

        $form->table->StartRow();

        $wardens = $roster->SearchPositionBetween(new Position(10),
                                                  $start,
                                                  $end,
                                                  $wing);
        
        $form->table->AddCell('Warden:', 
                              1, 
                              (count($wardens) ? count($wardens) : 1));

        if (count($wardens) == 0) {

          $form->table->AddCell('N/A');
          $form->table->EndRow();

        } else {

          $first = true;
          foreach ($wardens as $warden) {
            if ($first) {
              $first = false;
            } else {
              $form->table->StartRow();
            }
            $form->table->AddCell('<input type="checkbox" name="wing['
                .$wing->getID().'][wardens][]" id="warden'.$wing->getID()
                .$warden->getID().'" value="'.$warden->getID()
                .'" checked="checked">'
                .' <label for="warden'.$wing->getID().$warden->getID().'">'
                .$warden->GetName().'</label>');
            $form->table->EndRow();
          }

        }

        $form->StartSelect('Reports:',
                           'wing['.$wing->getID().'][report]');
        $form->AddOption(1, '4 Basic Reports');
        $form->AddOption(2, '5 Basic Reports');
        $form->AddOption(3, '4 Average Reports');
        $form->AddOption(4, '5 Average Reports');
        $form->AddOption(5, '5 Good Reports');
        $form->EndSelect();

        $form->StartSelect('Activities:',
                           'wing['.$wing->getID().'][activity]');
        $form->AddOption(1, '1-3 Activities');
        $form->AddOption(2, '4-6 Activities');
        $form->AddOption(3, '7-10 Activities');
        $form->AddOption(4, '11-15 Activities');
        $form->AddOption(5, '15+ Activities');
        $form->EndSelect();

        $form->StartSelect('Warden Activity:',
                           'wing['.$wing->getID().'][wardenother]');
        $form->AddOption(1, 'Sub-standard activity');
        $form->AddOption(2, 'Average activity');
        $form->AddOption(3, 'Good activity');
        $form->AddOption(4, 'Great activity');
        $form->AddOption(5, 'Excellent activity');
        $form->EndSelect();

        $form->StartSelect('Graduates:',
                           'wing['.$wing->getID().'][graduates]');
        $form->AddOption(1, '1-8 Graduates');
        $form->AddOption(2, '9-18 Graduates');
        $form->AddOption(3, '19-28 Graduages');
        $form->AddOption(4, '29-39 Graduates');
        $form->AddOption(5, '40+ Graduates');
        $form->EndSelect();

      }

      // }}}

      $form->AddSubmitButton('submit', 'Calculate Bonuses');

      $form->EndForm();

    } elseif ($_REQUEST['submit'] == 'Calculate Bonuses') {

      $form = new Form($page);

      // {{{ Calculate Kabal Credits

      foreach ($_REQUEST['kabal'] as $kid => $data) {

        $kabal = $roster->GetKabal($kid);

        $form->AddSectionTitle($kabal->getName());

        $form->table->StartRow();
        $form->table->AddCell('Chief:', 2);
        $form->table->EndRow();

        if (isset($data['chiefs']) && sizeof($data['chiefs']) > 0) {

          foreach ($data['chiefs'] as $id) {

            $chief = $roster->getPerson($id);

            $credits = floor(  (  (  ( $data['web'] * 3 )
                                   + ( $data['report'] * 3 )
																	 + ( $data['repqual'] * 3 )
                                   + ( $data['activity'] * 3 )
                                   + ( $data['chiefother'] * 3 )
                                   + ( $data['craother'] * 3 ) )
                                / 9) 
                             * 160000);

            $form->AddTextBox($chief->GetName(),
                              'div['.$kabal->getID().']['.$chief->GetID().']',
                              $credits);

          }

        }

        $form->table->StartRow();
        $form->table->AddCell('CRA:', 2);
        $form->table->EndRow();

        if (isset($data['cras']) && sizeof($data['cras']) > 0) {

          foreach ($data['cras'] as $id) {

            $cra = $roster->getPerson($id);

            $credits = floor(  (  (  ( $data['web'] * 3 )
                                   + ( $data['report'] * 3 )
																	 + ( $data['repqual'] * 3 )
                                   + ( $data['activity'] * 3 )
                                   + ( $data['chiefother'] * 3 )
                                   + ( $data['craother'] * 3 ) )
                                / 9) 
                             * 160000 * 0.25);

						print $cra->getName().'<br/><pre>'.print_r($credits, true).'</pre>';

            $form->AddTextBox($cra->GetName(),
                              'div['.$kabal->getID().']['.$cra->GetID().']',
                              $credits);

          }

        }

      }

      // }}}
      // {{{ Calculate Wing Credits

      foreach ($_REQUEST['wing'] as $wid => $data) {

        $wing = $roster->GetKabal($wid);

        $form->AddSectionTitle($wing->getName());

        $form->table->StartRow();
        $form->table->AddCell('Warden:', 2);
        $form->table->EndRow();

        if (isset($data['wardens']) && sizeof($data['wardens']) > 0) {

          foreach ($data['wardens'] as $id) {

            $warden = $roster->getPerson($id);

            $credits = floor(  (  (  ( $data['report'] * 3 )
                                   + ( $data['activity'] * 3 )
                                   + ( $data['wardenother'] * 3 )
                                   + ( $data['graduates'] * 3 ) )
                                / 9) 
                             * 160000);

            $form->AddTextBox($warden->GetName(),
                              'div['.$wing->getID().']['.$warden->GetID().']',
                              $credits);

          }

        }

      }

      // }}}

      $form->AddSubmitButton('submit', 'Award Bonuses');

      $form->EndForm();

    } elseif ($_REQUEST['submit'] == 'Award Bonuses') {

      $table = new Table();

      foreach ($_REQUEST['div'] as $div => $data) {

        $division = $roster->getDivision($div);

        $table->StartRow();

        $table->AddCell($division->getName(), 
                        1, 
                        (sizeof($data) ? sizeof($data) : 1));

        $first = true;

        foreach ($data as $id => $credits) {

          if ($first) {
            $first = false;
          } else {
            $table->StartRow();
          }

          $person = $roster->getPerson($id);

          $table->AddCell($person->getName());

          if ($person->AddCredits($credits,
                                  'Monthly Activity Bonus')) {

            $table->AddCell('OK');

          } else {

            $table->AddCell('Error<br>'.$person->error());

          }

          $table->EndRow();

        }

      }

      $table->EndTable();

    }

  } else {

    $last_month_start = mktime(0, 0, 0, date('m') - 1, 1, date('Y'));
    $last_month_end = mktime(0, 0, 0, date('m'), 0, date('Y'));

    $form = new Form($page);
    $form->AddDateBox('Start Date:', 'start', $last_month_start);
    $form->AddDateBox('End Date:', 'end', $last_month_end);
    $form->AddSubmitButton('submit', 'Start Bonuses');
    $form->EndForm();
  }

  admin_footer($auth_data);
}

?>
