<div class="wrap">	
	<h1>Settings</h1>
	
	<form method="post" action="options.php">
		<input type='hidden' name='site_member' value='site-member-settings' />
		<input type="hidden" name="action" value="update" />
		
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
							<input name="allow_registration" type="checkbox" id="allow_registration" value="1"  checked='checked' />
							Allow registration
						</label>
						<br />
						
						<label for="allow_registration_social">
							<input name="allow_registration_social" type="checkbox" id="allow_registration_social" value="1"  checked='checked' />
							Using Website
						</label>
						<br /><label for="allow_registration_social">
							<input name="allow_registration_social" type="checkbox" id="allow_registration_social" value="1"  checked='checked' />
							Using Facebook
						</label>
						<br />
						<label for="allow_registration_social">
							<input name="allow_registration_social" type="checkbox" id="allow_registration_social" value="1"  checked='checked' />
							Using Twitter
						</label>
						<br />
						<label for="allow_registration_social">
							<input name="allow_registration_social" type="checkbox" id="allow_registration_social" value="1"  checked='checked' />
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
						<label><input type='radio' name='default_registration_status' value='active' checked="checked"/>Active</label><br />
						<label><input type='radio' name='default_registration_status' value='pending' />Pending for approval</label><br />
						<label><input type='radio' name='default_registration_status' value='inactive' />InActive</label><br />
						<label><input type='radio' name='default_registration_status' value='blocked' />Blocked</label><br />
					</fieldset>
				</td>
			</tr>
			
			<tr>
				<th scope="row">Members Registration Level</th>
				<td>
					<fieldset>
						<legend class="screen-reader-text"><span>Members Registration Level</span></legend>
						
						<? foreach(site_members::$memberLevel as $key => $val){?>
						<label for="allow_registration">
							<input name="allow_registration" type="checkbox" id="allow_registration" value="<?=$key;?>" />
							<?=$val;?>
						</label>
						<br />
						
						<? } ?>
				</fieldset>
				</td>
			</tr>
			
		</table>
		
		
		<p class="submit">
			<input type="submit" name="submit" id="submit" class="button button-primary" value="Save Changes"  />
		</p>
		
	</form>



</div>