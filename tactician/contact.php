<?php
include('header.php');
page_header('Contact Us');

echo 'Got a problem, comment, or just want to flame the heck out of us? You can contact Tactician ' . roster_link($tactician) . ' at <A HREF="mailto:' . $tactician->GetEmail() . '">' . $tactician->GetEmail() . '</A>.';

page_footer();
?>
