<?php
include('header.php');
include_once('util/zip.lib.php');

$zipfile = new zipfile;
$result = mysql_query('SELECT * FROM missions ORDER BY mset DESC, title ASC', $db);
if ($result && mysql_num_rows($result)) {
	$titles = array();
	while ($row = mysql_fetch_array($result)) {
		$author = $roster->GetPerson($row['author']);
		if (isset($titles[$row['mset']]) && in_array($row['title'], $titles[$row['mset']])) {
			$title = stripslashes($row['title']) . ' - ' . $author->GetName();
		}
		else {
			$title = stripslashes($row['title']);
			$titles[$row['mset']][] = $row['title'];
		}
		$body = '<html><head><title>' . stripslashes($row['title']) . '</title></head><body><h1>' . stripslashes($row['title']) . '</h1><b>Written by ' . $author->GetName() . '</b><br><br>' . stripslashes($row['text']) . '</body></html>';
		$filename = 'Set ' . $row['mset'] . '\\' . str_replace(array('/', '\\', '?', '\'', '"', '*'), '', $title);
		$zipfile->addFile($body, $filename . '.html', time());
		$body = '<html><head><title>' . stripslashes($row['title']) . ' (Answer and Results)</title></head><body><h1>' . stripslashes($row['title']) . '</h1><b>Written by ' . $author->GetName() . '</b><br><br><b>Answer</b><br><br>' . stripslashes($row['answers']) . '<br><br><b>Results</b><br><br>' . stripslashes(nl2br($mission['results'])) . '</body></html>';
		$zipfile->addFile($body, $filename . ' - Answer.html', time());
	}
}
header('Content-Type: application/zip');
$zip = $zipfile->file();
header('Content-Length: ' . strlen($zip));
echo $zip;
?>
