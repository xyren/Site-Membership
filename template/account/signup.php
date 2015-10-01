<?

$_options = get_option('site-member-settings');
add_action('wp_print_styles',array('member_scripts','member_form_add'));
add_action('wp_print_scripts',array('member_scripts','member_form_add'));

get_header();
$_keyLevel = site_members::get_frontend_levelID();



$_levelTitle = site_members::memberLevel($_keyLevel);
if(empty($_options['allow_registration'])){
	echo 'registration is currently closed.';
	exit;
}

if(@!in_array('website',$_options['allow_registration_social'])){
	echo 'Site registration is currently not available. please try other options';
	exit;
}

if(@!in_array($_keyLevel,$_options['allow_registration_level'])){
	echo 'Registration for '. $_levelTitle .' is closed. ';
	exit;
}



$_error = '';
if(isset($_POST['submit'])){
	
	$_data = array();
	foreach($_POST as $key => $val){
		$_data[$key] = esc_attr($val);
	}
	
	//check empty duplicates already process by function below
	$_result = account::add_validate($_POST,$_keyLevel);
	if(is_array($_result)){
		$_error = $_result;
		print_r($_error);
	}else{
		echo 'Success! new account added.';
		unset($_data); //remove all post data.
	}
	
}

?>

<h1>signup - <?=$_levelTitle;?></h1>

<form id="user-info" name="user-info" method="post">
	<label>
	username: <input type="text" name="user" id="user" class="" value="<?=$_data['user'];?>">
	<br/><?=isset($_error['user']) ? $_error['user'] : '';?>
	</label><br/>
	
	<label>
	password: <i>will send to your email-address</i>
	<input type="hidden" name="pass" id="pass" value="admin">
	</label><br/>
	
	
	<label>
	email: <input type="text" name="email" id="email" class="email" value="<?=$_data['email'];?>">
	<br/><?=isset($_error['email']) ? $_error['email'] : '';?>
	</label><br/>
	
	<label>
	first name: <input type="text" name="fname" id="fname" class="" value="<?=$_data['fname'];?>">
	<br/><?=isset($_error['fname']) ? $_error['fname'] : '';?>
	</label><br/>
	
	<label>
	last name: <input type="text" name="lname" id="lname" class="" value="<?=$_data['lname'];?>">
	<br/><?=isset($_error['lname']) ? $_error['lname'] : '';?>
	</label><br/>

	<? wp_nonce_field(MEMBERS_SECRET.'_account_signup'); ?>
	<input type="hidden" name="action" id="action" value="sitemember_account_signup">
	<input type="submit" name="submit" id="submit" value="Submit" class="">
	
	
</form>

<div class="new-fb-btn new-fb-1 new-fb-default-anim"><div class="new-fb-1-1"><div class="new-fb-1-1-1">CONNECT WITH</div></div></div>
<a href="http://wp.xyren.pc/wp-login.php?loginFacebook=1&redirect=http://wp.xyren.pc" onclick="window.location = 'http://wp.xyren.pc/wp-login.php?loginFacebook=1&redirect='+window.location.href; return false;"> <img src="HereComeTheImage" /> </a>
<script>


</script>

<? get_footer();?>