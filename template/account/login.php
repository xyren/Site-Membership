<?

global $current_user;

$_error ='';
if(isset($_GET['logout']))
	$_error ='Account Logout successfully.';



$redirect = '/account/';//default to account dashboard

if($_POST){
	$username = $wpdb->escape($_REQUEST['log']);  
	$password = $wpdb->escape($_REQUEST['pwd']);  
	$remember = $wpdb->escape($_REQUEST['rememberme']); 
	$redirect = $wpdb->escape($_REQUEST['redirect_to']);
	$nonce = $wpdb->escape($_REQUEST['_wpnonce']);
	
	if($remember) $remember = "true";  
	else $remember = "false";  

	
	echo $nonce;
	$_login = account::login($username,$password,$remember,$nonce,$redirect);
	if($_login == true){
		//redirect already done by account::login
		echo 'suceess';
	}else{
		$_error = 'username not match. forgot password.';
	};
	
}

	get_header(); ?>
		<div class="loginform">
			<p><?=empty($_error)?'Please enter your username and password to continue':$_error;?></p>
			
			
			<? if( is_user_logged_in()){
				echo "Your currently as 
					<a href='/account/profile/' title='View Profile'>".$current_user->display_name."</a> - 
					<a href='/account/logout/' title='Logout Account'>Logout Account</a>";
			}
			?>
			<form method="post" action="/account/login/">
				<div class="formbox">
					<label for="user_login">Username:</label> <input type="text" name="log" id="user_login"><br />
					<label for="user_pass">Password:</label> <input type="password" name="pwd" id="user_pass"><br />
					<input type="hidden" name="rememberme" value="forever">
					<input type="text" name="redirect_to" value="<?=$redirect;?>">
					<? wp_nonce_field(MEMBERS_SECRET.'_account_login'); ?>
				</div>
				<p class="submit"><input type="submit" class="primary-button" value="Log in" name="wp-submit">
			</form>
		</div>
	<?
	get_footer();
	
	