<?

add_action('wp_ajax_teamphoto_add','teamphoto_add');
add_action('wp_ajax_nopriv_teamphoto_add','teamphoto_add');
function teamphoto_add($data_post=''){
	global $wpdb;
	$data = $_POST;
	unset($data['view'],$data['action'],$data['submit'],$data['ID'],$data['file_upload']);
	
	$now = date('Y-m-d G:i:s');
	$data['date_added']=$now;
	
	$member_data = clean_post($data);
	$teamphotoClass = new teamphoto();
	$insert_id = $teamphotoClass->add($member_data);
	
	$report=array();
	if(is_numeric($insert_id)){
		$report['text'] =  "Team Photo Successfully added. Saved under ID of <b>{$insert_id}</b>";
		$report['class'] = 'updated';
		$report['ID'] = $insert_id;
		
		//save image
		$photo = $data['photo'];
		$sport = $data['sport'];
		//photo uploaded temporary
		$is_temp_img = strpos($photo,'_temp');
		if($is_temp_img === false ){
			#no changes on photo
		}else{
			//$teamphotoClass->update($member_data);
			$ext = pathinfo($photo, PATHINFO_EXTENSION);
			$_filename = $insert_id .'.'. $ext;
			//save- photo
			$return_filename = teamphoto::savephoto(TEAMPHOTO_UPLOAD_DIR . $photo,$sport,'','',$_filename,150);
			$return_thumb = teamphoto::savephoto(TEAMPHOTO_UPLOAD_DIR . $photo,$sport,'/thumb','',$_filename,80);
			
			#remove the temp file
			if(file_exists(TEAMPHOTO_UPLOAD_DIR . $photo)){
				unlink(TEAMPHOTO_UPLOAD_DIR . $photo);
			}
			
			#save the changes on Database
			$update_field = array(
				'photo' => $return_filename,
				'photo_min' => $return_thumb
			);
			$teamphotoClass->update($update_field,$insert_id);
		}
		
		$teamphotoClass->add_logs($insert_id,'Add New Team -'.  $data['team']);
	}else{
		$report['text'] =  'Error: '.$wpdb->last_error;
		$report['class'] = 'error';
	}
	echo json_encode($report);
	exit();
	return;
}
add_action('wp_ajax_teamphoto_update','teamphoto_update');
add_action('wp_ajax_nopriv_teamphoto_update','teamphoto_update');
function teamphoto_update(){
	global $wpdb;
	
	$data = $_POST;
	
	$member_id = $data['ID'];
	unset($data['action'],$data['submit'],$data['ID'],$data['file_upload']);
	
	$teamphotoClass = new teamphoto();
	$member_data = clean_post($data);
	$teamphotoClass->_teamphoto_ID = $member_id;
	$update_id = $teamphotoClass->update($member_data);
	
	$report=array();
	if(is_numeric($update_id)){
		
		$report['text'] = "Changes Successfully saved.";
		$report['class'] = 'updated';
		$report['photo'] = $data['sport'];
		//save image
		$photo = $data['photo'];
		$sport = $data['sport'];
		//photo uploaded temporary
		$is_temp_img = strpos($photo,'_temp');
		if($is_temp_img === false ){
			#no changes on photo
		}else{
			//$teamphotoClass->update($member_data);
			$ext = pathinfo($photo, PATHINFO_EXTENSION);
			$_filename = $update_id .'.'. $ext;
			//save- photo
			$return_filename = teamphoto::savephoto(TEAMPHOTO_UPLOAD_DIR . $photo,$sport,'','',$_filename,150);
			$return_thumb = teamphoto::savephoto(TEAMPHOTO_UPLOAD_DIR . $photo,$sport,'/thumb','',$_filename,80);
			
			#remove the temp file
			if(file_exists(TEAMPHOTO_UPLOAD_DIR . $photo)){
				unlink(TEAMPHOTO_UPLOAD_DIR . $photo);
			}
			
			#save the changes on Database
			$update_field = array(
				'photo' => $return_filename,
				'photo_min' => $return_thumb
			);
			$teamphotoClass->update($update_field,$update_id);
			$report['text'] .= " <b>Logo updated.</b>";
			$report['photo'] = $return_filename;
		}
		$report['ID'] = $update_id;
		$teamphotoClass->add_logs($update_id,'Update Team Info -'.  $data['team']);
		
	}else{
		$report['text'] =  'Error: '.$wpdb->last_error;
		$report['class'] = 'error';
	}
	echo json_encode($report);
	exit;
	
}

