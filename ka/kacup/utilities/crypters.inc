<?
function encrypt($code) {

$coder = strtolower($code);

$letters = array("a", "b", "c", "d", "e", "f", "g", "h", "i", "j", "k", "l", "m", "n", "o", "p", "q", "r", "s", "t", "u", "v", "w", "x", "y", "z");

$values = array("1 ", "2 ", "3 ", "4 ", "5 ", "6 ", "7 ", "8 ", "9 ", "10 ", "11 ", "12 ", "13 ", "14 ", "15 ", "16 ", "17 ", "18 ", "19 ", "20 ", "21 ", "22 ", "23 ", "24 ", "25 ", "26 ");

shuffle($letters);
shuffle($values);

$return = str_replace($letters, $values, $coder);

return $return;
}

function alpha_encrypt($code) {

$code = strtolower($code);

$letters = array("a", "b", "c", "d", "e", "f", "g", "h", "i", "j", "k", "l", "m", "n", "o", "p", "q", "r", "s", "t", "u", "v", "w", "x", "y", "z");

$values = array("1 ", "2 ", "3 ", "4 ", "5 ", "6 ", "7 ", "8 ", "9 ", "10 ", "11 ", "12 ", "13 ", "14 ", "15 ", "16 ", "17 ", "18 ", "19 ", "20 ", "21 ", "22 ", "23 ", "24 ", "25 ", "26 ");

shuffle($letters);
shuffle($values);

$variables = array_merge($letters, $values);

shuffle($variables);

$return = str_replace($letters, $variables, $code);

return $return;
}

function hex($code) {

$code = strtolower($code);

$letters = array(" ", "a", "b", "c", "d", "e", "f", "g", "h", "i", "j", "k", "l", "m", "n", "o", "p", "q", "r", "s", "t", "u", "v", "w", "x", "y", "z");

$hex = array("20 ", "61 ", "62 ", "63 ", "64 ", "65 ", "66 ", "67 ", "68 ", "69 ", "6A ", "6B ", "6C ", "6D ", "6E ", "6F ", "70 ", "71 ", "72 ", "73 ", "74 ", "75 ", "76 ", "77 ", "78 ", "79 ", "7A ");

$return = str_replace($letters, $hex, $code);

return $return;

}

function binary($code) {

$code = strtolower($code);

$letters = array(" ", "a", "b", "c", "d", "e", "f", "g", "h", "i", "j", "k", "l", "m", "n", "o", "p", "q", "r", "s", "t", "u", "v", "w", "x", "y", "z");

$binary = array("00010100 ", "01100001 ", "01100010 ", "01100011 ", "01100100 ", "01100101 ", "01100110 ", "01100111 ", "01101000 ", "01101001 ", "01101010 ", "01101011 ", "01101100 ", "01101101 ", "01101110 ", "01101111 ", "01110000 ", "01110001 ", "01110010 ", "01110011 ", "01110100 ", "01110101 ", "01110110 ", "01110111 ", "01111000 ", "01111001 ", "01111010 ");

$return = str_replace($letters, $binary, $code);

return $return;

}
?>