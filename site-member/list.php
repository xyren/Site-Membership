<div class="wrap">
	<h1>
	<? 
		global $_memberLevel;
		
		$_reqID = explode('_',$_GET['page']);
		$_levelID = (int)end($_reqID );
		
		if(array_key_exists($_levelID, $_memberLevel)){
			echo "Manage ".$_memberLevel[$_levelID];
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
