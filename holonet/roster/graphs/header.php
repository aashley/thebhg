<?php
ini_set('include_path', ini_get('include_path') . ':/home/thebhg/domains/holonet.thebhg.org/jpgraph-2.1.4/src');
include('../header.php');
include('jpgraph.php');

// Individual graphs must include the relevant jpgraph_TYPE.php file.

function get_div_colour($div) {
	switch ($div->GetID()) {
		case 17:
			return 'seagreen3';
			break;
		case 3:
			return 'burlywood3';
			break;
		case 4:
			return 'darkorchid3';
			break;
		case 8:
			return 'darkblue';
			break;
		case 15:
			return 'gold';
			break;
		case 2:
			return 'brown4';
			break;
		case 13:
			return 'cyan4';
			break;
		case 10:
			return 'aliceblue';
			break;
		case 9:
			return 'azure3';
			break;
		case 12:
			return 'black';
			break;
		case 11:
			return 'gray6';
			break;
		case 18:
			return 'aquamarine';
			break;
		case 19:
			return 'chartreuse';
			break;
		case 16: default:
			return 'deeppink';
	}
}

function format_month_label($ts) {
	static $my;
	
	$str = date('M y', $ts);
	if (!is_array($my) || !in_array($str, $my)) {
		$my[] = $str;
		return $str;
	}
	else {
		return '';
	}
}

function format_credit_label($creds) {
	if ($creds < 1000) {
		return number_format($creds);
	}
	elseif ($creds < 1000000) {
		return number_format($creds / 1000) . 'k';
	}
	elseif ($creds < 1000000000) {
		$mil = $creds / 1000000;
		if ($mil < 10) {
			return number_format($mil, 2) . 'M';
		}
		elseif ($mil < 100) {
			return number_format($mil, 1) . 'M';
		}
		else {
			return number_format($mil) . 'M';
		}
	}
	else {
		return number_format($creds / 1000000000, 1) . 'B';
	}
}
?>
