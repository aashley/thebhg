<?php
//Build Header
include_once 'roster.inc';
include_once 'objects/include.php';
$roster = new Roster();
$fiction = new Fiction();

//Login
if (isset($_REQUEST['new']) || isset($_REQUEST['edit']) || isset($_REQUEST['mod']) || isset($_REQUEST['view-comp'])
 || isset($_REQUEST['compview']) || isset($_REQUEST['comment']) || isset($_REQUEST['move']) || isset($_REQUEST['newb']) 
 || isset($_REQUEST['editb']) || isset($_REQUEST['moveb']) || isset($_REQUEST['commentb']) || isset($_REQUEST['rate'])){
	$login = new Login_HTTP();
}

//Me and KK
$ric = new Person(2650);
$kk = new Person(85);

//Misc
function hr(){
	echo '<hr />';
}

function libraries($form, $lib = 1){
	global $login, $fiction;
	$form->StartSelect('Library:', 'libr', $lib);
	foreach ($fiction->AccessibleLibraries($login->GetID()) as $lib){
		$form->AddOption($lib->GetID(), $lib->GetName());
	}
	$form->EndSelect();
}

function HunterList($form){
	global $roster;
	
	$kabals_result = $roster->GetDivisions();
	$kabals = array();
	foreach ($kabals_result as $kabal) {
		if ($kabal->GetID() != 9 && $kabal->GetID() != 16) {
			$kabals[$kabal->GetName()] = "<option value=\"".$kabal->GetID()."\">"
	          .$kabal->GetName()."</option>\n";
		} 
    }
    
	$kabals = implode('', $kabals);
	?>
	<script language="JavaScript1.1" type="text/javascript">
	<!--
	function person(id, name) {
		this.id = id;
		this.name = name;
	}

	<?php
  
		reset($kabals_result);
    
	  $commindex = 0;
    
		foreach ($kabals_result as $kabal) {
      
			if ($kabal->GetID() == 16) {
        
				continue;
        
			}
      
			echo 'roster' . $kabal->GetID() . " = new Array();\n";
      
			$plebs = $kabal->GetMembers('name');
      
	    if (is_array($plebs)) {
        
	      $plebindex = 0;
        
        foreach ($plebs as $pleb) {
          $div_peeps[$pleb->GetName().':'.$plebindex] = 
            'roster'
            .(($kabal->GetID() == 9) 
              ? '10' 
              : $kabal->GetID()) 
            .'['.
            (($kabal->GetID() == 9 || $kabal->GetID() == 10) 
              ? $commindex++ 
              : $plebindex++)
            .'] = new person('.$pleb->GetID().', \''
            .str_replace("'", "\\'", substr($pleb->GetName(), 0, 20).((strlen($pleb->GetName()) > 20) ? '...' : ''))
            ."');\n";
            
        }
        
        echo implode('', $div_peeps);
        
        unset($div_peeps);
        
	    }
      
		}
    
	?>

	function swap_kabal(frm) {
		var kabal_list = eval("frm.kabal");
		var person_list = eval("frm.person");
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

	// -->
	</script>
	<noscript>
	This page requires JavaScript to function properly.
	</noscript>
    <?php
    
    $form->table->StartRow();
	$form->table->AddCell("<select name=\"kabal\" "."onChange=\"swap_kabal(this.form)\">"
        ."<option value=\"-1\">N/A</option>$kabals</select>");
    
	$cell = "<select name=\"person\">";
      
	$cell .= "<option value=\"0\" selected>N/A</option>\n" .implode("", $plebs);
    
	$cell .= "</select>";
    
	$form->table->AddCell($cell);
	$form->table->EndRow();
}

function output(){
	global $roster, $fiction, $login;
	
	if (is_object($login)){
		$div = $login->GetDivision();
		$pos = $login->GetPosition();
		$access = $fiction->PersonalAdmin($login->GetID(), $div->GetID(), $pos->GetID());
		$mod = array();
		$lib = array();
		$com = array();
		$acc_check = array();
	
		$FAMOD = ($login->GetID() == 2650
				|| $login->GetID() == 94
				|| $pos->GetID() == 3
				|| $pos->GetID() == 5
				|| $pos->GetID() == 10
				|| $fiction->FAMod($login->GetID()));
		$X = ($login->GetID() == 2650 
				|| $login->GetID() == 94
				|| $pos->GetID() == 3
				|| $pos->GetID() == 5
				|| $pos->GetID() == 10);
		
		foreach ($access as $arr){
			if ($arr['mod']){
				$mod[$arr['lib']->GetID()] = $arr['lib'];
			}
			if ($arr['libr']){
				$lib[$arr['lib']->GetID()] = $arr['lib'];
			}
			if ($arr['comp']){
				$com[$arr['lib']->GetID()] = $arr['lib'];
			}
		}
		
		$mod_acc = array_keys($mod);
		$lib_acc = array_keys($lib);
		$com_acc = array_keys($com);
	}
	
	if (isset($_REQUEST['rate'])){
		$art = $fiction->GetFiction($_REQUEST['rate']);
		$q = $art->Rate($_REQUEST['ratn'], $login->GetID());
		echo 'Your rating has '.($q ? '' : '<b>not</b> ').'been saved.<br />';
		echo '<a href="?fiction='.$art->GetID().'">Return to <i>'.$art->GetTitle().'</i></a>';
	} elseif (isset($_REQUEST['view_comp_results'])){
		if ($_REQUEST['comp_id']){
			$lib = new Competition($_REQUEST['comp_id']);
			$table = new Table();
			$table->StartRow();
			$table->AddHeader('Fiction');
			$table->AddHeader('Person');
			$table->AddHeader('Current Rank');
			$table->AddHeader('Total Score');
			$table->EndRow();
			foreach ($lib->GetSubmissions() as $sub){
				$p = $sub['fic']->GetPerson();
				$table->AddRow('<a target="viewf" href="?fiction='.$sub['fic']->GetID().'">'.
					$sub['fic']->GetTitle().'</a>', $p->GetName(), number_format($sub['rank']), number_format($sub['score']));
			}
			$table->EndTable();
		} else {
			$form = new Form($_SERVER['PHP_SELF']);
			$form->AddSectionTitle('View Competition');
			
			$form->StartSelect('Competition:', 'comp_id');
			foreach ($fiction->ClosedComps() as $lib){
				$libr = $lib->GetLibrary();
				$form->AddOption($lib->GetID(), 'Ends: '.$lib->Ends(true).' || Library: '.$libr->GetName());
			}
			$form->EndSelect();
			$form->AddSubmitButton('view_comp_results', 'View Submissions');
			
			$form->EndForm();
		}
	} elseif (isset($_REQUEST['fiction'])){
		if ($_REQUEST['fiction']){
			$art = $_REQUEST['fiction'];
		} else {
			$art = $fiction->RandomFiction();
		}
		$art = $fiction->GetFiction($art);
		if ((($art->Published() > 0) && !$art->DateDeleted()) || $admin){
			$art->View($_SERVER['REMOTE_ADDR']);
			$table = new Table();
			$table->StartRow();
			$table->AddHeader($art->GetTitle());
			$table->EndRow();
			
			if ($art->Rating()){
				$table->AddRow('Peer Rating: <center>'.$art->Rating(true));
			}
			
			$table->AddRow('Word Count: '.number_format(str_word_count(strip_tags($art->GetCount()))));
			$table->AddRow($art->GetFiction());
			
			$person = $art->GetPerson();
			
			$table->AddRow('Published by <a href="?library='.$person->GetID().'">'.$person->GetName().'</a> on '.$art->Published(true));
			$table->EndTable();

			$art->GradeBrakedown();
			
			hr();
			
			$table = new Table();
			
			$table->StartRow();
			$table->AddHeader('Comments', 2);
			$table->EndRow();
			
			$table->StartRow();
			$table->AddCell('<a href="?comment='.$art->GetID().'">Leave a Comment</a>', 2);
			$table->EndRow();
						
			if (count($art->GetComments())){
				foreach ($art->GetComments() as $comment){
					$table->AddRow('Posted by: '.$comment['per']->GetName().'<br />On: '.$comment['datefrmt'], 
					$comment['comment']);
				}
			}
			
			$table->EndTable();
			
			hr();
			
			$table = new Table();
			$table->StartRow();
			$table->AddHeader('Peer Rating');
			$table->EndRow();
			
			$r = '';
			$a = 1;
			for ($i = 0; $i <= 20; $i++){
				$r .= '<a href="?rate='.$art->GetID().'&ratn='.$i.'">';if ($i == 0){
					$r .= '0</a>';
					continue;
				}
				if ($a == 1){
					$r .= '<img border=0 src="rating/left.png">';
		 		}
		 		if ($a == 2){
			 		$r .= '<img border=0 src="rating/left-mid.png">';
		 		}
		 		if ($a == 3){
			 		$r .= '<img border=0 src="rating/right-mid.png">';
		 		}
		 		if ($a == 4){
			 		$r .= '<img border=0 src="rating/right.png">';
		 		}
		 		$r .= '</a>';
		 		$a++;
		 		if ($a > 4){
			 		$a = 1;
		 		}
			}
			
			$table->AddRow($r);
			$table->EndRow();
		}
	}
	//Comment Handlinig
	elseif (isset($_REQUEST['comment'])){
		if ($_REQUEST['comment']){
			$art = $_REQUEST['comment'];
		} else {
			echo 'You do not have a fiction to comment on, motard';
			exit;
		}
		$art = $fiction->GetFiction($art);
		if ((($art->Published() > 0) && !$art->DateDeleted()) || $admin){
			if ($_REQUEST['submit']){
				$q = $art->NewComment($login->GetID(), $_REQUEST['comments']);
				echo 'Comment left '.($q ? 'successfully.' : 'in limbo, due to errors');
				
				hr();
				
				echo '<a href="?fiction='.$art->GetID().'">Back to '.$art->GetTitle().'</a>';
			} else {
				$form = new Form($page);
				$p = $art->GetPerson();
				$form->AddSectionTitle('Comment on '.$p->GetName()."'s ".$art->GetTitle());
				
				$form->AddTextArea('Comment:', 'comments');
				
				$form->AddHidden('comment', $_REQUEST['comment']);
				$form->AddSubmitButton('submit', 'Post Comments');
				$form->EndForm();
			}
		}
	}
	elseif (isset($_REQUEST['book'])){
		if ($_REQUEST['book']){
			$art = $_REQUEST['book'];
		} else {
			$art = $fiction->RandomBook();
		}
		$art = $fiction->GetBook($art);
		if ((($art->Published() > 0) && !$art->DateDeleted()) || $admin){
			$art->View($_SERVER['REMOTE_ADDR']);
			$table = new Table();
			$table->StartRow();
			$table->AddHeader($art->GetName());
			$table->EndRow();
			$i = 1;
			
			if ($art->Rating()){
				$table->AddRow($art->Rating(true));
			}
			
			foreach ($art->SimipleChapters() as $id=>$title){
				$table->AddRow('Chapter '.$i.': <a href="?fiction='.$id.'">'.$title.'</a>');
				$i++;
			}
			
			$person = $art->GetPerson();
			
			$table->AddRow('Published by <a href="?library='.$person->GetID().'">'.$person->GetName().'</a> on '.$art->Published(true));
			$table->EndTable();
			
			hr();
			
			$table = new Table();
			
			$table->StartRow();
			$table->AddHeader('Comments', 2);
			$table->EndRow();
			
			$table->StartRow();
			$table->AddCell('<a href="?commentb='.$art->GetID().'">Leave a Comment</a>', 2);
			$table->EndRow();
						
			if (count($art->GetComments())){
				foreach ($art->GetComments() as $comment){
					$table->AddRow('Posted by: '.$comment['per']->GetName().'<br />On: '.$comment['datefrmt'], 
					$comment['comment']);
				}
			}
			
			$table->EndTable();
		}
	}
	elseif (isset($_REQUEST['commentb'])){
		if ($_REQUEST['commentb']){
			$art = $_REQUEST['commentb'];
		} else {
			echo 'You do not have a book to comment on, motard';
			exit;
		}
		$art = $fiction->GetBook($art);
		if ((($art->Published() > 0) && !$art->DateDeleted()) || $admin){
			if ($_REQUEST['submit']){
				$q = $art->NewComment($login->GetID(), $_REQUEST['comments']);
				echo 'Comment left '.($q ? 'successfully.' : 'in limbo, due to errors');
				
				hr();
				
				echo '<a href="?book='.$art->GetID().'">Back to '.$art->GetName().'</a>';
			} else {
				$form = new Form($page);
				$p = $art->GetPerson();
				$form->AddSectionTitle('Comment on '.$p->GetName()."'s ".$art->GetName());
				
				$form->AddTextArea('Comment:', 'comments');
				
				$form->AddHidden('commentb', $_REQUEST['commentb']);
				$form->AddSubmitButton('submit', 'Post Comments');
				$form->EndForm();
			}
		}
	}
	elseif (isset($_REQUEST['compview'])){
		if ($_REQUEST['compview']){
			$art = $_REQUEST['compview'];
			$art = $fiction->GetFiction($art);
		} else {
			echo 'You are not cleared to use this. Go away.';
			exit;
		}	

		if ((($art->Published() == false) && !$art->DateDeleted()) || $admin){
			$comp = $art->Competition();
			$lib = $comp->GetLibrary();
			if (!$FAMOD && (!in_array($lib->GetID(), $com_acc) && !in_array($lib->GetID(), $mod_acc))){
				echo 'You are not cleared to use this page';
				exit;
			}	 
			$table = new Table();
			$table->StartRow();
			$table->AddHeader($art->GetTitle());
			$table->EndRow();
			
			$table->AddRow('Word Count: '.number_format(str_word_count(strip_tags($art->GetCount()))));
			$table->AddRow($art->GetFiction());
			
			$person = $art->GetPerson();
			
			$table->AddRow('Submitted by <a href="?library='.$person->GetID().'">'.$person->GetName().'</a>');
			$table->EndTable();
		}	
	} elseif (isset($_REQUEST['newb'])){
		if ($_REQUEST['post']){
			$q = $fiction->NewBook($login->GetID(), $_REQUEST['title'], $_REQUEST['publish'], $_REQUEST['libr']);
			echo $_REQUEST['title'].' was '.($q ? ($_REQUEST['publish'] ? 'published' : 'logged').' into your library.' 
				: ' not submitted, due to errors. ');
		} else {
			$form = new Form($_SERVER['PHP_SELF']);
			$form->AddSectionTitle('New Book');
	
			$form->table->AddRow('Poster:', $login->GetName());
			$form->AddTextBox('Title:', 'title', '', 60);
			libraries($form);
			$form->AddCheckBox('Publish?', 'publish', 1);
			$form->AddHidden('post', 1);
			$form->AddSubmitButton('newb', 'Post Book');
			
			$form->EndForm();
		}
	} elseif (isset($_REQUEST['editb'])){
		$art = $fiction->GetBook($_REQUEST['fiction_id']);
		$p = $art->GetPerson();
		$cnfrm = ($login->GetID() == $p->GetID());
		if ($_REQUEST['post']){
			if (!$cnfrm){
				echo 'You are not cleared to access this page';
				exit;
			}
			$lib = $art->GetLibrary();
			$q = $art->Edit($_REQUEST['title'], $_REQUEST['publish'], $lib->GetID());
			echo $_REQUEST['title'].' was '.($q ? 'edited and '.($_REQUEST['publish'] ? 'published' : 'logged').' into your library.' 
				: ' not edited, due to errors. ');
		} elseif ($_REQUEST['newch']){
			if (!$cnfrm){
				echo 'You are not cleared to access this page';
				exit;
			}
			$q = $art->NewChapter($_REQUEST['ch_id']);
			$fic = $fiction->GetFiction($_REQUEST['ch_id']);
			echo $fic->GetTitle().' was '.($q ? 'added as a chapter.' : 'not added, due to errors.');
		} elseif ($_REQUEST['updwn']){
			if (!$cnfrm){
				echo 'You are not cleared to access this page';
				exit;
			}
			if (is_array($_REQUEST['dw'])){
				foreach ($_REQUEST['dw'] as $id=>$a){
					foreach ($a as $ch=>$b){
						$q = $art->MoveDown($id, $ch);
					}
				}
				echo 'Chapter was '.($q ? 'moved down.' : 'not moved, due to errors.');
			}
			if (is_array($_REQUEST['up'])){
				foreach ($_REQUEST['up'] as $id=>$a){
					foreach ($a as $ch=>$b){
						$q = $art->MoveUp($id, $ch);
					}
				}
				echo 'Chapter was '.($q ? 'moved up.' : 'not moved, due to errors.');
			}
			if (is_array($_REQUEST['dl'])){
				foreach ($_REQUEST['dl'] as $id=>$a){
					$q = $art->DeleteChapter($id);
				}
				echo 'Chapter was '.($q ? 'deleted.' : 'not deleted, due to errors.');
			}
		} elseif ($_REQUEST['fiction_id']) {
			if (!$cnfrm){
				echo 'You are not cleared to access this page';
				exit;
			}
			$form = new Form($_SERVER['PHP_SELF']);
			$form->AddSectionTitle('Edit Book');
	
			$form->table->AddRow('Poster:', $login->GetName());
			$form->AddTextBox('Title:', 'title', $art->GetName(), 60);
			$form->AddCheckBox('Publish?', 'publish', 1, ($art->Published() > 0));
			$form->AddHidden('post', 1);
			$form->AddHidden('fiction_id', $_REQUEST['fiction_id']);
			$form->AddSubmitButton('editb', 'Edit Book');
			
			$form->EndForm();
			
			hr();
			
			$form = new Form($_SERVER['PHP_SELF']);
			$form->AddSectionTitle('Add Chapter');
	
			$form->StartSelect('Fiction:', 'ch_id');
			foreach ($fiction->BuildLibrary($login->GetID()) as $id=>$name){
				$form->AddOption($id, $name);
			}
			$form->EndSelect();
			
			$form->AddHidden('newch', 1);
			$form->AddHidden('fiction_id', $_REQUEST['fiction_id']);
			$form->AddSubmitButton('editb', 'Add New Chapter');
			
			$form->EndForm();
			
			if ($art->ChapterCount()){
				hr();
				
				$form = new Form($page);
				$table = new Table();
				$table->StartRow();
				$table->AddHeader('Move Chapters', 4);
				$table->EndRow();
				
				foreach ($art->Chapters() as $i=>$f){
					foreach ($f as $id=>$fc){
						foreach ($fc as $c=>$fic){
							$table->AddRow($fic->GetTitle(), (($i > 1) ? '<input type="submit" class="chk" name="up['
							.$id.']['.$c.']" value="&uarr;">' : ''), (($i < $art->ChapterCount()) ? '<input type="submit" class="chk" name="dw['
							.$id.']['.$c.']" value="&darr;">' : ''), '<input type="submit" class="ck" name="dl['
							.$id.']" value="X">');
						}
					}
				}				
				$form->AddHidden('updwn', 1);
				$form->AddHidden('fiction_id', $_REQUEST['fiction_id']);
				$form->AddHidden('editb', 1);
				$table->EndTable();
				$form->EndForm();
			}
		} else {
			$form = new Form($_SERVER['PHP_SELF']);
			$form->AddSectionTitle('Edit Book');
	
			$form->table->AddRow('Poster:', $login->GetName());
			$form->StartSelect('Book:', 'fiction_id');
			foreach ($fiction->BookLibrary($login->GetID(), true) as $id=>$name){
				$form->AddOption($id, $name);
			}
			$form->EndSelect();
			
			$form->AddSubmitButton('editb', 'Edit Book');
			
			$form->EndForm();
		}
	} elseif (isset($_REQUEST['moveb'])){
		$art = $fiction->GetBook($_REQUEST['fiction_id']);
		$p = $art->GetPerson();
		$cnfrm = ($login->GetID() == $p->GetID());
		if ($_REQUEST['post']){
			if (!$cnfrm){
				echo 'You are not cleared to access this page';
				exit;
			}
			$q = $art->Edit($art->GetName(), (($art->Published() > 0) ? 1 : 0), $_REQUEST['libr']);
			$lib = new Library($_REQUEST['libr']);
			echo $art->GetName().' was '.($q ? 'moved to the '.$lib->GetName().' library.' 
				: ' not moved, due to errors. ');
		} elseif ($_REQUEST['fiction_id']) {
			if (!$cnfrm){
				echo 'You are not cleared to access this page';
				exit;
			}
			$form = new Form($_SERVER['PHP_SELF']);
			$form->AddSectionTitle('Move Fiction');
	
			$form->table->AddRow('Poster:', $login->GetName());
			$lib = $art->GetLibrary();
			libraries($form, $lib->GetID());
			$form->AddHidden('post', 1);
			$form->AddHidden('fiction_id', $_REQUEST['fiction_id']);
			$form->AddSubmitButton('moveb', 'Move Book');
			
			$form->EndForm();
		} else {
			$form = new Form($_SERVER['PHP_SELF']);
			$form->AddSectionTitle('Move Book');
	
			$form->table->AddRow('Poster:', $login->GetName());
			$form->StartSelect('Fiction:', 'fiction_id');
			foreach ($fiction->BookLibrary($login->GetID(), true) as $id=>$name){
				$form->AddOption($id, $name);
			}
			$form->EndSelect();
			
			$form->AddSubmitButton('moveb', 'Move Book');
			
			$form->EndForm();
		}
	}
	elseif (isset($_REQUEST['library'])){
		if ($_REQUEST['library']){
			$lib = $_REQUEST['library'];
		} else {
			$lib = $fiction->RandomLibrary();
		}
		$person = new Person($lib);
		
		$lib = $fiction->BookLibrary($person->GetID());
		$k = array_keys($lib);
		
		$lib = $fiction->BuildLibrary($person->GetID());
		$r = 0;
		
		$table = new Table();
		$table->StartRow();
		$table->AddHeader($person->GetName()."'s Library", 3);
		$table->EndRow();
		$i = 1;
		$a = 0;
		$t = false;
		$r = count($lib);
		$arl = array();
		
		if (count($k)){
			foreach ($lib as $id=>$per){
				if (in_array($id, $k)){
					continue;
				}
				$arl[$id] = $per;
			}
			
			$lib = $arl;
		}
		
		foreach ($lib as $id=>$per){
			$a++;
			$t = true;
			if ($i == 1){
				$table->StartRow();
			}
			$table->AddCell("<a href='?fiction=$id'>".$per."</a>", (($a == $r) ? (($i == 1) ? 3 : ($i == 2) ? 2 : 1) : 1));
			if ($i == 3){
				$table->EndRow();
				$i = 0;
			}
			$i++;
		}
		
		if (!$t){
			$table->StartRow();
			$table->AddCell('No Published, Non-Booked Fictions', 3);
			$table->EndRow();
		}
		
		$table->EndRow();
		$table->EndTable();
		
		$lib = $fiction->BookLibrary($person->GetID());
		
		if (count($lib)){
			hr();
			
			$table = new Table();
			$table->StartRow();
			$table->AddHeader($person->GetName()."'s Published Books", 3);
			$table->EndRow();
			$i = 1;
			$a = 0;
			$r = count($lib);
			
			foreach ($lib as $id=>$per){
				$a++;
				if ($i == 1){
					$table->StartRow();
				}
				$table->AddCell("<a href='?book=$id'>".$per."</a>", (($a == $r) ? (($i == 1) ? 3 : ($i == 2) ? 2 : 1) : 1));
				if ($i == 3){
					$table->EndRow();
					$i = 0;
				}
				$i++;
			}
			
			$table->EndRow();
		
			$table->EndTable();
		}
	}
	elseif (isset($_REQUEST['lib'])){
		$lib = $fiction->WritersList();
		
		$table = new Table();
		$table->StartRow();
		$table->AddHeader("Library Index", 3);
		$table->EndRow();
		$i = 1;
		asort($lib);
		foreach ($lib as $id=>$per){
			if ($i == 1){
				$table->StartRow();
			}
			$table->AddCell("<a href='?library=$id'>".$per."</a>");
			if ($i == 3){
				$table->EndRow();
				$i = 0;
			}
			$i++;
		}
		
		if ($i >= 2){
			if ($i != 3){
				$table->AddCell('&nbsp;');
			}
			$table->AddCell('&nbsp;');
			$table->EndRow();
		}
		
		$table->EndRow();
		$table->EndTable();
	} elseif (isset($_REQUEST['new'])){
		if ($_REQUEST['post']){
			$q = $fiction->NewFiction($login->GetID(), $_REQUEST['title'], $_REQUEST['text'], $_REQUEST['publish'], $_REQUEST['libr']);
			echo $_REQUEST['title'].' was '.($q ? ($_REQUEST['publish'] ? 'published' : 'logged').' into your library.' 
				: ' not submitted, due to errors. ');
		} else {
			$form = new Form($_SERVER['PHP_SELF']);
			$form->AddSectionTitle('New Fiction');
	
			$form->table->AddRow('Poster:', $login->GetName());
			$form->AddTextBox('Title:', 'title', '', 60);
			libraries($form);
			$form->AddTextArea('Fiction:', 'text', '', 30, 80);
			$form->AddCheckBox('Publish?', 'publish', 1);
			$form->AddHidden('post', 1);
			$form->AddSubmitButton('new', 'Post Fiction');
			
			$form->EndForm();
		}
	} elseif (isset($_REQUEST['edit'])){
		$art = $fiction->GetFiction($_REQUEST['fiction_id']);
		$p = $art->GetPerson();
		$cnfrm = ($login->GetID() == $p->GetID());
		if ($_REQUEST['post']){
			if (!$cnfrm){
				echo 'You are not cleared to access this page';
				exit;
			}
			$lib = $art->GetLibrary();
			$go = true;
			if ($art->date == -1){
				$comp = $art->Competition();
				if ($comp->graded == 0){
					if ($comp->CanGrade()){
						$go = false;
					}
				}
			}
			if ($go){
				$q = $art->Edit($_REQUEST['title'], $_REQUEST['text'], $_REQUEST['publish'], $lib->GetID());
				echo $_REQUEST['title'].' was '.($q ? 'edited and '.($_REQUEST['publish'] ? 'published' : 'logged').' into your library.' 
					: ' not edited, due to errors. ');
			} else {
				echo 'You cannot edit this fiction';
			}			
		} elseif ($_REQUEST['fiction_id']) {
			if (!$cnfrm){
				echo 'You are not cleared to access this page';
				exit;
			}
			$form = new Form($_SERVER['PHP_SELF']);
			$form->AddSectionTitle('Edit Fiction');
	
			$form->table->AddRow('Poster:', $login->GetName());
			$form->AddTextBox('Title:', 'title', $art->GetTitle(), 60);
			$form->table->AddRow('Word Count:', number_format(str_word_count(strip_tags($art->GetCount()))));
			$form->AddTextArea('Fiction:', 'text', $art->GetFiction(false), 30, 80);
			if ($art->date != -1){
				$form->AddCheckBox('Publish?', 'publish', 1, ($art->Published() > 0));
			}
			$form->AddHidden('post', 1);
			$form->AddHidden('fiction_id', $_REQUEST['fiction_id']);
			$form->AddSubmitButton('edit', 'Edit Fiction');
			
			$form->EndForm();
		} else {
			$form = new Form($_SERVER['PHP_SELF']);
			$form->AddSectionTitle('Edit Fiction');
	
			$form->table->AddRow('Poster:', $login->GetName());
			$form->StartSelect('Fiction:', 'fiction_id');
			foreach ($fiction->BuildLibrary($login->GetID(), true) as $id=>$name){
				$form->AddOption($id, $name);
			}
			$form->EndSelect();
			
			$form->AddSubmitButton('edit', 'Edit Fiction');
			
			$form->EndForm();
		}
	} elseif (isset($_REQUEST['move'])){
		$art = $fiction->GetFiction($_REQUEST['fiction_id']);
		$p = $art->GetPerson();
		$cnfrm = ($login->GetID() == $p->GetID());
		if ($_REQUEST['post']){
			if (!$cnfrm){
				echo 'You are not cleared to access this page';
				exit;
			}
			$q = $art->Edit($art->GetTitle(), $art->GetFiction(false), (($art->Published() > 0) ? 1 : 0), $_REQUEST['libr']);
			$lib = new Library($_REQUEST['libr']);
			echo $art->GetTitle().' was '.($q ? 'moved to the '.$lib->GetName().' library.' 
				: ' not moved, due to errors. ');
		} elseif ($_REQUEST['fiction_id']) {
			if (!$cnfrm){
				echo 'You are not cleared to access this page';
				exit;
			}
			$form = new Form($_SERVER['PHP_SELF']);
			$form->AddSectionTitle('Move Fiction');
	
			$form->table->AddRow('Poster:', $login->GetName());
			$lib = $art->GetLibrary();
			libraries($form, $lib->GetID());
			$form->AddHidden('post', 1);
			$form->AddHidden('fiction_id', $_REQUEST['fiction_id']);
			$form->AddSubmitButton('move', 'Move Fiction');
			
			$form->EndForm();
		} else {
			$form = new Form($_SERVER['PHP_SELF']);
			$form->AddSectionTitle('Move Fiction');
	
			$form->table->AddRow('Poster:', $login->GetName());
			$form->StartSelect('Fiction:', 'fiction_id');
			foreach ($fiction->BuildLibrary($login->GetID(), true) as $id=>$name){
				$form->AddOption($id, $name);
			}
			$form->EndSelect();
			
			$form->AddSubmitButton('move', 'Move Fiction');
			
			$form->EndForm();
		}
	} elseif (isset($_REQUEST['view-comp'])){
		$art = $fiction->GetComp($_REQUEST['comp_id']);
		if ($art->CanSubmit($login->GetID())){
			if ($_REQUEST['post']){
				$lib = $art->GetLibrary();
				$q = $fiction->NewFiction($login->GetID(), $_REQUEST['title'], $_REQUEST['text'], -1, $lib->GetID());
				$a = $art->Submit($login->GetID(), $q);
				echo $_REQUEST['title'].' was '.($a ? ' submitted to the competiton.' : ' not submitted, due to errors.');
			} else {
				$form = new Form($_SERVER['PHP_SELF']);
				$form->AddSectionTitle('New Fiction');
		
				$form->table->AddRow('Topic:', $art->GetDescription());
				
				$form->table->AddRow('Poster:', $login->GetName());
				$form->AddTextBox('Title:', 'title', '', 60);
				$form->AddTextArea('Fiction:', 'text', '', 30, 80);
				$form->AddHidden('post', 1);
				$form->AddHidden('comp_id', $_REQUEST['comp_id']);
				$form->AddSubmitButton('view-comp', 'Submit to Comp');
				
				$form->EndForm();
			}
		} else {
			echo 'You have submitted to this competition.';
		}
	} elseif (isset($_REQUEST['mod'])){
		switch ($_REQUEST['mod']){
			case 'lib':
				if (!$X){
					echo 'You are not cleared to use this page';
					exit;
				}
				if ($_REQUEST['post']){
					$q = $fiction->NewLibrary($_REQUEST['name'], $_REQUEST['key'], $_REQUEST['text'], $_REQUEST['all']);
					echo $_REQUEST['name'].' was '.($q ? 'added as a'.($_REQUEST['all'] ? 'n all access' 
						: ' restricted').' library.' : ' not created, due to errors.');
				} else {
					$form = new Form($_SERVER['PHP_SELF']);
					$form->AddSectionTitle('New Library');

					$form->AddTextBox('Name:', 'name', '', 60);
					$form->AddTextBox('Access Key:', 'key', '', 20);
					$form->AddTextArea('Description:', 'text');
					$form->AddCheckBox('All-Access Mode?', 'all', 1);
					$form->AddHidden('mod', 'lib');
					$form->AddSubmitButton('post', 'Create Library');
					
					$form->EndForm();
				}
			break;
			
			case 'make-fiction':
				if (!$FAMOD){
					echo 'You are not cleared to use this page';
					exit;
				}
				if ($_REQUEST['post']){
					$q = $fiction->NewFiction($_REQUEST['person'], $_REQUEST['title'], $_REQUEST['text'], $_REQUEST['publish'], $_REQUEST['libr']);
					$p = new Person($_REQUEST['person']);
					echo $_REQUEST['title'].' was '.($q ? ($_REQUEST['publish'] ? 'published' : 'logged').' into '.$p->GetName().'\'s library.' 
						: ' not submitted, due to errors. ');
				} else {
					$form = new Form($_SERVER['PHP_SELF']);
					$form->AddSectionTitle('New Fiction');
					HunterList($form);
					$form->AddTextBox('Title:', 'title', '', 60);
					foreach ($fiction->Libraries(true) as $lib){
						$form->AddOption($lib->GetID(), $lib->GetName());
					}
					$form->AddTextArea('Fiction:', 'text', '', 30, 80);
					$form->AddCheckBox('Publish?', 'publish', 1);
					$form->AddHidden('mod', 'make-fiction');
					$form->AddSubmitButton('post', 'Post Fiction');
					
					$form->EndForm();
				}
			break;
			
			case 'lib-key':
				if (!$X){
					echo 'You are not cleared to use this page';
					exit;
				}
				$lib = $fiction->GetLibrary($_REQUEST['library_id']);
				if ($_REQUEST['post']){
					$q = $lib->SetKey($_REQUEST['key']);
					echo 'Library Key was '.($q ? 'edited successfully. ' : 'not edited, due to errors.');
				} elseif ($_REQUEST['lib-edt']) {
					$form = new Form($_SERVER['PHP_SELF']);
					$form->AddSectionTitle('Edit Library Key');

					$form->AddTextBox('Key:', 'key', '', 20);
					$form->AddHidden('mod', 'lib-key');
					$form->AddHidden('library_id', $_REQUEST['library_id']);
					$form->AddSubmitButton('post', 'Set Library Key');
					
					$form->EndForm();
				} else {
					$form = new Form($_SERVER['PHP_SELF']);
					$form->AddSectionTitle('Edit Library Key');
					
					$form->StartSelect('Library:', 'library_id');
					foreach ($fiction->Libraries(true) as $lib){
						$form->AddOption($lib->GetID(), $lib->GetName());
					}
					$form->EndSelect();
					$form->AddHidden('mod', 'lib-key');
					$form->AddSubmitButton('lib-edt', 'Edit Library');
					
					$form->EndForm();
				}
			break;
			
			case 'lib-edit':
				if (!$FAMOD){
					echo 'You are not cleared to use this page';
					exit;
				}
				$lib = $fiction->GetLibrary($_REQUEST['library_id']);
				if ($_REQUEST['post']){
					$q = $lib->Edit($_REQUEST['name'], $_REQUEST['text'], $_REQUEST['all']);
					echo $_REQUEST['name'].' was '.($q ? 'edited to a'.($_REQUEST['all'] ? 'n all access' 
						: ' restricted').' library.' : ' not edited, due to errors.');
				} elseif ($_REQUEST['lib-edt']) {
					$form = new Form($_SERVER['PHP_SELF']);
					$form->AddSectionTitle('Edit Library');

					$form->AddTextBox('Name:', 'name', $lib->GetName(), 60);
					$form->AddTextArea('Description:', 'text', $lib->GetDescription(false));
					$form->AddCheckBox('All-Access Mode?', 'all', 1, ($lib->FullAccess() == 1));
					$form->AddHidden('mod', 'lib-edit');
					$form->AddHidden('library_id', $_REQUEST['library_id']);
					$form->AddSubmitButton('post', 'Edit Library');
					
					$form->EndForm();
				} else {
					$form = new Form($_SERVER['PHP_SELF']);
					$form->AddSectionTitle('Edit Library');
					
					$form->StartSelect('Library:', 'library_id');
					foreach ($fiction->Libraries(true) as $lib){
						$form->AddOption($lib->GetID(), $lib->GetName());
					}
					$form->EndSelect();
					$form->AddHidden('mod', 'lib-edit');
					$form->AddSubmitButton('lib-edt', 'Edit Library');
					
					$form->EndForm();
				}
			break;
			
			case 'lib-admin':
				if (!$FAMOD){
					echo 'You are not cleared to use this page';
					exit;
				}
				if ($_REQUEST['post']){
					if ($_REQUEST['person'] || $_REQUEST['position'] || ($_REQUEST['division'] && $_REQUEST['position'])){
						if ($_REQUEST['person'] && ($_REQUEST['position'] || ($_REQUEST['division'] && $_REQUEST['position']))){
							echo 'You cannot set that many options for an admin. Person only, Position only, or Position/Division';
						} else {
							$q = $fiction->NewAdmin($_REQUEST['person'], $_REQUEST['position'], $_REQUEST['division'],
							$_REQUEST['library_id'], $_REQUEST['moderator-access'], $_REQUEST['librarian-access'],
							$_REQUEST['competition-access']);
							echo 'New Administrator was '.($q ? ' added.' : ' not added, due to errors.');
						}
					} else {
						echo 'You must set either a Person, a Position, or a Position/Division combination';
					}
				} elseif ($_REQUEST['view']){
					$form = new Form($_SERVER['PHP_SELF']);

					$i = 1;
					echo '<table border=0 width=100% align=center>';
					foreach ($fiction->LibraryAdmin($_REQUEST['library_id']) as $id=>$lib){
						if ($i == 1){
							echo '<tr>';
							
						}
						echo '<td valign=top>';
						$table = new Table();
						($lib['person']->GetID() ? $table->AddRow('Person:', substr($lib['person']->GetName(), 0, 10).((strlen($lib['person']->GetName()) > 10) ? '...' : '')) : '');
						($lib['position']->GetID() ? $table->AddRow('Position:', $lib['position']->GetName()) : '');
						($lib['division']->GetID() ? $table->AddRow('Division:', $lib['division']->GetName()) : '');
						$table->AddRow('Moderator:', ($lib['mod'] ? 'Remove <input type=checkbox name=rmod['.$id.'] value=1>' : 'Add <input type=checkbox name=moder['.$id.'] value=1>'));
						$table->AddRow('Librarian:', ($lib['libr'] ? 'Remove <input type=checkbox name=rlibr['.$id.'] value=1>' : 'Add <input type=checkbox name=libr['.$id.'] value=1>'));
						$table->AddRow('Competitions:', ($lib['comp'] ? 'Remove <input type=checkbox name=rcomp['.$id.'] value=1>' : 'Add <input type=checkbox name=comp['.$id.'] value=1>'));
						$table->AddRow('Delete:', '<input type=checkbox name=del['.$id.'] value=1>');
						$table->EndTable();
						echo '</td>';
						if ($i == 3){
							echo '</tr>';
							$i = 0;
						}
						$i++;
					}
					echo '</table>';
					$form->AddHidden('mod', 'lib-admin');
					echo '<table border=0 width=100% align=center><tr><td>';
					echo '<input type=submit name=fix0r value="Alter Administrators">';
					echo '</td></tr></table>';
					$form->EndForm();
				} elseif ($_REQUEST['fix0r']){
					$error = 0;
					if (is_array($_REQUEST['del'])){
						foreach ($_REQUEST['del'] as $id=>$a){
							$e = $fiction->AdminFix($id, 'date_deleted', time());
							$error += ($e ? 0 : 1);
						}
					}
					if (is_array($_REQUEST['rmod'])){
						foreach ($_REQUEST['rmod'] as $id=>$a){
							$e = $fiction->AdminFix($id, 'moderator', 0);
							$error += ($e ? 0 : 1);
						}
					}
					if (is_array($_REQUEST['rlibr'])){
						foreach ($_REQUEST['rlibr'] as $id=>$a){
							$e = $fiction->AdminFix($id, 'librarian', 0);
							$error += ($e ? 0 : 1);
						}
					}
					if (is_array($_REQUEST['rcomp'])){
						foreach ($_REQUEST['rcomp'] as $id=>$a){
							$e = $fiction->AdminFix($id, 'competitions', 0);
							$error += ($e ? 0 : 1);
						}
					}
					if (is_array($_REQUEST['moder'])){
						foreach ($_REQUEST['moder'] as $id=>$a){
							$e = $fiction->AdminFix($id, 'moderator', 1);
							$error += ($e ? 0 : 1);
						}
					}
					if (is_array($_REQUEST['libr'])){
						foreach ($_REQUEST['libr'] as $id=>$a){
							$e = $fiction->AdminFix($id, 'librarian', 1);
							$error += ($e ? 0 : 1);
						}
					}
					if (is_array($_REQUEST['comp'])){
						foreach ($_REQUEST['comp'] as $id=>$a){
							$e = $fiction->AdminFix($id, 'competitions', 1);
							$error += ($e ? 0 : 1);
						}
					}
					echo ($error ? 'Errors occured. Admin not' : 'All edits successfully').' processed.';	
				} elseif ($_REQUEST['newsa']) {
					if ($X){
						$q = $fiction->AddFaMod($_REQUEST['person']);
						$p = new Person($_REQUEST['person']);
						echo $p->GetName().($q ? ' was added as a SuperAdmin.' : ' was not added, due to errors.');	
					}			
				} elseif ($_REQUEST['delsa']) {
					if ($X){
						$q = $fiction->RemoveFaMod($_REQUEST['sup_id']);
						$p = new Person($_REQUEST['sup_id']);
						echo $p->GetName().($q ? ' was removed as a SuperAdmin.' : ' was not removed, due to errors.');
					}
				} else {
					$form = new Form($_SERVER['PHP_SELF']);
					$form->AddSectionTitle('New Library Administrator');

					HunterList($form);
					
					$form->StartSelect('Position:', 'position');
					$form->AddOption(0, '');
					foreach ($roster->GetPositions() as $position){
						$form->AddOption($position->GetID(), $position->GetName());
					}
					$form->EndSelect();
					
					$form->StartSelect('Division:', 'division');
					$form->AddOption(0, '');
					foreach ($roster->GetDivisions() as $division){
						$form->AddOption($division->GetID(), $division->GetName());
					}
					$form->EndSelect();
					
					$form->StartSelect('Library:', 'library_id');
					foreach ($fiction->Libraries(true) as $lib){
						$form->AddOption($lib->GetID(), $lib->GetName());
					}
					$form->EndSelect();
					
					$form->AddCheckBox('Moderator', 'moderator-access', 1);
					$form->AddCheckBox('Librarian', 'librarian-access', 1);
					$form->AddCheckBox('Competitions', 'competition-access', 1);
					$form->table->StartRow();
					$form->table->AddCell('[Moderator]<br />&nbsp;&nbsp;&nbsp;&nbsp;This person has the ability of/to'
						.' delete Librarians and Competition administrators.<br />'
						.'[Librarian]<br />&nbsp;&nbsp;&nbsp;&nbsp;This person has the ability to edit and delete'
						.' fictions.<br />[Competitions]<br />&nbsp;&nbsp;&nbsp;&nbsp;This person has the ability to '
						.'run compeitions.', 2);
					$form->table->EndRow();
					$form->AddHidden('mod', 'lib-admin');
					$form->AddSubmitButton('post', 'Make Administrator');
					
					$form->EndForm();
					
					hr();
					
					$form = new Form($_SERVER['PHP_SELF']);
					$form->AddSectionTitle('Current Library Administrator');
					$form->StartSelect('Library:', 'library_id');
					foreach ($fiction->Libraries(true) as $lib){
						$form->AddOption($lib->GetID(), $lib->GetName());
					}
					$form->EndSelect();
					$form->AddHidden('mod', 'lib-admin');
					$form->AddSubmitButton('view', 'View Administrators');
					
					$form->EndForm();
					
					if ($X){
						hr();
					
						$form = new Form($_SERVER['PHP_SELF']);
						$form->AddSectionTitle('Remove Super Admin');
						$form->StartSelect('SuperAdmin:', 'sup_id');
						foreach ($fiction->FAMods() as $lib){
							$form->AddOption($lib->GetID(), $lib->GetName());
						}
						$form->EndSelect();
						$form->AddHidden('mod', 'lib-admin');
						$form->AddSubmitButton('delsa', 'Delete Super Administrator');
						$form->EndForm();
						hr();
					
						$form = new Form($_SERVER['PHP_SELF']);
						$form->AddSectionTitle('Add Super Admin');
						HunterList($form);
						$form->AddHidden('mod', 'lib-admin');
						$form->AddSubmitButton('newsa', 'New Super Administrator');
						$form->EndForm();
					}
				}
			break;
			
			case 'rest':
				if (!$X){
					echo 'You are not cleared to use this page';
					exit;
				}
				if ($_REQUEST['post']){
					$q = $fiction->NewRestriction($_REQUEST['library_id'], $_REQUEST['division']);
					echo 'New Library Restriction was '.($q ? ' added.' : ' not added, due to errors.');
				} elseif ($_REQUEST['view']){
					$form = new Form($_SERVER['PHP_SELF']);

					$i = 1;
					echo '<table border=0 width=100% align=center>';
					foreach ($fiction->LibraryRestrict($_REQUEST['library_id']) as $id=>$lib){
						if ($i == 1){
							echo '<tr>';
						}
						echo '<td valign=top>';
						$table = new Table();
						$table->StartRow();
						$table->AddHeader($lib['division']->GetName(), 2);
						$table->EndRow();
						$table->AddRow('Delete:', '<input type=checkbox name=del['.$id.'] value=1>');
						$table->EndTable();
						echo '</td>';
						if ($i == 3){
							echo '</tr>';
							$i = 0;
						}
						$i++;
					}
					echo '</table>';
					$form->AddHidden('mod', 'rest');
					echo '<table border=0 width=100% align=center><tr><td>';
					echo '<input type=submit name=fix0r value="Make Edits">';
					echo '</td></tr></table>';
					$form->EndForm();
				} elseif ($_REQUEST['fix0r']){
					$error = 0;
					if (is_array($_REQUEST['del'])){
						foreach ($_REQUEST['del'] as $id=>$a){
							$e = $fiction->RestrictFix($id, 'date_deleted', time());
							$error += ($e ? 0 : 1);
						}
					}
					echo ($error ? 'Errors occured. Restrictions not' : 'All edits successfully').' processed.';	
				} else {
					$form = new Form($_SERVER['PHP_SELF']);
					$form->AddSectionTitle('New Library Restrictions');
					
					$form->StartSelect('Division:', 'division');
					$form->AddOption(0, '');
					foreach ($roster->GetDivisions() as $division){
						$form->AddOption($division->GetID(), $division->GetName());
					}
					$form->EndSelect();
					
					$form->StartSelect('Library:', 'library_id');
					foreach ($fiction->Libraries(true) as $lib){
						if (!$lib->FullAccess()){
							$form->AddOption($lib->GetID(), $lib->GetName());
						}
					}
					$form->EndSelect();
					
					$form->AddHidden('mod', 'rest');
					$form->AddSubmitButton('post', 'Set Restriction');
					
					$form->EndForm();
					
					hr();
					
					$form = new Form($_SERVER['PHP_SELF']);
					$form->AddSectionTitle('Current Library Restrictions');
					$form->StartSelect('Library:', 'library_id');
					foreach ($fiction->Libraries(true) as $lib){
						if (!$lib->FullAccess()){
							$form->AddOption($lib->GetID(), $lib->GetName());
						}
					}
					$form->EndSelect();
					$form->AddHidden('mod', 'rest');
					$form->AddSubmitButton('view', 'View Restrictions');
					
					$form->EndForm();
				}
			break;
			
			case 'news':
				if (!$FAMOD){
					echo 'You are not cleared to use this page';
					exit;
				}
				if ($_REQUEST['post']){
					$q = $fiction->NewsPost($_REQUEST['news-post']);
					echo 'News was '.($q ? ' posted successfully.' : ' not posted, due to errors.');	
				} else {
					$form = new Form($_SERVER['PHP_SELF']);
					$form->AddSectionTitle('News Post');
					
					$form->AddTextArea('News Post:', 'news-post');
					
					$form->AddHidden('mod', 'news');
					$form->AddSubmitButton('post', 'Post News');
					
					$form->EndForm();
				}
			break;
			
			case 'edit-fictions':
				if (!$FAMOD && $_REQUEST['id']){
					$libs = explode(',', $_REQUEST['id']);
					foreach ($libs as $c){
						if (!in_array($c, $lib_acc) && !in_array($c, $mod_acc)){
							echo 'You are not cleared to use this page';
							exit;
						}
					}
				}
				$art = $fiction->GetFiction($_REQUEST['fiction_id']);
				
				if ($_REQUEST['post']){
					$go = true;
					if ($art->date == -1){
						$comp = $art->Competition();
						if ($comp->graded == 0){
							if ($comp->CanGrade()){
								$go = false;
							}
						}
					}
					if ($go){
						$q = $art->Edit($_REQUEST['title'], $_REQUEST['text'], $_REQUEST['publish'], $_REQUEST['libr']);
						$h = $art->GetPerson();
						echo $_REQUEST['title'].' was '.($q ? 'edited and '.($_REQUEST['publish'] ? 'published' : 'logged').' into '.$h->GetName().'\'s library.' 
						: ' not edited, due to errors. ');
					} else {
						echo 'You cannot edit this fiction';
					}
					
				} elseif ($_REQUEST['fiction_id']) {
					$form = new Form($_SERVER['PHP_SELF']);
					$form->AddSectionTitle('Edit Fiction');
					$form->AddHidden('id', $_REQUEST['id']);
					$per = $art->GetPerson();
					$form->table->AddRow('Poster:', $per->GetName());
					$lib = $art->GetLibrary();
					$form->AddHidden('libr', $lib->GetID());
					$form->AddTextBox('Title:', 'title', $art->GetTitle(), 60);
					$form->table->AddRow('Word Count:', number_format(str_word_count(strip_tags($art->GetCount()))));
					$form->AddTextArea('Fiction:', 'text', $art->GetFiction(false), 30, 80);
					if ($art->date != -1){
						$form->AddCheckBox('Publish?', 'publish', 1, ($art->Published() > 0));
					}
					$form->AddHidden('fiction_id', $_REQUEST['fiction_id']);
					$form->AddHidden('mod', 'edit-fictions');
					$form->AddSubmitButton('post', 'Edit Fiction');
					
					$form->EndForm();
				} elseif ($_REQUEST['hunter_id']) {
					$form = new Form($_SERVER['PHP_SELF']);
					$form->AddSectionTitle('Edit Fiction');
					$form->AddHidden('id', $_REQUEST['id']);
					$form->StartSelect('Fiction:', 'fiction_id');
					foreach ($fiction->BuildLibrary($_REQUEST['hunter_id'], true) as $id=>$fiction){
						$form->AddOption($id, $fiction);
					}
					$form->EndSelect();
					
					$form->AddHidden('mod', 'edit-fictions');
					$form->AddSubmitButton('eddt', 'Edit Fiction');
					
					$form->EndForm();
				} elseif ($_REQUEST['library_id'] || $_REQUEST['id']) {
					$form = new Form($_SERVER['PHP_SELF']);
					$form->AddSectionTitle('Edit Fiction');
					
					$lib = ($_REQUEST['library_id'] ? $_REQUEST['library_id'] : $_REQUEST['id']);
					$form->AddHidden('id', $_REQUEST['id']);
					$form->StartSelect('Hunter:', 'hunter_id');
					foreach ($fiction->WritersList(array($lib)) as $id=>$fiction){
						$form->AddOption($id, $fiction);
					}
					$form->EndSelect();
					
					$form->AddHidden('mod', 'edit-fictions');
					$form->AddSubmitButton('eddt', 'View Fictions');
					
					$form->EndForm();
				
				} else {
					$form = new Form($_SERVER['PHP_SELF']);
					$form->AddSectionTitle('Edit Fiction');
					
					$form->StartSelect('Library:', 'library_id');
					foreach ($fiction->Libraries(true) as $lib){
						$form->AddOption($lib->GetID(), $lib->GetName());
					}
					$form->EndSelect();
					
					$form->AddHidden('mod', 'edit-fictions');
					$form->AddSubmitButton('eddt', 'View Hunters');
					
					$form->EndForm();
				}
			break;
			
			case 'edit-comm':
				if (!$FAMOD && $_REQUEST['id']){
					$libs = explode(',', $_REQUEST['id']);
					foreach ($libs as $c){
						if (!in_array($c, $mod_acc)){
							echo 'You are not cleared to use this page';
							exit;
						}
					}
				}
				if ($_REQUEST['edtb']){
					$art = $fiction->GetBook($_REQUEST['fiction_id']);
				} else {
					$art = $fiction->GetFiction($_REQUEST['fiction_id']);
				}
				
				if ($_REQUEST['post']){
					$errors = 0;
					if (is_array($_REQUEST['del'])){
						foreach ($_REQUEST['del'] as $id=>$a){
							$q = $art->DeleteComment($id);
							$errors += ($q ? 1 : 0);
						}
					}
					echo $errors.' comment'.(($errors != 1) ? 's ' : ' ').($errors ? 'successfully deleted.' : 'not deleted, due to errors.');
				} elseif ($_REQUEST['fiction_id']) {
					$form = new Form($_SERVER['PHP_SELF']);
					$form->AddSectionTitle('Delete Comments');
					$form->AddHidden('id', $_REQUEST['id']);
					
					if (count($art->GetComments())){
						foreach ($art->GetComments() as $id=>$comm){
							$form->AddCheckBox($comm['per']->GetName(), 'del['.$id.']', 1);
							$form->table->AddRow($comm['datefrmt'], $comm['comment']);
						}
					}
					
					$form->AddHidden('fiction_id', $_REQUEST['fiction_id']);
					$form->AddHidden('mod', 'edit-comm');
					$form->AddHidden('edtb', $_REQUEST['edtb']);
					$form->AddSubmitButton('post', 'Delete Checked Comments');
					
					$form->EndForm();
				} elseif ($_REQUEST['hunter_id']) {
					$form = new Form($_SERVER['PHP_SELF']);
					$form->AddSectionTitle('Edit Comments - Fictions');
					$form->AddHidden('id', $_REQUEST['id']);
					$form->StartSelect('Fiction:', 'fiction_id');
					foreach ($fiction->BuildLibrary($_REQUEST['hunter_id'], true) as $id=>$ficion){
						$form->AddOption($id, $ficion);
					}
					$form->EndSelect();
					
					$form->AddHidden('mod', 'edit-comm');
					$form->AddSubmitButton('eddt', 'View Comments');
					$form->EndForm();
					
					hr();
					
					$form = new Form($_SERVER['PHP_SELF']);
					$form->AddSectionTitle('Edit Comments - Books');
					$form->AddHidden('id', $_REQUEST['id']);
					$form->StartSelect('Book:', 'fiction_id');
					foreach ($fiction->BookLibrary($_REQUEST['hunter_id'], true) as $id=>$fiction){
						$form->AddOption($id, $fiction);
					}
					$form->EndSelect();
					
					$form->AddHidden('mod', 'edit-comm');
					$form->AddSubmitButton('edtb', 'View Books');
					
					$form->EndForm();
				} elseif ($_REQUEST['library_id'] || $_REQUEST['id']) {
					$form = new Form($_SERVER['PHP_SELF']);
					$form->AddSectionTitle('Edit Comments');
					
					$lib = ($_REQUEST['library_id'] ? $_REQUEST['library_id'] : $_REQUEST['id']);
					$form->AddHidden('id', $_REQUEST['id']);
					$form->StartSelect('Hunter:', 'hunter_id');
					foreach ($fiction->WritersList(array($lib)) as $id=>$fiction){
						$form->AddOption($id, $fiction);
					}
					$form->EndSelect();
					
					$form->AddHidden('mod', 'edit-comm');
					$form->AddSubmitButton('eddt', 'View Fictions');
					
					$form->EndForm();
				
				} else {
					$form = new Form($_SERVER['PHP_SELF']);
					$form->AddSectionTitle('Edit Fiction');
					
					$form->StartSelect('Library:', 'library_id');
					foreach ($fiction->Libraries(true) as $lib){
						$form->AddOption($lib->GetID(), $lib->GetName());
					}
					$form->EndSelect();
					
					$form->AddHidden('mod', 'edit-comm');
					$form->AddSubmitButton('eddt', 'View Hunters');
					
					$form->EndForm();
				}
			break;
			
			case 'move-fictions':
				if (!$FAMOD && $_REQUEST['id']){
					$libs = explode(',', $_REQUEST['id']);
					foreach ($libs as $c){
						if (!in_array($c, $lib_acc) && !in_array($c, $mod_acc)){
							echo 'You are not cleared to use this page';
							exit;
						}
					}
				}
				$art = $fiction->GetFiction($_REQUEST['fiction_id']);
				
				if ($_REQUEST['post']){
					$q = $art->Edit($_REQUEST['title'], $_REQUEST['text'], $_REQUEST['publish'], $_REQUEST['libr']);
					$lib = $fiction->GetLibrary($_REQUEST['libr']);
					echo $_REQUEST['title'].' was '.($q ? 'moved into the '.$lib->GetName().' library.' 
					: ' not moved, due to errors. ');
				} elseif ($_REQUEST['fiction_id']) {
					$form = new Form($_SERVER['PHP_SELF']);
					$form->AddSectionTitle('Move Fiction');
					$form->AddHidden('id', $_REQUEST['id']);
					$per = $art->GetPerson();
					$form->table->AddRow('Poster:', $per->GetName());
					$form->table->AddRow('Title:', $art->GetTitle());
					$lib = $art->GetLibrary();
					
					$form->StartSelect('Library:', 'libr', $lib->GetID());
					if (is_array($libs) && count($libs)){
						if (!in_array(1, $libs)){
							$libs[] = 1;
						}
						foreach ($libs as $lib){
							$lib = $fiction->GetLibrary($lib);
							$form->AddOption($lib->GetID(), $lib->GetName());
						}
					} else {
						foreach ($fiction->Libraries(true) as $lib){
							$form->AddOption($lib->GetID(), $lib->GetName());
						}
					}
					$form->EndSelect();
					
					$form->AddHidden('title', $art->GetTitle());
					$form->AddHidden('text', $art->GetFiction(false));
					$form->AddHidden('publish', (($art->Published() > 0) ? 1 : 0));
					$form->AddHidden('fiction_id', $_REQUEST['fiction_id']);
					$form->AddHidden('mod', 'move-fictions');
					$form->AddSubmitButton('post', 'Set Library');
					
					$form->EndForm();
				} elseif ($_REQUEST['hunter_id']) {
					$form = new Form($_SERVER['PHP_SELF']);
					$form->AddSectionTitle('Move Fiction');
					$form->AddHidden('id', $_REQUEST['id']);
					$form->StartSelect('Fiction:', 'fiction_id');
					foreach ($fiction->BuildLibrary($_REQUEST['hunter_id'], true) as $id=>$fiction){
						$form->AddOption($id, $fiction);
					}
					$form->EndSelect();
					
					$form->AddHidden('mod', 'move-fictions');
					$form->AddSubmitButton('eddt', 'Edit Fiction');
					
					$form->EndForm();
				} elseif ($_REQUEST['library_id'] || $_REQUEST['id']) {
					$form = new Form($_SERVER['PHP_SELF']);
					$form->AddSectionTitle('Move Fiction');

					$lib = ($_REQUEST['library_id'] ? $_REQUEST['library_id'] : $_REQUEST['id']);
					
					$form->AddHidden('id', $_REQUEST['id']);
					$form->StartSelect('Hunter:', 'hunter_id');
					foreach ($fiction->WritersList(array($lib)) as $id=>$fiction){
						$form->AddOption($id, $fiction);
					}
					$form->EndSelect();
					
					$form->AddHidden('mod', 'move-fictions');
					$form->AddSubmitButton('eddt', 'Move Fiction');
					
					$form->EndForm();
				
				} else {
					$form = new Form($_SERVER['PHP_SELF']);
					$form->AddSectionTitle('Move Fiction');
					
					$form->StartSelect('Library:', 'library_id');
					foreach ($fiction->Libraries(true) as $lib){
						$form->AddOption($lib->GetID(), $lib->GetName());
					}
					$form->EndSelect();
					
					$form->AddHidden('mod', 'move-fictions');
					$form->AddSubmitButton('eddt', 'View Hunters');
					
					$form->EndForm();
				}
			break;
			
			case 'edit-libr':
				if (!$FAMOD && $_REQUEST['id']){
					$libs = explode(',', $_REQUEST['id']);
					foreach ($libs as $c){
						if (!in_array($c, $mod_acc)){
							echo 'You are not cleared to use this page';
							exit;
						}
					}
				}
				if ($_REQUEST['post']){
					if ($_REQUEST['person'] || $_REQUEST['position'] || ($_REQUEST['division'] && $_REQUEST['position'])){
						if ($_REQUEST['person'] && ($_REQUEST['position'] || ($_REQUEST['division'] && $_REQUEST['position']))){
							echo 'You cannot set that many options for an admin. Person only, Position only, or Position/Division';
						} else {
							$q = $fiction->NewAdmin($_REQUEST['person'], $_REQUEST['position'], $_REQUEST['division'],
							$_REQUEST['library_id'], 0, 1, 0);
							echo 'New Librarian was '.($q ? ' added.' : ' not added, due to errors.');
						}
					} else {
						echo 'You must set either a Person, a Position, or a Position/Division combination';
					}
				} elseif ($_REQUEST['view']){
					$form = new Form($_SERVER['PHP_SELF']);

					$i = 1;
					echo '<table border=0 width=100% align=center>';
					foreach ($fiction->LibraryAdmin($_REQUEST['library_id']) as $id=>$lib){
						if ($lib['libr']){
							if ($i == 1){
								echo '<tr>';
								
							}
							echo '<td valign=top>';
							$table = new Table();
							($lib['person']->GetID() ? $table->AddRow('Person:', substr($lib['person']->GetName(), 0, 10).((strlen($lib['person']->GetName()) > 10) ? '...' : '')) : '');
							($lib['position']->GetID() ? $table->AddRow('Position:', $lib['position']->GetName()) : '');
							($lib['division']->GetID() ? $table->AddRow('Division:', $lib['division']->GetName()) : '');
							$table->AddRow('Librarian:', ($lib['libr'] ? 'Remove <input type=checkbox name=rlibr['.$id.'] value=1>' : 'Add <input type=checkbox name=libr['.$id.'] value=1>'));
							$table->EndTable();
							echo '</td>';
							if ($i == 3){
								echo '</tr>';
								$i = 0;
							}
							$i++;
						}
					}
					echo '</table>';
					$form->AddHidden('mod', 'edit-libr');
					$form->AddHidden('id', $_REQUEST['id']);
					echo '<table border=0 width=100% align=center><tr><td>';
					echo '<input type=submit name=fix0r value="Alter Administrators">';
					echo '</td></tr></table>';
					$form->EndForm();
				} elseif ($_REQUEST['fix0r']){
					$error = 0;
					if (is_array($_REQUEST['rlibr'])){
						foreach ($_REQUEST['rlibr'] as $id=>$a){
							$e = $fiction->AdminFix($id, 'librarian', 0);
							$error += ($e ? 0 : 1);
						}
					}
					if (is_array($_REQUEST['libr'])){
						foreach ($_REQUEST['libr'] as $id=>$a){
							$e = $fiction->AdminFix($id, 'librarian', 1);
							$error += ($e ? 0 : 1);
						}
					}
					echo ($error ? 'Errors occured. Admin not' : 'All edits successfully').' processed.';	
				} else {
					$form = new Form($_SERVER['PHP_SELF']);
					$form->AddSectionTitle('New Librarian');

					HunterList($form);
					
					$form->StartSelect('Position:', 'position');
					$form->AddOption(0, '');
					foreach ($roster->GetPositions() as $position){
						$form->AddOption($position->GetID(), $position->GetName());
					}
					$form->EndSelect();
					
					$form->StartSelect('Division:', 'division');
					$form->AddOption(0, '');
					foreach ($roster->GetDivisions() as $division){
						$form->AddOption($division->GetID(), $division->GetName());
					}
					$form->EndSelect();
					
					$form->StartSelect('Library:', 'library_id');
					if (is_array($libs) && count($libs)){
						foreach ($libs as $lib){
							$lib = $fiction->GetLibrary($lib);
							$form->AddOption($lib->GetID(), $lib->GetName());
						}
					} else {
						foreach ($fiction->Libraries(true) as $lib){
							$form->AddOption($lib->GetID(), $lib->GetName());
						}
					}
					$form->EndSelect();
					$form->AddHidden('id', $_REQUEST['id']);
					$form->AddHidden('mod', 'edit-libr');
					$form->AddSubmitButton('post', 'Make Librarian');
					
					$form->EndForm();
					
					hr();
					
					$form = new Form($_SERVER['PHP_SELF']);
					$form->AddSectionTitle('Current Librarians');
					
					$form->StartSelect('Library:', 'library_id');
					if (is_array($libs) && count($libs)){
						foreach ($libs as $lib){
							$lib = $fiction->GetLibrary($lib);
							$form->AddOption($lib->GetID(), $lib->GetName());
						}
					} else {
						foreach ($fiction->Libraries(true) as $lib){
							$form->AddOption($lib->GetID(), $lib->GetName());
						}
					}
					$form->EndSelect();
					$form->AddHidden('id', $_REQUEST['id']);
					
					$form->AddHidden('mod', 'edit-libr');
					$form->AddSubmitButton('view', 'View Librarians');
					
					$form->EndForm();
				}
			break;
			
			case 'edit-comp':
				if (!$FAMOD && $_REQUEST['id']){
					$libs = explode(',', $_REQUEST['id']);
					foreach ($libs as $c){
						if (!in_array($c, $mod_acc)){
							echo 'You are not cleared to use this page';
							exit;
						}
					}
				}
				if ($_REQUEST['post']){
					if ($_REQUEST['person'] || $_REQUEST['position'] || ($_REQUEST['division'] && $_REQUEST['position'])){
						if ($_REQUEST['person'] && ($_REQUEST['position'] || ($_REQUEST['division'] && $_REQUEST['position']))){
							echo 'You cannot set that many options for an admin. Person only, Position only, or Position/Division';
						} else {
							$q = $fiction->NewAdmin($_REQUEST['person'], $_REQUEST['position'], $_REQUEST['division'],
							$_REQUEST['library_id'], 0, 0, 1);
							echo 'New Competition Admin was '.($q ? ' added.' : ' not added, due to errors.');
						}
					} else {
						echo 'You must set either a Person, a Position, or a Position/Division combination';
					}
				} elseif ($_REQUEST['view']){
					$form = new Form($_SERVER['PHP_SELF']);

					$i = 1;
					echo '<table border=0 width=100% align=center>';
					foreach ($fiction->LibraryAdmin($_REQUEST['library_id']) as $id=>$lib){
						if ($lib['comp']){
							if ($i == 1){
								echo '<tr>';
								
							}
							echo '<td valign=top>';
							$table = new Table();
							($lib['person']->GetID() ? $table->AddRow('Person:', substr($lib['person']->GetName(), 0, 10).((strlen($lib['person']->GetName()) > 10) ? '...' : '')) : '');
							($lib['position']->GetID() ? $table->AddRow('Position:', $lib['position']->GetName()) : '');
							($lib['division']->GetID() ? $table->AddRow('Division:', $lib['division']->GetName()) : '');
							$table->AddRow('Competition:', ($lib['comp'] ? 'Remove <input type=checkbox name=rlibr['.$id.'] value=1>' : 'Add <input type=checkbox name=libr['.$id.'] value=1>'));
							$table->EndTable();
							echo '</td>';
							if ($i == 3){
								echo '</tr>';
								$i = 0;
							}
							$i++;
						}
					}
					echo '</table>';
					$form->AddHidden('mod', 'edit-comp');
					$form->AddHidden('id', $_REQUEST['id']);
					echo '<table border=0 width=100% align=center><tr><td>';
					echo '<input type=submit name=fix0r value="Alter Administrators">';
					echo '</td></tr></table>';
					$form->EndForm();
				} elseif ($_REQUEST['fix0r']){
					$error = 0;
					if (is_array($_REQUEST['rlibr'])){
						foreach ($_REQUEST['rlibr'] as $id=>$a){
							$e = $fiction->AdminFix($id, 'competitions', 0);
							$error += ($e ? 0 : 1);
						}
					}
					if (is_array($_REQUEST['libr'])){
						foreach ($_REQUEST['libr'] as $id=>$a){
							$e = $fiction->AdminFix($id, 'competitions', 1);
							$error += ($e ? 0 : 1);
						}
					}
					echo ($error ? 'Errors occured. Admin not' : 'All edits successfully').' processed.';	
				} else {
					$form = new Form($_SERVER['PHP_SELF']);
					$form->AddSectionTitle('New Competition Admin');

					HunterList($form);
					
					$form->StartSelect('Position:', 'position');
					$form->AddOption(0, '');
					foreach ($roster->GetPositions() as $position){
						$form->AddOption($position->GetID(), $position->GetName());
					}
					$form->EndSelect();
					
					$form->StartSelect('Division:', 'division');
					$form->AddOption(0, '');
					foreach ($roster->GetDivisions() as $division){
						$form->AddOption($division->GetID(), $division->GetName());
					}
					$form->EndSelect();
					
					$form->StartSelect('Library:', 'library_id');
					if (is_array($libs) && count($libs)){
						foreach ($libs as $lib){
							$lib = $fiction->GetLibrary($lib);
							$form->AddOption($lib->GetID(), $lib->GetName());
						}
					} else {
						foreach ($fiction->Libraries(true) as $lib){
							$form->AddOption($lib->GetID(), $lib->GetName());
						}
					}
					$form->EndSelect();
					$form->AddHidden('id', $_REQUEST['id']);
					$form->AddHidden('mod', 'edit-comp');
					$form->AddSubmitButton('post', 'Make Competition Admin');
					
					$form->EndForm();
					
					hr();
					
					$form = new Form($_SERVER['PHP_SELF']);
					$form->AddSectionTitle('Current Competition Administrators');
					
					$form->StartSelect('Library:', 'library_id');
					if (is_array($libs) && count($libs)){
						foreach ($libs as $lib){
							$lib = $fiction->GetLibrary($lib);
							$form->AddOption($lib->GetID(), $lib->GetName());
						}
					} else {
						foreach ($fiction->Libraries(true) as $lib){
							$form->AddOption($lib->GetID(), $lib->GetName());
						}
					}
					$form->EndSelect();
					$form->AddHidden('id', $_REQUEST['id']);
					
					$form->AddHidden('mod', 'edit-comp');
					$form->AddSubmitButton('view', 'View Competition Admin');
					
					$form->EndForm();
				}
			break;
			
			case 'edit-libi':
				if (!$FAMOD && $_REQUEST['id']){
					$libs = explode(',', $_REQUEST['id']);
					foreach ($libs as $c){
						if (!in_array($c, $lib_acc) && !in_array($c, $mod_acc)){
							echo 'You are not cleared to use this page';
							exit;
						}
					}
				}
				$lib = $fiction->GetLibrary($_REQUEST['library_id']);
				if ($_REQUEST['post']){
					$q = $lib->Edit($_REQUEST['name'], $_REQUEST['text'], $_REQUEST['all']);
					echo $_REQUEST['name'].' was '.($q ? 'edited.' : ' not edited, due to errors.');
				} elseif ($_REQUEST['lib-edt']) {
					$form = new Form($_SERVER['PHP_SELF']);
					$form->AddSectionTitle('Edit Library');

					$form->AddTextBox('Name:', 'name', $lib->GetName(), 60);
					$form->AddTextArea('Description:', 'text', $lib->GetDescription(false));
					$form->AddHidden('all', (($lib->FullAccess() == 1) ? 1 : 0));
					$form->AddHidden('mod', 'edit-libi');
					$form->AddHidden('library_id', $_REQUEST['library_id']);
					$form->AddSubmitButton('post', 'Edit Library');
					
					$form->EndForm();
				} else {
					$form = new Form($_SERVER['PHP_SELF']);
					$form->AddSectionTitle('Edit Library');
					
					$form->StartSelect('Library:', 'library_id');
					if (is_array($libs) && count($libs)){
						foreach ($libs as $lib){
							$lib = $fiction->GetLibrary($lib);
							$form->AddOption($lib->GetID(), $lib->GetName());
						}
					} else {
						foreach ($fiction->Libraries(true) as $lib){
							$form->AddOption($lib->GetID(), $lib->GetName());
						}
					}
					$form->EndSelect();
					$form->AddHidden('id', $_REQUEST['id']);
					
					$form->AddHidden('mod', 'edit-libi');
					$form->AddSubmitButton('lib-edt', 'Edit Library');
					
					$form->EndForm();
				}
			break;
			
			case 'new-cmg':
				if (!$FAMOD){
					echo 'You are not cleared to use this page';
					exit;
				}
				if ($_REQUEST['post']){
					$q = $fiction->NewCompGuide($_REQUEST['name'], $_REQUEST['text']);
					echo $_REQUEST['name'].' was '.($q ? 'added.' : ' not added, due to errors.');
				} else {
					$form = new Form($_SERVER['PHP_SELF']);
					$form->AddSectionTitle('New Competition Guideline');

					$form->AddTextBox('Name:', 'name', '', 30);
					$form->AddTextBox('Description:', 'text', '', 60);
					$form->AddHidden('mod', 'new-cmg');
					$form->AddSubmitButton('post', 'Create Guideline');
					
					$form->EndForm();
				}
			break;
			
			case 'edit-cmg':
				if (!$FAMOD){
					echo 'You are not cleared to use this page';
					exit;
				}
				$lib = $fiction->GetGuide($_REQUEST['edit_id']);
				if ($_REQUEST['post']){
					$q = $lib->Edit($_REQUEST['name'], $_REQUEST['text']);
					echo $_REQUEST['name'].' was '.($q ? 'edited.' : ' not edited, due to errors.');
				} elseif ($_REQUEST['cmg-edt']) {
					$form = new Form($_SERVER['PHP_SELF']);
					$form->AddSectionTitle('Edit Competition Guide');

					$form->AddTextBox('Name:', 'name', $lib->GetName(), 30);
					$form->AddTextBox('Description:', 'text', $lib->GetDescription(false), 60);
					$form->AddHidden('mod', 'edit-cmg');
					$form->AddHidden('edit_id', $_REQUEST['edit_id']);
					$form->AddSubmitButton('post', 'Submit Edits');
					
					$form->EndForm();
				} else {
					$form = new Form($_SERVER['PHP_SELF']);
					$form->AddSectionTitle('Edit Competition Guide');
					
					$form->StartSelect('Guide:', 'edit_id');
					foreach ($fiction->CompGuides(true) as $lib){
						$form->AddOption($lib->GetID(), $lib->GetName());
					}
					$form->EndSelect();
					$form->AddHidden('mod', 'edit-cmg');
					$form->AddSubmitButton('cmg-edt', 'Edit Guide');
					
					$form->EndForm();
				}
			break;
			
			case 'del-cmg':
				if (!$FAMOD){
					echo 'You are not cleared to use this page';
					exit;
				}
				if ($_REQUEST['post']){
					$lib = $fiction->GetGuide($_REQUEST['edit_id']);
					$q = $lib->del(1);
					echo $lib->GetName().' was '.($q ? 'deleted.' : ' not deleted, due to errors.');
				} elseif ($_REQUEST['post-p']){
					$lib = $fiction->GetPack($_REQUEST['edit_id']);
					$q = $lib->del(1);
					echo $lib->GetName().' was '.($q ? 'deleted.' : ' not deleted, due to errors.');
				} else {
					$form = new Form($_SERVER['PHP_SELF']);
					$form->AddSectionTitle('Edit Competition Guide');
					
					$form->StartSelect('Guide:', 'edit_id');
					foreach ($fiction->CompGuides(true) as $lib){
						$form->AddOption($lib->GetID(), $lib->GetName());
					}
					$form->EndSelect();
					$form->AddHidden('mod', 'del-cmg');
					$form->AddSubmitButton('post', 'Delete Guide');
					
					$form->EndForm();
					
					hr();
					
					$form = new Form($_SERVER['PHP_SELF']);
					$form->AddSectionTitle('Edit Competition Pack');
					
					$form->StartSelect('Pack:', 'edit_id');
					foreach ($fiction->CompPacks(true) as $lib){
						$form->AddOption($lib->GetID(), $lib->GetName());
					}
					$form->EndSelect();
					$form->AddHidden('mod', 'del-cmg');
					$form->AddSubmitButton('post-p', 'Delete Pack');
					
					$form->EndForm();
				}
			break;
			
			case 'new-cmp':
				if (!$FAMOD){
					echo 'You are not cleared to use this page';
					exit;
				}
				if ($_REQUEST['post']){
					$q = $fiction->NewCompPack($_REQUEST['name'], $_REQUEST['text']);
					echo $_REQUEST['name'].' was '.($q ? 'added.' : ' not added, due to errors.');
				} else {
					$form = new Form($_SERVER['PHP_SELF']);
					$form->AddSectionTitle('New Competition Pack');

					$form->AddTextBox('Name:', 'name', '', 30);
					$form->AddTextBox('Description:', 'text', '', 60);
					$form->AddHidden('mod', 'new-cmp');
					$form->AddSubmitButton('post', 'Create Package');
					
					$form->EndForm();
				}
			break;
			
			case 'edit-cmp':
				if (!$FAMOD){
					echo 'You are not cleared to use this page';
					exit;
				}
				$lib = $fiction->GetPack($_REQUEST['edit_id']);
				if ($_REQUEST['post']){
					$q = $lib->Edit($_REQUEST['name'], $_REQUEST['text']);
					echo $_REQUEST['name'].' was '.($q ? 'edited.' : ' not edited, due to errors.');
				} elseif ($_REQUEST['cmp-edt']) {
					$form = new Form($_SERVER['PHP_SELF']);
					$form->AddSectionTitle('Edit Competition Package');

					$form->AddTextBox('Name:', 'name', $lib->GetName(), 30);
					$form->AddTextBox('Description:', 'text', $lib->GetDescription(false), 60);
					$form->AddHidden('mod', 'edit-cmp');
					$form->AddHidden('edit_id', $_REQUEST['edit_id']);
					$form->AddSubmitButton('post', 'Submit Edits');
					
					$form->EndForm();
				} else {
					$form = new Form($_SERVER['PHP_SELF']);
					$form->AddSectionTitle('Edit Competition Pack');
					
					$form->StartSelect('Package:', 'edit_id');
					foreach ($fiction->CompPacks(true) as $lib){
						$form->AddOption($lib->GetID(), $lib->GetName());
					}
					$form->EndSelect();
					$form->AddHidden('mod', 'edit-cmp');
					$form->AddSubmitButton('cmp-edt', 'Edit Package');
					
					$form->EndForm();
				}
			break;
			
			case 'pack':
				if (!$FAMOD){
					echo 'You are not cleared to use this page';
					exit;
				}
				$lib = $fiction->GetPack($_REQUEST['edit_id']);
				if ($_REQUEST['post']){
					$q = $lib->AddToPack($_REQUEST['guide'], $_REQUEST['points']);
					echo 'Contents were '.($q ? 'added.' : ' not added, due to errors.');
				} elseif ($_REQUEST['modify']) {
					$errors = 0;
					if (is_array($_REQUEST['del'])){
						foreach ($_REQUEST['del'] as $id=>$a){
							$b = $lib->RemoveFromPack($id);
							$errors += ($b ? 1 : 0);
						}
					}
					if (is_array($_REQUEST['pts'])){
						foreach ($_REQUEST['pts'] as $id=>$a){
							$b = $lib->UpdatePackPoints($id, $a);
							$errors += ($b ? 1 : 0);
						}
					}
					echo ($errors ? 'All edits processed.' : 'Errors occured, some edits may not have processed.');
				} elseif ($_REQUEST['edt']) {
					$fa = $lib->PackContents();
					$form = new Form($_SERVER['PHP_SELF']);

					foreach ($fa as $id=>$data){
						$form->AddSectionTitle($data['guide']->GetName());
						$form->AddCheckBox('Delete?', 'del['.$id.']', 1);
						$form->AddTextBox('Set Points:', 'pts['.$id.']', $data['points'], 5);
					}
					
					$form->AddHidden('mod', 'pack');
					$form->AddHidden('edit_id', $_REQUEST['edit_id']);
					$form->AddSubmitButton('modify', 'Build Pack');
					
					$form->EndForm();
				} elseif ($_REQUEST['pack-view']) {
					$form = new Form($_SERVER['PHP_SELF']);
					$form->AddSectionTitle('Add New Guideline');

					$form->AddTextBox('Points:', 'points', '', 5);
					$form->StartSelect('Guide:', 'guide');
					foreach ($fiction->CompGuides() as $liba){
						$form->AddOption($liba->GetID(), $liba->GetName());
					}
					$form->EndSelect();
					$form->AddHidden('mod', 'pack');
					$form->AddHidden('edit_id', $_REQUEST['edit_id']);
					$form->AddSubmitButton('post', 'Build Pack');
					
					$form->EndForm();
					
					hr();
					
					$form = new Form($_SERVER['PHP_SELF']);
					$form->AddSectionTitle('Edit/Delete Guideline');
					$form->table->AddRow('Total Points: ', $lib->PackPoints());
					$form->StartSelect('Guide :: Points:', 'guide');
					foreach ($lib->PackContents() as $id=>$lib){
						$form->AddOption($id, $lib['guide']->GetName().' :: '.$lib['points']);
					}
					$form->EndSelect();
					$form->AddHidden('mod', 'pack');
					$form->AddHidden('edit_id', $_REQUEST['edit_id']);
					$form->AddSubmitButton('edt', 'Edit Competition');
					
					$form->EndForm();
				} else {
					$form = new Form($_SERVER['PHP_SELF']);
					$form->AddSectionTitle('Manage Pack Contents');
					
					$form->StartSelect('Package:', 'edit_id');
					foreach ($fiction->CompPacks() as $lib){
						$form->AddOption($lib->GetID(), $lib->GetName());
					}
					$form->EndSelect();
					$form->AddHidden('mod', 'pack');
					$form->AddSubmitButton('pack-view', 'View Contents');
					
					$form->EndForm();
				}
			break;
			
			case 'comp-start':
				if (!$FAMOD && $_REQUEST['id']){
					$libs = explode(',', $_REQUEST['id']);
					foreach ($libs as $c){
						if (!in_array($c, $com_acc) && !in_array($c, $mod_acc)){
							echo 'You are not cleared to use this page';
							exit;
						}
					}
				}
				if ($_REQUEST['post']){
					$q = $fiction->NewCompetition($_REQUEST['library_id'], $_REQUEST['package_id'], $_REQUEST['text'],
						parse_date_box('starts'), parse_date_box('ends'));
					echo 'Competition was '.($q ? 'added.' : ' not added, due to errors.');
				} else {
					$form = new Form($_SERVER['PHP_SELF']);
					$form->AddSectionTitle('New Competition');

					$form->StartSelect('Library:', 'library_id');
					if (is_array($libs) && count($libs)){
						foreach ($libs as $lib){
							$lib = $fiction->GetLibrary($lib);
							$form->AddOption($lib->GetID(), $lib->GetName());
						}
					} else {
						foreach ($fiction->Libraries(true) as $lib){
							$form->AddOption($lib->GetID(), $lib->GetName());
						}
					}
					$form->EndSelect();
					
					$form->StartSelect('<a href="?pack">Package</a>:', 'package_id');
					foreach ($fiction->CompPacks() as $lib){
						$form->AddOption($lib->GetID(), $lib->GetName());
					}
					$form->EndSelect();
					
					$form->AddHidden('id', $_REQUEST['id']);
					$form->AddTextArea('Description:', 'text', '');
					$form->AddDateBox('Starts:', 'starts', time(), 1);
					$form->AddDateBox('Ends:', 'ends', time()+(3600*24*7), 1);
					$form->AddHidden('mod', 'comp-start');
					$form->AddSubmitButton('post', 'Add Competition');
					
					$form->EndForm();
				}
			break;
			
			case 'comp-edit':
				if (!$FAMOD && $_REQUEST['id']){
					$libs = explode(',', $_REQUEST['id']);
					foreach ($libs as $c){
						if (!in_array($c, $com_acc) && !in_array($c, $mod_acc)){
							echo 'You are not cleared to use this page';
							exit;
						}
					}
				}
				$lib = $fiction->GetComp($_REQUEST['edit_id']);
				if ($_REQUEST['post']){
					$q = $lib->Edit($_REQUEST['library_id'], $_REQUEST['package_id'], $_REQUEST['text'],
						parse_date_box('starts'), parse_date_box('ends'), 0);
					echo 'Competition was '.($q ? 'edited.' : ' not edited, due to errors.');
				} elseif ($_REQUEST['delete']){
					$q = $lib->del(1);
					echo 'Competition was '.($q ? 'deleted.' : ' not deleted, due to errors.');
				} elseif ($_REQUEST['cmp-edt']) {
					$form = new Form($_SERVER['PHP_SELF']);
					
					$form->AddHidden('id', $_REQUEST['id']);
					$form->AddHidden('edit_id', $_REQUEST['edit_id']);
					$form->AddHidden('mod', 'comp-edit');
					$form->table->AddRow('Delete?', '<input type="submit" name="delete" value="Yes">');
					
					$form->EndForm();
					
					hr();
					
					$form = new Form($_SERVER['PHP_SELF']);
					$form->AddSectionTitle('Edit Competition');

					$libr = $lib->GetLibrary();
					$form->StartSelect('Library:', 'library_id', $libr->GetID());
					if (is_array($libs) && count($libs)){
						foreach ($libs as $libr){
							$libr = $fiction->GetLibrary($libr);
							$form->AddOption($libr->GetID(), $libr->GetName());
						}
					} else {
						foreach ($fiction->Libraries(true) as $libr){
							$form->AddOption($libr->GetID(), $libr->GetName());
						}
					}
					$form->EndSelect();
					
					$pack = $lib->GetPack();
					
					$form->StartSelect('<a href="?pack='.$pack->GetID().'">Package</a>:', 'package_id', $pack->GetID());
					foreach ($fiction->CompPacks() as $libr){
						$form->AddOption($libr->GetID(), $libr->GetName());
					}
					$form->EndSelect();
					
					$form->AddHidden('id', $_REQUEST['id']);
					$form->AddTextArea('Description:', 'text', $lib->GetDescription(false));
					$form->AddDateBox('Starts:', 'starts', $lib->Starts());
					$form->AddDateBox('Ends:', 'ends', $lib->Ends());
					$form->AddHidden('edit_id', $_REQUEST['edit_id']);
					$form->AddHidden('mod', 'comp-edit');
					$form->AddSubmitButton('post', 'Edit Competition');
					
					$form->EndForm();
				} else {
					$form = new Form($_SERVER['PHP_SELF']);
					$form->AddSectionTitle('Edit Competition');
					
					$form->StartSelect('Competition:', 'edit_id');
					if (!count($libs)){
						foreach ($fiction->Libraries(true) as $libr){
							$libs[] = $libr->GetID();
						}
					}
					foreach ($fiction->EditableComps($libs) as $lib){
						$libr = $lib->GetLibrary();
						$form->AddOption($lib->GetID(), 'Starts: '.$lib->Starts(true).' || Library: '.$libr->GetName());
					}
					$form->EndSelect();
					$form->AddHidden('mod', 'comp-edit');
					$form->AddHidden('id', $_REQUEST['id']);
					$form->AddSubmitButton('cmp-edt', 'Edit Competition');
					
					$form->EndForm();
				}
			break;
			
			case 'grade-comp':
				if (!$FAMOD && $_REQUEST['id']){
					$libs = explode(',', $_REQUEST['id']);
					foreach ($libs as $c){
						if (!in_array($c, $com_acc) && !in_array($c, $mod_acc)){
							echo 'You are not cleared to use this page';
							exit;
						}
					}
				}
				$lib = $fiction->GetComp($_REQUEST['edit_id']);
				if ($_REQUEST['schupa_grade']){
					$lib->ReRank();
					if ($lib->CanGrade()){
						$q = $lib->Grade();
						echo 'Competition was '.($q ? 'graded.' : ' not graded, due to errors.');
					} else {
						echo 'Already graded.';
					}
				} elseif ($_REQUEST['post']){
					$q = $lib->GradeComp($_REQUEST['grade'], $login->GetID());
					echo 'Competition was '.($q ? 'graded.' : ' not graded, due to errors.');
					$lib->ReRank();
				} elseif ($_REQUEST['cmp-edt']) {
					$views = false;
					if ($lib->CanGrade($login->GetID()) || isset($_REQUEST['fskup'])){
						echo '<h4 align=center>Notice</h4>Submit your grades at your convenience. However, if you do not finish completely, be sure to inform the Moderator of this library, so they do not close the competition before your grades are in.';
						$form = new Form($_SERVER['PHP_SELF']);
						$form->table->startrow();
						$form->table->AddCell($lib->GetDescription(), 2);
						$form->table->EndRow();
						$pack = $lib->GetPack();
						if (isset($_REQUEST['fskup'])){
							$base = $lib->BooBoo($login->GetID());
						}
						$def = '';
						foreach ($lib->GetSubmissions() as $id=>$roll){								
							$p = $roll['fic']->GetPerson();
							$form->AddSectionTitle($p->GetName());
							//$form->AddCheckBox('Disqualify:', 'del['.$roll['fic']->GetID().']', 1);
							$form->table->AddRow('Fiction:', '<a target="viewf" href="?compview='.$roll['fic']->GetID().'">'.
								$roll['fic']->GetTitle().'</a>');
							$ar = array();
							foreach ($pack->PackContents() as $id=>$cnt){
								if (is_array($base)){
									$ar[$cnt['points']][] = 1;
									$i = (count($ar[$cnt['points']])-1);
									$def = $base[$cnt['points']][$roll['fic']->GetID()][$i];
								}
								$form->AddTextBox($cnt['guide']->GetName().' (xx/'.$cnt['points'].')', 'grade['.
									$cnt['points'].']['.$roll['fic']->GetID().'][]', $def, 5);
							}
						}
						
						$form->AddHidden('id', $_REQUEST['id']);
						$form->AddHidden('edit_id', $_REQUEST['edit_id']);
						$form->AddHidden('mod', 'grade-comp');
						$form->AddSubmitButton('post', 'Grade Submissions');
						$form->EndForm(); 
						
						hr();
					} else {	
						
						$form = new Form($_SERVER['PHP_SELF']);
						$form->AddHidden('id', $_REQUEST['id']);
						$form->AddHidden('edit_id', $_REQUEST['edit_id']);
						$form->AddHidden('mod', 'grade-comp');
						$form->AddHidden('fskup', 1);
						$form->AddSubmitButton('cmp-edt', 'Regrade Submission!');
						$form->EndForm();
						
						hr();
						
						echo '<h5 align=center>Note</h5> The word counts are aproximate, due to webformatting. However, they are acurate to about 120 words.<br />If the person violates the word count by less than 120, the chance is they have violated the word count limit, and it is suggested you check the file in Word or some other Text Processor to ensure the violation.';					
						$table = new Table();
						$table->StartRow();
						$table->AddHeader('Fiction');
						$table->AddHeader('Person');
						$table->AddHeader('Current Rank');
						$table->AddHeader('Total Score');
						$table->EndRow();
						foreach ($lib->GetSubmissions() as $sub){
							$p = $sub['fic']->GetPerson();
							$table->AddRow('<a target="viewf" href="?compview='.$sub['fic']->GetID().'">'.
								$sub['fic']->GetTitle().'</a>', $p->GetName(), number_format($sub['rank']), number_format($sub['score']));
						}
						$table->EndTable();
						
						hr();
						$views = true;
					}
					$shown = false;
					$libs = explode(',', $_REQUEST['id']);
					foreach ($libs as $c){
						if (in_array($c, $mod_acc) || $FAMOD){
							if (!$shown){
								if ($lib->CanGrade()){
									$form = new Form($_SERVER['PHP_SELF']);
							
									$form->table->StartRow();
									$form->table->AddCell($lib->PercentGraded(), 2);
									$form->table->EndRow();
									$form->AddHidden('edit_id', $_REQUEST['edit_id']);
									$form->AddHidden('mod', 'grade-comp');
									$form->AddSubmitButton('schupa_grade', 'Finalize Grades and Determine Winners');
									
									$form->EndForm();
									$shown = true;
								} else {																	
									$form = new Form($_SERVER['PHP_SELF']);
							
									foreach ($lib->GetSubmissions() as $id=>$roll){
										$p = $roll['fic']->GetPerson();
										$form->AddCheckBox($p->GetName() . ' :: <a target="viewf" href="?compview='.$roll['fic']->GetID().'">'.
								$roll['fic']->GetTitle().'</a>', 'del['.$roll['fic']->GetID().']', 1);
									}
									
									$form->AddHidden('id', $_REQUEST['id']);
									$form->AddHidden('edit_id', $_REQUEST['edit_id']);
									$form->AddHidden('mod', 'grade-comp');
									$form->AddSubmitButton('delete', 'Delete Marked Submissions');
									
									$form->EndForm();
								}							
							}
						}
					}
					
					if ($FAMOD && !$views){
						echo '<h5 align=center>FA Mods</h5>The current standings. Make sure they\'re not retarded.';					
						$table = new Table();
						$table->StartRow();
						$table->AddHeader('Fiction');
						$table->AddHeader('Person');
						$table->AddHeader('Current Rank');
						$table->AddHeader('Total Score');
						$table->EndRow();
						foreach ($lib->GetSubmissions() as $sub){
							$p = $sub['fic']->GetPerson();
							$table->AddRow('<a target="viewf" href="?compview='.$sub['fic']->GetID().'">'.
								$sub['fic']->GetTitle().'</a>', $p->GetName(), number_format($sub['rank']), number_format($sub['score']));
						}
						$table->EndTable();
						
						hr();
					}
					
				} else {
					$form = new Form($_SERVER['PHP_SELF']);
					$form->AddSectionTitle('Grade/View Competition');
					
					$form->StartSelect('Competition:', 'edit_id');
					if (!count($libs)){
						foreach ($fiction->Libraries(true) as $libr){
							$libs[] = $libr->GetID();
						}
					}
					foreach ($fiction->GradeableComps($libs) as $lib){
						$libr = $lib->GetLibrary();
						$form->AddOption($lib->GetID(), 'Starts: '.$lib->Starts(true).' || Library: '.$libr->GetName());
					}
					$form->EndSelect();
					$form->AddHidden('mod', 'grade-comp');
					$form->AddHidden('id', $_REQUEST['id']);
					$form->AddSubmitButton('cmp-edt', 'View Submissions');
					
					$form->EndForm();
				}
			break;
			
			default:
				if ($login->GetID() == 2650 || $pos->GetID() == 5){
					$table = new Table();
					$table->StartRow();
					$table->AddHeader('Library Control Options', 3);
					$table->EndRow();
					
					$table->StartRow();
					$table->AddCell('<a href="?mod=lib">New Library Section</a>');
					$table->AddCell('<a href="?mod=rest">Library Restrictions</a>');
					$table->AddCell('<a href="?mod=lib-key">Set New Library Key</a>');
					$table->EndRow();

					$table->EndTable();
					
					hr();
					
				}
				
				if ($login->GetID() == 2650 || $fiction->FAMod($login->GetID()) || $pos->GetID() == 5){
					$table = new Table();
					$table->StartRow();
					$table->AddHeader('Archive Moderator Options', 3);
					$table->EndRow();
					
					$table->StartRow();
					$table->AddCell('<a href="?mod=edit-fictions">Edit Fictions</a>');
					$table->AddCell('<a href="?mod=move-fictions">Move Fictions</a>');
					$table->AddCell('<a href="?mod=make-fiction">New Fiction</a>');
					$table->EndRow();
					
					$table->StartRow();
					$table->AddCell('<a href="?mod=lib-edit">Edit Library Section</a>');
					$table->AddCell('<a href="?mod=lib-admin">Library Administrators</a>');
					$table->AddCell('<a href="?mod=edit-comm">Delete Comments</a>');
					$table->EndRow();
					
					$table->StartRow();
					$table->AddCell('<a href="?mod=del-cmg">Delete Guideline/Pack</a>');
					$table->AddCell('<a href="?mod=new-cmg">New Competition Guideline</a>');
					$table->AddCell('<a href="?mod=edit-cmg">Edit Competition Guideline</a>');
					$table->EndRow();
					
					$table->StartRow();
					$table->AddCell('<a href="?mod=new-cmp">New Competition Package</a>');
					$table->AddCell('<a href="?mod=edit-cmp">Edit Competition Package</a>');
					$table->AddCell('<a href="?mod=pack">Manage Pack Contents</a>');
					$table->EndRow();
					
					$table->StartRow();
					$table->AddCell('<a href="?mod=comp-start">Start Competition</a>');
					$table->AddCell('<a href="?mod=comp-edit">Edit Competition</a>');
					$table->AddCell('<a href="?mod=grade-comp">Grade Comp/View Entries</a>');
					$table->EndRow();

					$table->EndTable();
					
					hr();
				}
				
				if ($login->GetID() == 2650 || (count($access) && !$fiction->FAMod($login->GetID()))){
					$table = new Table();
					$librar = false;
					$compep = false;
					
					if (count($mod)){
						$id = array();
						foreach ($mod as $idr=>$libr){
							$id[$idr] = $libr;
						}
						$id = implode(',', array_keys($id));
						
						$liba = true;
						$coma = true;
							$table->StartRow();
							$table->AddHeader('Moderator Options', 3);
							$table->EndRow();

							$table->StartRow();
							$table->AddCell('<a href="?mod=edit-libr&id='.$id.'">Edit Librarians</a>');
							$table->AddCell('<a href="?mod=edit-comp&id='.$id.'">Edit Competition Access</a>');
							$table->AddCell('<a href="?mod=edit-comm&id='.$id.'">Delete Comments</a>');
							$table->EndRow();
					}
					
					if (count($lib) || $liba){
						$id = array();
						foreach ($mod as $idr=>$libr){
							$id[$idr] = $libr;
						}
						foreach ($lib as $idr=>$libr){
							$id[$idr] = $libr;
						}
						$id = implode(',', array_keys($id));
						
						$table->StartRow();
						$table->AddHeader('Librarian Options', 3);
						$table->EndRow();
							
						$table->StartRow();
						$table->AddCell('<a href="?mod=edit-fictions&id='.$id.'">Edit Fictions</a>');
						$table->AddCell('<a href="?mod=move-fictions&id='.$id.'">Move Fictions</a>');
						$table->AddCell('<a href="?mod=edit-libi&id='.$id.'">Edit Library Information</a>');
						$table->EndRow();
					}
					
					if (count($com) || $coma){
						$id = array();
						foreach ($mod as $idr=>$libr){
							$id[$idr] = $libr;
						}
						foreach ($com as $idr=>$libr){
							$id[$idr] = $libr;
						}
						$id = implode(',', array_keys($id));
						
						$table->StartRow();
						$table->AddHeader('Competition Options', 3);
						$table->EndRow();
							
						$table->StartRow();
						$table->AddCell('<a href="?mod=comp-start&id='.$id.'">Start Competition</a>');
						$table->AddCell('<a href="?mod=comp-edit&id='.$id.'">Edit Competition</a>');
						$table->AddCell('<a href="?mod=grade-comp&id='.$id.'">Grade Comp/View Entries</a>');
						$table->EndRow();
					}
					
					$table->EndTable();
					
					hr();
				}
				
				$fix = $fiction->OpenCompetitions($login->GetID());
				$fics = array();
				foreach ($fix as $fic){
					if ($fic->CanSubmit($login->GetID())){
						$fics[] = $fic;
					}
				}
				
				if (count($fics)){
					$form = new Form($page);
					$form->AddSectionTitle('Submit to Competition');
					$form->table->StartRow();
					$form->table->AddCell('<h4 align=center>Note</h4>If you are trying to submit to a competition, select it from the dropdown box below, and use that form.<br /> That is the <b>only</b> way to put your fiction into a competition.', 2);
					$form->table->EndRow();
					$form->StartSelect('Competition:', 'comp_id');
					foreach ($fics as $fic){
						$libr = $fic->GetLibrary();
						$form->AddOption($fic->GetID(), 'Starts: '.$fic->Starts(true).' || Library: '.$libr->GetName());
					}
					$form->EndSelect();
					$form->AddSubmitButton('view-comp', 'Competition');
					$form->EndForm();
					hr();
				}
				
				$table = new Table();
				$table->StartRow();
				$table->AddHeader('Personal Options', 3);
				$table->EndRow();
				
				$table->StartRow();
				$table->AddCell('<a href="?new">New Fiction</a>');
				$table->AddCell('<a href="?edit">Edit Fiction</a>');
				$table->AddCell('<a href="?move">Move Fiction</a>');
				$table->EndRow();
							
				$table->StartRow();
				$table->AddCell('<a href="?newb">New Book</a>');
				$table->AddCell('<a href="?editb">Edit Book</a>');
				$table->AddCell('<a href="?moveb">Move Book</a>');
				$table->EndRow();
							
				$table->EndTable();
			break;
		}
	} else {
		foreach ($fiction->GetNews() as $date=>$news){
			$table = new Table();
			$table->StartRow();
			$table->AddHeader('Fiction Archive News - '.date('j F Y \a\t G:i:s T', $date));
			$table->EndRow();
			$table->AddRow($news);
			$table->EndTable();
			
			hr();
		}
	}
}
	
?>
