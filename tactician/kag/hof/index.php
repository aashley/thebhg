<?php
include_once('header.php');
page_header('KAG Hall of Fame');
?>
			<div>
				<h2>Welcome to the KAG Hall of Fame</h2>
				<p>Welcome to the KAG Hall of Fame. Within these walls you will find information on the greatest hunters the Kabal Games have ever seen. You can find information here on who has the most points in KAG history, the best individual KAGs, the most event wins, along with other categories bound to create hours of argument about who the best hunter is in KAG history.</p>
				<p>Please note that points both within the Hall of Fame and the Long Term Statistics are displayed in a scaled form, which ensures that the achievements of the past can be fairly compared with the achievements of the present. This is ensured by scaling scores in KAGs with lower maximum point values than today to the all-time maximum, which is currently <?php echo GetScaledMaximum(); ?>.
				<p>Please select the category you are interested in from the list provided at left.</p>
			</div>
<?php
page_footer();
?>
