<?php 

	$system = $this->get_template_vars ('system');

	$style_obj = new Style (8);
	$css = $style_obj->GetContent();
	$this->assign ('css', $css);

	$login_obj = new Login_HTTP ();
	$blog_obj = new Blog ($login_obj->GetID ());
	$person_obj = $blog_obj->GetPerson();
	$blogURL = $system["home"] . $blog_obj->GetLinktitle() . "/";

	$this_day = mktime (0, 0, 0, $_REQUEST["month"], $_REQUEST["day"], $_REQUEST["year"]);
	$entry_obj = $blog_obj->GetEntry ($_REQUEST["entryid"], $this_day);

	$blog = array (
		"foaf"        => (is_numeric ($person_obj->GetID ()) ? 1 : 0),
		"geourl"      => (strlen ($blog_obj->GetICBM ()) > 0 ? 1 : 0),
		"icbm"          => $blog_obj->GetICBM(),
		"title"         => $blog_obj->GetTitle(),
		"description"   => $blog_obj->GetDescription(),
		"url"           => $blogURL,
		"owner"         => $person_obj->GetName(),
		"ownerid"       => $person_obj->GetID()
	);
	$this->assign ('blog', $blog);

	$entry = array (
		"id"            => $entry_obj->GetID(),
		"content"       => $entry_obj->GetMessage(),
		"postedby"      => $person_obj->GetName(),
		"email"         => $person_obj->GetEmail(),
		"title"         => $entry_obj->GetTitle(),
		"linktitle"     => $entry_obj->GetTitleword(),
		"longdate"      => date ("l, F jS Y", $entry_obj->GetTimestamp()),
		"date"          => date("g:i A", $entry_obj->GetTimestamp()),
		"url"           => $system["home"] . "admin/entries/" . date("Y/m/d/", $entry_obj->GetTimestamp()) . $entry_obj->GetTitleword(),
		"comments"      => $entry_obj->GetCommentsNum(),
		"categories"    => $entry_obj->GetCategoryArray(),
		"show_comments" => $entry_obj->AllowComments(),
		"status" => $entry_obj->GetStatus()
	);
	$this->assign ('entry', $entry);

	$status_array = array (
		"0" => "Draft",
		"1" => "Published"
	);
	$this->assign ('status_array', $status_array);

	if (isset ($_POST["Modify"]))
	{		
		if (!isset ($_POST["category"]))
			$_POST["category"] = array (0);

		$entry_obj->SetTitle ($_POST["title"]);
		$entry_obj->SetMessage ($_POST["message"]);
		$entry_obj->SetCategories (serialize ($_POST["category"]));
		$entry_obj->SetAllowComments ((isset ($_POST["allowcomments"]) ? 1 : 0));
		$entry_obj->SetStatus ($_POST["status"]);

		header ("Location: " . $blogURL . date("Y/m/d/", $entry_obj->GetTimestamp()) . $entry_obj->GetTitleword());
	} else {
		$categories_array = $blog_obj->GetCategories(); 
		$categories = array();
		foreach ($categories_array as $category_obj)
		{
			$tmp = $category_obj->GetID();
			$categories [$tmp] = $category_obj->GetTitle();
		}
		$this->assign ('categories', $categories);
	}
?>
