<div class="wrap">
	<h1>
	<? 
		$_levelID = site_members::get_levelID_from_url();
		$_level = site_members::memberLevel($_levelID);
		if(!empty($_level)){
			echo "Manage ".$_level;
		}else{
			die('Request Member Level not found.');
		}
	?>

		<a href="admin.php?page=site-member-list_<?=$_levelID;?>&action=add" class="page-title-action">Add New</a>
	</h1>
		
	<div class="updated below-h2 hidden" id="message" ></div>
	<?
	$member_list = new members_list_Table($_levelID);
	$member_list->prepare_items();
	$member_list->display();
    ?>

</div>
