

	<div class="wrap">	
		<div id="icon-options-general" class="icon32 icon32-posts-post"><br></div>	
		<h2>Add New Race
		<?
		$eventID = (int)$_GET['eventID'];
		if(!empty($eventID)){?>
		 	<a href="?page=horse-event&id=<?=$eventID?>&action=view" class="add-new-h2">Back to List</a>
		<?}else{?>
			<a href="<?=refer_link()?>" class="add-new-h2">Back to List</a>
		<? } ?>
		</h2>			
	<br/> 	
	<br/>
	
	<? 	
		global $form_event_action, $form_action;	
		$form_event_action = 'horse_race_add';
		
		$form_action="add";
		$horseRaceClass = new horse_event();
		$horseRaceClass->setrace();
		$_horseRace = $horseRaceClass->info();	
		$horseRace = (object) $_horseRace;			
		include('form.race.php');
		?>
	</div>