<?php
import_request_variables('gp');

// Make sure this request is coming in on an SSL connection
// For local testing you may wish to disable this, but please leave it on
// for the production environment
if (!(   isset($_SERVER['HTTPS'])
      && $_SERVER['HTTPS'] == 'on')) {

  if (isset($text)) {
    header('Content-Type: text/plain; charset=UTF-8');
  }
  else {
    header('Content-Type: text/xml; charset=UTF-8');
  }
  
  echo "<?xml version=\"1.0\"?>\n";

  echo <<<EOE
<error>
	<message>You must access these XML files through HTTPS.</message>
</error>
EOE;

  exit;

}
  

ini_set('include_path', ini_get('include_path') . ':/var/www/html/include');
include('roster.inc');

$roster = new Roster();

function xmlentities($str) {
	return str_replace(array('&', '<', '>', '"'), array('&amp;', '&lt;', '&gt;', '&#x22;'), $str);
}

function handle_attribute($object, $attrib, $indent = 1) {
	$attrib = strtolower($attrib);
	if (method_exists($object, "Get$attrib")) {
		$function = "Get$attrib";
	}
	elseif (method_exists($object, $attrib)) {
		$function = $attrib;
	}
	else {
		return false;
	}
	$retval = call_user_method($function, $object);
	if (is_object($retval)) {
		if (method_exists($retval, 'getid')) {
			if (method_exists($retval, 'getname')) {
				$name = $retval->GetName();
			}
			$retval = $retval->GetID();
		}
		else {
			return false;
		}
	}
	for ($i = 0; $i <= $indent; $i++) {
		echo '	';
	}
	if ($retval === false) {
		$retval = '0';
	}
	echo "<$attrib" . ($name ? ' name="' . xmlentities($name) . '">' : '>') . xmlentities($retval) . "</$attrib>\n";
	return true;
}

function person($person, $indent = 0) {
	for ($i = 0; $i < $indent; $i++) {
		echo '	';
	}
	echo '<person id="' . $person->GetID() . "\">\n";

	handle_attribute($person, 'id', $indent);
	handle_attribute($person, 'name', $indent);
	handle_attribute($person, 'email', $indent);
	handle_attribute($person, 'rank', $indent);
	handle_attribute($person, 'division', $indent);
	handle_attribute($person, 'position', $indent);
  handle_attribute($person, 'cadre', $indent);
	handle_attribute($person, 'homepage', $indent);
	handle_attribute($person, 'ircnicks', $indent);
	handle_attribute($person, 'quote', $indent);
	handle_attribute($person, 'joindate', $indent);
	handle_attribute($person, 'rankcredits', $indent);
	handle_attribute($person, 'accountbalance', $indent);
	handle_attribute($person, 'lastupdate', $indent);
	handle_attribute($person, 'hasship', $indent);
	handle_attribute($person, 'completedntc', $indent);
	handle_attribute($person, 'ishunter', $indent);
	handle_attribute($person, 'isdeleted', $indent);
	handle_attribute($person, 'isactive', $indent);
  handle_attribute($person, 'incadre', $indent);
  handle_attribute($person, 'iscadreleader', $indent);
	handle_attribute($person, 'idline', $indent);

	$medals = $person->GetMedals();
	if ($medals && count($medals)) {
		for ($i = 0; $i < ($indent + 1); $i++) {
			echo '	';
		}
		echo "<medals>\n";
		foreach ($medals as $medal) {
			for ($i = 0; $i < ($indent + 2); $i++) {
				echo '	';
			}
			$medal_obj = $medal->GetMedal();
//			echo '<!-- ' . $medal_obj->Error() . " -->\n";
			echo '<medal name="' . $medal_obj->GetName() . '" abbrev="' . $medal_obj->GetAbbrev() . '" date="' . $medal->GetDate() . '" medal="' . $medal_obj->GetID() . '" reason="' . xmlentities($medal->GetReason()) . '">' . xmlentities($medal->GetID()) . "</medal>\n";
		}
		for ($i = 0; $i < ($indent + 1); $i++) {
			echo '	';
		}
		echo "</medals>\n";
	}

	for ($i = 0; $i < $indent; $i++) {
		echo '	';
	}
	echo "</person>\n";
}

function rank($rank, $indent = 0) {
	for ($i = 0; $i < $indent; $i++) {
		echo '	';
	}
	echo "<rank>\n";

	handle_attribute($rank, 'id', $indent);
	handle_attribute($rank, 'name', $indent);
	handle_attribute($rank, 'abbrev', $indent);
	handle_attribute($rank, 'requiredcredits', $indent);
	handle_attribute($rank, 'isalwaysavailable', $indent);
	handle_attribute($rank, 'isunlimitedcredits', $indent);
	handle_attribute($rank, 'ismanuallyset', $indent);

	for ($i = 0; $i < $indent; $i++) {
		echo '	';
	}
	echo "</rank>\n";
}

function division($division, $indent = 0) {
	for ($i = 0; $i < $indent; $i++) {
		echo '	';
	}
	echo "<division>\n";

	handle_attribute($division, 'id', $indent);
	handle_attribute($division, 'name', $indent);
	handle_attribute($division, 'isactive', $indent);
	handle_attribute($division, 'iskabal', $indent);

	if (!$short) {
		$members = $division->GetMembers();
		foreach ($members as $member) {
			for ($i = 0; $i <= $indent; $i++) {
				echo '	';
			}
			echo '<member name="' . xmlentities($member->GetName()) . '">' . $member->GetID() . "</member>\n";
		}
	}

	for ($i = 0; $i < $indent; $i++) {
		echo '	';
	}
	echo "</division>\n";
}

function cadre($cadre, $indent = 0) {
	for ($i = 0; $i < $indent; $i++) {
		echo '	';
	}
	echo "<cadre>\n";

	handle_attribute($cadre, 'id', $indent);
	handle_attribute($cadre, 'name', $indent);
	handle_attribute($cadre, 'homepage', $indent);
	handle_attribute($cadre, 'slogan', $indent);
  handle_attribute($cadre, 'isactive', $indent);
  handle_attribute($cadre, 'leader', $indent);

	if (!$short) {
    if ($cadre->IsActive()) {
  		$members = $cadre->GetMembers();
	  	foreach ($members as $member) {
		  	for ($i = 0; $i <= $indent; $i++) {
			  	echo '	';
  			}
	  		echo '<member name="' . xmlentities($member->GetName()) . '">' . $member->GetID() . "</member>\n";
		  }
    }
	}

	for ($i = 0; $i < $indent; $i++) {
		echo '	';
	}
	echo "</cadre>\n";
}

function position($position, $indent = 0) {
	for ($i = 0; $i < $indent; $i++) {
		echo '	';
	}
	echo "<position>\n";

	handle_attribute($position, 'id', $indent);
	handle_attribute($position, 'name', $indent);
	handle_attribute($position, 'abbrev', $indent);
	handle_attribute($position, 'income', $indent);
	handle_attribute($position, 'istrainee', $indent);

	for ($i = 0; $i < $indent; $i++) {
		echo '	';
	}
	echo "</position>\n";
}

if (isset($text)) {
	header('Content-Type: text/plain; charset=UTF-8');
}
else {
	header('Content-Type: text/xml; charset=UTF-8');
}

echo "<?xml version=\"1.0\"?>\n";
?>
