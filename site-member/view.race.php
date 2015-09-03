

	<div class="wrap">	
		<div id="icon-options-general" class="icon32 icon32-posts-post"><br></div>	
		<h2>Race Details
			<a href="<?=refer_link()?>" class="add-new-h2">Back to List</a>
		</h2>			
		<br/> 
		
	<style type="text/css">
		#ID{width: 70px;}
		#race_title{width: 150px;}
		#race_result{width: 100px;}
		#date_added{width: 120px;}
		.button-primary span.count{color:#fff}
	
	</style>
	
	<div class="updated below-h2 hidden" id="message" >		</div>

	
	

<div id="col-right">
	<div class="col-wrap">
		<div class="form-wrap">
		<a href="?page=horse-price&action=add&raceID=<?=$_REQUEST['id'];?>" class="button-primary">Add Race Price</a>
				<? 	
		
	$horse_race = new horse_racing_price_list_Table();
    $horse_race->_refer = refer_by();
	
	$_REQUEST['raceID'] = (int) $_REQUEST['id'];
	
    $horse_race->prepare_items();
    $horse_race->display();
	

    ?>
			
			
			<script>
	
	jQuery(document).ready(function() {
		jQuery('.delete-race').click(function() {
			var t_ID = jQuery(this).attr('item');
		
			var ask_confirm = confirm("Are you sure you want to delete this Race?");
			if(ask_confirm == true){
				jQuery.ajax({
					url: "<?=site_url().'/wp-admin/admin-ajax.php'?>",
					type: 'post',
					dataType: "json",
					data: 'action=horse_racing_delete_race&ID='+t_ID,
					success: function(datae) {
						jQuery('#message').removeClass('updated');
						jQuery('#message').removeClass('error');
						
						jQuery('#message').fadeOut().fadeIn();
						jQuery('#message').addClass(datae['class']);
						jQuery('#message').html('<p>'+datae['text']+'</p>');
						
						if(datae['ID'] != null){
							jQuery('#row-' + t_ID).css('background-color','#ff8888');
							jQuery('#row-' + t_ID).fadeOut(700);
						}else{
							return false;
						}
					}
				});
				return false;
			}else{
				return false;
			}
		});
		
		jQuery('.delete-race-yes').live("click",function(){
			var t_ID = jQuery(this).attr('item');
	
			jQuery.ajax({
				url: "<?=site_url().'/wp-admin/admin-ajax.php'?>",
				type: 'post',
				dataType: "json",
				data: 'action=horse_racing_delete_race&confirm=yes&ID='+t_ID,
				success: function(datae) {
					jQuery('#message').removeClass('updated');
					jQuery('#message').removeClass('error');
					
					jQuery('#message').fadeOut().fadeIn();
					jQuery('#message').addClass(datae['class']);
					jQuery('#message').html('<p>'+datae['text']+'</p>');
					
					if(datae['ID'] != null){
						jQuery('#row-' + t_ID).css('background-color','#ff8888');
						jQuery('#row-' + t_ID).fadeOut(700);
					}else{
						return false;
					}
				}
			});
			return false;
		});
		
		jQuery('.delete-cancel').live("click",function(){
			jQuery('#message').fadeOut();
			jQuery('#message').html('<p>Delete Cancelled.</p>');
			return false;
		});
		
		
	});	
		
	</script>
	
	
	
		<?
		
		if(isset($_GET['action']) and !isset($_GET['paged'])){ ?>			
		<script>			
			var the_td = jQuery('#td_<?=$_GET['id']?>').parent();		
			var the_tr = jQuery(the_td).parent(); 
			/* .css('background-color','#ff0000'); */
			the_tr.each(function(){
				jQuery(this).find('td').css('background-color','#ffffba');				
				jQuery(this).find('th').css('background-color','#ffffba');
				});		
		</script>
		<? } ?>		
			
			
		</div>
	</div>
</div>


	
		<? 	$horseRace_id = $_GET['id'];
			if(empty($horseRace_id)) return;
			$horseRaceClass = new horse_event();
			$horseRaceClass->setrace();
			$horseRaceClass->set($horseRace_id);
			$horseRace = $horseRaceClass->info();
			$horseRace = unstrip_array($horseRace);
			$horseRace_info = (object) $horseRace;
			include('view.race-details.php');
			?>
			
	</div>