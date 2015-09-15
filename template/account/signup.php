<?


add_action('wp_print_scripts','member_scripts::member_form_add');

//wp_enqueue_style('jquery'); 

get_header();
$_function = get_query_var('lv');



?>

<h1>signup - <?=$_function;?></h1>


<form>
	<label>
	username: <input type="text" name="user" id="user" class="">
	</label><br/>
	
	<label>
	password: <i>will send to your email-address</i>
	</label><br/>
	
	
	<label>
	email: <input type="text" name="email" id="email" class="">
	</label><br/>
	
	<label>
	first name: <input type="text" name="fname" id="fname" class="">
	</label><br/>
	
	<label>
	last name: <input type="text" name="lname" id="lname" class="">
	</label><br/>

	<input type="submit" name="submit" id="submit" value="Submit" class="">
	
	

</form>
<script>


</script>

<? get_footer();?>