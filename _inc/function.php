<?

function teamphoto_info($id,$ret_var = 'ID'){
	global $wpdb;
	$q = "SELECT {$ret_var} FROM ".TEAMPHOTO_TABLE." WHERE ID = '".$id."'";
	return $wpdb->get_var($q);
}

function teamphoto_src($search_array,$src='photo'){
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
		$img_src = TEAMPHOTO_URL_PLUG.'/generic.png';
	}
	return $img_src;
}


function teamphoto_action_script(){
	
	wp_deregister_script( 'jquery'); 
	wp_register_script( 'jquery', TEAMPHOTO_URL_PLUG . '/js/jquery.min.js','', '1.7.2');

	wp_register_script( 'jquery', TEAMPHOTO_URL_PLUG.'/js/jquery.min.js'); 
	wp_register_script( 'jquery-validate', TEAMPHOTO_URL_PLUG.'/js/jquery.validate.js'); 
	wp_register_script( 'jquery-uploadify', TEAMPHOTO_URL_PLUG.'/uploadify/jquery.uploadify.min.js'); 
	wp_register_style( 'uploadify', TEAMPHOTO_URL_PLUG.'/uploadify/uploadify.css');
	
	wp_enqueue_script('jquery-validate');
	wp_enqueue_script('jquery-uploadify');
	wp_enqueue_script('media-upload');
	wp_enqueue_script('thickbox');
	wp_enqueue_style('uploadify');
	
	
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
function teamphoto_iframe_script(){
	
	wp_deregister_script('jquery');
	wp_register_script( 'jquery', TEAMPHOTO_URL_PLUG . '/js/jquery.min.js','', '1.7.2');
	wp_register_script( 'jquery-uploadify', TEAMPHOTO_URL_PLUG.'/uploadify/jquery.uploadify.min.js'); 
	wp_register_style( 'uploadify', TEAMPHOTO_URL_PLUG.'/uploadify/uploadify.css');

	
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


function teamphoto_flag_country($country,$as_html = true,$img_attr = array()){
	$upload_dir = wp_upload_dir(); 
	
	$country_flag = str_replace(' ','_',$country);
	$flag_img_url = TEAMPHOTO_FLAG_URL;
	if(!file_exists(TEAMPHOTO_FLAG_DIR .'/'.$country_flag.'.png')){
		$flag_img_url .= '/NA.png';
	}else{
		$flag_img_url .= '/'.$country_flag.'.png';
	}
	
	if($as_html == true){
		$image_styles = '';
		if(is_array($img_attr)){
			foreach($img_attr as $image_style => $style_val){
				$image_styles .= $image_style. '="'.$style_val.'" ';
			}
		}else{
			$image_styles .=$img_attr;
		}
		return '<img src="'.$flag_img_url.'" alt="'.$country.'" title="'.$country.'" '.$image_styles.'>';
	}else{
		return $flag_img_url;
	}
}
function teamphoto_country(){
	
	
	foreach(glob(TEAMPHOTO_FLAG_DIR.'/*.gif') as $country){
		$flags_arr[]= str_replace('_',' ', str_replace('.gif','',basename($country)));
	}
	return $flags_arr;
}

function team_refer_by(){
	$url_enc = str_replace( "\\" ,'',  $_SERVER['REQUEST_URI'] );
	$url_enc = esc_attr( $url_enc );
	return urlencode( $url_enc );
}
function team_refer_link(){
	if(empty($_REQUEST['refer'])){
		return 'admin.php?page=team-photo';
	}
	$refer_lnk = str_replace( "\\" ,'',  $_REQUEST['refer'] );
	return $refer_lnk;
}

