<?php

$pagename = "News";

include("header.php");

echo "<table width=\"90%\" cellpadding=\"0\" cellspacing=\"0\" border=\"0\" align=\"center\">\n";

include("functions/db.php");
include("functions/roster.php");
include("config.php");

$art_count = 0;
if (!isset($_REQUEST["maxposts"])) {
  $maxposts = $default_maxposts;
} else {
  $maxposts = $_REQUEST["maxposts"];
}
$news = mysql_query("SELECT * FROM cup_newsboard ORDER BY article_id DESC LIMIT $maxposts", $db);
while ($article = mysql_fetch_array($news, MYSQL_ASSOC)) {
  $id = $article["poster_id"];
  $poster = new Person($id);
  $name = $poster->GetName();
  $timestamp = $article["timestamp"];
  $subject = $article["subject"];
  $content = nl2br($article["article"]);

  $layout = file('http://katest.thebhg.org/kac/news/layout.php');
  for ($i = 0; $i < sizeof($layout); $i++) {
    $layout[$i] = str_replace("%NAME%", $name, $layout[$i]);
    $layout[$i] = str_replace("%DATE%", date($date_format, $timestamp), $layout[$i]);
    $layout[$i] = str_replace("%SUBJECT%", $subject, $layout[$i]);
    $layout[$i] = str_replace("%CONTENT%", $content, $layout[$i]);
    $output[$art_count] .= $layout[$i];
  }

  $art_count++;
}

// Print the articles, and handle the 'no posts' article.
if (($art_count > 1) AND ($art_count <= $maxposts)) {
  for ($i = 0; $i < (count($output) - 1); $i++) { echo $output[$i]; }
} elseif ($art_count > $maxposts) {
  for ($i = 0; $i < count($output); $i++) { echo $output[$i]; }
} else {
  echo $output[0];
}

echo "</table>\n";

echo "<form method=post action=$PHP_SELF>";
echo "Display Posts: <input type=text name=maxposts size=2 value=".$maxposts.">";
echo "</form>";
echo "<br>";

include("footer.php");

?>