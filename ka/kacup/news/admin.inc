<? require_once '../../Layout.inc';

  $pagename = "News Admin";
  $path_to_base = "../";
  $min_rank = 2;

  include("../functions/auth.php");
  
  if ($is_authorised) {

    include("../functions/db.php");
    include("../header.php");

    if ($_REQUEST["new_article"]) { // Add a new article
      $subject = $_REQUEST["subject"];
      $article = $_REQUEST["article"];

      if (mysql_query("INSERT INTO cup_newsboard VALUES (NULL, $id, UNIX_TIMESTAMP(), '$subject', '$article')", $db)) {
        echo "<p class=\"msg\">The article was successfully added.</p>\n";
      } else {
        echo "<p class=\"msg\">An error occurred whilst adding the article.</p>\n";
      }
    }

    if ($_REQUEST["edit_article"]) { // Edit an existing article
      $article_id = $_REQUEST["article_id"];
      $subject = $_REQUEST["subject"];
      $article = $_REQUEST["article"];

      if (mysql_query("UPDATE cup_newsboard SET subject=\"$subject\", article=\"$article\" WHERE article_id=$article_id LIMIT 1", $db)) {
        echo "<p class=\"msg\">The article was successfully edited.</p>\n";
      } else {
        echo "<p class=\"msg\">An error occurred whiles editing the article.</p>\n";
      }
    }

    if ($_REQUEST["delete_article"]) { // Delete an article
      $article_id = $_REQUEST["article_id"];

      if (mysql_query("DELETE FROM cup_newsboard WHERE article_id=$article_id LIMIT 1", $db)) {
        echo "<p class=\"msg\">The article was successfully deleted.</p>\n";
      } else {
        echo "<p class=\"msg\">An error occurred whilst deleting the article.</p>\n";
      }
    }

    if ($_REQUEST["delete"]) {
      $article_id = $_REQUEST["article_id"];
      echo "<p>Really delete article $article_id?</p>\n";
      echo "<table><tr>\n<td>\n";
      echo "<form method=\"post\" action=\"$PHP_SELF\">\n";
      echo "<input type=\"hidden\" name=\"delete_article\" value=\"1\" />\n";
      echo "<input type=\"hidden\" name=\"article_id\" value=\"$article_id\" />\n";
      echo "<input type=\"hidden\" name=\"op\" value=\"news\" />\n";
      echo "<input type=\"submit\" value=\"Yes\" />\n";
      echo "</form>\n";
      echo "</td>\n<td>\n";
      echo "<form method=\"post\" action=\"$PHP_SELF\">\n";
      echo "<input type=\"hidden\" name=\"op\" value=\"news\" />\n";
      echo "<input type=\"submit\" value=\"No\" />\n";
      echo "</form>\n";
      echo "</td>\n</tr></table>\n";
    }

    if ($_REQUEST["edit"]) {
      $article_id = $_REQUEST["article_id"];
      echo "<p>Currently editing article $article_id</p>";
      echo "<form method=\"post\" action=\"$PHP_SELF\"><input type=\"submit\" value=\"Cancel Edit\" />";
      echo "<input type=\"hidden\" name=\"op\" value=\"news\" />\n";
      echo "</form>\n";
    }

    echo "<form method=\"post\" action=\"$PHP_SELF\">\n";
 echo "<input type=\"hidden\" name=\"op\" value=\"news\" />\n";
    if ($_REQUEST["edit"]) {
      $art_to_edit = mysql_query("SELECT * FROM cup_newsboard WHERE article_id=$article_id LIMIT 1", $db);
      $article_array = mysql_fetch_array($art_to_edit, MYSQL_ASSOC);
      $subject = $article_array["subject"];
      $article = $article_array["article"];

      echo "<input type=\"hidden\" name=\"edit_article\" value=\"1\" />\n";
      echo "<input type=\"hidden\" name=\"article_id\" value=\"$article_id\" />\n";
    } else {
      $subject = "";
      $article = "";

      echo "<input type=\"hidden\" name=\"new_article\" value=\"1\">\n";
    }

    echo "<p>Subject: <input type=\"text\" name=\"subject\" value=\"$subject\" size=\"40\" /></p>\n";

    echo "<p>Article:<br />\n";
    echo "<textarea name=\"article\" cols=\"50\" rows=\"10\">$article</textarea>\n";
    echo "</p>\n";

    echo "<input type=\"submit\" value=\"Submit\" /> <input type=\"reset\" value=\"Clear Form\" />\n";
    echo "</form>\n";

    echo "<table class=\"contrast\">\n";
    echo "<tr><th><p class=\"contrast\">Subject</p></th><th><p class=\"contrast\">Date</p></th><th><p class=\"contrast\">Edit article</p></th><th><p class=\"contrast\">Delete article</p></th></tr>\n";
    $articles = mysql_query("SELECT article_id, timestamp, subject FROM cup_newsboard ORDER BY article_id DESC", $db);
    while ($article_array = mysql_fetch_array($articles, MYSQL_ASSOC)) {
      $article_id = $article_array["article_id"];
      $timestamp = $article_array["timestamp"];
      $subject = $article_array["subject"];

      echo "<tr>\n";
      echo "  <td class=\"contrast\"><p>$subject</p></td>\n";
      echo "  <td class=\"contrast\"><p>".date("Y-m-d @ H:i", $timestamp)."</p></td>\n";
      echo "  <td><form method=\"post\" action=\"$PHP_SELF\">";
 echo "<input type=\"hidden\" name=\"op\" value=\"news\" />\n";
echo "<input type=\"hidden\" name=\"edit\" value=\"1\" /><input type=\"hidden\" name=\"article_id\" value=\"$article_id\" /><input type=\"submit\" value=\"Edit\" /></form></td>\n";
      echo "  <td><form method=\"post\" action=\"$PHP_SELF\">";
 echo "<input type=\"hidden\" name=\"op\" value=\"news\" />\n";
echo "<input type=\"hidden\" name=\"delete\" value=\"1\" /><input type=\"hidden\" name=\"article_id\" value=\"$article_id\" /><input type=\"submit\" value=\"Delete\" /></form></td>\n";
      echo "</tr>\n";
    }

    echo "</table>\n";

    include("../footer.php");

    exit;

  }

ConstructLayout();
?>
