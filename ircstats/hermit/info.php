<?php $title = 'Information'; include('header.php'); ?>
<b>Hey! I only came here for the up-to-date stats I'm used to!</b><br>
Then you want the <a href="../current.php">current stats</a> page, as listed in the PISG section at left.
<hr>
<b>What's the difference between the Hermit stats and PISG stats?</b><br>
They're generated using two different programs. The Hermit stats are generated via code custom-written for the BHG, specially optimised to keep track of the different nicks people use and keep an internal database of those nicks. <a href="http://pisg.sf.net/">PISG</a> is an open-source Perl program that can calculate a far wider variety of stats than Hermit, but isn't really geared up to generate the statistics specifically needed for IRC credits.
<hr>
<b>Why do the figures differ between the two types of stats?</b><br>
There are likely to be differences in figures between the PISG stats(the pages with a grey/mauve background), and the Hermit stats (pages with a black background). For the purposes of IRC credits, the PISG stats are authoritative before September 2002, and the Hermit stats are the authoritative ones thereafter.
<hr>
<b>How far back do the stats go?</b><br>
The earliest day in the database is the 2nd of July, 2002. There are no plans to import older days, due to Tad having used a different log format before then, primarily.
<hr>
<b>Who can access the pages in the restricted section?</b><br>
The #bhg log archive can be accessed by any Commission member, while the overall admin (which isn't actually that interesting, consisting mainly of tools to manually manipulate the Hermit database) is accessible by Jer only.
<hr>
<b>Where should I report a bug?</b><br>
The <a href="http://bugs.thebhg.org/">bug tracker</a>.
<?php
include('footer.php');
?>
