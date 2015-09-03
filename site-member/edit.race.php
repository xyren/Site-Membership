

	<div class="wrap">	
		<div id="icon-options-general" class="icon32 icon32-posts-post"><br></div>	
		<h2>Edit Horse Race info
			<a href="<?=refer_link()?>" class="add-new-h2">Back to List</a>
			</h2>			
	<br/> 	
	<br/>
	
	<? 	
		$horseRace_id = $_GET['id'];
		if(empty($horseRace_id)) return;
		
		global $form_event_action, $form_action;	
		$form_event_action = 'horse_race_update';
		
		$form_action="update";
		$horseRaceClass = new horse_event();	
		$horseRaceClass->setrace();
		$horseRaceClass->set($horseRace_id);
		$_horseRace = $horseRaceClass->info();	
		$horseRace = (object) $_horseRace;			
		include('form.race.php');
		?>
	</div>