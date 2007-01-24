<?php

/**
 * Edit Exams
 *
 * @access public
 * @package Citadel
 * @author Adam Ashley <adam_ashley@softhome.net>
 * @version $Revision: 1.19 $
 */

/**
 * Include Library System so we can access list of available texts
 */
include_once 'library.inc';

// {{{ Admin_Edit()

/**
 * The Edit Exam Page
 * 
 * @access public
 * @param array crumbTrail from above
 * @param string path info below this page
 * @param object Login_HTTP Login Object
 * @return void
 */
function Admin_Edit($crumbTrail, $path, &$login) {
  global $citadel;

  $path = explode('/', $path);

  if (   isset($path[1])
      && $path[1] > '') {

    $exam = $citadel->GetExambyAbbrev($path[1]);

    page_header($GLOBALS['site']['title'].' :: Administration :: '
        .'Edit '.$exam->GetName().' Exam',
        '',
        $crumbTrail);

    $loginpos = $login->GetPosition();

    if (   in_array($login->GetID(), $exam->GetMarkers(true))
        || $loginpos->GetID() == 2
				|| $loginpos->GetID() == 10
				|| $login->GetID() == 94) {

      $form = new Citadel_HTML_QuickForm();

      $form->updateAttributes(array('onSubmit' => 'submit_markers(this.form)'));

      $defaultValues = array('name' => $exam->GetName(),
                             'abbr' => $exam->GetAbbrev(),
                             'description' => $exam->GetDescription(),
                             'numberquestions' => $exam->GetNumberofQuestions(),
                             'passgrade' => $exam->GetPassGrade(),
                             'creditaward' => $exam->GetCreditAward(),
                             'notebook' => $exam->GetNotebookID());

      $form->setDefaults($defaultValues);

      $form->addElement('hidden',
                        'exam',
                        $exam->GetID());

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

      $form->addElement('static',
                        'markers',
                        'Markers:',
                        GenerateMarkerSelect($exam));

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
      $form->addRule('markers', 'At least one Marker is a required', 'required');
      $form->addRule('description', 'Exam Description is a required field', 'required');
      $form->addRule('numberquestions', 'Number of Questions is a required field', 'required');
      $form->addRule('passgrade', 'Passing Grade is a required field', 'required');
      $form->addRule('creditaward', 'Credit Award is a required field', 'required');
      $form->addRule('notebook', 'Course Notes is a required field', 'required');
      $form->addRule('abbr', 'Exam Abbreviations must be between 2 and 6 characters', 'rangelength', array('2','6'));
      $form->addRule('numberquestions', 'Number of Questions must be a number', 'numeric');
      $form->addRule('creditaward', 'Credit Award must be a number', 'numeric');
      $form->addRule('passgrade', 'Passing Grade must be a number', 'numeric');
      $form->addRule('passgrade', 'Passing Grade must be between 1 and 3 characters', 'rangelength', array('1','3'));
      $form->addRule('numberquestions', 'Number of Questions must be non-zero', 'nonzero');
  
/*      $renderer = &$form->defaultRenderer();

      // Set Custom rendering for 'buttons' element
      $renderer->setElementTemplate(
          "</table>\n"
          ."<p>\n"
          ."\t<table class=\"buttons\">\n"
          ."\t\t<tr>\n"
          ."\t\t\t<td>{element}</td>\n"
          ."\t\t</tr>\n"
          ."\t</table>\n"
          ."</p>\n"
          ."<table>",
          'buttons');*/
  
      $buttons[] = &HTML_QuickForm::createElement('submit', null, 'Submit');
      $buttons[] = &HTML_QuickForm::createElement('reset', null, 'Reset');
      $form->addGroup($buttons, 'buttons');

      if ($form->validate()) {
  
        $form->freeze();
        $form->process('ProcessEdit', false);
  
      } else {
  
        $form->display();
  
      }

    } else {

      print '<p>You do not have permission to edit this exam.</p>';

    }

  } else {

    page_header($GLOBALS['site']['title'].' :: Administration :: '
        .'Edit Exams',
        '',
        $crumbTrail);

    print '<h1>Edit Exams</h1>';

    $exams = &$citadel->GetExamsMarkedBy($login);

    $table = new HTML_Table();

    for ($i = 0; $i < sizeof($exams); $i++) {

      $table->addRow(
          array($exams[$i]->GetName().' ['.$exams[$i]->GetAbbrev().']',
                '<a href="'.$GLOBALS['site']['file_root'].'admin/edit/'
                .strtolower($exams[$i]->GetAbbrev()).'">Edit Exam</a>')
          );

    }

    print '<p>'.$table->toHtml().'</p>';

  }

  page_footer();

}

