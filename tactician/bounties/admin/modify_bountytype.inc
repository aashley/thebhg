<?php
$hunttype_obj = $ka->GetHuntType($_GET['id']);
?>
    <h2>Modify a Bounty Type</h2>
<?php
echo '<p>Modifying '.$hunttype_obj->GetName().'</p>';
if (isset($_POST["finish"])) {
    if ($_POST['first_reward']) $first_reward = $_POST['first_reward'];
    else $first_reward = 0;
    if ($_POST['kabal_first_reward']) $kabal_first_reward = $_POST['kabal_first_reward'];
    else $kabal_first_reward = 0;
    $ok = true;
    if (!$hunttype_obj->SetName($_POST['name'])) $ok = 'Name';
    if (!$hunttype_obj->SetAbbr($_POST['abbr'])) $ok = 'Abbreviation';
    if (!$hunttype_obj->SetFirstReward($first_reward)) $ok = 'First Place Reward';
    if (!$hunttype_obj->SetRewards($_POST['rewards'])) $ok = 'Rewards';
    if (!$hunttype_obj->SetKabalFirstReward($kabal_first_reward)) $ok = 'Kabal Bounty First Place Reward';
    if (!$hunttype_obj->SetKabalRewards($_POST['kabalrewards'])) $ok = 'Kabal Bounty Rewards';
    if (!$hunttype_obj->SetNumQuestions($_POST['num_questions'])) $ok = 'Number of Questions';
    if (!$hunttype_obj->SetNumAnswers($_POST['num_answers'])) $ok = 'Number of Answers';
    if (!$hunttype_obj->SetQuestionType($_POST['question_type'])) $ok = 'Question Type';
    if (!$hunttype_obj->SetDesc(html_entity_decode(addslashes(htmlspecialchars($_POST['desc']))))) $ok = 'Description';
    if ($ok == true) echo "<p>This hunt type has been modified successfully.</p>";
    else echo "Error at: ".$ok;
} elseif (isset($_POST['continue'])) {
?>
    <form action="<?php echo $_SERVER['REQUEST_URI']; ?>" method="post">
        <?php
        $rewards = $hunttype_obj->GetReward();
        $last_reward = (count($rewards) - 1);
        $kabalrewards = $hunttype_obj->GetKabalRewards();
        //KA hunts credits
        if ($_POST['first']) {
            echo "<label for=\"first_reward\">Reward for first place. (ICs)</label>";
            echo "<input type=\"text\" size=\"30\" id=\"first_reward\" name=\"first_reward\" value=\"".$hunttype_obj->GetFirstReward()."\"></input>";
        }
        $toadd = $num_answers - $last_reward;
        for ($i = 0; $i < $_POST['num_answers']; $i++) {
            echo "<label for=\"rewards[$i]\">Reward for ".((int) $_POST['num_answers'] - $i)."/".$_POST['num_answers']." correct. (ICs)</label>";
            echo "<input type=\"text\" size=\"30\" id=\"rewards[$i]\" name=\"rewards[$i]\" value=\"";
            if (($i - $toadd) != $last_reward) echo $rewards[($i - $toadd)];
            echo "\"></input>";
        }
        echo "<label for=\"rewards[".$_POST['num_answers']."]\">Reward for 0/".$_POST['num_answers']." correct. (ICs)</label>";
        echo "<input type=\"text\" size=\"30\" id=\"rewards[".$_POST['num_answers']."]\" name=\"rewards[".$_POST['num_answers']."]\" value=\"".$rewards[$last_reward]."\"></input>";
        //Kabal hunt credits
        if ($_POST['first']) {
            echo "<label for=\"kabal_first_reward\">Kabal bounty reward for first place. (ICs)</label>";
            echo "<input type=\"text\" size=\"30\" id=\"kabal_first_reward\" name=\"kabal_first_reward\" value=\"".$hunttype_obj->GetKabalFirstReward()."\"></input>";
        }
        $toadd = $num_answers - $last_reward;
        for ($i = 0; $i < $_POST['num_answers']; $i++) {
            echo "<label for=\"kabalrewards[$i]\">Kabal bounty reward for ".((int) $_POST['num_answers'] - $i)."/".$_POST['num_answers']." correct. (ICs)</label>";
            echo "<input type=\"text\" size=\"30\" id=\"kabalrewards[$i]\" name=\"kabalrewards[$i]\" value=\"";
            if (($i - $toadd) != $last_reward) echo $kabalrewards[($i - $toadd)];
            echo "\"></input>";
        }
        echo "<label for=\"kabalrewards[".$_POST['num_answers']."]\">Kabal bounty reward for 0/".$_POST['num_answers']." correct. (ICs)</label>";
        echo "<input type=\"text\" size=\"30\" id=\"kabalrewards[".$_POST['num_answers']."]\" name=\"kabalrewards[".$_POST['num_answers']."]\" value=\"".$kabalrewards[$last_reward]."\"></input>";

        echo "<input type=\"hidden\" name=\"name\" value=\"".$_POST['name']."\"></input>";
        echo "<input type=\"hidden\" name=\"abbr\" value=\"".$_POST['abbr']."\"></input>";
        echo "<input type=\"hidden\" name=\"num_questions\" value=\"".$_POST['num_questions']."\"></input>";
        echo "<input type=\"hidden\" name=\"num_answers\" value=\"".$_POST['num_answers']."\"></input>";
        echo "<input type=\"hidden\" name=\"question_type\" value=\"".$_POST['question_type']."\"></input>";
        echo "<input type=\"hidden\" name=\"desc\" value=\"".$_POST['desc']."\"></input>";
        ?>
        <br />
        <input type="submit" name="finish" value="Finish" class="submit" />
    </form>
<?php
} else {
?>
    <form action="<?php echo $_SERVER['REQUEST_URI']; ?>" method="post">
        <label for="name"><strong>Name</strong> of bounty?</label>
        <input type="text" size="30" id="name" name="name" value="<?=$hunttype_obj->GetName()?>"></input>
        <label for="abbr"><strong>Abbreviation</strong> of bounty? (No spaces please)</label>
        <input type="text" size="10" id="abbr" name="abbr" value="<?=$hunttype_obj->GetAbbr()?>"></input>
        <label for="num_questions">How many <strong>questions</strong> should the bounty have?</label>
        <input type="text" size="10" id="num_questions" name="num_questions" onchange="if (this.value != '1') first.checked=false" value="<?=$hunttype_obj->GetNumQuestions()?>"></input>
        <label for="num_answers">How many <strong>answers</strong> should the bounty have?</label>
        <input type="text" size="10" id="num_answers" name="num_answers" value="<?=$hunttype_obj->GetNumAnswers()?>"></input>
        <label for="first">Should there be a <strong>first place</strong> reward?</label>
        <span style="vertical-align: top">Yes</span>&nbsp;<input type="checkbox" name="first" id="first"<?php if ($hunttype_obj->GetFirstReward() != false) echo ' CHECKED'; ?>></input>
        <label for="question_type">What <strong>type</strong> of questions should they be?</label>
        <select id="question_type" name="question_type">
            <option value="text"<?php if ($hunttype_obj->GetQuestionType() == 'text') echo ' SELECTED'; ?>>Text</option>
            <option value="picture"<?php if ($hunttype_obj->GetQuestionType() == 'picture') echo ' SELECTED'; ?>>Picture</option>
        </select>
        <label for="desc">Please make a <strong>description</strong> of the bounty type.</label>
        <textarea rows="4" cols="30" id="desc" name="desc"><?php echo $hunttype_obj->GetDesc(); ?></textarea>
        <br />
        <input type="submit" name="continue" value="Continue to the Next Step" class="submit" />
    </form>
<?php
}
echo '<p><a href="'.$_SERVER['PHP_SELF'].'">Click here</a> to return to the administration page.</p>';
?>