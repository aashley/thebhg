<?php 

	$system = $this->get_template_vars ('system');

	$style_obj = new Style (8);
	$css = $style_obj->GetContent();
	$this->assign ('css', $css);

	$login_obj  = new Login_HTTP ();
	$blog_obj   = new Blog ($login_obj->GetID ());
	$person_obj = $blog_obj->GetPerson();
	$blogURL    = $system["home"] . $blog_obj->GetLinktitle() . "/";

	$blog = array (
		"foaf"        => (is_numeric ($person_obj->GetID ()) ? 1 : 0),
		"geourl"      => (strlen ($blog_obj->GetICBM ()) > 0 ? 1 : 0),
		"icbm"        => $blog_obj->GetICBM(),
		"title"       => $blog_obj->GetTitle(),
		"description" => $blog_obj->GetDescription(),
		"url"         => $blogURL,
		"owner"       => $person_obj->GetName(),
		"ownerid"     => $person_obj->GetID(),
		"comments"    => $blog_obj->GetDefaultComments()
	);
	$this->assign ('blog', $blog);

	if (isset ($_POST["Create"]))
	{		
		if (!isset ($_POST["category"]))
			$_POST["category"] = array (0);

		$this->CreateEntry ($login_obj->GetID (), $_POST["title"], $_POST["message"], serialize ($_POST["category"]), (isset ($_POST["allowcomments"]) ? 1 : 0), $_POST["status"]);

		header ("Location: " . $blogURL);
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
