<?

include('Kabal_Hunts/Utilities/crypters.inc');

if ($hunt_type == 17){

$hunter = encrypt($cypher1);

$answer = strtolower($cypher1);

} 

if ($hunt_type == 18){

$hunter = alpha_encrypt($cypher2);

$answer = strtolower($cypher2);

} 

if ($hunt_type == 19){

if ($nerdcypher1) {

$hunter = binary($nerdcypher1);

$answer = strtolower($nerdcypher1);

} elseif ($nerdcypher2) {

$hunter = hex($nerdcypher2);

$answer = strtolower($nerdcypher2);
}

} 

if ($hunt_type == 23){

include_once 'roster.inc';

$roster = new Roster();
$person = $roster->GetPerson($fake);
$bio = $person->GetBioData();
$url = $bio->GetImageURL();

$hunter = "<img src=".$url.">";

}

if ($hunt){
$die = 1;
} else {
$hunt = "0";
}

if ($answer){
$die = 1;
} else {
$answer = "0";
}

if ($options){
$die = 1;
} else {
$options = "0";
}

if ($image){
$file = $_FILES['image']['tmp_name'];
$read = fopen($file, "rb");
$put = filesize($file);
$get = fread($read, $put);
$image = addslashes($get);
$type = $_FILES['image']['type'];
} else {
$image = "0";
$size = "0";
}
include_once('Kabal_Hunts/Objects/kabal_hunts.inc'); 

$kh = new Kabal_Hunts();

$set_hunt = new New_Hunt($hunter, $answer, $hunt_type, $reasoning, $image, $type, $options);

if ($set_hunt) {
echo "<center>New hunt added successfully!";
} else {
echo "<center>Error adding new hunt.";
}

?>