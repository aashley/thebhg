<?php

/**
 * Create a new question
 *
 * @access public
 * @author Adam Ashley <aashley@optimiser.com>
 * @package Citadel
 * @version $Revision: 1.2 $
 */

// {{{ Admin_Questions_Create()

/**
 * Generate the Create Question Page
 *
 * @access public
 * @param array the crumbtrail from above
 * @param Login_HTTP The logged in user
 * @param Citadel_Exam the exam we creating in
 * @return void
 */
function Admin_Questions_Create($crumbTrail, &$login, &$exam) {

  page_header($GLOBALS['site']['title'].' :: Administration '
      .' :: Edit '.$exam->GetName().' Exam Questions :: Create Question',
      '',
      $crumbTrail);
  
  $form = new Citadel_HTML_QuickForm();

  $form->addElement('hidden',
                    'exam',
                    $exam->GetID());

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
    $form->process('ProcessCreate', false);

  } else {

    $form->display();

  }

  page_footer();

}

// }}}
// {{{ ProcessCreate()

/**
 * Process the create question form
 *
 * @access private
 * @param array the values of the fields submitted
 * @return void
 */
function ProcessCreate($values) {
  global $citadel;

  $exam = $citadel->GetExam($values['exam']);

  if ($exam->AddQuestion($values['question'],
                         $values['answer'],
                         $values['points'],
                         (($values['mandatory'] == 1) ? true : false))) {

    print '<p>Successfully created question.</p>';

  } else {

    print '<p>Error creating question.</p>'
      .'<p>ERROR: '.$exam->Error().'</p>';

  }

  print '<p><a href="'.$GLOBALS['site']['file_root'].'admin/questions/'
    .strtolower($exam->GetAbbrev()).'">Back to Questions</a></p>';

}

// }}}

?>
