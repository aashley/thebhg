<?php 
include_once 'header.php';
?>
    <head>
        <title>BHG Fiction Archive</title>
        <!--<meta http-equiv="Content-Type" content="charset=UTF-8">-->
    	<style type="text/css">
			<!--
			BODY {  background-color: #FFFFFF;
				    font-size: 10pt;
				    color: #000000;
				    font-family: Verdana, Arial, sans-serif;
				    margin-top: 0px;
				    margin-right: 0px;
				    margin-bottom: 0px;
				    margin-left: 0px}
				    
			TH {
					text-align: center;
					background: #00009C;
					color: #ffffff;
					font-family: Verdana, Arial, Helvetica, Sans-Serif;
					font-size: 10pt;
					font-weight: bold;
			}
							
			TD {    font-size: 10pt;
					text-align: left;
			}
			
			INPUT {
				border: 1px solid black;
				background: #BBBBBB;
				font-size: 10pt;
			}
			
			INPUT.chk {
				border: 1px solid black;
				background: #BB4444;
				font-size: 10pt;
			}
			
			INPUT.ck {
				border: 1px solid black;
				background: #4444BB;
				font-size: 10pt;
			}
			
			TEXTAREA {
				border: 1px solid black;
				background: #BBBBBB;
				font-size: 10pt;
			}
			
			OPTION {
				background: #DDDDDD;
				font-size: 10pt;
			}
			
			SELECT {
				background: #DDDDDD;
				font-size: 10pt;
				border: none;
			}
			
			TD.NavHeader { 	font-size: 10pt;
							color: #ffffff;
							background-color: #00009C;
							font-variant: small-caps; 
							text-decoration: underline;
			}
			
			TD.NavBody { 	background-color: #AAAAAA; 
							text-align: center;
							color: #000000; 
							font-variant: small-caps;
			}
			
			table.nav { 	width: 90%; 
							border: 1px solid #777777; 
							border-collapse: collapse;
			}
			
			A { text-decoration: none;
			    color: #00009C;}
			
			A:hover {text-decoration: underline;}
			
			.disclaim {font-size: 8pt;
			    color: #676767;
			    font-family: Courier New, Courier}
			    
			hr {
				border: none;
				border-bottom: 1px solid black;
				width: 95%;
				margin-top: 1em;
				margin-bottom: 1em;
			}
			-->
		</style>
        
    </head>
    <body>
	<img src="banner.jpg" width="100%" alt="banner" /><br />
	        <table style="width: 100%; border: 0 none inherit; text-align: center" cellpadding="2" cellspacing="2">
	            <tr>	            
	                <td style="width: 15%; text-align: center; vertical-align: top">
	                	<table border=0 cellspacing=0 cellpadding=0 align=center><tr><td><?php
		                	$table = new Table();
		                	
							$table->StartRow();
							$table->AddHeader('Archive Navigation');
							$table->EndRow();
							
							$table->AddRow('<a href="/">Home</a>');
							$table->AddRow('<a href="?fiction">Random Fiction</a>');
							$table->AddRow('<a href="?library">Random Library</a>');
							$table->AddRow('<a href="?book">Random Book</a>');
							$table->AddRow('<a href="?lib">Library Index</a>');
							$table->AddRow('<a href="?mod">Admin</a>');
							$table->EndTable();
							
							hr();
							
							$table = new Table();
		                	
							$table->StartRow();
							$table->AddHeader('Archive Statistics');
							$table->EndRow();
							
							$table->AddRow('Total Fictions: '.number_format($fiction->TotalFictions()));
							$table->AddRow('Total Writers: '.number_format($fiction->TotalWriters()));
							$table->AddRow("<a href='?view_comp_results'>Comp Results</a>");
							$fic = $fiction->LatestFiction();
							$table->AddRow("<a href='?fiction=$fic'>Latest Change</a>");
							$fic = $fiction->LatestFicByID();
							$table->AddRow("<a href='?fiction=$fic'>Latest Fiction</a>");
							$rat = $fiction->HighestRated();
							if ($rat){
								$table->AddRow("<a href='?fiction=$rat'>Highest Rated Fiction</a>");
							}
							$rat = $fiction->HighestRatedBook();
							if ($rat){
								$table->AddRow("<a href='?book=$rat'>Highest Rated Book</a>");
							}
							$rat = $fiction->MostViewedFic();
							if ($rat){
								$table->AddRow("<a href='?fiction=$rat'>Most Viewed Fiction</a>");
							}
							$rat = $fiction->MostViewedBook();
							if ($rat){
								$table->AddRow("<a href='?book=$rat'>Most Viewed Book</a>");
							}
							
							$table->EndTable();
						?></td></tr></table>
	                </td>
        			<td style="width: 80%; text-align: center; vertical-align: top">
        				<table border=0 cellspacing=0 cellpadding=0 align=center><tr><td><?php output(); ?></td></tr></table>
                	</td>                
            	</tr>
        	</table>
        	
        <p class="disclaim" style="text-align: center">
            <? echo 'Fiction Archive Code &copy; 2003-2004 <a href="mailto:' . $ric->GetEmail() . '">' . $ric->GetName() . '</a><br />';
               echo 'Layout &copy; 2003-2004 <a href="mailto:' . $kk->GetEmail() . '">' . $kk->GetName() . '</a><br />';
               echo '[Code v2.5 :: Roll in the Hay]<br /><br />';
               echo "Whoa! Letters like 'u' and 'r' can mean words like 'you' and 'are'!";
               
				?>
               <br /><br />This site conforms to the Emperors Hammer 
               <a href=\"http://www.emperorshammer.org/privacy.htm\">Privacy Policy</a> and 
               <a href=\"http://www.emperorshammer.org/irc.htm\">Codes of Conduct</a>.
        </p>
    </body>
</html>