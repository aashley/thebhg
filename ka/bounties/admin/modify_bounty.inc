<?php /* Fooling VIM */ ?>
<div>
<?php
$hunt = $ka->GetHunt($_GET['id']);
$type_obj = $hunt->GetHuntType();

echo '<h2>Modify an existing Bounty</h2>';
echo '<p>Modifying '.$type_obj->GetName().'-'.$hunt->GetHuntNum().'</p>';
if (isset($_POST["submit"])) {
    $content['questions'] = $_POST['question'];
    $content['answers'] = $_POST['answer'];
    $start = mktime ($_POST['start_hour'], $_POST['start_minute'], 0, $_POST["start_month"], $_POST["start_day"], $_POST["start_year"], date('I', $hunt->GetStartTimestamp()));
    $end = mktime (23, 59, 59, $_POST["end_month"], $_POST["end_day"], $_POST["end_year"], date('I', $hunt->GetEndTimestamp()));
    if ($end < $start) {
        echo "<p>Error. Your start date is after your end date. Please go back and correct this.</p>";
        ConstructLayout();
        exit();
    }
    $ok = true;
    $move = false;
    if (!$hunt->SetStartTimestamp ($start)) $ok = 'Start Timestamp';
    if (!$hunt->SetEndTimestamp ($end)) $ok = 'End Timestamp';
    if (!$hunt->SetContent ($content)) $ok = 'Content';
    if (!$hunt->SetDivision ($_POST['division'])) $ok = 'Division';
    if ($type_obj->GetFirstReward()) {
        if (!$hunt->SetHuntFirst($_POST['first_reward'])) $ok = 'First place Reward';
    }
    if (!$hunt->SetHuntRewards($_POST['rewards'])) $ok = 'Rewards';
    if ($type_obj->GetQuestionType() == 'picture') {
        //QUESTION TYPE=PICTURE
        $uploadfile = $uploaddir. $type_obj->GetAbbr(). '-'. $hunt->GetID(). '.jpg';
        if ($_FILES['uploadhunt']['tmp_name'][0] == '') $move = true;
        elseif ((move_uploaded_file($_FILES['uploadhunt']['tmp_name'][0], $uploadfile)) && (chmod($uploadfile, 0777))) $move = true;
    }
    if (($ok == true) && (($move != false) || ($type_obj->GetQuestionType() != 'picture'))) {
        //Successful
        echo '<p>This bounty has been modified successfully.</p>';
    } else {
        if ($move == false) {
            echo '<br />File upload error: '.$_FILES['uploadhunt']['error']['0'];
            echo '<br />Upload destination: '.$uploadfile;
            echo '<br />Additional debugging info:<br />';
            print_r($_FILES);
        }
        if ($ok != true) {
            echo 'Error at setting: '.$ok;
        }
    }
} else {
    // Create a list of months, is there a better way?
    $months = array ("January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December");
    echo '<form action="'.$_SERVER['REQUEST_URI'].'" method="post" enctype="multipart/form-data">';
    echo '<input type="hidden" id="type" name="type" value="'.$type_obj->GetID().'"></input>';
    echo '<label for="division"><strong>Who</strong> can participate?</label>';
    echo '<select id="division" name="division">';
    // REMOVE "2500" FROM PR/JUD CHECK BELOW
    //CHECKING IF PERSON ADDING HUNT IS TACT/U/WARD, RESPECTIVELY
    if ($access == 2 || ($login_position->GetID() == 3) || ($login_position->GetID() == 2) || ($login_position->GetID() == 10) || ($login->getID() == 2650)) {
        $kabals = $roster->GetKabals();
        $viewable = $hunt->GetDivisionID();
        foreach ($kabals as $kabal) {
            echo '<option value="'.$kabal->GetID().'"';
            if ($viewable == $kabal->GetID()) echo ' selected="selected"';
            echo '>'.$kabal->GetName().'</option>';
        }
        echo '<option value="18"';
        if ($viewable == 18) echo ' selected="selected"';
        echo '>Citadel</option>';
        echo '<option value="-1"';
        if ($viewable == -1) echo ' selected="selected"';
        echo '>Everyone</option>';
    }
    //CHECKING IF PERSON ADDING HUNT IS CH/CRA
    elseif (($login_position->GetID() == 11) || ($login_position->GetID() == 12)) {
        $division = $login->GetDivision();
        echo '<option value="'.$division->GetID().'">'.$division->GetName().'</option>';
    }
    echo "</select><br />\n";

    //SELECT START DATE
    echo '<label for="start">What day should the bounty <strong>start</strong> on?</label>';
    //SELECT FOR MONTH
    echo '<select name="start_month" id="start_month">';
    for ($i = 1; $i <= 12; $i++) {
        echo '<option value="'.$i.'"';
        if ($i == date('n', $hunt->GetStartTimestamp())) {
            echo ' selected';
        }
        echo '>'.$months[$i-1].'</option>';
    }
    echo "</select>\n";
    //SELECT FOR DAY
    echo '<select name="start_day" id="start_day">';
    for ($i = 1; $i <= 31; $i++) {
        echo '<option value="'.$i.'"';
        if ($i == date('j', $hunt->GetStartTimestamp())) {
            echo ' selected';
        }
        echo '>'.$i.'</option>';
    }
    echo "</select>\n";
    //SELECT FOR YEAR
    echo '<select name="start_year" id="start_year">';
    echo '<option value="'.(date('Y', $hunt->GetStartTimestamp()) - 1).'">'.(date('Y', $hunt->GetStartTimestamp()) - 1).'</option>';
    echo '<option value="'. date('Y', $hunt->GetStartTimestamp()).'" selected>'.date('Y', $hunt->GetStartTimestamp()).  '</option>';
    echo '<option value="'.(date('Y', $hunt->GetStartTimestamp()) + 1).'">'.(date('Y', $hunt->GetStartTimestamp()) + 1).'</option>';
    echo "</select><br />\n";

    if ($access == 2) { //Start Time
        echo 'Start time (HH:mm):<br />'
           . '<input type="text" name="start_hour" value="'.date('G', $hunt->GetStartTimestamp()).'" size="2"></input>&nbsp;:&nbsp;'
           . '<input type="text" name="start_minute" value="'.date('i', $hunt->GetStartTimestamp()).'" size="2"></input><br />';
    } else {
        echo '<input type="hidden" name="start_hour" value="'.date('G', $hunt->GetStartTimestamp()).'" size="2"></input>'
           . '<input type="hidden" name="start_minute" value="'.date('i', $hunt->GetStartTimestamp()).'" size="2"></input>';
    }

    //SELECT END DAY
    echo '<label for="end">What day should the bounty <strong>end</strong> on?</label>';
    //SELECT FOR MONTH
    echo '<select name="end_month" id="end_month">';
    for ($i = 1; $i <= 12; $i++) {
        echo '<option value="'.$i.'"';
        if ($i == date('n', $hunt->GetEndTimestamp())) {
            echo ' selected';
        }
        echo '>'.$months[$i-1].'</option>';
    }
    echo "</select>\n";
    //SELECT FOR DAY
    echo '<select name="end_day" id="end_day">';
    for ($i = 1; $i <= 31; $i++) {
        echo '<option value="'.$i.'"';
        if ($i == date('j', $hunt->GetEndTimestamp())) {
            echo ' selected';
        }
        echo '>'.$i.'</option>';
    }
    echo "</select>\n";
    //SELECT FOR YEAR
    echo '<select name="end_year" id="end_year">';
    echo '<option value="'.(date('Y', $hunt->GetEndTimestamp()) - 1).'">'.(date('Y', $hunt->GetEndTimestamp()) - 1).'</option>';
    echo '<option value="'. date('Y', $hunt->GetEndTimestamp()).'" selected>'.date('Y', $hunt->GetEndTimestamp()).  '</option>';
    echo '<option value="'.(date('Y', $hunt->GetEndTimestamp()) + 1).'">'.(date('Y', $hunt->GetEndTimestamp()) + 1).'</option>';
    echo "</select><br />\n";

    //CUSTOM CONTENT, WHAT TO MODIFY
    $num_questions = $type_obj->GetNumQuestions();
    $num_answers = $type_obj->GetNumAnswers();
    $question_type = $type_obj->GetQuestionType();
    $content = $hunt->GetContent();
    $questions = $content['questions'];
    $answers = $content['answers'];
    $first_reward = $hunt->GetHuntFirst();
    $rewards = $hunt->GetHuntRewards();
    if ($first_reward) {
        echo "<label for=\"first_reward\">Reward for first place. (ICs)</label>";
        echo "<input type=\"text\" size=\"30\" id=\"first_reward\" name=\"first_reward\" value=\"$first_reward\"";
        if (($login_position->GetID() == 10) || ($login_position->GetID() == 11) || ($login_position->GetID() == 12)) {
            echo " readonly";
        }
        echo "></input>";
    }
    for ($i = 0; $i < $num_answers; $i++) {
        echo "<label for=\"rewards[$i]\">Reward for ".((int) $num_answers - $i)."/".$num_answers." correct. (ICs)</label>";
        echo "<input type=\"text\" size=\"30\" id=\"rewards[$i]\" name=\"rewards[$i]\" value=\"";
        echo $rewards[$i];
        echo "\"";
        if (($login_position->GetID() == 10) || ($login_position->GetID() == 11) || ($login_position->GetID() == 12)) {
            echo " readonly";
        }
        echo "></input>";
    }
    echo "<label for=\"rewards[".$num_answers."]\">Reward for 0/".$num_answers." correct. (ICs)</label>";
    echo "<input type=\"text\" size=\"30\" id=\"rewards[".$num_answers."]\" name=\"rewards[".$num_answers."]\" value=\"".$rewards[$num_answers]."\"";
    if (($login_position->GetID() == 10) || ($login_position->GetID() == 11) || ($login_position->GetID() == 12)) {
        echo " readonly";
    }
    echo "></input>";

    switch ($question_type) {
        case 'picture':
            echo '<br />Current Bounty Picture:<br />';
            echo '<img src="'.$base.'bounties/hunt_images/'.$type_obj->GetAbbr().'-'.$hunt->GetID().'.jpg" /><br />';
            echo '<input type="hidden" name="max_file_size" value="300000"></input>';
            for ($i = 0; $i < $num_questions; $i++) {
                echo '<label for="uploadhunt['.$i.']">Upload a new bounty <strong>picture</strong>. (Make sure it is .jpg and under 300 Kb)</label>';
                echo '<input type="file" name="uploadhunt['.$i.']" id="uploadhunt['.$i.']" accept="image/jpeg"></input><br />';
            }
        break;

        case 'text':
            for ($i = 0; $i < $num_questions; $i++) {
                echo '<label for="question['.$i.']">Bounty <strong>Question</strong> '.($i + 1).'/'.$num_questions.':</label>';
                echo '<input type="text" size="30" name="question['.$i.']" id="question['.$i.']" value="'.htmlspecialchars($questions[$i]).'"></input><br />';
            }
        break;
    }
    for ($i = 0; $i < $num_answers; $i++) {
        echo '<label for="answer['.$i.']">Bounty <strong>Answer</strong> '.($i + 1).'/'.$num_answers.':</label>';
        echo '<input type="text" size="30" name="answer['.$i.']" id="answer['.$i.']" value="'.htmlspecialchars($answers[$i]).'"></input><br />';
    }

    //FINISH BUTTON
    echo '<input type="submit" name="submit" value="Finish" class="submit"></input>';
    echo '</form>';
}
?>
</div>
