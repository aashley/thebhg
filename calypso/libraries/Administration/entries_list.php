<?php 

	$system = $this->get_template_vars ('system');

	$style_obj = new Style (8);
	$css = $style_obj->GetContent();
	$this->assign ('css', $css);

	$login_obj  = new Login_HTTP ();
	$blog_obj   = new Blog ($login_obj->GetID ());
	$person_obj = $blog_obj->GetPerson();
	$blogURL    = $system["home"] . $blog_obj->GetLinktitle() . "/";

	if (is_numeric($person_obj->GetID()))
		$foaf = 1;
	else
		$foaf = 0;

	if (strlen($blog_obj->GetICBM()) > 0)
		$geourl = 1;
	else
		$geourl = 0;

	$blog = array (
		"foaf"          => $foaf,
		"geourl"        => $geourl,
		"icbm"          => $blog_obj->GetICBM(),
		"title"         => $blog_obj->GetTitle(),
		"description"   => $blog_obj->GetDescription(),
		"url"           => $blogURL,
		"owner"         => $person_obj->GetName(),
		"ownerid"       => $person_obj->GetID()
	);
	$this->assign ('blog', $blog);

	if (isset ($_POST["Delete"])) 
	{
		foreach ($_POST["entries"] as $entry_id) 
		{
			$entry_obj = new Entry ($entry_id);
			$entry_obj->Delete();
		}
	}

	$entries_array = $blog_obj->GetEntries ();
	$entries = array();
	foreach ($entries_array as $entry_obj)
	{
		$entries [] = array (
			"id"    => $entry_obj->GetID(),
			"title" => $entry_obj->GetTitle(),
			"url"   => $system["home"] . "admin/entries/" . date("Y/m/d/", $entry_obj->GetTimestamp()) . $entry_obj->GetTitleword(),
			"date"  => date ("F jS Y", $entry_obj->GetTimestamp()),
			"state" => (($entry_obj->GetStatus() == 0) ? "Draft" : "Published")
		);
	}
	$this->assign ('entries', $entries);
?>
