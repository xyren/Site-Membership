<?
/*
Tab Name: API Settings
Tab ID: tab-content-api
*/


global $_include,$_help_tab;

$_help_tab[] = array(
	'id'       => 'help-settings-apis',
	'title'    => __( 'APIs - Facebook' ),
	'content'  => '<h3>Setup</h3>
		  <p>
		  <ol><li><a href="https://developers.facebook.com/apps/" target="_blank">Create a facebook app!</a></li>  
		  <li>Don\'t choose from the listed options, but click on <kbd>advanced setup</kbd> in the bottom.</li>  
		  <li>Choose an <kbd>app name</kbd>, and a <kbd>category</kbd>, then click on <kbd>Create App ID</kbd>.</li>  
		  <li>Pass the security check.</li>  
		  <li>Go to the <kbd>Settings</kbd> of the application.</li>  
		  <li>Click on <kbd>+ Add Platform</kbd>, and choose <kbd>Website</kbd>.</li>      
		  <li>Give your website\'s address at the <kbd>Site URL</kbd> field with: <kbd>'.get_bloginfo('url').'</kbd></li>  
		  <li>Give a <kbd>Contact Email</kbd> and click on <kbd>Save Changes</kbd>.</li>  
		  <li>Go to <kbd>Status & Review</kbd>, and change the availability for the general public to <kbd>YES</kbd>.</li>  
		  <li>Go back to the <kbd>Settings</kbd>, and copy the <kbd>App ID</kbd>, and <kbd>APP Secret</kbd>, which you have to copy and paste below.</li>  
		  <li><b>Save changes!</b></li></ol>  
		  '
);


if($_include != true){
	
?>

	<div class="nav-tab-wrapper-content hide" id="tab-content-api">
	
	
		<table class="form-table">
			<tr>
			
				<th scope="row">Facebook </th>
				<td>
					<fieldset>
						<legend class="screen-reader-text"><span>Facebook App ID</span></legend>
						<label for="api_facebook_appID">
							<input name="api_facebook_appID" type="text" id="api_facebook_appID" value="<?=$_options['api_facebook_appID'];?>" class="regular-text code" />
							App ID
							<p class="description"></p>
						</label>
						<br />
						
						<legend class="screen-reader-text"><span>Facebook App Secret</span></legend>
						<label for="api_facebook_appSecret">
							<input name="api_facebook_appSecret" type="text" id="api_facebook_appSecret" value="<?=$_options['api_facebook_appSecret'];?>" class="regular-text code" />
							App Secret
							<p class="description"></p>
						</label>
						<br />
						
					</fieldset>
					
				</td>
			</tr>
			
		</table>
	</div>
<?
}

