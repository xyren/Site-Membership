<div class="wrap">
	<h1>
	<? 
		global $_memberLevel,$_memberLevel_ID;
		if(array_key_exists($_memberLevel_ID, $_memberLevel)){
			echo "Manage ".$_memberLevel[$_memberLevel_ID];
		}else{
			die('Request Member Level not found.');
		}
	?>

		<a href="admin.php?page=site-member-list_<?=$_memberLevel_ID;?>&action=add" class="page-title-action">Add New</a>
	</h1>
		
	<div class="updated below-h2 hidden" id="message" ></div>
	<?
	$member_list = new members_list_Table($_memberLevel_ID);
	$member_list->prepare_items();
	$member_list->display();
    ?>

</div>
