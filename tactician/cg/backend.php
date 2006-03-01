<?php
include('header.php');
header('Content-Type: text/xml');

$cgs = $ka->GetCGs();
$last_cg = end($cgs);

$cgid = $last_cg->GetID();
$roman = roman($cgid);

echo <<<EOH
<?xml version="1.0" encoding="UTF-8"?>
<rss version="0.92">
	<channel>
		<title>CG $roman Results</title>
		<link>{$base}cg/cg.php?id=$cgid</link>
		<description>Results for CG $roman</description>
		<language>en</language>

EOH;

foreach ($last_cg->GetCadreTotals() as $kid=>$total) {
	$cadre = $roster->GetCadre($kid);
	$kname = $cadre->GetName();
	$total = number_format($total);
	echo <<<EOI
		<item>
			<link>{$base}cg/cadre.php?cg=$cgid&amp;cadre=$kid</link>
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
