<?php

include_once 'header.php';

page_header('Tactician Ladder');

echo '<div><h2>The Tactician Ladder</h2>Within the Bounty Hunter\'s Guild, there are many subtle levels of skill which manifest themselves in different areas. Some are adept at the missions distributed by the Strategist, while others find themselves more learned towards my activites. As such, every month, I will generates a ladder to rank the performance of the hunters on my missions. The ranks are drawn from the categories of the Online Missions and the Tactician Bounties and the awards scheme is as follows:<p>[Online Missions]<br />1 Point - Non No-Effort Solution<br />1 Additional Point - Correct Answer<br />1 Additional Point - First Place<p>[Kabal Hunts]<br />1 Point - Non No-Effort Solution<br />1 Additional Point - Correct Answer<br />1 Additional Point - First Place<p>With that in mind, I urge you to put you best foot forward and climb the ladder. The higher up on it you are, the more I will look down on you with favor, hunter. Official ladder ranks will be avilable for the past month 5 days after it ends.<p>Good Hunting<p style="text-align: right;">-Tactician ' . $judicator->getName() . '</p></div>';



page_footer();

?>