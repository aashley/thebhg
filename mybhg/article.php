<?php
include_once('roster.php');
$item = $news->GetItem($_REQUEST['id']);
$title = 'View Article :: ' . $item->GetTitle();
include('header.php');


$article = new BlockTable();
$article->StartRow();
$article->AddHeader($item->GetTitle(), $columns);
$article->EndRow();

$article->StartRow();
$poster = $item->GetPoster();
$article->AddHeader('Posted by <a href="http://holonet.thebhg.org/index.php?module=roster&amp;page=hunter&amp;id=' . $poster->GetID() . '">' . $poster->GetName() . '</a> on ' . date('j F Y \a\t G:i:s T', $item->GetTimestamp()));
$article->EndRow();

$article->StartRow();
$article->AddCell($item->Render('%message%'), $columns);
$article->EndRow();
$article->EndTable();

$show_blocks = true;
include('footer.php');
?>
