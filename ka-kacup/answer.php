<?

if ($hunt) {

if ($action == 'process'){

$complete = new Hunt($hunt);

if ($options > 0){

$i = 0;
$ans = "";
while ($i < $options) {

$req = '$ans_'.$i;

$ans .= $_REQUEST['$req'];

$i++;

}

}

$ans = $answer;

if ($reason == "yes"){

$ans = 'Answer: '.$answer.' Reasoning: '.$reasoning;

}

if ($complete->Process($bhg_id, $hunt_call, $ans)) {

echo "Processed";

} else {
echo "<center>";
echo "Not processed";
echo "<br>";
echo $complete->error;
}

}

} else {

echo "You must enter an answer.";

}

?>