<div>
<h2>Create a new Bounty Type</h2>
<?php
if (isset($_POST["finish"])) {
    $hunttype_obj = $ka->CreateHunt_Type ($_POST['name'], $_POST['abbr'], $_POST['rewards'], $_POST['kabalrewards'], $_POST['num_questions'], $_POST['num_answers'], $_POST['question_type'], html_entity_decode($_POST['desc']), $_POST['first_reward'], $_POST['kabal_first_reward']);
    if ($hunttype_obj) echo "<p>Your new bounty type has been created successfully.</p>";
    else echo "Error: ".$ka->Error();
} elseif (isset($_POST['continue'])) {
?>
    <form action="<?php echo $_SERVER['REQUEST_URI']; ?>" method="post">
        <?php
        //First loop does credits for KA hunts
        //Second loop does credits for kabal hunts
        if ($_POST['first']) {
            echo "<label for=\"first_reward\">Reward for first place. (ICs)</label>";
            echo "<input type=\"text\" size=\"30\" id=\"first_reward\" name=\"first_reward\" />";
        }
        for ($i = 0; $i < $_POST['num_answers']; $i++) {
            echo "<label for=\"rewards[$i]\">Reward for ".((int) $_POST['num_answers'] - $i)."/".$_POST['num_answers']." correct. (ICs)</label>";
            echo "<input type=\"text\" size=\"30\" id=\"rewards[$i]\" name=\"rewards[$i]\" />";
        }
        echo "<label for=\"rewards[".$_POST['num_answers']."]\">Reward for 0/".$_POST['num_answers']." correct. (ICs)</label>";
        echo "<input type=\"text\" size=\"30\" id=\"rewards[".$_POST['num_answers']."]\" name=\"rewards[".$_POST['num_answers']."]\" />";

        //Kabal hunts credits
        if ($_POST['first']) {
            echo "<label for=\"kabal_first_reward\">Kabal bounty reward for first place. (ICs)</label>";
            echo "<input type=\"text\" size=\"30\" id=\"kabal_first_reward\" name=\"kabal_first_reward\" />";
        }
        for ($i = 0; $i < $_POST['num_answers']; $i++) {
            echo "<label for=\"kabalrewards[$i]\">Kabal bounty reward for ".((int) $_POST['num_answers'] - $i)."/".$_POST['num_answers']." correct. (ICs)</label>";
            echo "<input type=\"text\" size=\"30\" id=\"kabalrewards[$i]\" name=\"rewards[$i]\" />";
        }
        echo "<label for=\"kabalrewards[".$_POST['num_answers']."]\">Reward for 0/".$_POST['num_answers']." correct. (ICs)</label>";
        echo "<input type=\"text\" size=\"30\" id=\"kabalrewards[".$_POST['num_answers']."]\" name=\"kabalrewards[".$_POST['num_answers']."]\" />";

        echo "<input type=\"hidden\" name=\"name\" value=\"".$_POST['name']."\" />";
        echo "<input type=\"hidden\" name=\"abbr\" value=\"".$_POST['abbr']."\" />";
        echo "<input type=\"hidden\" name=\"num_questions\" value=\"".$_POST['num_questions']."\" />";
        echo "<input type=\"hidden\" name=\"num_answers\" value=\"".$_POST['num_answers']."\" />";
        echo "<input type=\"hidden\" name=\"question_type\" value=\"".$_POST['question_type']."\" />";
        echo "<input type=\"hidden\" name=\"desc\" value=\"".addslashes(htmlspecialchars(nl2br($_POST['desc'])))."\" />";
        ?>
        <br />
        <input type="submit" name="finish" value="Finish" class="submit" />
    </form>
<?php
} else {
?>
    <form action="<?php echo $_SERVER['REQUEST_URI']; ?>" method="post">
        <label for="name"><strong>Name</strong> of bounty?</label>
        <input type="text" size="30" id="name" name="name" />
        <label for="abbr"><strong>Abbreviation</strong> of bounty? (No spaces please)</label>
        <input type="text" size="10" id="abbr" name="abbr" />
        <label for="num_questions">How many <strong>questions</strong> should the bounty have?</label>
        <input type="text" size="10" id="num_questions" name="num_questions" value="1" onchange="if (this.value != '1') first.checked=false" />
        <label for="num_answers">How many <strong>answers</strong> should the bounty have?</label>
        <input type="text" size="10" id="num_answers" name="num_answers" value="1" />
        <label for="first">Should there be a <strong>first place</strong> reward?</label>
        <span style="vertical-align: top">Yes</span>&nbsp;<input type="checkbox" name="first" id="first" checked="checked" />
        <label for="question_type">What <strong>type</strong> of questions should they be?</label>
        <select id="question_type" name="question_type">
            <option value="text">Text</option>
            <option value="picture">Picture</option>
        </select>
        <label for="desc">Please make a <strong>description</strong> of the bounty type.</label>
        <textarea rows="4" cols="30" id="desc" name="desc"></textarea>
        <br />
        <input type="submit" name="continue" value="Continue to the Next Step" class="submit" />
    </form>
<?php
}
?>
</div>
