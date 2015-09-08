<?

function sitemember_info($id,$ret_var = 'ID'){
	global $wpdb;
	$q = "SELECT {$ret_var} FROM ".TEAMPHOTO_TABLE." WHERE ID = '".$id."'";
	return $wpdb->get_var($q);
}

function sitemember_src($search_array,$src='photo'){
	global $wpdb;
	$search_str = '';
	if(is_array($search_array)){
		foreach($search_array as $key => $val){
			$search_str = " {$key} = '{$val}'" ;
		}
	}else{
		$search_str = " ID = '{$search_array}'";
	}
	$q = "SELECT {$src} FROM ".TEAMPHOTO_TABLE." WHERE $search_str";
	
	$img_src = $wpdb->get_var($q);
	$img_src = stripcslashes($img_src);
	if(!empty($img_src)){
		$img_src = TEAMPHOTO_UPLOAD_URL . $img_src;
	}else{
		$img_src = MEMBERS_URL_PLUG.'/generic.png';
	}
	return $img_src;
}


function sitemember_action_script(){
	
	//wp_deregister_script( 'jquery'); 
	//wp_register_script( 'jquery', MEMBERS_URL_PLUG . '/assets/js/jquery-1.11.3.min.js','', '1.11.3');

	//wp_register_script( 'jquery', MEMBERS_URL_PLUG.'/js/jquery.min.js'); 
	/* wp_register_script( 'jquery-validate', MEMBERS_URL_PLUG.'/js/jquery.validate.js'); 
	wp_register_script( 'jquery-uploadify', MEMBERS_URL_PLUG.'/uploadify/jquery.uploadify.min.js'); 
	wp_register_style( 'uploadify', MEMBERS_URL_PLUG.'/uploadify/uploadify.css');
	
	wp_enqueue_script('jquery-validate');
	wp_enqueue_script('jquery-uploadify'); */
	//wp_enqueue_script('media-upload');
	//wp_enqueue_script('thickbox');
	//wp_enqueue_style('uploadify');
	
	
	if(($_GET['page']=='team-photo')or($_GET['page']=='team-photo')){
		wp_admin_css('thickbox');
		//add_thickbox();
		//wp_enqueue_script('jquery-ui-autocomplete');
	}
}
if(!function_exists('clean_post')){
	function clean_post($post){
		if(isset($post)){
			foreach($post as $key=>$value){
				$post[$key]=trim(htmlspecialchars(mysql_real_escape_string($value)));
			}
		}
		return $post;
	}
}
function sitemember_iframe_script(){
	
	wp_deregister_script('jquery');
	wp_register_script( 'jquery', MEMBERS_URL_PLUG . '/js/jquery.min.js','', '1.7.2');
	wp_register_script( 'jquery-uploadify', MEMBERS_URL_PLUG.'/uploadify/jquery.uploadify.min.js'); 
	wp_register_style( 'uploadify', MEMBERS_URL_PLUG.'/uploadify/uploadify.css');

	
	wp_enqueue_style( 'global' );
	wp_enqueue_style( 'wp-admin'); 
	wp_enqueue_style( 'admin-ui-theme'); 
	 
	
	wp_enqueue_style('jquery-ui-theme');
	wp_admin_css('css/wp-admin.min');
	wp_enqueue_style('buttons');
	wp_enqueue_style('colors'); 
	//do_action("admin_print_styles"); 
	
	wp_print_styles('buttons'); 
	wp_print_styles('colors');
	wp_print_styles('uploadify');
	
	wp_print_scripts('jquery');
	wp_print_scripts('jquery-uploadify');
	add_thickbox();
}
