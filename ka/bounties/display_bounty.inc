<?php
$login = new Login_HTTP();
$login_id = $login->GetID();
$login_division = $login->GetDivision();
$login_division = $login_division->GetID();
$login_idline = $login->IDLine(0);
$login_email = $login->GetEmail();


if ($_POST['submit']) {
    if ($login_id && $login_email && $login_idline && $_POST['answer']) {
        $hunt = $ka->GetHunt($_POST['hunt']);
        $hunt_type = $hunt->GetHuntType();
        if ($hunt->HasSubmitted($login_id)) {
             echo "<br /><br />Sorry, but you have already submitted an answer for this event."; //Should NEVER get here...
        } else {
            //Email and headers built here
            $email_headers = "From: KA Hunt Centre <kahunts@thebhg.org>\nReply-To: ".$login_email."\nX-Mailer: PHP";
            $recipient = "kahunts@thebhg.org, ".$login_email;
            $message = "The following answer(s) has been submitted from this IP: ".$_SERVER['REMOTE_ADDR']."\n\n\n";
            $i = 0;
            foreach ($_POST['answer'] as $answer) {
                $i++;
                $message .= $i.': '.$answer."\n";
            }
            $message .= "\n\n".$login_idline."\n".$login_email."\n\n";
            $data = $hunt->CreateSubmission($login_id, $_POST['answer'], $_SERVER['REMOTE_ADDR']);
            echo mysql_error($hunt->ka_db);
            $sent_mail = mail ($recipient, $_POST['subject'], $message, $email_headers);
            if ($sent_mail && $data) {
                echo "<br /><br /><p style=\"text-align: center\">Entry submitted successfully</p>";
            } else {
                echo "<br /><br /><p style=\"text-align: center\">Error! Please contact the Judicator.</p>";
            }
        }
        echo "<br /><br /><a href=\"".$_SERVER['PHP_SELF']."?site=index\">Return to hunts</a><br /><br />";
        ConstructLayout();
        exit;
    } else {
        echo "<br /><br /><p class=\"heading\">You've made an error. Please go back and complete the form.</p>";
        echo "<br /><br /><a href=\"".$_SERVER['PHP_SELF']."?site=index\">Return to hunts</a><br /><br />";
        ConstructLayout();
        exit;
    }
}




$hunt = $ka->GetHunt($_GET['id']);
$hunt_type = $hunt->GetHuntType();

// If you've submitted for a hunt and the hunt's still up, you can't submit again.
if (    ($hunt->HasSubmitted($login_id))
    && ($hunt->GetStartTimestamp() <= time())
    && ($hunt->GetEndTimestamp() >= time())) {
    $person = new Person($login_id);

    print '<div>'
      .'<h2>Complete Hunt: '.$hunt_type->getName().' '.$hunt->getHuntNum()
      .'</h2>'
      .'<p>Sorry, but you have already submitted an answer for this '
      .'event.</p>'
      .'<p>You are logged in as: '.$person->IDLine(0).'<br />'."\n"
      .'If you are not this person, please <a href="'
      .$_SERVER['PHP_SELF'].'?site=logout">log out</a>, then close all '
      .'browser windows and try again.</p>'
      .'</div>';

    ConstructLayout();
    exit;
}

// If the hunt is not availiable to everyone and you're not in that kabal and
// the hunt is currently active, you can't see it/submit for it.
if (   ($hunt->GetDivisionID() != -1)
    && ($hunt->GetDivisionID() != $login_division)
    && ($hunt->GetStartTimestamp() <= time())
    && ($hunt->GetEndTimestamp() >= time())) {

    $division = $hunt->GetDivision();
    $person = new Person($login_id);

    print '<div>'
      .'<h2>Complete Hunt: '.$hunt_type->getName().' '.$hunt->getHuntNum()
      .'</h2>'
      .'<p>Sorry, but you are not in '.$division->GetName().' kabal. You '
      .'may not participate in this hunt unless you are in that kabal.</p>'
      .'<p>You are logged in as: '.$person->IDLine(0)."<br />\n"
      .'If you are not this person, please <a href="'.$_SERVER['PHP_SELF']
      .'?site=logout">log out</a>, then close all browser windows and try '
      .'again.</p>'
      .'</div>'
      ;
    ConstructLayout();
    exit;
}

