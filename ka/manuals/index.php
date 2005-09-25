<?php

$site = $_GET[site];

require_once '../Layout.inc';
if($site == "")
{
    $site = "index";
include ("index.inc");
}else{
    include("" . $site . ".inc");
}
ConstructLayout($title);
?>