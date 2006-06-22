<?php
echo '<div>';
echo '<h2>Create a new Bounty</h2>';
if (isset($_POST["submit"])) {
    //QUESTION TYPE=TEXT
    $content['questions'] = $_POST['question'];
    $content['answers'] = $_POST['answer'];
    $first_reward = $_POST['first_reward'];
    $rewards = $_POST['rewards'];
    $content = serialize($content);
    $start = mktime ($_POST['start_hour'], $_POST['start_minute'], 0, $_POST["start_month"], $_POST["start_day"], $_POST["start_year"], date('I'));
    $end = mktime (23, 59, 59, $_POST["end_month"], $_POST["end_day"], $_POST["end_year"], date('I'));
    if ($end < $start) {
        echo "<p>Error. Your start date is after your end date. Please go back and correct this.</p>";
        ConstructLayout();
        exit();
    }
    //Main Create Hunt method call
    $hunt = $ka->CreateHunt ($_POST["type"], $_POST["division"], $rewards, $content, $start, $end, $first_reward);
    $type_obj = $ka->GetHuntType($_POST['type']);
    if ($type_obj->GetQuestionType() == 'picture') {
        //QUESTION TYPE=PICTURE
        $uploadfile = $uploaddir. $type_obj->GetAbbr(). '-'. $hunt->GetID(). '.jpg';
        if ((move_uploaded_file($_FILES['uploadhunt']['tmp_name'][0], $uploadfile)) && (chmod($uploadfile, 0777))) $move = true;
    }
    if (($hunt != false) && (($move != false) || ($type_obj->GetQuestionType() != 'picture'))) {
        //Successful
        echo '<p>Your new bounty has been posted.</p>';
    } else {
        if ($move == false) {
//            echo '<br />File upload error: '.$_FILES['uploadhunt']['error']['0'];
//            echo '<br />Upload destination: '.$uploadfile;
//            echo '<br />Additional debugging info:<br />';
//            print_r($_FILES);
            switch ($_FILES['uploadhunt']['error']) {
                case 0:
                echo '<br />There were no errors. If you\'re reading this, something really big is wrong, contact an admin as soon as possible.<br />';
                break;
                case 1:
                echo '<br />The uploaded file exceeds the upload_max_filesize directive in php.ini.<br />Please make the file smaller.<br />';
                break;
                case 2:
                echo '<br />The uploaded file exceeds the MAX_FILE_SIZE directive that was specified in the html form.<br />'
                   . 'Please make sure that the file you\'re trying to upload is less than 300Kb!!!<br />';
                break;
                case 3:
                echo '<br />The uploaded file was only partially uploaded.<br />Please reupload the file by using the form in the edit bounty function.<br />';
                break;
                case 4:
                echo '<br />No file was uploaded.<br />Please edit the bounty and upload a file.<br />';
                break;
                default:
                echo '<br />You definitely shouldn\'t be here... Since you are, something is horribly wrong. Contact an admin as soon as possible.<br />';
            }
        }
        if ($hunt == false) {
            echo '<br />Error: '.$hunt;
            echo '<br />POST info:';
            print_r($_POST);
        }
    }
} elseif (isset($_POST['type'])) {
    // Create a list of months, is there a better way?
    $months = array ("January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December");
    echo '<form action="'.$_SERVER['REQUEST_URI'].'" method="post" ENCTYPE="multipart/form-data">';
    echo '<input type="hidden" id="type" name="type" value="'.$_POST['type'].'"></input>';
    echo '<input type="hidden" id="division" name="division" value="'.$_POST['division'].'"></input>';
    $type_obj = $ka->GetHuntType($_POST['type']);

    //SELECT START DATE
    echo '<label for="start">What day should the bounty <strong>start</strong> on?</label>';
    //SELECT FOR MONTH
    echo '<select name="start_month" id="start_month">';
    for ($i = 1; $i <= 12; $i++) {
        echo '<option value="'.$i.'"';
        if ($i == date('n')) {
            echo ' selected';
        }
        echo '>'.$months[$i-1].'</option>';
    }
    echo "</select>\n";
    //SELECT FOR DAY
    echo '<select name="start_day" id="start_day">';
    for ($i = 1; $i <= 31; $i++) {
        echo '<option value="'.$i.'"';
        if ($i == date('j')) {
            echo ' selected';
        }
        echo '>'.$i.'</option>';
    }
    echo "</select>\n";
    //SELECT FOR YEAR
    echo '<select name="start_year" id="start_year">';
    echo '<option value="'.(date('Y') - 1).'">'.(date('Y') - 1).'</option>';
    echo '<option value="'. date('Y').'" selected>'.date('Y').  '</option>';
    echo '<option value="'.(date('Y') + 1).'">'.(date('Y') + 1).'</option>';
    echo "</select><br />\n";

    if ($access == 2) { //Random Start Time
        echo 'Start time (HH:mm):<br />'
           . '<input type="text" name="start_hour" value="'.mt_rand(0, 23).'" size="2"></input>&nbsp;:&nbsp;'
           . '<input type="text" name="start_minute" value="'.mt_rand(0, 59).'" size="2"></input><br />';
    } else {
        echo '<input type="hidden" name="start_hour" value="'.mt_rand(0, 23).'" size="2"></input>'
           . '<input type="hidden" name="start_minute" value="'.mt_rand(0, 59).'" size="2"></input>';
    }

    //SELECT END DAY
    echo '<label for="end">What day should the bounty <strong>end</strong> on?</label>';
    //SELECT FOR MONTH
    echo '<select name="end_month" id="end_month">';
    for ($i = 1; $i <= 12; $i++) {
        echo '<option value="'.$i.'"';
        if ($i == date('n')) {
            echo ' selected';
        }
        echo '>'.$months[$i-1].'</option>';
    }
    echo "</select>\n";
    //SELECT FOR DAY
    echo '<select name="end_day" id="end_day">';
    for ($i = 1; $i <= 31; $i++) {
        echo '<option value="'.$i.'"';
        if ($i == date('j')) {
            echo ' selected';
        }
        echo '>'.$i.'</option>';
    }
    echo "</select>\n";
    //SELECT FOR YEAR
    echo '<select name="end_year" id="end_year">';
    echo '<option value="'.(date('Y') - 1).'">'.(date('Y') - 1).'</option>';
    echo '<option value="'. date('Y').'" selected>'.date('Y').  '</option>';
    echo '<option value="'.(date('Y') + 1).'">'.(date('Y') + 1).'</option>';
    echo "</select><br />\n";

    //CUSTOM CONTENT, WHAT TO ADD
    $num_questions = $type_obj->GetNumQuestions();
    $num_answers = $type_obj->GetNumAnswers();
    $question_type = $type_obj->GetQuestionType();
    if ($_POST['division'] != -1) {
        $first_reward = $type_obj->GetKabalFirstReward();
        $rewards = $type_obj->GetKabalRewards();
    }
    else {
        $first_reward = $type_obj->GetFirstReward();
        $rewards = $type_obj->GetReward();
    }

    if ($first_reward) {
        echo "<label for=\"first_reward\">Reward for first place. (ICs)</label>";
        echo "<input type=\"text\" size=\"30\" id=\"first_reward\" name=\"first_reward\" value=\"$first_reward\"";
        if ($access < 2) {
            echo " readonly";
        }
        echo "></input>";
    }
    for ($i = 0; $i < $num_answers; $i++) {
        echo "<label for=\"rewards[$i]\">Reward for ".((int) $num_answers - $i)."/".$num_answers." correct. (ICs)</label>";
        echo "<input type=\"text\" size=\"30\" id=\"rewards[$i]\" name=\"rewards[$i]\" value=\"";
        echo $rewards[$i];
        echo "\"";
        if ($access < 2) {
            echo " readonly";
        }
        echo "></input>";
    }
    echo "<label for=\"rewards[".$num_answers."]\">Reward for 0/".$num_answers." correct. (ICs)</label>";
    echo "<input type=\"text\" size=\"30\" id=\"rewards[".$num_answers."]\" name=\"rewards[".$num_answers."]\" value=\"".$rewards[$num_answers]."\"";
    if ($access < 2) {
        echo " readonly";
    }
    echo "></input>";

    switch ($question_type) {
        case 'picture':
        //MAX FILE SIZE SETTING
        echo '<input type="hidden" name="MAX_FILE_SIZE" value="300000"></input>';
        for ($i = 0; $i < $num_questions; $i++) {
            echo '<label for="uploadhunt['.$i.']">Upload bounty <strong>picture</strong>. (Make sure it is .jpg and under 300 Kb)</label>';
            echo '<input type="file" name="uploadhunt['.$i.']" id="uploadhunt['.$i.']" ACCEPT="image/jpeg"></input><br />';
        }
        for ($i = 0; $i < $num_answers; $i++) {
            echo '<label for="answer['.$i.']">Bounty <strong>Answer</strong> '.($i + 1).'/'.$num_answers.':</label>';
            echo '<input type="text" size="30" name="answer['.$i.']" id="answer['.$i.']"></input><br />';
        }
        break;

        case 'text':
        if ($num_questions == $num_answers) {
            //questions and answers together
            for ($i = 0; $i < $num_answers; $i++) {
                echo '<label for="question['.$i.']">Bounty <strong>Question</strong> '.($i + 1).'/'.$num_questions.':</label>';
                echo '<input type="text" size="30" name="question['.$i.']" id="question['.$i.']"></input><br />';
                echo '<label for="answer['.$i.']">Bounty <strong>Answer</strong> '.($i + 1).'/'.$num_answers.':</label>';
                echo '<input type="text" size="30" name="answer['.$i.']" id="answer['.$i.']"></input><br />';
            }
        } else {
            //questions and answers apart
            for ($i = 0; $i < $num_questions; $i++) {
                echo '<label for="question['.$i.']">Bounty <strong>Question</strong> '.($i + 1).'/'.$num_questions.':</label>';
                echo '<input type="text" size="30" name="question['.$i.']" id="question['.$i.']"></input><br />';
            }
        }
        break;
    }
    if ($num_answers != $num_questions) {
        //Seperate questions and answers
        for ($i = 0; $i < $num_answers; $i++) {
            echo '<label for="answer['.$i.']">Bounty <strong>Answer</strong> '.($i + 1).'/'.$num_answers.':</label>';
            echo '<input type="text" size="30" name="answer['.$i.']" id="answer['.$i.']"></input><br />';
        }
    }

    //FINISH BUTTON
    echo '<input type="submit" name="submit" value="Finish" class="submit"></input>';
    echo '</form>';
} else {
    //SELECT WHICH HUNT TYPE TO ADD
    echo '<form action="'.$_SERVER['REQUEST_URI'].'" method="post">';
    echo '<label for="type">What <strong>type</strong> of bounty?</label>';
    echo '<select id="type" name="type">';
    $types = $ka->GetHuntTypes();
    foreach ($types as $type) {
        echo '<option value="'.$type->GetID().'">'.$type->GetName().'</option>';
    }
    echo '</select><br />';
    echo '<label for="division"><strong>Who</strong> can participate?</label>';
    echo '<select id="division" name="division">';
    //CHECKING IF PERSON ADDING HUNT IS TACT/U/WARD, RESPECTIVELY
    if (($login_position->GetID() == 3) || ($login_position->GetID() == 2) || ($login_position->GetID() == 10) || $access == 2) {
        $kabals = $roster->GetKabals();
        foreach ($kabals as $kabal) {
            echo '<option value="'.$kabal->GetID().'">'.$kabal->GetName().'</option>';
        }
        echo '<option value="18">Citadel</option>';
        echo '<option value="-1" selected="selected">Everyone</option>';
    }
    //CHECKING IF PERSON ADDING HUNT IS CH/CRA
    elseif (($login_position->GetID() == 11) || ($login_position->GetID() == 12)) {
        $division = $login->GetDivision();
        echo '<option value="'.$division->GetID().'">'.$division->GetName().'</option>';
    }
    echo "</select><br />\n";
    echo '<input type="submit" value="Next Step" class="submit"></input>';
    echo '</form>';
}
?>
</div>
