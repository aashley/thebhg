<?php
include('header.php');
page_header();
?>
<STYLE TYPE="text/css">
<!--
TR, TD, IMG {
	margin: 0;
	padding: 0;
	border: 0;
}
A {
	color: black;
}
-->
</STYLE>
<TABLE BORDER="0" STYLE="margin: 0; padding: 0" WIDTH="105" CELLSPACING="0" CELLPADDING="0">
<TR><TD WIDTH="4"><IMG SRC="images/top-left.png"></TD><TD><IMG SRC="images/top.png" WIDTH="97" HEIGHT="4"></TD><TD WIDTH="4"><IMG SRC="images/top-right.png"></TD></TR>
<TR><TD WIDTH="4"><IMG SRC="images/left.png" HEIGHT="100%" WIDTH="4"></TD><TD STYLE="background: #a5a5a5"><CENTER>
<A HREF="main.php" TITLE="View the current news for <?php echo $str_name; ?>">News</A><BR>
<A HREF="catalogue.php" TITLE="View our catalogue of <?php echo $str_plural; ?>">Catalogue</A><BR>
<A HREF="registries/index.php" TITLE="See what other <?php echo $str_people; ?> have bought">Registries</A><BR>
<A HREF="faq.php" TITLE="What is this place?">FAQ</A><BR>
<A HREF="admin/index.php" TITLE="<?php echo $str_abbrev; ?> administration (Restricted access)">Administration</A>
</CENTER></TD><TD WIDTH="4"><IMG SRC="images/right.png" HEIGHT="100%" WIDTH="4"></TD></TR>
<TR><TD WIDTH="4"><IMG SRC="images/bottom-left.png"></TD><TD><IMG SRC="images/bottom.png" WIDTH="97" HEIGHT="4"></TD><TD WIDTH="4"><IMG SRC="images/bottom-right.png"></TD></TR>
</TABLE>
<?php
page_footer();
?>
