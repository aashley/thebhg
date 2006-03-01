<?php

class Gui extends Podracer {
	var $title;
	var $content;
	var $template;
	var $table;
	var $output;
	
	function Gui () {
		Podracer::Podracer();
		
		$this->title = "Unset";
		$this->template = "Unset";
	}
			
	function GetTitle()	{
		return $this->title;
	}
	
	function SetTitle($new_title) {
		$this->title = $new_title;
	}
			
	function AddContent($line) {
		$this->content .= $line;
	}
	
	function GetContent() {
		return $this->content;
	}
	
	function GetTemplate() {
		return $this->template;
	}
	
	function SetTemplate($new_template) {
		$this->template = $new_template;
	}
	
	function CreateTable() {
		$this->table = "<table width=\"99%\" border=\"0\" cellspacing=\"0\" cellpadding=\"0\" bgcolor=\"#000000\" align=\"center\">\r\n";
		$this->table .= "%rows%";
		$this->table .= "</table>\r\n";
	}
	
	function AddRow($col_info, $colspan) {
		$row = "<tr>\r\n"; 
		for ($i = 0; $i < sizeof($col_info); $i++) {
			$row .= "<td ";
			if ($colspan > 1) { $row .= "colspan=\"$colspan\" "; }
			$row .= "bgcolor=\"#B5BBC0\" valign=\"top\">".$col_info[$i]."</td>\r\n";
		}
		$row .= "</tr>\r\n";
		$this->table = eregi_replace ("%rows%", $row."%rows%", $this->table);
	}
	
	function ReturnTable() {
		$this->content .= eregi_replace ("%rows%", "", $this->table);
	}

	function OutputGui() {
		global $base_font;
		global $base_size;
		global $base_url;
		if ($this->template == "Unset"){
			echo "Error, you must set the template file first.";
		} else {
			$file = join ('', file ($this->template));
			$file = eregi_replace ("%title%", $this->title, $file);
			$file = eregi_replace ("%content%", $this->content, $file);
			$file = eregi_replace ("%base_font%", $base_font, $file);
			$file = eregi_replace ("%base_size%", $base_size, $file);
			$file = eregi_replace ("%base_url%", $base_url, $file);
		}
	    ob_start();
				echo $file;	
	    ob_end_flush();
	}
}
?>