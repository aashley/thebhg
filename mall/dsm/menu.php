<?php
include('header.php');
page_header();
?>
<A HREF="main.php">News</A><BR>
<A HREF="catalogue.php"><?php echo ucwords($hull_singular); ?> Catalogue</A><BR>
<A HREF="partcat.php"><?php echo ucwords($mod_singular); ?> Catalogue</A><BR>
<A HREF="shipcat.php"><?php echo ucwords($str_singular); ?> Catalogue</A><BR>
<A HREF="junkyard.php"><?php echo ucwords($junkyard_name); ?></A><BR>
<A HREF="registries/index.php">Registries</A><BR>
<A HREF="faq.php">FAQ</A><BR>
<A HREF="contact.php">Contact Us</A><BR>
<A HREF="admin/index.php" STYLE="color: #7f7fff">Administration</A>
<?php
page_footer();
?>
