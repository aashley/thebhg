<?php

/**
 * Grade a specific submission for this exam
 *
 * @access public
 * @package Citadel
 * @author Adam Ashley <adam_ashley@softhome.net>
 * @version $Revision: 1.29 $
 */

// {{{ Admin_Grade_Exam()

/**
 * The function to generate the layout
 * 
 * @access public
 * @param array The CrumbTrail from above
 * @param object Login_HTTP The logged in user
 * @param object Citadel_Exam the Exam we are supposedly accessing. If we get
 *                            here than the logged in user is allowed to grade
 *                            this exam.
 * @param integer The ID Number of the completed exam we are supposedly marking
 * @return void
 */
function Admin_Grade_Exam($crumbTrail, &$login, &$exam, $resultid) {
  global $citadel;

  $result = $citadel->GetResult($resultid);

  page_header($GLOBALS['site']['title'].' :: Administration :: '
      .'Grade '.$exam->GetName().' Exam :: Submission #'.$result->GetID(),
      '',
      $crumbTrail);

  $rexam = $result->GetExam();

  if ($rexam->GetID() == $exam->GetID()) {

    if (!$result->IsGraded()) {

      $person = $result->GetPerson();
  
      print '<h1>Grade Submission #'.$result->GetID().' from '
        .$person->GetName().' for the '.$exam->GetName().' Exam</h1>';
    
      $form = new Citadel_HTML_QuickForm();
  
      $renderer = &$form->defaultRenderer();
  
      $renderer->clearAllTemplates();
  
      $fields = array();
  
      $answers = &$result->GetAnswers();
  
      for ($i = 0; $i < sizeof($answers); $i++) {
  
        $question = $answers[$i]->GetQuestion();
  
        $parts['question'] = &HTML_QuickForm::createElement(
            'static',
            null,
            'Question&nbsp;'.($i + 1).':',
            nl2br($question->GetQuestionText()).' <b>('
              .$question->GetPossibleMarks().' points)</b>');
  
        $parts['officalanswer'] = &HTML_QuickForm::createElement(
            'static',
            null,
            'Offical&nbsp;Answer&nbsp;'.($i + 1).':',
            nl2br($question->GetOfficalAnswer()));
  
        $parts['answer'] = &HTML_QuickForm::createElement(
            'static',
            null,
            'Answer&nbsp;'.($i + 1).':',
            nl2br($answers[$i]->GetAnswer()));
  
        $parts['comment'] = &HTML_QuickForm::createElement(
            'textarea',
            'comment',
            'Comment&nbsp;'.($i + 1).':');
  
        $parts['comment']->SetRows(7);
        $parts['comment']->SetCols(45);
  
        $parts['points'] = &HTML_QuickForm::createElement(
            'text',
            'points',
            'Points&nbsp;Awarded:');
  
        $parts['points']->SetSize(5);
  
        $fname = 'answer['.$answers[$i]->GetID().']';
  
        $form->addGroup($parts, $fname);
  
        $rules['points'][0] = array('Points for answer are required',
                                    'required');
        $rules['points'][1] = array('Points must be numeric', 'numeric');
        $form->addGroupRule($fname, $rules);
  
        $fields[] = $fname;
  
      }
  
      $renderer->setElementTemplate(
          "<p>\n"
          ."\t<table class=\"grading\">\n"
          ."{element}"
          ."<!-- BEGIN error -->\t\t<tr>\n"
          ."\t\t\t<td colspan=\"2\"><span style=\"color: #ff0000\">{error}"
              ."</span></td>\n"
          ."\t\t</tr>\n<!-- END error -->"
          ."\t</table>\n"
          ."</p>\n"
          );
  
      foreach ($fields as $field) {
  
        $renderer->setGroupElementTemplate(
          "\t\t<tr>\n"
          ."\t\t\t<th>{label}<!-- BEGIN required -->"
            ."<span style=\"color: #ff0000\">*</span>"
            ."<!-- END required --></th>\n"
          ."\t\t\t<td>{element}</td>\n"
          ."\t\t</tr>\n",
          $field);
  
      }
  
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
  
      $buttons[] = &HTML_QuickForm::createElement('submit', null, 'Submit');
      $buttons[] = &HTML_QuickForm::createElement('reset', null, 'Reset');
      $form->addGroup($buttons, 'buttons');
  
      if ($form->validate()) {
  
        $form->freeze();
        $form->process('ProcessGrade', false);
  
      } else {
  
        $form->display();
  
      }

    } else {

      print '<p>This exam has already been marked. You can not mark it again.'
        .'</p>';

    }

  } else {

    print 'What do you think you\'re up to? The submission you tried to grade '
      .'does not belong to this exam.';

  }

  page_footer();

}

// }}}
// {{{ ProcessGrade()

/**
 * Process the submitted Exam and tell them so
 *
 * @access private
 * @param array the submitted form contents
 * @return void
 */
function ProcessGrade($results) {
  global $citadel;

  $login = new Login_HTTP();

  if (DEBUG) {
    
    print '<pre>';
    print_r($results);
    print '</pre>';

  }

  $result = null;

  $success = true;

  foreach ($results['answer'] as $id => $values) {

    $answer = $citadel->GetAnswer($id);

    if (is_null($result)) {

      $result = $answer->GetCompletedExam();

    }

    if (!$answer->SetMark($values['points'])) {

      print 'Could not save marks for answer #'.$id.'<br />';

      $success = false;

    }

    if (!$answer->SetComments($values['comment'])) {

      print 'Could not save comments for answer #'.$id.'<br />';

      $success = false;

    }

  }

  if ($success) {

    if ($result->Grade($login)) {
    
      print '<p>Exam Graded. Click <a href="'.$GLOBALS['site']['file_root']
        .'admin/grade">here</a> to grade another.</p>';

    } else {

      print '<p>There was an error while grading this submission.<br />'
        .$result->Error().'</p>';

    }

  } else {

    print '<p>Could not save at least one piece of data. Not marking exam as '
      .'graded.</p>';

  }

}

// }}}
?>
