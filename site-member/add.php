<div class="wrap">	
	<h1 id="add-new-user">Add New 
		<?
		$_levelID = site_members::get_levelID_from_url();
		$_level = site_members::memberLevel($_levelID);
		if(!empty($_level)){
			echo $_level;
		}else{
			die('Request Member Level not found.');
		}?>
	</h1>
	
	
	<p>Create a brand new <?=$_level;?> and add them to this site.</p>
	
	<div id="ajax-response"></div>
	
	
	<?
	
$_error = '';
if(isset($_POST['submit'])){
	
	$_data = array();
	foreach($_POST as $key => $val){
		$_data[$key] = esc_attr($val);
	}
	
	//check empty duplicates already process by function below
	$_result = account::add_validate($_POST,$_levelID);
	if(is_array($_result)){
		$_error = $_result;
		echo '<div id="message" class="error notice is-dismissible">';
		echo '<p>';
		print_r($_error);
		echo '</p></div>';
	}else{
		echo '<div id="message" class="updated notice is-dismissible">';
		echo '<p>Success! new account added.</p>';
		echo '</div>';
		unset($_data); //remove all post data.
	}
}


?>
<style>
.form-required td .description{color:#dc3232 !important};
</style>

<form name="createuser" id="createuser" method="post" class="validate" novalidate="novalidate">
	<? wp_nonce_field(MEMBERS_SECRET.'_account_signup'); ?>
	<input type="hidden" name="action" id="action" value="sitemember_account_add_admin">
	
	<table class="form-table">
		<tr class="form-field form-required <?=isset($_error['user']) ? 'form-invalid' : '';?>">
			<th scope="row"><label for="user">Username <span class="description">(required)</span></label></th>
			<td><span class="description"><?=isset($_error['user']) ? $_error['user'].'<br/>' : '';?></span>
			<input type="text" name="user" id="user" class="required" value="<?=$_data['user'];?>" required autocapitalize="none" autocorrect="off" >
			</td>
		</tr>
		<tr class="form-field <?=!empty(isset($_error['pass'])) ? 'form-invalid' : '';?>">
			<th scope="row"><label for="pass">Password </label></th>
			<td><span class="description">Will send to your email-address. <?=isset($_error['pass']) ? $_error['pass'].'<br/>' : '';?></span>
				<input type="hidden" name="pass" id="pass" class="" value="admin" aria-required="true" autocapitalize="none" autocorrect="off" >
			</td>
		</tr>
		<tr class="form-field form-required <?=isset($_error['email']) ? 'form-invalid' : '';?>">
			<th scope="row"><label for="email">E-mail <span class="description">(required)</span></label></th>
			<td><span class="description"><?=isset($_error['email']) ? $_error['email'].'<br/>' : '';?></span>
			<input type="text" name="email" id="email" class="" value="<?=$_data['email'];?>" aria-required="true" autocapitalize="none" autocorrect="off" >
			</td>
		</tr>
		<tr class="form-field form-required <?=isset($_error['fname']) ? 'form-invalid' : '';?>">
			<th scope="row"><label for="fname">First Name <span class="description">(required)</span></label></th>
			<td><span class="description"><?=isset($_error['fname']) ? $_error['fname'].'<br/>' : '';?></span>
			<input type="text" name="fname" id="fname" class="" value="<?=$_data['fname'];?>" aria-required="true" autocapitalize="none" autocorrect="off" >
			</td>
		</tr>
		<tr class="form-field form-required <?=isset($_error['lname']) ? 'form-invalid' : '';?>">
			<th scope="row"><label for="lname">Last Name <span class="description">(required)</span></label></th>
			<td><span class="description"><?=isset($_error['lname']) ? $_error['lname'].'<br/>' : '';?></span>
			<input type="text" name="lname" id="lname" class="" value="<?=$_data['lname'];?>" aria-required="true" autocapitalize="none" autocorrect="off" >
			</td>
		</tr>
	</table>
	
	
	<p class="submit">
		<input type="submit" name="submit" id="submit" value="Add New <?=$_level;?>" class="button button-primary">
	</p>
	
</form>




	</div>