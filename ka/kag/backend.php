<?php
include('header.php');
header('Content-Type: text/xml');

$kags = $ka->GetKAGs();
$last_kag = end($kags);

$kagid = $last_kag->GetID();
$roman = roman($kagid);

echo <<<EOH
<?xml version="1.0" encoding="UTF-8"?>
<rss version="0.92">
	<channel>
		<title>KAG $roman Results</title>
		<link>{$base}kag/kag.php?id=$kagid</link>
		<description>Results for KAG $roman</description>
		<language>en</language>

EOH;

foreach ($last_kag->GetKabalTotals() as $kid=>$total) {
	$kabal = $roster->GetKabal($kid);
	$kname = $kabal->GetName();
	$total = number_format($total);
	echo <<<EOI
		<item>
			<link>{$base}kag/kabal.php?kag=$kagid&amp;kabal=$kid</link>
			<title>$kname: $total</title>
		</item>

EOI;
}

echo <<<EOF
	</channel>
</rss>
EOF;

exit;
?>
