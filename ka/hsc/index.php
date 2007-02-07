<? require_once '../Layout.inc'; 
$subarray = array(	'BHG Overview'=>'hsc/?sec=1',
					'Getting Started'=>'hsc/?sec=2',
					'Graduating the Citadel'=>'hsc/?sec=3',
					'Structure of the BHG'=>'hsc/?sec=4',
					'BHG Credit System'=>'hsc/?sec=5',
					'Ranks and Positions'=>'hsc/?sec=6',
					'The ID Line'=>'hsc/?sec=7',
					'Commission'=>'hsc/?sec=8',
					'Kabal Authority'=>'hsc/?sec=9',
					'The Citadel'=>'hsc/?sec=10',
					'Communications'=>'hsc/?sec=11',
					'Activities'=>'hsc/?sec=12',
					'Xerokine Outlet Center'=>'hsc/?sec=13',
					'Choosing a Kabal'=>'hsc/?sec=14',
					'Links'=>'hsc/?sec=15');
$go = false;
if (isset($_REQUEST['sec'])){
	$page = 's'.$_REQUEST['sec'].'.php';
	if (file_exists($page))
		include_once $page;
	else {
		$go = true;
	}
} else
$go = true;

if ($go){
?>
<div><h2>Welcome</h2>
The purpose of the <strong>Head Start Center [HSC]</strong> is to direct new members, Trainees, of the Bounty Hunters Guild in the right direction upon joining. The HSC is not meant to replace or supercede the Hunter’s Manual or any other such documentation in the BHG; in fact, it should act as a supplement to these. Information presented in the HSC will be formatted to best fit the following criteria: simplicity in understanding what information is given, logical ordering of information, and omission of unnecessary information. If all of these factors are met, then each Trainee that uses the HSC should successfully be integrated into the BHG. The ultimate goal of the HSC is the graduation of Trainees from the Citadel, taking with them enough information to get them started as Hunters.
<p>Each section of the HSC is listed below. Trainees may browse through the sections in any order they wish; however, it is highly suggested that they go through them in order, starting with Section 1. This program has been formatted to take, at the very longest, two weeks. This allows Trainees to go through just one Section per day, allowing them to get adjusted to the workings of the BHG while at the same time keeping their learning pace steady. Of course, those who wish to work faster are encouraged to do so.</div>

<? 
}
ConstructLayout(); ?>
