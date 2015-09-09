
<style>
input{outline-width: 0px; outline-style: none;}
input{border-radius: 3px;border: 1px solid #dfdfdf;background-color: #ffffff;color: #333333;}
input:focus{box-shadow: 1px 1px 2px rgba(0, 0, 0, 0.1);border-color: #aaaaaa;}

</style>
<div class="below-h2" style="display:none;" id="message"></div>


<form method="POST" id="question-form" action="<?=admin_url("admin-ajax.php")?>">

	<table class="form-table">
		<tbody>
			<tr class="form-field form-required">
				<th scope="row" style="width:200px;"><label for="question"> Question<span class="description">(required)</span></label></th>
				<td>
				<textarea name="question" type="text" id="question" rows="5"><?=stripslashes($questionInfo->question)?></textarea>
				</td>
			</tr>
			<tr class="form-field form-required">
				<th scope="row"><label for="choices">choices</th>
				<td>
					
					<?
					
					$_choice = json_decode($questionInfo->choices);
					if(!empty($_choice)){
						for($x=0;$x<=4;$x++){
							if($questionInfo->answerID == $x){
								echo '<input name="answerID" type="radio" id="answer_'.$x.'" checked="checked" value="'.$x.'"  />';
							}else{
								echo '<input name="answerID" type="radio" id="answer_'.$x.'" value="'.$x.'"  />';
							}
							echo '<input name="choices[]" type="text" id="choices_'.$x.'" value="'.stripslashes($_choice[$x]).'"  /><br/>';
							
						}
					}else{
					?>
						<input name="answerID" type="radio" id="answer_0" checked="checked" value="0"  />
						<input name="choices[]" type="text" id="choices_0" value=""  /><br/>
						
						<? for($x=1;$x<=4;$x++){ ?>
						<input name="answerID" type="radio" id="answer_<?=$x;?>" value="<?=$x?>"  />
						<input name="choices[]" type="text" id="choices_<?=$x;?>" value=""  /><br/>
					<? }
					} ?>
					<br/>
					 <span class="description">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 
						Click the radio button as a correct answer . Minimum of two.</span></label>
				</td>
			</tr>		
			<tr class="form-field">
				<th scope="row"></th>
				<td>				
					<p class="submit">
						<input id="submit" class="button-primary" type="submit" value="Save Question" name="submit">
						<img alt="" class="ajax-loading" src="<?=admin_url('images/wpspin_light.gif');?>">
						<input type="hidden" name="action" value="<?=$form_event_action;?>">
						<input type="hidden" name="ID" value="<?=$questionInfo->ID?>" >
						<input type="hidden" name="subjID" value="<?=$_subjID;?>" >
					</p>
				</td>
			</tr>
		</tbody>
	</table>
	
</form>
			
		
<style>
	label.error{clear: both;display:block;color:#900000;background-color:#ffebe8;border:0px solid #cc0000;padding: 2px 4px;
	margin-right:5px;-webkit-border-radius: 3px;-moz-border-radius: 3px;border-radius: 3px;font-style:italic}
	input.error{color:#900000;background-color:#ffebe8;}
</style>
<script>
	
  jQuery(document).ready(function() {
	
	function questionBeforeSubmit(){
		jQuery("#wpcontent .ajax-loading").css('visibility','visible');
		jQuery('#message').fadeOut();
		jQuery('#message').removeClass('updated');
		jQuery('#message').removeClass('error');
	}
	function questionSuccess(){ 
		jQuery("#wpcontent .ajax-loading").css('visibility','hidden'); 
		jQuery('#message').fadeIn();
	}
	
	// Form submission - ajax
	jQuery("#question-form").submit(function(){
		
		
		questionBeforeSubmit();
		
		if(jQuery('#question').val() == ''){
			jQuery('#message').addClass('error');
			jQuery("#message").html('<p>Question field cannot be empty.</p>');
			questionSuccess();
			return false;
		}
		
		
		if(jQuery('input[name="answerID"]').is(":checked")){
			currentVal = jQuery('input[name="answerID"]:checked').val();
			if(jQuery('#choices_'+currentVal).val() == ''){
				jQuery('#message').addClass('error');
				jQuery("#message").html('<p><b>Selected answer</b> cannot be empty.</p>');
				questionSuccess();
				return false;
			}
		}
		
		
		jQuery.ajax({
			type: "post",
			url: "<?=admin_url("admin-ajax.php")?>",
			data: jQuery('#question-form').serialize(),
			success: function(result){
				response = jQuery.parseJSON(result);
				jQuery('#message').addClass(response['class']);
				jQuery("#message").html('<p>'+response['text']+'</p>');
				
				questionSuccess();
				return false;
			}
		});
		return false;
	});
 
 });


</script>