<div class="wrap">
	<div id="icon-users" class="icon32 icon32-posts-post"><br></div>
	<h2>
		Horse Race
		<a href="?page=horse-race&action=add&refer=<?=refer_by()?>" class="add-new-h2">Add New</a>
	</h2>
	
	<div class="updated below-h2 hidden" id="message" >		</div>
	<? 		
	$horse_race = new horse_racing_race_list_Table();
    $horse_race->_refer = refer_by();
    $horse_race->prepare_items();
    $horse_race->display();
    ?>

</div>
