<?php
include('header.php');

page_header();

echo <<<EOM
<H1>$str_name Administration</H1><HR>
<U>Hulls</U><BR>
<A HREF="add_type.php">Add New Type</A><BR>
<A HREF="edit_type.php">Edit Type</A><BR>
<A HREF="add_item.php">Add New Item</A><BR>
<A HREF="edit_item.php">Edit Item</A><BR>
<A HREF="add_bay_type.php">Add Bay Type</A><BR>
<A HREF="edit_bay_type.php">Edit Bay Type</A><BR>
<A HREF="add_bay.php">Add Bay</A><BR>
<A HREF="edit_bay.php">Edit Bay</A><BR>
<A HREF="add_ship.php">Add New Pre-Defined Ship</A><HR>
<U>Parts</U><BR>
<A HREF="add_part_type.php">Add Part Type</A><BR>
<A HREF="edit_part_type.php">Edit Part Type</A><BR>
<A HREF="add_part.php">Add New Part</A><BR>
<A HREF="edit_part.php">Edit Part</A><BR>
<A HREF="delete_part.php">Delete Part</A><HR>
<U>FAQ</U><BR>
<A HREF="add_faq_section.php">Add FAQ Section</A><BR>
<A HREF="edit_faq_section.php">Edit FAQ Section</A><BR>
<A HREF="delete_faq_section.php">Delete FAQ Section</A><BR>
<A HREF="add_faq.php">Add FAQ</A><BR>
<A HREF="edit_faq.php">Edit FAQ</A><BR>
<A HREF="delete_faq.php">Delete FAQ</A><BR>
EOM;

page_footer();
?>
