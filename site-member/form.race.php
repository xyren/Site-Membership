

<style>
input{outline-width: 0px; outline-style: none;}
input{border-radius: 3px;border: 1px solid #dfdfdf;background-color: #ffffff;color: #333333;}
input:focus{box-shadow: 1px 1px 2px rgba(0, 0, 0, 0.1);border-color: #aaaaaa;}

</style>
<div class="below-h2" style="display:none;" id="message"></div>

<form method="POST" id="users-form" action="<?=admin_url("admin-ajax.php")?>">

	<table class="form-table" style="width:550px">
		<tbody>
			<tr class="form-field form-required">
				<th scope="row" style="width:200px;"><label for="race_title">Race Title<span class="description">(required)</span></label></th>
				<td><input name="race_title" type="text" id="race_title" size="30" value="<?=$horseRace->race_title?>" placeholder="Race 1" class="required" /></td>
			</tr>
			<tr class="form-field form-required">
				<th scope="row"><label for="horsebreed">Horse Breed <span class="description"></span></label></th>
				<td><input name="horsebreed" type="text" id="horsebreed" value="<?=$horseRace->horsebreed?>" placeholder="Thoroughbred" /></td>
			</tr>
			
			<tr class="form-field form-required">
				<th scope="row"><label for="horsename">Winning Horse<span class="description">(required)</span></label></th>
				<td><input name="horsename" type="text" id="horsename" value="<?=$horseRace->horsename?>" class="required" placeholder="Sliotar" ></td>
			</tr>
			
			<tr class="form-field form-required">
				<th scope="row"><label for="scratches">Scratches<span class="description">(required)</span></label></th>
				<td><input name="scratches" type="text" id="scratches" value="<?=$horseRace->scratches?>" class="required" placeholder="No Scratches" ></td>
			</tr>
			
			<tr class="form-field form-required">
				<th scope="row"><label for="race_result">Race Result<span class="description">(required)</span></label></th>
				<td><input name="race_result" type="text" id="race_result" value="<?=$horseRace->race_result?>" class="required" placeholder="2/5/1/" ></td>
			</tr>
			
			<tr class="form-field form-required">
				<th scope="row"><label for="race_result">Event<span class="description">(required)</span></label></th>
				<td>
				<? 
				$_horseEventID = 0;
				if(isset($_GET['eventID'])){
					$_horseEventID = (int)$_GET['eventID'];
					$horseRace->horseevent_id = $_horseEventID ;
				}
				global $wpdb;
				if(($form_action=="update" and $_GET['viewby']=='horse-event')or $_GET['viewby']=='horse-event'){
					echo '<b>';
					echo date('Y-m-d',strtotime( horse_event_get_info($horseRace->horseevent_id,'eventdate')));
					echo ' - '.horse_event_get_info($horseRace->horseevent_id,'eventname');
					echo '</b>';
					?>
					<input name="horseevent_id" type="hidden" id="horseevent_id" value="<?=$horseRace->horseevent_id;?>" class="required"  />
				
				<? }else{ ?>
				<select name="horseevent_id" type="text" id="horseevent_id" class="required" <? 
					
					if(($form_action=="update" and $_GET['viewby']=='horse-event') or ($form_action=="add" and is_numeric($_GET['eventID']))){
						echo 'readonly="true"';
					}
				?>>
					<option value="">-- Please select --</option>
					<?
					
					
					$horseevent_SQL = $wpdb->get_results("SELECT * FROM ".HORSE_RACING_TABLE." ORDER BY eventdate DESC");
					foreach ( $horseevent_SQL as $horseEvent ){
						$_selectedID = '';
						if($_horseEventID == $horseEvent->ID){
							$_selectedID = "selected='true'";
						}
						echo "<option value='{$horseEvent->ID}' {$_selectedID} >{$horseEvent->eventdate} - {$horseEvent->eventname}</option>";
					}

					?></select>
				<? }?>
					</td>
			</tr>
			
			<tr class="form-field form-required">
				<th scope="row"><label for="videocode">Video Embed Code</label></th>
				<td><textarea name="videocode" id="videocode" rows="5" cols="45" ><?=stripslashes($horseRace->videocode)?></textarea></td>
			</tr>
			
			
		</tbody>
	</table>
	
	
	<p class="submit">
		<input id="submit" class="button-primary" type="submit" value="Save Race Info" name="submit">
		<img alt="" class="ajax-loading" src="<?=WP_HOME.'/wp-admin'?>/images/wpspin_light.gif">
		<input type="hidden" name="action" value="<?=$form_event_action;?>">
		<input type="hidden" name="ID" value="<?=$horseRace->ID;?>" >
	</p>
</form>
			
<style>
	label.error{color:#900000;background-color:#ffebe8;border:0px solid #cc0000;padding: 2px 4px;
	margin-right:5px;-webkit-border-radius: 3px;-moz-border-radius: 3px;border-radius: 3px;font-style:italic}
	input.error{color:#900000;background-color:#ffebe8;}
</style>
<script>
	
  jQuery(document).ready(function() {
	
	jQuery.validator.addMethod("checkRace_Availability",function(value,element){
		var race_title = jQuery("#race_title").val();
		var horseevent_id = jQuery("#horseevent_id").val();
		ret = jQuery.ajax({
			url: "<?=admin_url("admin-ajax.php")?>",
			type: "POST",
			async: false,
			data: "action=horse_racing_race_check&posttype=race&field=race_title&ID=<?=$horseRace->ID;?>&val="+race_title+"&field2=horseevent_id&val2="+horseevent_id,
			success: function(output) {
				if(output=='true'){
					return true;}else{return false;}
			}
		});
		if(ret.responseText=='true'){
			return true;}else{ return false;
		}
	},"Sorry, Race Title already exist in selected horse Event.");
	// handles Form submission
	jQuery("#users-form").validate({
		rules:{
			race_title:{required:true, checkRace_Availability:true}
		}
	});
	
	function userBeforeSubmit(){
		jQuery("#wpcontent .ajax-loading").css('visibility','visible');
		jQuery('#message').fadeOut();
		jQuery('#message').removeClass('updated');
		jQuery('#message').removeClass('error');
	}
	function userSuccess(){ 
		jQuery("#wpcontent .ajax-loading").css('visibility','hidden'); 
		jQuery('#message').fadeIn();
	}
	
	// Form submission - ajax
	jQuery("#users-form").submit(function(){
		if(jQuery(this).valid() == false){
			jQuery('#message').fadeOut();
			return false;
		}
		
		userBeforeSubmit();
		jQuery.ajax({
			type: "post",
			url: "<?=admin_url("admin-ajax.php")?>",
			data: jQuery('#users-form').serialize(),
			success: function(result){
				response = jQuery.parseJSON(result);
				jQuery('#message').addClass(response['class']);
				jQuery("#message").html('<p>'+response['text']+'</p>');
				userSuccess();
				return false;
			}
		});
		return false;
	});
 
 });


</script>