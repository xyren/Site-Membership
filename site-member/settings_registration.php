<?
/*
Tab Name: Registration/ Login
Tab ID: tab-content-registration
*/

global $_include,$_help_tab;

$_help_tab[] = array(
	'id'       => 'help-settings-registration',
	'title'    => __( 'Registration' ),
	'content'  => 'Help tab for registration'
);


if($_include != true){
?>


	<div class="nav-tab-wrapper-content hide" id="tab-content-registration">
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
	</div>
	
<?

}
	