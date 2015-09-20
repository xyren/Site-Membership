<div class="wrap">	
	<h1>Settings</h1>
	
	
	<div id="ajax-response"></div>
	<?
	
	$_options = get_option('site-member-settings');
	
	//print_r($_options);
	?>
	
	<script>
	jQuery(document).ready(function($) {
		
		jQuery('#site-member-settings').on("submit", function(){
			$(this).api_ajax("#ajax-response","Settings successfully saved.");
			return false;
		});
	});
	</script>
	
	
	<form method="post" name="site-member-settings" id="site-member-settings">
		<input type="hidden" name="action" value="settings_save" />
		
		<?php wp_nonce_field(MEMBERS_SECRET.'_settings'); ?>
		
		<h3 class="title">Registration/Login</h3>
		
		<p>Default configuration about registration and some affected about Login.</p>
		
		<table class="form-table">
			<tr>
				<th scope="row">Members Registration/ Login</th>
				<td>
					<fieldset>
						<legend class="screen-reader-text"><span>Members Registration</span></legend>
						<label for="allow_registration">
							<input name="allow_registration" type="checkbox" id="allow_registration" value="true" <? checked( $_options['allow_registration'], true);?>/>
							Allow registration
						</label>
						<br />
						
						<label for="allow_registration_social_website">
							<input name="allow_registration_social[]" type="checkbox" id="allow_registration_social_website" value="website" <? checked(@in_array('website',$_options['allow_registration_social']));?>/>
							Using Website
						</label>
						<br /><label for="allow_registration_social_facebook">
							<input name="allow_registration_social[]" type="checkbox" id="allow_registration_social_facebook" value="facebook" <? checked(@in_array('facebook',$_options['allow_registration_social']));?>/>
							Using Facebook
						</label>
						<br />
						<label for="allow_registration_social_twitter">
							<input name="allow_registration_social[]" type="checkbox" id="allow_registration_social_twitter" value="twitter" <? checked(@in_array('twitter',$_options['allow_registration_social']));?>/>
							Using Twitter
						</label>
						<br />
						<label for="allow_registration_social_google">
							<input name="allow_registration_social[]" type="checkbox" id="allow_registration_social_google" value="google" <? checked(@in_array('google',$_options['allow_registration_social']));?>/>
							Using Google/ Gmail
						</label>
						<br />
						
						
					
				<p class="description">(If not allow, all social registration option doesn't apply.)</p>
				</fieldset>
				</td>
			</tr>
			
			<tr class="avatar-settings">
				<th scope="row">Registration Default status</th>
				<td>
					<fieldset><legend class="screen-reader-text"><span>Registration Default status</span></legend>
						<label><input type='radio' name='default_registration_status' value='active' <? checked( $_options['default_registration_status'], 'active');?>/>Active</label><br />
						<label><input type='radio' name='default_registration_status' value='pending' <? checked( $_options['default_registration_status'], 'pending');?>/>Pending for approval</label><br />
						<label><input type='radio' name='default_registration_status' value='inactive' <? checked( $_options['default_registration_status'], 'inactive');?> />InActive</label><br />
						<label><input type='radio' name='default_registration_status' value='blocked' <? checked( $_options['default_registration_status'], 'blocked');?>/>Blocked</label><br />
					</fieldset>
				</td>
			</tr>
			
			<tr>
				<th scope="row">Members Registration Level</th>
				<td>
					<fieldset>
						<legend class="screen-reader-text"><span>Members Registration Level</span></legend>
						
						<? foreach(site_members::$memberLevel as $key => $val){?>
						<label for="allow_registration_level_<?=$key;?>">
							<input name="allow_registration_level[]" type="checkbox" id="allow_registration_level_<?=$key;?>" value="<?=$key;?>" <? checked(@in_array($key,$_options['allow_registration_level']));?>/>
							<?=$val;?>
						</label>
						<br />
						
						<? } ?>
				</fieldset>
				</td>
			</tr>
			
		</table>
		
		invite sign up settings.. only allow if admin and modulator.
		
		
		
		
		<p class="submit">
			<input type="submit" name="submit" id="submit" class="button button-primary" value="Save Changes"  />
		</p>
		
	</form>



</div>