// If the hunt is currently active and we make it this far in the page
if (   ($hunt->GetStartTimestamp() <= time())
    && ($hunt->GetEndTimestamp() >= time())) {

    //Hunt is Active
    echo  "<div>\n"
      .'<h2>Complete Hunt: '.$hunt_type->GetName().' '.$hunt->GetHuntNum()
      ."</h2>\n"
      .'<p>This hunt started on '
      .date('l, F jS, Y', $hunt->GetStartTimestamp())
      ."<br />\n"
      .'This hunt ends on '
      .date('l, F jS, Y', $hunt->GetEndTimestamp())
      ."</p>\n"
      //Hunt Description
      .'<blockquote>'.$hunt_type->GetDesc()."</blockquote>\n"
      ."</div>\n";

    echo "<form action=\"".$_SERVER['PHP_SELF']."?site=display_bounty\" method=\"post\">";
    echo "<input type=\"hidden\" name=\"subject\" value=\"".$hunt_type->GetName()." ".$hunt->GetHuntNum()."\">";
    echo "<input type=\"hidden\" name=\"hunt\" value=\"".$_GET['id']."\">";
    $caption = "Answer Hunt Questions";
    $table = new HTML_Table();
    $table->setCaption($caption);
    //Hunt questions
    $hunt_content = $hunt->GetContent();
    $hunt_questions = $hunt_content['questions'];
    if ($hunt_type->GetQuestionType() == 'picture') {
        //Multiple Pictures have not been built in yet as there seems to be no need for them.
        $table->AddRow( array('<img src="hunt_images/'.$hunt_type->GetAbbr().'-'.$hunt->GetID().'.jpg" />'),
                        array('colspan'=>'2', 'style'=>'text-align: center')
                      );
        for ($i = 0; $i < $hunt_type->GetNumAnswers(); $i++) {
            $table->AddRow (array(  'Answer:',
                                    '<input type="text" size="30" name="answer['.$i.']">'),
                                    array(),
                                    'TD'
                                    );
        }
    } else {
        //The next if-then-else is for formatting only.
        //If the number of answers is equal to the number of questions, the questions are matched up with the answers.
        //This allows for easier answering.
        if ($hunt_type->GetNumAnswers() == $hunt_type->GetNumQuestions()) {
            for ($i = 0; $i < $hunt_type->GetNumQuestions(); $i++) {
                $table->AddRow (array(($i + 1).': ', stripslashes($hunt_questions[$i])));
                $table->AddRow (array(  'Answer:',
                                        '<input type="text" size="30" name="answer['.$i.']">'));
            }
        } else {
            for ($i = 0; $i < $hunt_type->GetNumQuestions(); $i++) {
                $table->AddRow (array(($i + 1).': ', stripslashes($hunt_questions[$i])));
            }
            for ($i = 0; $i < $hunt_type->GetNumAnswers(); $i++) {
                $table->AddRow (array(  'Answer '.($i + 1).':',
                                        '<input type="text" size="30" name="answer['.$i.']">'));
            }
        }
    }
    echo $table->ToHTML();

    print "\n"
      .'<table>'
      .'<caption>Confirm Personal Details</caption>'
      .'<tr><td colspan="2">Please confirm your details. If you are not '
      .'this person, please <a href="'.$_SERVER['PHP_SELF']
      .'?site=logout">log out</a>, then close all browser windows and '
      .'try again.</td></tr>'."\n"
      .'<tr><td>Your ID Line:</td><td>'.$login->IDLine(0).'</td></tr>'."\n"
      .'<tr><td>Your ID #:</td><td>'.$login->GetID()."</td></tr>\n"
      .'<tr><td>Your Email:</td><td>'.$login->GetEmail()."</td></tr>\n"
      .'</table>'
      .'<p style="text-align: center">'
      .'<input type="submit" name="submit" value="Submit entry">'
      .'&nbsp;&nbsp;&nbsp;'
      .'<input type="reset" name="Reset" value="Reset"></p>'
      .'</form>';

} elseif (   ($hunt->GetStartTimestamp() >= time())
          && ($hunt->GetEndTimestamp() >= time())) {

    // Hunt has not begun yet. Hunter should not be here. This hunt should
    // NOT be displayed.
    // Hunters are not supposed to know when exactly hunts are supposed to
    // be out.
    // That is why begin date is not shown.
    print '<div>'
      .'<h2>Complete Hunt: '.$hunt_type->getName().' '.$hunt->getHuntNum()
      .'</h2>'
      .'<p>This hunt has not begun yet.</p>'
      .'</div>';

} else {

    //Hunt has ended.
    echo "<div>\n"
      .'<h2>Hunt Results: '.$hunt_type->GetName().' '.$hunt->GetHuntNum()
      ."</h2>\n"
      ."\n<p>This hunt started on "
      .date('l, F jS, Y', $hunt->GetStartTimestamp())
      .'<br />'
      ."\nThis hunt ended on "
      .date('l, F jS, Y', $hunt->GetEndTimestamp())."</p>\n"
      //Hunt Description
      .'<blockquote>'.$hunt_type->GetDesc()."</blockquote>\n"
      ."</div>\n";
    //Hunt questions
    $hunt_content = $hunt->GetContent();
    $hunt_questions = $hunt_content['questions'];
    $hunt_answers = $hunt_content['answers'];
    $caption = "View Hunt Answers and Results";
    $table = new HTML_Table();
    $table->setCaption($caption);
    if ($hunt_type->GetQuestionType() == 'picture') {
        //Multiple Pictures have not been built in yet as there seems to be no need for them.
        $table->AddRow(array('<img src="/hunt_images/'.$hunt_type->GetAbbr().'-'.$hunt->GetID().'.jpg" />'));
        $table->AddRow(array('The answer was: '.$hunt_answers[0]));
    } else {
        //The next if-then-else is for formatting only.
        //If the number of answers is equal to the number of questions, the questions are matched up with the answers.
        //This allows for easier answering.
        if ($hunt_type->GetNumAnswers() == $hunt_type->GetNumQuestions()) {
            for ($i = 0; $i < $hunt_type->GetNumQuestions(); $i++) {
                $table->AddRow (array(($i + 1).': ', stripslashes($hunt_questions[$i])));
                $table->AddRow (array(  'Answer:',
                                        stripslashes($hunt_answers[$i])));
            }
        } else {
            for ($i = 0; $i < $hunt_type->GetNumQuestions(); $i++) {
                $table->AddRow (array(($i + 1).': ', stripslashes($hunt_questions[$i])));
            }
            for ($i = 0; $i < $hunt_type->GetNumAnswers(); $i++) {
                $table->AddRow (array(  'Answer '.($i + 1).':',
                                        stripslashes($hunt_answers[$i])));
            }
        }
    }
    echo $table->toHTML();
    $hunt->RenderGrades();
}

?>
