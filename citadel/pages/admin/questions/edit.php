<?php

/**
 * Editing and Deleting of questions
 *
 * @access public
 * @author Adam Ashey <adam_ashley@softhome.net>
 * @package Citadel
 * @version $Revision: 1.7 $
 */

// {{{ Admin_Questions_Edit()

/**
 * Entry Point Do Access point
 *
 * @access public
 * @param array the crumbTrail from above
 * @param object Login_HTTP the logged in user
 * @param object Citadel_Exam the Exam we editing
 * @param integer the ID Number of the question to edit
 * @param boolean whether we are deleting this question or not
 * @return void
 */
function Admin_Questions_Edit($crumbTrail, 
                              &$login, 
                              &$exam, 
                              $questionid, 
                              $delete = false) {
  global $citadel;

  $question = $citadel->GetQuestion($questionid);

  $qexam = $question->GetExam();

  if ($delete) {

    page_header($GLOBALS['site']['title'].' :: Administration :: Delete '
        .'Question',
        '',
        $crumbTrail);

  } else {

    page_header($GLOBALS['site']['title'].' :: Administration :: Edit '
        .'Question',
        '',
        $crumbTrail);

  }

  if ($qexam->GetID() == $exam->GetID()) {

    if ($delete) {

      Handle_Delete($exam, $question);

    } else {

      Render_Edit($exam, $question);

    }

  } else {

    print '<p>That question does not belong to this exam and can not be '
      .'edited.</p>';

  }

  page_footer();

}

// }}}
// {{{ Render_Edit()

/**
 * Render the Edit Question Page
 *
 * @access public
 * @param object Citadel_Exam
 * @param object Citadel_Question
 * @return void
 */
function Render_Edit(&$exam, &$question) {

  $form = new Citadel_HTML_QuickForm();

  $defaultValues =
    array('question'  => $question->GetQuestionText(),
          'answer'    => $question->GetOfficalAnswer(),
          'points'    => $question->GetPossibleMarks(),
          'mandatory' => ($question->IsMandatory() ? 1 : 0));

  $form->setDefaults($defaultValues);

  $form->addElement('hidden',
                    'questionid',
                    $question->GetID());

  $question = &$form->addElement('textarea',
                                 'question',
                                 'Question Text:');
  $question->setRows(5);
  $question->setCols(35);

  $answer = &$form->addElement('textarea',
                               'answer',
                               'Offical Answer:');
  $answer->setRows(5);
  $answer->setCols(35);

  $points = &$form->addElement('text',
                               'points',
                               'Possible Marks:');
  $points->setSize(10);

  $mandatory = &$form->addElement('select',
                                  'mandatory',
                                  'Mandatory:',
                                  array(0 => 'No',
                                        1 => 'Yes'));

  $form->addRule('question', 'Question Text is a required field', 'required');
  $form->addRule('answer', 'Offical Answer is a required field', 'required');
  $form->addRule('points', 'Possible Marks is a required field', 'required');
  $form->addRule('mandatory', 'Mandatory is a required field', 'required');
  $form->addRule('points', 'Possible Marks must be a number', 'numeric');
  $form->addRule('points', 'Possible Marks must be non-zero', 'non-zero');

  $buttons[] = &HTML_QuickForm::createElement('submit', null, 'Submit');
  $buttons[] = &HTML_QuickForm::createElement('reset', null, 'Reset');
  $form->addGroup($buttons, 'buttons');

  if ($form->validate()) {

    $form->freeze();
    $form->process('Process_Edit', false);

  } else {

    $form->display();

  }

}

// }}}
// {{{ Process_Edit()

/**
 * Process the Edit Form
 *
 * @access private
 * @param array the submitted form values
 * @return void
 */
function Process_Edit($values) {
  global $citadel;

  $question = $citadel->GetQuestion($values['questionid']);

  $exam = &$question->GetExam();

  print '<p>Saving Change to Question.</p>';

  $table = new HTML_Table();

  $table->addCol(array('Setting Question Text:',
                       'Setting Offical Answer:',
                       'Setting Possible Marks:',
                       'Setting Mandatory:'),
                 array(),
                 'TH');

  $col = array();

  if ($question->SetQuestionText($values['question'])) {

    $col[] = 'OK';

  } else {

    $col[] = 'ERROR: '.$question->Error();

  }

  if ($question->SetOfficalAnswer($values['answer'])) {

    $col[] = 'OK';

  } else {

    $col[] = 'ERROR: '.$question->Error();

  }

  if ($question->SetPossibleMarks($values['points'])) {

    $col[] = 'OK';

  } else {

    $col[] = 'ERROR: '.$question->Error();

  }

  if ($question->SetMandatory(($values['mandatory'] == 1) ? true : false)) {

    $col[] = 'OK';

  } else {

    $col[] = 'ERROR: '.$question->Error();

  }

  $table->addCol($col);

  print '<p>'.$table->toHtml().'</p>'
    .'<p><a href="'.$GLOBALS['site']['file_root'].'admin/questions/'
    .strtolower($exam->GetAbbrev()).'">Back to Questions</a></p>';

}

// }}}
// {{{ Handle_Delete()

/**
 * Handle deletion of questions
 *
 * Renders the confirmation question and does the deletion
 *
 * @access public
 * @param object Citadel_Exam
 * @param object Citadel_Question
 * @return void
 */
function Handle_Delete(&$exam, &$question) {

  if (   isset($_REQUEST['confirm'])
      && $_REQUEST['confirm'] == 'true') {

    if ($question->Delete()) {

      print '<p>Question Deleted.</p>';

    } else {

      print '<p>Error Deleting Question.</p>'
        .'<p>ERROR: '.$question->Error().'</p>';

    }

    print '<p><a href="'.$GLOBALS['site']['file_root'].'admin/questions/'
      .strtolower($exam->GetAbbrev()).'">Back to Questions</a></p>';

  } else {

    print '<p>Do you really wish to delete the question: \''
      .$question->GetQuestionText().'\'?'

      .'<p>[ '

      .'<a href="'.$GLOBALS['site']['file_root'].'admin/questions/'
      .strtolower($exam->GetAbbrev()).'/'.$question->GetID().'/delete'
      .'?confirm=true">Yes</a> '

      .'| '

      .'<a href="'.$GLOBALS['site']['file_root'].'admin/questions/'
      .strtolower($exam->GetAbbrev()).'">No</a> '

      .']</p>';

  }

}

// }}}

?>
