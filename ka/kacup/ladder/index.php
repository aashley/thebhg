<?php

  $pagename = "The Ladder";
  include("../header.php");

  echo "<p style=\"text-align: center;\">\n";
  echo "<img src=\"ladder.php?";
  if (isset($_REQUEST['kac_id'])) { echo "kac_id=".$_REQUEST['kac_id']; } else { echo "now=1"; }
  echo "\" alt=\"KAC Ladder for current Cup\" />\n";
  echo "</p>\n";

  include("../footer.php");

?>
