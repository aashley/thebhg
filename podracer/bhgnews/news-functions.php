<?php

  function prepVar($var) {
    $var = stripslashes($var);
    $var = str_replace("'", "&#39;", $var);
    $var = str_replace("\"", "&#34;", $var);
    return $var;
  }

?>