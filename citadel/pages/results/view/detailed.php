<?php

function Results_View_Detailed($crumbTrail, $id) {
  global $citadel;

  $result = $citadel->GetResult($id);

  $exam = $result->GetExam();
  
  $person = $result->GetPerson();

  page_header($GLOBALS['site']['title'].' :: Results :: '.$exam->GetName()
      .' :: Detailed View #'.$result->GetID(),
      '',
      $crumbTrail);

  print '<h1>Exam Result #'.$result->GetID().'</h1>';

  $login = new Login_HTTP();

  if ($login->IsValid()) {

    $loginpos = $login->GetPosition();
    
    if (   $login->GetID() == $person->GetID()
        || $loginpos->GetID() == 5
        || in_array($login->GetID(), $exam->GetMarkers(true))) {
  
      $table = new HTML_Table();
  
      $table->addRow(array('ID Line',
                           $person->IDLine(0)));
  
      $table->addRow(array('Exam',
                           $exam->GetName().' ['.$exam->GetAbbrev().']'));
  
      $table->addRow(array('Date Taken',
                           date('F jS Y, g:iA', $result->GetDateTaken())));
  
      $table->addRow(array('Score',
                           number_format($result->GetScore(), 2).'%'));
  
      if ($result->GetNumCorrect() > 0) {
  
        $correct = $result->GetCorrectAnswers();
  
        $cout = '';
  
        foreach ($correct as $answer) {
  
          $qtable = new HTML_Table(array('class' => 'internal'));
  
          $qtable->addCol(array('Question:',
                                'Answer:',
                                'Comment:',
                                'Score:'),
                          array(),
                          'TH');
  
          $question = $answer->GetQuestion();
  
          $qtable->addCol(array($question->GetQuestionText(),
                                nl2br($answer->GetAnswer()),
                                nl2br($answer->GetComments()),
                                $answer->GetMark().' of '
                                .$answer->GetPossibleMark()));
  
          $cout .= $qtable->toHtml().'<hr>';
  
        }
  
        $table->addRow(array('Correct',
                             $cout));
  
      }
  
      if ($result->GetNumIncorrect() > 0) {
  
        $incorrect = $result->GetIncorrectAnswers();
  
        $incout = '';
  
        foreach ($incorrect as $answer) {
  
          $qtable = new HTML_Table(array('class' => 'internal'));
  
          $qtable->addCol(array('Question:',
                                'Answer:',
                                'Comments:',
                                'Score:'),
                          array(),
                          'TH');
  
          $question = $answer->GetQuestion();
  
          $qtable->addCol(array($question->GetQuestionText(),
                                nl2br($answer->GetAnswer()),
                                nl2br($answer->GetComments()),
                                $answer->GetMark().' of '
                                .$answer->GetPossibleMark()));
  
          $incout .= $qtable->toHtml().'<hr>';
  
        }
  
        $table->addRow(array('Incorrect',
                             $incout));

      }

      print '<p>'.$table->toHtml().'</p>';

    } else {

      print '<p>You do not have permission to view the details of this result.'
        .'</p>';

    }

  } else {

    print '<p>You do not have permission to view the details of this result.'
      .'</p>';

  }

  page_footer();

}
