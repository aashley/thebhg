<?php include('header.php'); ?>
Welcome to the IRC stats page. Some useless information is contained here on who frequents #bhg and how much they say.
<br><br>
<?php
$jer = $roster->GetPerson(666);
$rank = $jer->GetRank();
echo '<a href="mailto:' . $jer->GetEmail() . '">' . $rank->GetName() . ' ' . $jer->GetName() . '</a>';
include('footer.php');
?>
