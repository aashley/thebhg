<?php

/**
 * Create an Exam
 *
 * @access public
 * @package Citadel
 * @author Adam Ashley <adam_ashley@softhome.net>
 * @version $Revision: 1.1 $
 */

/**
 * Include Library System so we can access list of available texts
 */
include_once 'library.inc';

// {{{ Admin_Create()

/**
 * The Create Exam Page
 * 
 * @access public
 * @param array crumbTrail from above
 * @param string path info below this page
 * @param object Login_HTTP Login Object
 * @return void
 */
function Admin_Create($crumbTrail, $path, &$login) {
  global $citadel;

  page_header($GLOBALS['site']['title'].' :: Administration :: '
      .'Create Exam',
      '',
      $crumbTrail);

  $loginpos = $login->GetPosition();

  if (   $loginpos->GetID() == 5
      || $login->GetID() == 94) {
  
    $form = new Citadel_HTML_QuickForm();
  
    $name = &$form->addElement('text',
        'name',
        'Name:');
    $name->setSize(40);
    
    $abbr = &$form->addElement('text',
        'abbr',
        'Abbreviation:');
    $abbr->setSize(10);
    
    $desc = &$form->addElement('textarea',
        'description',
        'Description:');
    $desc->setRows(6);
    $desc->setCols(40);

    $marker = &$form->addElement('text',
        'marker',
        'Marker\'s ID Number:');
    $marker->setSize(10);
    
    $num = &$form->addElement('text',
        'numberquestions',
        'Number of Questions:');
    $num->setSize(10);
    
    $pass = &$form->addElement('text',
        'passgrade',
        'Passing Grade (%):');
    $pass->setSize(10);
    
    $credit = &$form->addElement('text',
        'creditaward',
        'Credit Award:');
    $credit->setSize(10);
    
    $shelf = new Shelf(5);
    
    $books = $shelf->GetBooks();
    
    $boptions = array();
    
    for ($i = 0; $i < sizeof($books); $i++) {
      
      $boptions[$books[$i]->GetID()] = $books[$i]->GetTitle();
      
    }
    
    $form->addElement('select',
        'notebook',
        'Course Notes:',
        $boptions);
    
    $form->addRule('name', 'Exam Name is a required field', 'required');
    $form->addRule('abbr', 'Exam Abbreviation is a required field', 'required');
    $form->addRule('description', 'Exam Description is a required field', 'required');
    $form->addRule('marker', 'Marker\'s ID Number is a required field', 'required');
    $form->addRule('numberquestions', 'Number of Questions is a required field', 'required');
    $form->addRule('passgrade', 'Passing Grade is a required field', 'required');
    $form->addRule('creditaward', 'Credit Award is a required field', 'required');
    $form->addRule('notebook', 'Course Notes is a required field', 'required');
    $form->addRule('abbr', 'Exam Abbreviations must be between 2 and 6 characters', 'rangelength', '2,6');
    $form->addRule('numberquestions', 'Number of Questions must be a number', 'numeric');
    $form->addRule('creditaward', 'Credit Award must be a number', 'numeric');
    $form->addRule('passgrade', 'Passing Grade must be a number', 'numeric');
    $form->addRule('passgrade', 'Passing Grade must be between 1 and 3 characters', 'rangelength', '1,3');
    $form->addRule('numberquestions', 'Number of Questions must be non-zero', 'nonzero');
    $form->addRule('marker', 'Marker\'s ID Number must be a number', 'numeric');
    $form->addRule('marker', 'Marker\'s ID Number must be non-zero', 'nonzero');
    
    $buttons[] = &HTML_QuickForm::createElement('submit', null, 'Submit');
    $buttons[] = &HTML_QuickForm::createElement('reset', null, 'Reset');
    $form->addGroup($buttons, 'buttons');
    
    if ($form->validate()) {
      
      $form->freeze();
      $form->process('ProcessCreate', false);
      
    } else {
      
      $form->display();
      
    }

  } else {

    print '<p>You do not have permission to create exams.</p>';

  }

  page_footer();

}

// }}}
// {{{ ProcessCreate()

/**
 * Process the submitted data from the form.
 *
 * @access private
 * @param array the submitted form elements
 * @return void
 */
function ProcessCreate($values) {
  global $citadel;

  print '<p>Creating '.$values['name'].' Exam.</p>';

  if ($citadel->CreateExam($values['name'],
                           $values['abbr'],
                           $values['description'],
                           $values['marker'],
                           $values['numberquestions'],
                           $values['passgrade'],
                           $values['creditaward']) !== false) {

    print '<p>Exam Successfully Created.</p>';

  } else {

    print '<p>Error creating Exam. '.$citadel->Error().'</p>';

  }

}

// }}}

?>
