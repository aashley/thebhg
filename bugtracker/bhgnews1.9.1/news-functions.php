<?php
  
  //connect to news database
  $db = mysql_connect("localhost", $dbusername, $dbpassword);
  mysql_select_db($dbname);
  
  //Roster v3 Object
  ini_set('include_path', ini_get('include_path').':/home/thebhg/public_html/include');
  include_once ('roster.inc');
  $roster_obj = new Roster ();

  function prepVar($var) {
    $var = stripslashes($var);
    $var = str_replace("'", "&#39;", $var);
    $var = str_replace("\"", "&#34;", $var);
    return $var;
  }

  function convertURL($msg) {
    $msg = eregi_replace("([[:alnum:]]+)://([^[:space:]]*)([[:alnum:]#?/&=])", "<a href='\\1://\\2\\3' target='_blank' target='_new'>\\1://\\2\\3</a>", $msg);
    $msg = eregi_replace("(([a-z0-9_]|\\-|\\.)+@([^[:space:]]*)([[:alnum:]-]))", "<a href='mailto:\\1' target='_new'>\\1</a>", $msg);
    $msg = eregi_replace("\[([[:alnum:]]+)\]([^[:space:]]*)([[:alnum:]#?/&=])\[/img\]", "<img src='http://\\2\\3' border='0'>", $msg);
    $msg = str_replace("[quote]", "<br><blockquote><font face='arial, helvetica, sans-serif' size='1'>quote:</font><hr>", $msg);
    $msg = str_replace("[/quote]", "<hr></blockquote><br>", $msg);
    return $msg;
  }

?>