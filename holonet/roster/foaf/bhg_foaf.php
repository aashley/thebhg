<?php

	/**
	 * FOAF functions for the roster.
	 * @package Roster
	 * @subpackage Utilities
	 */

	require_once 'roster.inc';
    	require_once 'XML/FOAF.php';

	// Lets put the "options" at the top.
	define ('ARMOR_LOCATION', 'http://holonet.thebhg.org/roster/armour/armour.php?id=%s');
	define ('IPKC_LOCATION',  'http://holonet.thebhg.org/roster/ipkc/ipkc2.php?id=%s');
	define ('FOAF_LOCATION',  'http://holonet.thebhg.org/roster/foaf/person.php?id=%s');

	/**
	 * Convert a person into a FOAF object.
	 *
	 * @author Thomas Reynolds <Thomas.Reynolds@asu.edu>
	 * @param integer
	 * @param boolean
	 * @return XML_FOAF
	 */
	function person_to_foaf ($person_id, $simple = false)
	{
		// Grab info about the person from the Roster.
		$person_obj = new Person ($person_id);

		// Populate with information about this person.
		$person = new XML_FOAF ();
		$person->newAgent ('person');
		$person->setName ($person_obj->GetName ());
		$person->addMbox ($person_obj->GetEmail (), TRUE);

		if ($simple)
			$person->addSeeAlso (sprintf (FOAF_LOCATION, $person_obj->GetID ()));
		else {
			// We <3 ourselves
			$person->addInterest ('http://www.thebhg.org/');

			// Armor
			$person->addImg (sprintf (ARMOR_LOCATION, $person_obj->GetID ()));
  
			// IPKC
			$person->addDepiction (sprintf (IPKC_LOCATION, $person_obj->GetID ()));

			// Nicknames
			if (strlen ($person_obj->GetIRCNicks ()) > 0)
				$person->addNick ($person_obj->GetIRCNicks ());

			// Homepage
			if (strlen ($person_obj->GetHomePage ()) > 0)
				$person->addHomepage ($person_obj->GetHomePage ());

			// Jabber
			if (strlen ($person_obj->GetJabber ()) > 0)
				$person->addJabberID ($person_obj->GetJabber ());

			// AIM
			if (strlen ($person_obj->GetAIM ()) > 0)
				$person->addAimChatID ($person_obj->GetAIM ());

			// ICQ
			if (strlen ($person_obj->GetICQ ()) > 0)
				$person->addIcqChatID ($person_obj->GetICQ ());

			// Yahoo
			if (strlen ($person_obj->GetYahoo ()) > 0)
				$person->addYahooChatID ($person_obj->GetYahoo ());

			// MSN
			if (strlen ($person_obj->GetMSN ()) > 0)
				$person->addMsnChatID ($person_obj->GetMSN ());
		}

		return $person;
	}

	/**
	 * Convert a cadre into a FOAF object.
	 *
	 * @author Thomas Reynolds <Thomas.Reynolds@asu.edu>
	 * @param integer
	 * @return XML_FOAF
	 */
	function cadre_to_foaf ($cadre_id)
	{
		// Grab info about the Cadre from the Roster.
		$cadre_obj = new Cadre ($cadre_id);

		$cadre_group->newAgent ('group');
		$cadre_group->setName ($cadre_obj->GetName ());
		$cadre_group->addHomepage ($cadre_obj->GetHomePage ());

		$members_array = $cadre_obj->GetMembers ();
		foreach ($members_array as $member_obj)
		{
			$person = person_to_foaf ($member_obj->GetID (), TRUE);
			$cadre_group->AddMember ($person);
		}

		return $cadre_group;
	}

	/**
	 * Convert a division into a FOAF object.
	 *
	 * @author Thomas Reynolds <Thomas.Reynolds@asu.edu>
	 * @param integer
	 * @return XML_FOAF
	 */
	function division_to_foaf ($division_id)
	{
		// Grab info about the Division from the Roster.
		$division_obj = new Division ($division_id);

		$division_group->newAgent ('group');
		$division_group->setName ($division_obj->GetName ());
		$division_group->addMbox ($division_obj->GetMailingList (), TRUE);
		$division_group->addHomepage ($division_obj->GetHomePage ());

		$members_array = $division_obj->GetMembers ();
		foreach ($members_array as $member_obj)
		{
			$person = person_to_foaf ($member_obj->GetID (), TRUE);
			$division_group->AddMember ($person);
		}

		return $division_group;
	}
?>
