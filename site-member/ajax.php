<?

add_action('wp_ajax_member_add','member_add');
//add_action('wp_ajax_nopriv_question_add','question_add'); do not allow to public ajax
function member_add($data_post=''){
	global $wpdb;
	$data = $_POST;
	unset($data['action'],$data['submit'],$data['ID']);
	
	$data['date_added'] = date( 'Y-m-d H:i:s');
	
	$wpdb->insert($wpdb->prefix . 'questions' , $data);
	$insert_id= $wpdb->insert_id;
	
	
	if(!empty($insert_id)){
		$report['text'] =  "New Successfully added. Saved under ID of <b>{$insert_id}</b>";
		$report['text'] .=  "<script>jQuery('#question-form').slideUp();</script>";
		$report['class'] = 'updated';
		$report['ID'] = $insert_id;
		
		$userdata = array(
			'user_pass' => esc_attr($ProfilePassword),
			'user_login' => esc_attr($ProfileUsername),
			'first_name' => esc_attr($ProfileContactNameFirst),
			'last_name' => esc_attr($ProfileContactNameLast),
			'user_email' => esc_attr($ProfileContactEmail),
			'role' => get_option('default_role')
		);
		$new_user = wp_insert_user( $userdata );
	}else{
		$report['text'] =  'Error: '.$wpdb->last_error;
		$report['class'] = 'error';
	}
	echo json_encode($report);
	exit();
	return;
}

add_action('wp_ajax_question_update','question_update');
add_action('wp_ajax_nopriv_question_update','question_update');
function question_update(){
	global $wpdb;
	
	$data = $_POST;
	
	$question_id = $data['ID'];
	unset($data['action'],$data['submit'],$data['ID']);
	$data['choices'] = json_encode($data['choices']);
	
	$wpdb->update($wpdb->prefix . 'questions' , $data,array('ID'=>$question_id));
	
	$report=array();
	if(empty($wpdb->last_error)){
		$report['text'] = "Changes Successfully saved.";
		$report['class'] = 'updated';
		$report['ID'] = $update_id;
		
			update_user_meta(isset($_REQUEST['wpuserid'])?$_REQUEST['wpuserid']:"", 'rb_agency_interact_profiletype', $ProfileType);
							update_user_meta(isset($_REQUEST['wpuserid'])?$_REQUEST['wpuserid']:"", 'rb_agency_interact_pgender', esc_attr($ProfileGender));

						if ($ProfileUserLinked > 0) {
							/* Update WordPress user information. */
							update_user_meta($ProfileUserLinked, 'first_name', esc_attr($ProfileContactNameFirst));
							update_user_meta($ProfileUserLinked, 'last_name', esc_attr($ProfileContactNameLast));
							update_user_meta($ProfileUserLinked, 'nickname', esc_attr($ProfileContactDisplay));
							update_user_meta($ProfileUserLinked, 'display_name', esc_attr($ProfileContactDisplay));
							//update_usermeta($ProfileUserLinked, 'user_email', esc_attr($ProfileContactEmail));
							wp_update_user( array( 'ID' => $ProfileUserLinked,  'user_email' => esc_attr($ProfileContactEmail) ) );
							update_user_meta( $ProfileUserLinked, 'rb_agency_interact_profiletype',true);

						}
						
						
	}else{
		$report['text'] =  'Error: '.$wpdb->last_error;
		$report['class'] = 'error';
	}
	echo json_encode($report);
	exit;
	
}

add_action('wp_ajax_question_delete','question_delete');
add_action('wp_ajax_nopriv_question_delete','question_delete');
function question_delete(){
	global $wpdb;
	$data = $_POST;
	
	$question_id = $data['ID'];
	unset($data['action']);
	
	$report = array();
	$wpdb->delete($wpdb->prefix . 'questions' , $data);
	$report['text'] =  "Question Successfully deleted.";
	$report['class'] = 'updated';
	$report['ID'] = $question_id;

	echo json_encode($report);
	exit;
}