// }}}
// {{{ ProcessEdit()

/**
 * Process the submitted data from the form.
 *
 * @access private
 * @param array the submitted form elements
 * @return void
 */
function ProcessEdit($values) {
  global $citadel, $roster;

  $exam = $citadel->GetExam($values['exam']);

  print '<p>Saving Changes to '.$exam->GetName().' Exam.</p>';

  $table = new HTML_Table();

  $table->addCol(array('Setting Name:',
                       'Setting Abbreviation:',
                       'Setting Description:',
                       'Setting Number of Questions:',
                       'Setting Passing Grade (%):',
                       'Setting Credit Award:',
                       'Setting Notebook:',
                       'Setting Markers:'),
                 array(),
                 'TH');

  $col = array();

  if ($exam->SetName($values['name'])) {

    $col[] = 'OK';

  } else {

    $col[] = 'ERROR: '.$exam->Error();

  }

  if ($exam->SetAbbrev($values['abbr'])) {

    $col[] = 'OK';

  } else {

    $col[] = 'ERROR: '.$exam->Error();

  }

  if ($exam->SetDescription($values['description'])) {

    $col[] = 'OK';

  } else {

    $col[] = 'ERROR: '.$exam->Error();

  }

  if ($exam->SetNumberofQuestions($values['numberquestions'])) {

    $col[] = 'OK';

  } else {

    $col[] = 'ERROR: '.$exam->Error();

  }

  if ($exam->SetPassGrade($values['passgrade'])) {

    $col[] = 'OK';

  } else {

    $col[] = 'ERROR: '.$exam->Error();

  }

  if ($exam->SetCreditAward($values['creditaward'])) {

    $col[] = 'OK';

  } else {

    $col[] = 'ERROR: '.$exam->Error();

  }

  if ($exam->SetNotebook($values['notebook'])) {

    $col[] = 'OK';

  } else {

    $col[] = 'ERROR: '.$exam->Error();

  }

  $markeroutput = '';

  foreach ($values['markers'] as $markerid) {

    $marker = $roster->GetPerson($markerid);

    if (in_array($markerid, $values['oldmarkers'])) {

      $markeroutput .= $marker->GetName().': Already Marker<br>';

    } else {

      $markeroutput .= 'Adding '.$marker->GetName().': ';

      if ($exam->AddMarker($markerid)) {

        $markeroutput .= 'OK<br>';

      } else {

        $markeroutput .= $exam->Error.'<br>';

      }

    }

  }

  foreach ($values['oldmarkers'] as $markerid) {

    if (!in_array($markerid, $values['markers'])) {

      $marker = $roster->GetPerson($markerid);

      $markeroutput .= 'Removing '.$marker->GetName().': ';

      if ($exam->RemoveMarker($markerid)) {

        $markeroutput .= 'OK';

      } else {

        $markeroutput .= $exam->Error().'<br>';

      }

    }

  }

  $col[] = $markeroutput;

  $table->addCol($col);

  print '<p>'.$table->toHtml().'</p>';

}

// }}}
// {{{ GenerateMarkerSelect()

/**
 * Generate the multiple selects and javascript to handle the marker select
 *
 * @access private
 * @param object Citadel_Exam
 * @return string the HTML
 */
