<?php
$login = new Login_HTTP();
$login_id = $login->GetID();
$login_position = $login->GetPosition();
$login_position = $login_position->GetID();
$login_division = $login->GetDivision();
$login_division = $login_division->GetID();
$special = false;
$allowed = array(2, 4, 5, 6, 8); //Allows following: Underlord, Specialist, Executor, Judicator, Proctor
$chcraward = array(10, 11, 12); //Chief, CRA and Warden
$submission = $ka->GetSubmission($_GET['id']);
$person = $submission->GetPerson();
$person_id = $person->GetID();
$person_div = $person->GetDivision();
$person_div = $person_div->GetID();
if (array_search($login_position, $allowed) !== false)
    $special = true; //Allows certain commission to view
elseif (
    (array_search($login_position, $chcraward) !== false)
     && ($login_division == $person_div)
)
    $special = true; //Allows CH/CRA/Warden to see if the CH/CRA/Warden is in the submission person's division
if (!isset($_GET['id'])) { //No submission ID number provided
    echo "Error, no submission ID number provided. Please do not type this address in.<br />\n";
    echo "If you got here from a link, please contact the administrator of that website. Thanks.";
    ConstructLayout();
    exit;
}
if (($login_id != $person_id) && ($special === false)) { //Not this person or no access
    echo "You are not this person. You are not allowed to see this hunter's submission details.";
    ConstructLayout();
    exit;
}

$hunt_obj = $submission->GetHunt();
$hunt_type = $hunt_obj->GetHuntType();
$content = $hunt_obj->GetContent();
$num_answers = $hunt_type->GetNumAnswers();
$num_questions = $hunt_type->GetNumQuestions();

$table = new HTML_Table();
if ($grade_obj) {
    if ($grades['status'] == 0) $table->AddRow( array("This submission was marked as a No Effort submission."),
                                                array("colspan"=>"3"));
    if ($grades['status'] == -1) $table->AddRow(array("This submission was marked as Not Included.<br />This may be for a number of reasons. Please contact the Judicator or Proctor if you have any questions."),
                                                array("colspan"=>"3"));
}
$sub_answers = $submission->GetAnswer();
$rank = $person->GetRank();
$grade_obj = $hunt_obj->IsGraded();
$table->setCaption($person->GetName()."'s Hunt submission for ".$hunt_type->GetName()." ".$hunt_obj->GetHuntNum().".");

$table->altRowAttributes(
    1,
    array(
        'style' => 'background-color: transparent'
        ),
    array(
        'style' => 'background-color: #4C4C4C'
        ),
    false);
if ($grade_obj != false)
    $grades = $grade_obj->GetGrades($submission->GetID());
$table->AddRow(array(   $rank->GetAbbrev().' '.$person->GetName(),
                        $submission->GetSubmissionIP(),
                        date("jS M Y, H:i T", $submission->GetTimestamp())));
//Questions and answers
if ($num_answers == $num_questions) {
    //Equal number of questions and answers (Trivia, stuff like that)
    //Echos questions and answers together
    for ($j = 0; $j < $num_questions; $j++) {
        $table->AddRow(array(   "Question ".($j + 1).":",
                                $content['questions'][$j]),
                       array(array(''),
                             array('colspan' => 2)));
        if ($grade_obj) {
            $table->AddRow(array(   "Correct Answer ".($j + 1).":",
                                    $content['answers'][$j]),
                           array(array(''),
                                 array('colspan' => 2)));
        }
        $table->AddRow(array(   "Answer ".($j + 1).":",
                                $sub_answers[$j]),
                       array(array(''),
                             array('colspan' => 2)));
        if ($grade_obj) {
            if ($grades['status'] == 1) {
                $table->AddRow(array(   "Correct/Incorrect",
                                        ($grades['question'][$j] == 1) ? 'Correct' : 'Incorrect'),
                               array(array(''),
                                     array('colspan' => 2)));
            }
        }
    }
}
else {
    //Unequal number of questions and answers (HTH)
    //Echos all the questions first, then the answers
    for ($j = 0; $j < $num_questions; $j++) {
        $table->AddRow(array(   "Question ".($j + 1).":",
                                $content['questions'][$j]),
                       array(array(''),
                             array('colspan' => 2)));
    }
    for ($j = 0; $j < $num_answers; $j++) {
        if ($grade_obj) {
            $table->AddRow(array(   "Correct Answer ".($j + 1).":",
                                    $content['answers'][$j]),
                           array(array(''),
                                 array('colspan' => 2)));
        }
        $table->AddRow(array(   "Answer ".($j + 1).":",
                                $sub_answers[$j]),
                       array(array(''),
                             array('colspan' => 2)));
        if ($grade_obj) {
            if ($grades['status'] == 1) {
                $table->AddRow(array(   "Correct/Incorrect",
                                        ($grades['question'][$j] == 1) ? 'Correct' : 'Incorrect'),
                               array(array(''),
                                     array('colspan' => 2)));
            }
        }
    }
}
echo $table->toHTML();
?>
