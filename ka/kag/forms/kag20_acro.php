<?
 include_once("roster.inc");
 $person = new Login_HTTP(); 
?>
<html>
 <head>
  <title>Kabal Authority Games</title>
 </head>
 <body alink="#FF6633" bgcolor="#000000" link="#ffffff" text="#ffffff" vlink="#ffffff">
  <div align="center">
   <table width="700">
    <tr><td><p><font color="#FFFFFF" face="Arial, Helvetica, sans-serif" size="5"><b><center>
	 KAG XX Acrophobia
	</center></b></font></p>
<?
 if((time() >= "1106197260") && (time() <= "1107144060")) {
	 /* $hunters = parse_ini_file("kag20_acro.ini",0);
	 $x = 0;
	 foreach($hunters as $id) {
		 if($id === $person->GetID()) {
			 $x = 1;
		 }
	 }
	 if($x) {
		 echo "<center><strong>You have already submitted.</strong></center>";
	 } else { */
		if(!$_POST[submit]) { ?>
    <form action="" method="post">
     1) JDS<br>
     <input type="text" name="set_1" size="100"><br>
     2) HJEP<br>
     <input type="text" name="set_2" size="100"><br>
     3) OEMFD<br>
     <input type="text" name="set_3" size="100"><br>
     4) KANSJE<br>
     <input type="text" name="set_4" size="100"><br>
     5) QSMEJFP<br>
     <input type="text" name="set_5" size="100"><br>
     6) LKSADMSK<br>
     <input type="text" name="set_6" size="100"><br>
     7) NEMDNFSLR<br>
     <input type="text" name="set_7" size="100"><br>
     8) IKEJDNERHS<br>
     <input type="text" name="set_8" size="100"><br>
     9) MASNDOFENRP<br>
     <input type="text" name="set_9" size="100"><br>
     10) RGMWENSHBAHR<br>
     <input type="text" name="set_10" size="100"><br>
     <br>
     Your ID Line: <? echo $person->IDLine(0); ?>	<br>
     <br>
     <input type="submit" name="submit" value="Submit!">
     </form>
<?
	 	} else {
		 	$headers = "From: KAG Acrophobia <ka@thebhg.org>\n";
		 	$headers .= "Reply-To: Kabal Authority <ka@thebhg.org>";
		 	$to = "ka@thebhg.org";
		 	$subject = "KAG 20: Acrophobia submission";
		 	$message = "Submission from ".$person->IDLine(0)."\n\n";
		 	$message .= "Set 1:\n";
		 	$message .= "$_POST[set_1]\n\n";
		 	$message .= "Set 2:\n";
		 	$message .= "$_POST[set_2]\n\n";
		 	$message .= "Set 3:\n";
		 	$message .= "$_POST[set_3]\n\n";
		 	$message .= "Set 4:\n";
		 	$message .= "$_POST[set_4]\n\n";
		 	$message .= "Set 5:\n";
		 	$message .= "$_POST[set_5]\n\n";
		 	$message .= "Set 6:\n";
		 	$message .= "$_POST[set_6]\n\n";
		 	$message .= "Set 7:\n";
		 	$message .= "$_POST[set_7]\n\n";
		 	$message .= "Set 8:\n";
		 	$message .= "$_POST[set_8]\n\n";
		 	$message .= "Set 9:\n";
		 	$message .= "$_POST[set_9]\n\n";
		 	$message .= "Set 10:\n";
		 	$message .= "$_POST[set_10]\n\n";
		 	mail($to,$subject,$message,$headers);
		 	// $file = fopen("kag20_acro.ini","a");
		 	// fwrite($file,"id_".count($hunters)." = ".$person->GetID()."\n");
		 	echo "Thank you for your submission.";
	 	}
	// }
 } else {
	 echo "<center><strong>This event ";
	 if(time() < "1106197260") {
	 	echo "hasn't started yet";
 	} else {
	 	echo "has already ended";
 	}
 	echo ", ".$person->GetName()."</strong></center>";
 }
?>