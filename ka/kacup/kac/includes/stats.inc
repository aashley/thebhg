<?

$stat = new Stats();

$current = $stat->CurrentSeason();
$future = $stat->FutureSeason();
$active = $stat->CSActive();

if ($current) {
$season = new Season(17);
$start = getdate($season->GetStart());
$end = getdate($season->GetEnd());

if ($active){
echo "The current Kabal Authority Cup season is number ";
echo $season->GetRoman();
echo "<br>Season Started ";
echo $start['weekday'].", ".$start['month']." ".$start['mday'].", ".$start['year'];

echo "<br>Season will end ";
echo $end['weekday'].", ".$end['month']." ".$end['mday'].", ".$end['year'];

echo "<br>";
echo $season->GetRemaining();
} else {
echo "The last Kabal Authority Cup season was number ";
echo $season->GetRoman();
echo "<br>Season Started ";
echo $start['weekday'].", ".$start['month']." ".$start['mday'].", ".$start['year'];

echo "<br>Season Ended ";
echo $end['weekday'].", ".$end['month']." ".$end['mday'].", ".$end['year'];

echo "<br>";
echo $season->GetRemaining();
}
} else {
$season = new Season($future);
$start = getdate($season->GetStart());
$end = getdate($season->GetEnd());

echo "The next Kabal Authority Cup season is number ";
echo $season->GetRoman();
echo "<br>Season will start ";
echo $start['weekday'].", ".$start['month']." ".$start['mday'].", ".$start['year'];

echo "<br>Season will end ";
echo $end['weekday'].", ".$end['month']." ".$end['mday'].", ".$end['year'];

echo "<br>";
echo $season->GetWait();

}

?>