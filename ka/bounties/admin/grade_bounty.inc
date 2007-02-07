<div>
<?php
//Setting Variables
$hunt_id = $_GET['id'];
if (!$hunt_id) $hunt_id = $_POST['id'];
$hunt_obj = $ka->GetHunt($hunt_id);
$hunt_type = $hunt_obj->GetHuntType();
$submissions = $hunt_obj->GetSubmissions();
$first_reward = $hunt_obj->GetHuntFirst();
$rewards = $hunt_obj->GetHuntRewards();
$content = $hunt_obj->GetContent();
$num_answers = $hunt_type->GetNumAnswers();
$num_questions = $hunt_type->GetNumQuestions();
//Header
echo "<h2>Grading ";
echo $hunt_type->GetName()." ";
echo $hunt_obj->GetHuntNum();
echo "</h2>\n";
if ($hunt_obj->GetID() !== $hunt_id) {
    echo 'This bounty does not exist. Please don\'t type in numbers. If you got here through a link, please contact the administrator of the webpage.';
} elseif ($hunt_obj->GetEndTimestamp() >= time()) {
    echo 'This bounty has not ended yet. Please wait for it to end before grading.';
} elseif ($hunt_obj->IsGraded() === false) {
    //Grading stuff here
    if ($_POST['grade']) {
        $grades = $_POST['grades'];
        $grade_obj = $hunt_obj->Grade($grades);
        $error = $hunt_obj->AwardCredits($grade_obj); //Error checking
        if ($error === false) {
            echo "<p class=\"heading\">Your bounty has been successfully graded and credits have been awarded. Thank you, come again.</p><br />";
        } else {
            echo "<p style=\"heading\">Error!!</p>";
            echo "<p style=\"heading\">Please contact an admin with the following error message:</p>";
            echo "<p style=\"font-size: 10pt; font-family: 'Courier New', 'Lucida Console', monospace;\">".$hunt_obj->Error()."<br />".$error.'</p><br />';
        }
        /* POSTing debug
        $stuff = print_r($_POST['grades'], true);
        $stuff = htmlspecialchars($stuff);
        $stuff = nl2br($stuff);
        $stuff = str_replace(' ', '&nbsp;', $stuff);
        echo $stuff;
        */
    } else {
        echo "There have been a total of ".$hunt_obj->GetSubmissionsCount()." summaries.<br /><br />\n";
        $total = $num_answers + 1 + $num_answers;
        echo "<form action=\"".$_SERVER['REQUEST_URI']."\" method=\"post\">\n";
        echo "<input type=\"hidden\" name=\"id\" value=\"".$_GET['id']."\" />";
        for ($i = 0; $i < $hunt_obj->GetSubmissionsCount(); $i++) { //Goes through all the submissions
            echo "<div>\n<table>\n<tr>\n";
            $submission = $submissions[$i];
            $sub_answers = $submission->GetAnswer();
            $person = $submission->GetPerson();
            $person_id = $person->GetID();
            $rank = $person->GetRank();
            echo '<td colspan="2">'.$rank->GetAbbrev().' '.$person->GetName()."</td>\n";
            echo '<td>'.$submission->GetSubmissionIP()."</td>\n";
            echo '<td>'.date("jS M Y, H:i T", $submission->GetTimestamp())."</td>\n";
            echo '<td><select name="grades['.$i.'][status]"><option value="1">Valid</option><option value="0">No Effort</option><option value="-1">Don\'t Include</option></select></td>'."\n";
            echo '<input type="hidden" name="grades['.$i.'][id]" value="'.$submission->GetID().'" />'."\n";
            echo "</tr>\n";
            //Questions and answers
            //Can't make this use HTML_Table as this uses col and rowspan.
            if ($num_answers == $num_questions) {
                //Equal number of questions and answers (Trivia, stuff like that)
                //Echos questions and answers together
                for ($j = 0; $j < $num_questions; $j++) {
                    echo "<tr>\n";
                    echo "<td colspan=\"1\" style=\"background-color: #6C6C6C\">Question ".($j + 1).":</td><td colspan=\"3\" style=\"background-color: #6C6C6C\">".$content['questions'][$j]."</td>\n";
                    echo '<td rowspan="3" valign="bottom"><select name="grades['.$i.'][question]['.$j.']"><option value="1">Correct</option><option value="0">Incorrect</option></select></td>'."\n";
                    echo "</tr>\n<tr>\n";
                    echo "<td colspan=\"1\">Correct Answer ".($j + 1).":</td><td colspan=\"3\">".$content['answers'][$j]."</td>\n";
                    echo "</tr>\n<tr>\n";
                    echo "<td colspan=\"1\" style=\"background-color: #6C6C6C\">Answer ".($j + 1).":</td><td colspan=\"3\" style=\"background-color: #6C6C6C\">".$sub_answers[$j]."</td>\n";
                    echo "</tr>\n<tr><td colspan=\"4\" style=\"border: 0 none #FFFFFF\">&nbsp;</td></tr>\n";
                }
            }
            else {
                //Unequal number of questions and answers (HTH)
                //Echos all the questions first, then the answers
                for ($j = 0; $j < $num_questions; $j++) {
                    echo "<tr>\n";
                    echo "<td colspan=\"2\">Question ".($j + 1).":</td><td colspan=\"3\">".$content['questions'][$j]."</td>\n";
                    echo "</tr>\n";
                }
                for ($j = 0; $j < $num_answers; $j++) {
                    echo "<tr>\n";
                    echo "<td colspan=\"1\">Correct Answer ".($j + 1).":</td><td colspan=\"3\">".$content['answers'][$j]."</td>\n";
                    echo '<td rowspan="2" valign="bottom"><select name="grades['.$i.'][question]['.$j.']"><option value="1">Correct</option><option value="0">Incorrect</option></select></td>'."\n";
                    echo "</tr>\n<tr>\n";
                    echo "<td colspan=\"1\">Answer ".($j + 1).":</td><td colspan=\"3\">".$sub_answers[$j]."</td>\n";
                    echo "</tr>\n";
                }
            }
            echo "</table>\n</div>\n";
        }
        echo "<input type=\"submit\" name=\"grade\" value=\"Grade Bounty\" />&nbsp;&nbsp;<input type=\"reset\" value=\"Reset Grades\" />\n";
    }
} else {
    echo 'This bounty has already been graded. Please use the <a href="'.$_SERVER['PHP_SELF'].'?site=grade_edit&id='.$_GET['id'].'">edit grades</a> function to change the grades.';
}
?>
</div>
