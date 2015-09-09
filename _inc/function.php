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