<?php
include('header.php');
page_header('Contact Us');

echo 'Got a problem, comment, or just want to flame the heck out of us? You can contact Tactician ' . roster_link($tactician) . ' at <A HREF="mailto:' . urlencode($tactician->GetEmail()) . '">' . $tactician->GetEmail() . '</A> or Marshal ' . roster_link($marshal) . ' at <A HREF="mailto:'.urlencode($marshal->GetEmail()) . '">.';

page_footer();
?>
