<?php
include('header.php');

page_header();

echo <<<EOM
<B>$str_name Administration</B><HR>
<A HREF="add_type.php">Add New Type</A><BR>
<A HREF="edit_type.php">Edit Type</A><BR>
<A HREF="add_item.php">Add New Item</A><BR>
<A HREF="edit_item.php">Edit Item</A><BR>
<A HREF="delete_item.php">Delete Item</A><HR>
<A HREF="add_faq_section.php">Add FAQ Section</A><BR>
<A HREF="edit_faq_section.php">Edit FAQ Section</A><BR>
<A HREF="delete_faq_section.php">Delete FAQ Section</A><BR>
<A HREF="add_faq.php">Add FAQ</A><BR>
<A HREF="edit_faq.php">Edit FAQ</A><BR>
<A HREF="delete_faq.php">Delete FAQ</A><BR>
EOM;

page_footer();
?>
