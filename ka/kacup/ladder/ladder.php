<?php

include('../functions/db.php');

function draw_ladder($kabal1, $kabal2, $kabal3, $kabal4, $kabal5, $kabal6, $kabal7, $winner27, $winner36, $winner45, $semi1winner, $semi2winner, $finalwinner) {
  $ladder = imagecreatetruecolor(600,400);
  $bg = imagecolorallocate($ladder, 47,79,79);
  $fg = imagecolorallocate($ladder, 119,136,153);
  imagefilledrectangle($ladder, 0,0,600,400, $bg);
  imageline($ladder, 51, 125, 82, 150, $fg);
  imageline($ladder, 51, 175, 82, 150, $fg);
  imageline($ladder, 51, 225, 82, 250, $fg);
  imageline($ladder, 51, 275, 82, 250, $fg);
  imageline($ladder, 51, 325, 82, 350, $fg);
  imageline($ladder, 51, 375, 82, 350, $fg);
  imageline($ladder, 150, 50, 181, 100, $fg);
  imageline($ladder, 150, 150, 181, 100, $fg);
  imageline($ladder, 150, 250, 181, 300, $fg);
  imageline($ladder, 150, 350, 181, 300, $fg);
  imageline($ladder, 281, 100, 312, 200, $fg);
  imageline($ladder, 281, 300, 312, 200, $fg);
  imagecopy($ladder, imagecreatefromjpeg("images/ka-cup.jpg"), 442,100, 0,0, 158,200);
  imagecopy($ladder, imagecreatefromjpeg("images/kabal-".$kabal2."/48.jpg"), 1,351, 0,0, 48,48);
  imagecopy($ladder, imagecreatefromjpeg("images/kabal-".$kabal3."/48.jpg"), 1,151, 0,0, 48,48);
  imagecopy($ladder, imagecreatefromjpeg("images/kabal-".$kabal4."/48.jpg"), 1,201, 0,0, 48,48);
  imagecopy($ladder, imagecreatefromjpeg("images/kabal-".$kabal5."/48.jpg"), 1,251, 0,0, 48,48);
  imagecopy($ladder, imagecreatefromjpeg("images/kabal-".$kabal6."/48.jpg"), 1,101, 0,0, 48,48);
  imagecopy($ladder, imagecreatefromjpeg("images/kabal-".$kabal7."/48.jpg"), 1,301, 0,0, 48,48);
  imagecopy($ladder, imagecreatefromjpeg("images/kabal-".$kabal1."/64.jpg"), 84,18, 0,0, 64,64);
  imagecopy($ladder, imagecreatefromjpeg("images/kabal-".$winner27."/64.jpg"), 84,318, 0,0, 64,64);
  imagecopy($ladder, imagecreatefromjpeg("images/kabal-".$winner36."/64.jpg"), 84,118, 0,0, 64,64);
  imagecopy($ladder, imagecreatefromjpeg("images/kabal-".$winner45."/64.jpg"), 84,218, 0,0, 64,64);
  imagecopy($ladder, imagecreatefromjpeg("images/kabal-".$semi1winner."/96.jpg"), 183,52, 0,0, 96,96);
  imagecopy($ladder, imagecreatefromjpeg("images/kabal-".$semi2winner."/96.jpg"), 183,252, 0,0, 96,96);
  imagecopy($ladder, imagecreatefromjpeg("images/kabal-".$finalwinner."/128.jpg"), 314,136, 0,0, 128,128);
  header("Content-Type: image/jpeg");
  imagejpeg($ladder);
  imagedestroy($ladder);
}

if (isset($_REQUEST['now'])) {
  $placings_db = mysql_query("SELECT * FROM cup_placings ORDER BY kac_id DESC LIMIT 1", $db);
  $placings = mysql_fetch_array($placings_db, MYSQL_ASSOC);
  draw_ladder($placings['position_1'], $placings['position_2'], $placings['position_3'], $placings['position_4'], $placings['position_5'], $placings['position_6'], $placings['position_7'], $placings['winner_2_7'], $placings['winner_3_6'], $placings['winner_4_5'], $placings['winner_top'], $placings['winner_bottom'], $placings['winner']);
}

if (isset($_REQUEST['kac_id'])) {
  $placings_db = mysql_query("SELECT * FROM cup_placings WHERE kac_id=$kac_id LIMIT 1", $db);
  $placings = mysql_fetch_array($placings_db, MYSQL_ASSOC);
  draw_ladder($placings['position_1'], $placings['position_2'], $placings['position_3'], $placings['position_4'], $placings['position_5'], $placings['position_6'], $placings['position_7'], $placings['winner_2_7'], $placings['winner_3_6'], $placings['winner_4_5'], $placings['winner_top'], $placings['winner_bottom'], $placings['winner']);
}

?>