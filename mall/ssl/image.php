<?php
include('header.php');

$item = new Item($id);
header('Content-Type: ' . $item->GetImageType());
echo $item->GetImage();
?>
