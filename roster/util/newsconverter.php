<?php

include_once('/home/virtual/site5/fst/usr/share/roster3/include');

print '<HTML><HEAD><TITLE>Convert News Script</TITLE></HEAD><BODY>';

$news = new News('roster-69god');

if (isset($_REQUEST['coderid'])) {

  $olddb = mysql_connect("localhost", $_REQUEST['username'], $_REQUEST['password']);
  mysql_select_db($_REQUEST['database'], $olddb);

  $sql = 'SELECT * '
        .'FROM newsboard '
        .'ORDER BY timestamp';

  $posts = mysql_query($sql, $olddb);

  while ($post = mysql_fetch_array($posts)) {

    $sql = 'INSERT INTO newsboard (section, '
                                  .'timestamp, '
                                  .'poster, '
                                  .'topic, '
                                  .'message) '
          .'VALUES ('.$news->GetCoderID($_REQUEST['coderid']).', '
                     .$post['timestamp'].', '
                     .$post['poster'].', '
                     .'\''.addslashes(stripslashes($post['topic'])).'\', '
                     .'\''.addslashes(stripslashes($post['message'])).'\')';

    if (mysql_query($sql, $news->roster_db)) {
      
    } else {

      print 'Could not insert message '.$post['topicid'].'<br>'
        .'ERROR: '.mysql_errno($news->roster_db).': '.mysql_error($news->roster_db).'<br>'
        .'SQL: '.$sql.'<br>';

    }

  }

}

print '<FORM ACTION="'.$_SERVER['PHP_SELF'].'" METHOD="POST">'
    .'New Coder ID: <INPUT TYPE="TEXT" NAME="coderid"><br>'
    .'Database: <INPUT TYPE="TEXT" NAME="database"><br>'
    .'Username: <INPUT TYPE="TEXT" NAME="username"><br>'
    .'Password: <INPUT TYPE="PASSWORD" NAME="password"><br>'
    .'<INPUT TYPE="submit" VALUE="Submit">'
    .'</FORM>';

print '</BODY></HTML>';

?>
