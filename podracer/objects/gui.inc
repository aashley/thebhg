<?php

	/***************************************
	* Gui Class
	* This class is very simple. All it does
	* is allow you to create a Gui object
	* get/set some basic values and then 
	* return the entire gui for printing.
	***************************************/
	
	class Gui
	{
		var $title;
		var $content;
		var $template;
		var $table;
		var $output;
		
		function Gui () // Constructor
		{
			$this->title = "Unset";
			$this->template = "Unset";
		}
				
		function getTitle ()
		{
			return $this->title;
		}
		
		function setTitle ($new_title)
		{
			$this->title = $new_title;
		}
				
		function addContent ($line)
		{
			$this->content .= $line;
		}
		
		function getContent ()
		{
			return $this->content;
		}
		
		function getTemplate ()
		{
			return $this->template;
		}
		
		function setTemplate ($new_template)
		{
			$this->template = $new_template;
		}
		
		function createTable () 
		{
			$this->table = "<table width=\"99%\" border=\"0\" cellspacing=\"0\" cellpadding=\"0\" bgcolor=\"#000000\" align=\"center\">\r\n";
			$this->table .= "%rows%";
			$this->table .= "</table>\r\n";
		}
		
		function addRow ($col_info, $colspan)
		{
			$row = "<tr>\r\n"; 
			for ($i = 0; $i < sizeof($col_info); $i++)
			{
				$row .= "<td ";
				if ($colspan > 1) { $row .= "colspan=\"$colspan\" "; }
				$row .= "bgcolor=\"#B5BBC0\" valign=\"top\">".$col_info[$i]."</td>\r\n";
			}
			$row .= "</tr>\r\n";
			$this->table = eregi_replace ("%rows%", $row."%rows%", $this->table);
		}
		
		function returnTable ()
		{
			$this->content .= eregi_replace ("%rows%", "", $this->table);
		}
	
		function outputGui ()
		{
			global $base_font;
			global $base_size;
			global $base_url;
			if ($this->template == "Unset")
				echo "Error, you must set the template file first.";
			else
			{
				$file = join ('', file ($this->template));
				$file = eregi_replace ("%title%", $this->title, $file);
				$file = eregi_replace ("%content%", $this->content, $file);
				$file = eregi_replace ("%base_font%", $base_font, $file);
				$file = eregi_replace ("%base_size%", $base_size, $file);
				$file = eregi_replace ("%base_url%", $base_url, $file);
        ob_start();
				echo $file;	
        header('Content-Length: '.ob_get_length());
        ob_end_flush();
			}
		}
	}
?>