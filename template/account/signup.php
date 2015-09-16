<?


add_action('wp_print_scripts','member_scripts::member_form_add');

//wp_enqueue_style('jquery'); 

get_header();

$_level = get_query_var('lv');
if(!empty($_level)){
	
	$_level=ucwords(str_replace('-',' ',$_level));
	if(in_array($_level, site_members::$memberLevel)){
		$_levelTitle = $_level;
	}
}else{
	$_levelTitle = $_level = 'Member';
}

(int)$_keyLevel = array_search($_levelTitle, site_members::$memberLevel); // $key = 2; level


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
<script>


</script>

<? get_footer();?>