function GenerateMarkerSelect(&$exam) {
  global $roster;

  $output = <<<EOJ
<script language="JavaScript1.1" type="text/javascript">
<!--
function person(id, name) {
  this.id = id;
  this.name = name;
}
EOJ;

  $kabals_result = $roster->GetDivisions();
  
  $commindex = 0;
  
  foreach ($kabals_result as $kabal) {
    
    if ($kabal->GetID() == 16) {
      
      continue;
      
    }
    
    $output .= 'roster' . $kabal->GetID() . " = new Array();\n";
    
    $plebs = $kabal->GetMembers('name');
    
    if (is_array($plebs)) {
      
      $plebindex = 0;
      
      foreach ($plebs as $pleb) {
        
        $div_peeps[$pleb->GetName().':'.$plebindex] = 
          'roster'
          .(($kabal->GetID() == 9) 
              ? '10' 
              : $kabal->GetID()) 
          .'['
          .(($kabal->GetID() == 9 || $kabal->GetID() == 10) 
              ? $commindex++ 
              : $plebindex++)
          ."] = new person(".$pleb->GetID().', \''
              .str_replace("'", "\\'", shorten_string($pleb->GetName(), 20))
              ."');\n";
      
      }
      
      $output .= implode('', $div_peeps);
      
      unset($div_peeps);
      
    }
    
  }
    
	$output .= <<<EOJ2

function swap_kabal(frm, id) {
  var kabal_list = eval("frm.kabal" + id);
  var person_list = eval("frm.person" + id);
  var kabal = kabal_list.options[kabal_list.options.selectedIndex].value;
  if (kabal > 0) {
    var kabal_array = eval("roster" + kabal);
    var new_length = kabal_array.length;
    person_list.options.length = new_length;
    for (i = 0; i < new_length; i++) {
      person_list.options[i] = new Option(kabal_array[i].name, kabal_array[i].id, false, false);
    }
  }
  else {
    person_list.options.length = 1;
    person_list.options[0] = new Option("N/A", -1, false, false);
  }
}

function add_marker(frm) {
  var person_list = eval("frm.person1");
  var marker_list = document.getElementById("marker");

  if (person_list.selectedIndex < 0) {

    alert("You must select at least one person to add them to the Markers List.");
    return false;

  } else {

    for (var i = 0; i < person_list.length; i++) {

      var item = person_list.options[i];

      if (item.value == "") { continue; }

      if (item.selected) {

        var exist = 1;

        for (var j = 0; j < marker_list.length; j++) {

          if (item.value == marker_list.options[j].value) {

            exist = 0;
            continue;

          }

        }

        if (exist) {

          marker_list.options[marker_list.length] = 
            new Option(item.text, item.value);

        }

      }

    }

  }

}

function remove_marker(frm) {
  var marker_list = document.getElementById("marker");

  for (var i = (marker_list.length - 1); i >= 0; i--) {

    if (marker_list.options[i].selected) {

      marker_list.options[i] = null;

    }

  }

}

function submit_markers(frm) {
  var marker_list = document.getElementById("marker");

  for (var i = 0; i < marker_list.length; i++) {

    marker_list.options[i].selected = true;

  }

  return true;

}

// -->
</script>
<noscript>
This page requires JavaScript to function properly.
</noscript>
EOJ2;

  $table = new HTML_Table(array('class' => 'internal'));

  $col = "<select name=\"kabal1\" onChange=\"swap_kabal(this.form, 1)\">"
    ."<option value=\"-1\">N/A</option>";

  reset($kabals_result);

  foreach ($kabals_result as $kabal) {

    if ($kabal->GetID() != 9
        && $kabal->GetID() != 16) {

      $col .= '<option value="'.$kabal->GetID().'">'.$kabal->GetName()
        ."</option>\n";

    }

  }

  $col .= '</select><br>'
    .'<select name="person1" multiple="multiple" size="5">'
    .'<option value="-1">N/A</option>'
    .'</select>';

  $table->addCol(array($col),
                 array('width' => 50));

  $col = '<input type="button" value="Add >>" onClick="add_marker(this.form)">'
    .'<br>'
    .'<br>'
    .'<input type="button" value="<< Remove" onClick="remove_marker(this.form)"'
    .'>';

  $table->addCol(array($col),
                 array('align' => 'center',
                       'width' => 50));

  $markers = $exam->GetMarkers();

  $hidden = '';
  $option = '';

  foreach ($markers as $marker) {

    $hidden .= '<input type="hidden" name="oldmarkers[]" value="'
      .$marker->GetID().'">';

    $option .= '<option value="'.$marker->GetID().'">'
      .shorten_string($marker->GetName(), 20).'</option>';

  }

  $col = $hidden
    .'<select id="marker" name="markers[]" multiple="multiple" size="6">'
    .$option
    .'</select>';

  $table->addCol(array($col));

  $output .= $table->toHtml();

  return $output;

}

// }}}
// {{{ shorten_string()

function shorten_string($string, $length = 40) {
  if (strlen($string) > $length) {
    return substr($string, 0, $length)."...";
  }
  else {
    return $string;
  }
}

// }}}

?>