add_action('wp_ajax_teamphoto_delete','teamphoto_delete');
add_action('wp_ajax_nopriv_teamphoto_delete','teamphoto_delete');
function teamphoto_delete(){
	global $wpdb;
	$data = $_POST;
	
	$team_id = $data['ID'];
	$teamphotoClass = new teamphoto();

	$teamphotoClass->_teamphoto_ID = $team_id;
	
	$photo_path = teamphoto_info($team_id,'photo');
	$photo_path_min = teamphoto_info($team_id,'photo_min');
	
	
	$team_name = teamphoto_info($team_id,'team');
	$delete_id = $teamphotoClass->delete($team_id);
	
	//wp_mail('jenner.alagao@gmail.com','APT Testssss','accoutn deletessss');
	$report=array();
	if(is_numeric($delete_id)){
		$report['text'] =  "Team Photo Successfully deleted.";
		$report['class'] = 'updated';
		$report['ID'] = $delete_id;
		#remove the temp file
		if(file_exists(TEAMPHOTO_UPLOAD_DIR . $photo_path_min)){
			//unlink(TEAMPHOTO_UPLOAD_DIR . $photo_path_min);
		}
		if(file_exists(TEAMPHOTO_UPLOAD_DIR . $photo_path)){
			//unlink(TEAMPHOTO_UPLOAD_DIR . $photo_path);
		}
		$teamphotoClass->add_logs($delete_id,'Delete Team - '. $team_name);
	}else{
		$report['text'] = '<b>Error: NOT YET ready</b>'.$wpdb->last_error;
		$report['class'] = 'error';
	}

	echo json_encode($report);
	exit;
	
}

add_action('wp_ajax_teamphoto_check','teamphoto_check');
add_action('wp_ajax_nopriv_teamphoto_check','teamphoto_check');
function teamphoto_check(){
	global $wpdb;
	$field = trim($_POST['field']);
	$val = trim($_POST['val']);
	$ID = trim($_POST['ID']);
	
	$teamphotoClass = new teamphoto();
	$count = $teamphotoClass->checking($field,$val,$ID);
	if($count > 0){
		echo 'false';
	}else{
		echo 'true';
	}
	exit();
}


add_action('wp_ajax_teamphoto_saveimg','teamphoto_saveimg');
add_action('wp_ajax_nopriv_teamphoto_saveimg','teamphoto_saveimg');
function teamphoto_saveimg(){
	
	global $wpdb,$upload_dir;
	$img = trim($_POST['imgpath']);
	$sport = trim($_POST['sport']);
	$ext = pathinfo($img, PATHINFO_EXTENSION);

	$ID = trim($_POST['ID']);
	
	$root_path = $upload_dir['basedir'];
	
	$image = wp_get_image_editor($root_path .'/'.$img);
	
	if ( ! is_wp_error($image)){
		
		$_filename = $ID. '.' .$ext;
		//save- photo
		$return_filaname = teamphoto::savephoto($root_path .'/'.$img,$sport,'/','',$_filename,150);
		
		//save thumb
		$return_thumb = teamphoto::savephoto($root_path .'/'.$img,$sport,'/thumb/','',$_filename,80);

		//return the thumbnail
		echo $return_thumb;
		
		$update_field = array(
			'photo' => '/teams/'. $sport .'/'. $_filename,
			'photo_min' => '/teams/'. $sport .'/thumb/'. $_filename
		);
		
		$teamphotoClass = new teamphoto();
		$teamphotoClass->update($update_field,$ID);
		$team_name = teamphoto_info($ID,'team');

		$teamphotoClass->add_logs($ID,'Upload Photo - '. $team_name);

	
	}else{
		echo 'error';
	}
	exit;
}

add_action('wp_ajax_teamphoto_saveimg_temp','teamphoto_saveimg_temp');
add_action('wp_ajax_nopriv_teamphoto_saveimg','teamphoto_saveimg_temp');
function teamphoto_saveimg_temp(){
	
	global $wpdb,$upload_dir;
	$img = trim($_POST['imgpath']);
	
	$sport = '_temp';
	$root_path = $upload_dir['basedir'];
	
	$image = wp_get_image_editor($root_path .'/'.$img);
	if ( ! is_wp_error($image)){
		$return_filaneme = teamphoto::savephoto($root_path .'/'.$img,$sport,'','_thumb-');
		echo $return_filaneme;
	}else{
		echo 'error'.$root_path;
	}
	exit;
}