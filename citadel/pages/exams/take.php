<?php

/**
 * Actually do an exam
 *
 * @access public
 * @package Citadel
 * @author Adam Ashley <adam_ashley@softhome.net>
 * @version $Revision: 1.16 $
 */

// {{{ Exams_Take()

/**
 * Generate the requested page
 *
 * @access public
 * @param array the crumbTrail from higher pages
 * @param array the path info below this page
 * @return void
 */
function Exams_Take($crumbTrail, $path) {
  global $citadel;

  $path = explode('/', $path);

  if (isset($path[1])) {

    $exam = $citadel->GetExambyAbbrev($path[1]);

    if ($exam !== false) {

      page_header($GLOBALS['site']['title'].' :: Exams :: Take '
          .$exam->GetName().' Exam',
          '',
          $crumbTrail);

      $login = new Login_HTTP($citadel->roster_coder);

      /* Not needed
      if ($login->IsValid()) {*/

        $previous = &$citadel->GetPersonsResults($login,
                                                 CITADEL_PASSED);

        $cando = true;

        foreach ($previous as $prev) {

          $pexam = $prev->GetExam();

          if ($pexam->GetID() == $exam->GetID()) {

            $cando = false;

          }

        }

        if ($cando) {

          $pending = &$citadel->GetPersonsResults($login,
                                                  CITADEL_PENDING);

          $notpending = true;

          foreach ($pending as $pend) {

            $pexam = $pend->GetExam();

            if ($pexam->GetID() == $exam->GetID()) {

              $notpending = false;

            }

          }

          if ($notpending) {

            $result = $exam->TakeExam($login);

            // Do the exam stuff
            RenderExam($result);

          } else {

            print '<p>You already have a submission awaiting marking. Please '
              .'wait until you fail that before trying to take the exam again.'
              .'</p>';

          }

        } else {

          print '<p>You have already passed this exam. You can not take it '
            .'again.</p>';

        }

      /* Not needed
      } else {

        print '<p>Could not log you in. You must be logged in to take a '
          .'Citadel Exam.</p>';

      }*/

    } else {

      page_header($GLOBALS['site']['title'].' :: Exams :: Take Exam',
          '',
          $crumbTrail);

      print '<p>Invalid Exam specified. Please check the URL and try again.'
        .'</p>';

    }

  } else {

    page_header($GLOBALS['site']['title'].' :: Exams :: Take Exam',
        '',
        $crumbTrail);

    print '<p>You have not specified which exam you wish to take.</p>';

  }

  page_footer();

}

// }}}
// {{{ RenderExam()

/**
 * Render the Form for the person to take the exam
 *
 * @access private
 * @param object Citadel_CompletedExam
 * @return void
 */
function RenderExam(&$result) {

  $exam = $result->GetExam();

  print '<h1>'.$exam->GetName().' Exam ('.$exam->GetNumberofQuestions()
      .' questions)</h1>';

  $form = new Citadel_HTML_QuickForm();

  $renderer = &$form->defaultRenderer();

  $renderer->clearAllTemplates();

  $renderer->setElementTemplate(
      "<p>\n"
      ."\t<table>\n"
      ."\t\t<tr>\n"
      ."\t\t\t<td>{label}</td>\n"
      ."\t\t</tr>\n"
      ."\t\t<tr>\n"
      ."\t\t\t<td><!-- BEGIN error --><span style=\"color: #ff0000\">{error}"
          ."</span><br /><!-- END error -->{element}</td>\n"
      ."\t\t</tr>\n"
      ."\t</table>\n"
      ."</p>\n"
      );

  // Set Custom rendering for 'buttons' element
  $renderer->setElementTemplate(
      "<p>\n"
      ."\t<table class=\"buttons\">\n"
      ."\t\t<tr>\n"
      ."\t\t\t<td>{element}</td>\n"
      ."\t\t</tr>\n"
      ."\t</table>\n"
      ."</p>\n",
      'buttons');

  $answers = $result->GetAnswers();

  $defaultValues = array();

  foreach ($answers as $answer) {

    $question = $answer->GetQuestion();

    $qelement = &$form->addElement('textarea', 
        'answers['.$answer->GetID().']',
        nl2br($question->GetQuestionText()).' <b>('
          .$question->GetPossibleMarks()
          .' points)</b>');

    $defaultValues['answers['.$answer->GetID().']'] = $answer->GetAnswer();

    $qelement->SetRows(7);
    $qelement->SetCols(45);
    
  }

  $form->setDefaults($defaultValues);

  $buttons[] = &HTML_QuickForm::createElement('submit', null, 'Submit');
  $buttons[] = &HTML_QuickForm::createElement('reset', null, 'Reset');
  $form->addGroup($buttons, 'buttons');

  if ($form->validate()) {

    $form->freeze();
    $form->process('ProcessExam', false);

  } else {

    $form->display();

  }

}

// }}}
// {{{ ProcessExam()

/**
 * Process the submitted Exam and tell them so
 *
 * @access private
 * @param array the submitted form contents
 * @return void
 */
function ProcessExam($results) {
  global $citadel;

  $result = null;

  $success = true;

  foreach ($results['answers'] as $id => $text) {

    $answer = $citadel->GetAnswer($id);

    if (is_null($result)) {

      $result = $answer->GetCompletedExam();

    }

    if (!$answer->SetAnswer($text)) {

      $success = false;

      print 'Could not save answer #'.$id.'<br />';

    }

  }

  if ($success) {

    if ($result->Complete()) {
    
      print '<p>Your submission has been saved and is now awaiting '
        .'marking.</p>';
      
    } else {
      
      print '<p>There was an error while saving your submission.<br />'
        .$result->Error().'</p>';
      
    }

  } else {

    print '<p>At least one answer could not be saved. Not marking exam as '
      .'complete.</p>';

  }
  
}

// }}}

?>
