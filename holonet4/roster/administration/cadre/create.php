<?php

function cadre(&$form){
	$form->addElement('header', null, 'Cadre');
	$form->addElement('text', 'name', 'Name', array('size'=>15));
	$form->addElement('text', 'slogan', 'Slogan', array('size'=>25));
	$form->addElement('text', 'logo', 'URL of Logo', array('size'=>25));
	$form->addElement('textarea', 'welcome', 'Welcome Text for New Members<br /><br /><small>Text Replacements:<br />
		%N - Hunter\'s Name<br />
		%R - Hunter\'s Rank<br />
		%C - Cadre Name<br />
		%CR - Cadre Rank of User</small>', array('cols'=>45, 'rows'=>20));
}

class page_roster_administration_cadre_create extends holonet_page {

	public function __construct($trail) {

		parent::__construct($trail);

		$this->secure = 1;

	}

	public function buildPage() {

		$this->pageBuilt = true;

		$this->setTitle('Create Cadre');

		$user = $GLOBALS['bhg']->user;
		
		$form = new holonet_form('create_cadre');
		$renderer =& $form->defaultRenderer();
		$confed = $user->canCreateCadre(true);
		
		switch (true){
			case ($user->canCreateCadre()):
				cadre($form);
				break;
				
			case ($user->canCreateCadre(true)):
				cadre($form);
				$form->addElement('static',
					'reassign_header',
					array(
						'&nbsp;',
						'Confederate Members',
						));
	
				$renderer->setElementTemplate("\n"
						."\t<tr>\n"
						."\t\t<th class=\"label\">{label}</th>\n"
						."\t\t<th class=\"label_2\">{label_2}</th>\n"
						."\t</tr>",
						'reassign_header');
		
				for ($i = 0; $i < 6; $i++) {
		
					$fields = array();
		
					$fields[] = $form->createElement('personselect',
							'person',
							null);
		
					$form->addGroup($fields, 'reassign['.$i.']', 'Confederate ' . ($i + 1));
		
					$renderer->setElementTemplate("\n"
							."\t<tr>\n"
							."\t\t<td class=\"label\"><!-- BEGIN required --><span style=\"color: #ff0000\">*</span><!-- END required -->{label}</td>\n"
							."\t\t{element}\n"
							."\t</tr>",
							'reassign['.$i.']');
		
					$renderer->setGroupTemplate("\n{content}", 'reassign['.$i.']');
					$renderer->setGroupElementTemplate("\n<td valign=\"top\">{element}</td>", 'reassign['.$i.']');
				}
				break;

				case ($user->getPosition()->isCadreExempt()):
				default:
					$this->addBodyContent('You can not create a Cadre.');
					return false;
					break;
		}
		
		$form->addButtons('Submit to Enforcer');
		
		if ($form->validate()) {

			$values = $form->exportValues();
			$account = $user->getAccountBalance();

			if (isset($values['reassign']))
				foreach ($values['reassign'] as $key => $member){
					$member = bhg_roster::getPerson($member['person'][1]);
					if ($member->canCreateCadre())
						$error[] = $member->getName() . ' is <strong>NOT</strong> eligible for confederation.';
					else $confederates[] = $member;
				}
			
			if (count($error)){
				$this->addBodyContent('<strong>Errors</strong><br />');
				$this->addBodyContent(implode('<br />', $error));
				$this->addBodyContent('<hr noshade="noshade" /><br />');
				$this->addBodyContent($form);
			} else {
			
				try {

					$this->addBodyContent('<p>Attempting to submit '. $values['name'] . ' for approval...');
	
					$user->requestCreateCadre($values['name'], $values['slogan'], $values['logo'], $values['welcome'], $values['confederates']);
	
					$this->addBodyContent('Success.</p>');
					
				} catch (bhg_fatal_exception $e) {
	
					$this->addBodyContent('Failure.</p>');
					$this->addBodyContent($e->__toString());
	
				}
				
			}

		} else {

			$this->addBodyContent($form);

		}

		$this->addSideMenu($GLOBALS['holonet']->roster->getAdministrationMenu());

	}

	public function canAccessPage(bhg_roster_person $user) {

		return true;

	}

}

function _checkOldPassword($value, $limit = null) {

	return $GLOBALS['bhg']->user->checkPassword($value);

}

?>
