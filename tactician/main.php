<?php
include('header.php');
page_header();
?>
Welcome to the Office of the Tactician of the <A HREF="http://www.thebhg.org/" TARGET="_top">Bounty Hunter's Guild</A>. Here you may read missions past, attempt missions present, and wait with dread for missions future.<BR><BR>
<?php
echo '<B><A HREF="mailto:' . $tactician->GetEMail() . '">' . $rank->GetName() . ' ' . $tactician->GetName() . ', ' . $pos->GetName() . '</B></A>';
?>
<BR><BR><HR NOSHADE><BR>
<CENTER><B>News</B></CENTER><BR><BR>
<?php
include('news.php');
page_footer();
?>
