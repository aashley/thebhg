<?php

function Results_View_Normal($crumbTrail, $id) {
  global $citadel;

  $result = $citadel->GetResult($id);

  $exam = $result->GetExam();
  
  $person = $result->GetPerson();

  page_header($GLOBALS['site']['title'].' :: Results :: '.$exam->GetName()
      .' :: View #'.$result->GetID(),
      '',
      $crumbTrail);

  print '<h1>Exam Result #'.$result->GetID().' [ '
    .'<a href="'.$GLOBALS['site']['file_root'].'results/view/'
    .$result->GetID().'/detailed">View Details</a> ]</h1>';

  $table = new HTML_Table();

  $table->addRow(array('ID Line',
                       $person->IDLine(0)));

  $table->addRow(array('Exam',
                       $exam->GetName().' ['.$exam->GetAbbrev().']'));

  $table->addRow(array('Date Taken',
                       date('F jS Y, g:iA', $result->GetDateTaken())));

  $table->addRow(array('Score',
                       number_format($result->GetScore(), 2).'%'));

  if (DEBUG) {

    $c = $result->GetNumCorrect();

    if ($c === false) {

      RegisterDebug('Error Getting Number Correct: '.$result->Error());

    } else {
      
      RegisterDebug('Number of Correct Answers: '.$c);

    }

  }

  if ($result->GetNumCorrect() > 0) {

    $correct = $result->GetCorrectAnswers();

    $cout = '';

    foreach ($correct as $answer) {

      $qtable = new HTML_Table(array('class' => 'internal'));

      $qtable->addCol(array('Question:',
                            'Comments:',
                            'Score:'),
                      array(),
                      'TH');

      $question = $answer->GetQuestion();

      $qtable->addCol(array($question->GetQuestionText(),
                            nl2br($answer->GetComments()),
                            $answer->GetMark().' of '
                            .$answer->GetPossibleMark()));

      $cout .= $qtable->toHtml().'<hr>';

    }

    $table->addRow(array('Correct',
                         $cout));

  }

  if (DEBUG) {

    $i = $result->GetNumIncorrect();

    if ($i === false) {

      RegisterDebug('Error Getting Number Incorrect: '.$result->Error());

    } else {

      RegisterDebug('Number of Incorrect Answers: '.$result->GetNumIncorrect());

    }

  }

  if ($result->GetNumIncorrect() > 0) {

    $incorrect = $result->GetIncorrectAnswers();

    $incout = '';

    foreach ($incorrect as $answer) {

      $qtable = new HTML_Table(array('class' => 'internal'));

      $qtable->addCol(array('Question:',
                            'Comments:',
                            'Score:'),
                      array(),
                      'TH');

      $question = $answer->GetQuestion();

      $qtable->addCol(array($question->GetQuestionText(),
                            nl2br($answer->GetComments()),
                            $answer->GetMark().' of '
                            .$answer->GetPossibleMark()));

      $incout .= $qtable->toHtml().'<hr>';

    }

    $table->addRow(array('Incorrect',
                         $incout));

  }

  print '<p>'.$table->toHtml().'</p>';

  page_footer();

}
