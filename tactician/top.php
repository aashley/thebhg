<?php
include('header.php');
page_header('', 'TOP');
echo '<IMG SRC="banner.php' . (isset($_REQUEST['line']) ? '?line=' . urlencode($_REQUEST['line']) : '') . '">';
page_footer();
?>
