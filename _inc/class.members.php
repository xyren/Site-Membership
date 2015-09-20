<?php


class account extends site_members{

	var $_data;
	
	var $_sitemember_ID;
	var $_ID;
	public static $_table = MEMBERS_TABLE;
	
	function __construct(){
		
	}
	
	public function ajax_init(){

		add_action('wp_ajax_account_checkusername',array('account','checkusername'));
		add_action('wp_ajax_nopriv_account_checkusername',array('account','checkusername'));
		add_action('wp_ajax_account_checkemail',array('account','checkemail'));
		add_action('wp_ajax_nopriv_account_checkemail',array('account','checkemail'));
		
		add_action('wp_ajax_settings_save',array('account','settings_save'));
		
	}
	
	public function settings_save($data_post=''){
		global $wpdb;
		
		$data = $_POST;
		if(is_array($data_post))
			$data = $data_post;
		
		unset($data['_wp_http_referer'],$data['_wpnonce'],$data['action']);
		update_option('site-member-settings',$data);
		/* 
        if(username_exists($data['user'])){
            if(!is_array($data_post)){
				echo '1';exit;
			}
            return true;
		} */
		echo true;
        exit;
	}
	
	public function checkusername($data_post=''){
		global $wpdb;
		
		$data = $_POST;
		if(is_array($data_post))
			$data = $data_post;
		
        if(username_exists($data['user'])){
            if(!is_array($data_post)){
				echo '1';exit;
			}
            return true;
		}
        return false;
	}
	
	public function checkemail($data_post=''){
		global $wpdb;
		
		$data = $_POST;
		if(is_array($data_post))
			$data = $data_post;
			
        if(email_exists($data['email'])){
            if(!is_array($data_post)){
				echo '1';exit;
			}
			return true;
        }
        return false;
        
	}
	
	public function validate_username($str =''){
        $allowed = array(".", "-", "_");
        if ( ctype_alnum(str_replace($allowed,'',$str))){
            return true;
        }else{
            return false;
        }
	}
	
	
	public function login($_username ='', $_password ='', $_remember= false, $_nonce='', $_redirect=''){
		global $error,$current_user;
		
		//security check for cache based etc.
		if (!wp_verify_nonce($_nonce,MEMBERS_SECRET.'_account_login')){
			return false;
		}
		
		$login = wp_signon(
			array(
				'user_login' =>$_username , 
				'user_password' => $_password, 
				'remember' => $_remember
			));

        get_currentuserinfo();
    
		if(isset($login->ID)) {
			//check if user login success
			wp_set_current_user($login->ID);// populate
			
			if(!empty($_redirect)){
				header("Location: ". get_bloginfo("wpurl").$_redirect);
			} else {
				// If Admin, redirect to plugin
				if( $user_info->user_level > 7) {
					echo 'admin';
				} else {
					header("Location: ". get_bloginfo("wpurl"). $customUrl);
				}
			}
			return true;
		}
		
		if ( is_wp_error($login))
			return false;
	}
	
	public function add_validate($_data,$_role = 0){
		global $wpdb;
		
		//$_data = $data_post;
		$_data['role'] = $_role;
		if(empty($_role)) $_data['role'] =1;//default signup level 1= members
		
		//pass will be auto generate
		$_required = array('user','pass','fname','lname','email','role');
		
		if(!isset($_data['pass'])){
			$_data['pass'] = wp_generate_password( 8, false );
		}
		$_error =array();
		foreach($_required as $key){
			if(empty($_data[$key])){
				$_error[$key] = 'This field is required.';
			}
		}
		//check valid username
		if(account::validate_username($_data['user']) == true){
			//check duplicate
			if(account::checkusername($_data) == true and !empty($_data['user'])){
				$_error['user'] = 'Username already exist.';
			}
		}else{
			if(!empty($_data['user']))
				$_error['user'] = 'Invalid username. Only (_)underscore and (.)dot are special characters allowed.';
		}
		
		if(!empty($_data['user']) and strlen($_data['user']) <=3){
			$_error['user'] = 'Minimum of 4 characters.';
		}
		
		
		if (filter_var($_data['email'], FILTER_VALIDATE_EMAIL)){
			if(account::checkemail($_data) == true and !empty($_data['user'])){
				$_error['email'] = 'Email already exist.';
			}
		}else{
			if(!empty($_data['email']))
				$_error['email'] = 'Invalid email address.';
		}
		//security check for cache based etc.
		if (!wp_verify_nonce($_data['_wpnonce'],MEMBERS_SECRET.'_account_signup')){
			$_error['nonce'] = 'Session expired. please refresh the page.';
		}
		
		if(!empty($_error))
			return $_error;
		
		return account::add($_data);
		
	}
	
	public function add($_data){
		global $wpdb;
		$now = current_time('mysql');
		
		
		$_member = new member_level(esc_attr($_data['role']));
		$_roleID = $_member->key;
			
			
		$userdata = array(
			'user_login' => esc_attr($_data['user']),
			'user_pass' => esc_attr($_data['pass']),
			'first_name' => esc_attr($_data['fname']),
			'last_name' => esc_attr($_data['lname']),
			'user_email' => esc_attr($_data['email']),
			'role' =>  $_roleID,
		);
		//add to wordpress users
		$new_user = wp_insert_user( $userdata );
		//add to our site-member table relationship
		$wpdb->insert(MEMBERS_TABLE , array('userID'=>$new_user , 'member_accepted'=>$now , 'level_id' => $_data['role']));
		$insert_id= $wpdb->insert_id;
		return $insert_id;
	}
	
	
	
	
	
	
	/* 
	function setPhoto(){
		$this->_table_name = TEAMPHOTO_TABLE;
	}
	function setLogs(){
		$this->_table_name = TEAMPHOTO_TABLE_LOGS;
	} */
	
	function set($_sitemember_ID){
		global $wpdb;
		$this->_sitemember_ID = $_sitemember_ID;
		if(empty($this->_sitemember_ID)){
			return false;
		}
		$data = $wpdb->get_row("SELECT * FROM {$this->_table_name} WHERE ID = {$this->_sitemember_ID}", ARRAY_A);
		$this->_data = $this->cleanup($data);
		
		
		return $this->_data;
	}
	function info(){
		return $this->_data;
	}
	
	
	function cleanup($array){
		foreach($array as &$val){
			if(is_array($val)){
				$val = unstrip_array($val);
			}else{
				$val = stripslashes($val);
			}
		}
		return $array;
	}
	
	function add_logs($team_id, $updates = 'Updates'){
		$current_user = wp_get_current_user();
		$user_id = $current_user->ID;
		$now = date('Y-m-d G:i:s');
		$data_logs= array(
			'team_id'	=> $team_id,
			'changes'=>  $updates,
			'user_id'=> $user_id,
			'date_added'	=> $now
		);
		$this->setLogs();
		$this->add($data_logs);
	}
	
	/* function add($emp_data){
		global $wpdb;
		$this->_data = $this->cleanup($emp_data);
		$wpdb->insert($this->_table_name,$this->_data);
		return $wpdb->last_error . $wpdb->insert_id;
	} */
	function update($emp_data,$ID=0){
	
		global $wpdb;
		
		if($ID == 0){
			$ID = $this->_sitemember_ID;
		}
		
		$this->_data = $this->cleanup($emp_data);
		$wpdb->update($this->_table_name,$this->_data,array('ID'=>$ID));
		return $wpdb->last_error . $this->_sitemember_ID;
	}
	function delete($ID=0){
		global $wpdb;
		$wpdb->delete($this->_table_name,array('ID'=>$ID));
		return $wpdb->last_error . $this->_sitemember_ID;
	}
	
	public function savephoto($photo_src,$sport,$add_path='',$add_img_fname='',$filename = '',$size = 150){
		$sport = preg_replace("/[^A-Za-z0-9]/", '', $sport);
		$sport = strtolower($sport);
		
		$sport_path = '/teams/'. $sport . '/'. $add_path .'/';
		$sport_path = str_replace('//','/',$sport_path);
		$img_path = sitemember::$_uploadDIR . $sport_path ;
		if(!is_dir($img_path)){
			mkdir($img_path);
		}
		
		$_filename =  basename($photo_src);
		if(!empty($filename)){
			$_filename = $add_img_fname . $filename;
		}
		
		$_newfile = str_replace('//','/',$img_path . $_filename);
		if(file_exists($_newfile)){
			unlink($_newfile);
		}
		
		if(file_exists($photo_src)){
			//size always square
			sitemember::_resize($photo_src, $size, $size ,$_newfile);
		}else{
			$sport_path ='Error: ';
			$_filename=' Image not exist';
		}
		return $sport_path . $_filename;
	}
		
	public function _resize($img, $w, $h, $newfilename) {
		//Check if GD extension is loaded
		if (!extension_loaded('gd') && !extension_loaded('gd2')) {
			trigger_error("GD is not loaded", E_USER_WARNING);
			return false;
		}

		//Get Image size info
		$imgInfo = getimagesize($img);
		switch ($imgInfo[2]) {
			case 1: $im = imagecreatefromgif($img); break;
			case 2: $im = imagecreatefromjpeg($img);  break;
			case 3: $im = imagecreatefrompng($img); break;
			default:  trigger_error('Unsupported filetype!', E_USER_WARNING);  break;
		}
		
	 /* 
		//If image dimension is smaller, do not resize
		if ($imgInfo[0] <= $w && $imgInfo[1] <= $h) {
			$nHeight = $imgInfo[1];
			$nWidth = $imgInfo[0];
		}else{
		//yeah, resize it, but keep it proportional
			if ($w/$imgInfo[0] > $h/$imgInfo[1]) {
				$nWidth = $w;
				$nHeight = $imgInfo[1]*($w/$imgInfo[0]);
			}else{
				$nWidth = $imgInfo[0]*($h/$imgInfo[1]);
				$nHeight = $h;
			}
		}
		*/
		$imgInfo = getimagesize($img);
		$ratio = $imgInfo[0]/$imgInfo[1]; // width/height
		if( $ratio > 1) {
			$nWidth = $w;
			$nHeight = $h/$ratio;
		}
		else {
			$nWidth = $w*$ratio;
			$nHeight = $h;
		}
		
		$nWidth = round($nWidth);
		$nHeight = round($nHeight);

		$newImg = imagecreatetruecolor($nWidth, $nHeight);

		/* Check if this image is PNG or GIF, then set if Transparent*/  
		if(($imgInfo[2] == 1) OR ($imgInfo[2]==3)){
			imagealphablending($newImg, false);
			imagesavealpha($newImg,true);
			$transparent = imagecolorallocatealpha($newImg, 255, 255, 255, 127);
			imagefilledrectangle($newImg, 0, 0, $nWidth, $nHeight, $transparent);
		}
		imagecopyresampled($newImg, $im, 0, 0, 0, 0, $nWidth, $nHeight, $imgInfo[0], $imgInfo[1]);

		//Generate the file, and rename it to $newfilename
		switch ($imgInfo[2]) {
			case 1: imagegif($newImg,$newfilename); break;
			case 2: imagejpeg($newImg,$newfilename);  break;
			case 3: imagepng($newImg,$newfilename); break;
			default:  trigger_error('Failed resize image!', E_USER_WARNING);  break;
		}
		return $newfilename;
	}
	
	function checking($field,$val,$ID=0){
		global $wpdb;
		
		$ID = trim($ID);
		$val = trim($val);
		$field = trim($field);
		$search_ID ='';
		
		if($ID>0){
			$search_ID = "AND NOT ID={$ID}";
		}
			
		$q = "SELECT ID FROM {$this->_table_name} WHERE {$field} LIKE '{$val}' {$search_ID}";
		$count = $wpdb->get_var($q);
		return $count;
	}
	function search($field,$val,$ID=0){
		global $wpdb;
		
		$ID = trim($ID);
		$val = trim($val);
		$field = trim($field);
		$search_ID ='';
		
		if($ID>0){
			$search_ID = "AND NOT ID={$ID}";
		}
		$q = "SELECT ID FROM {$this->_table_name} WHERE {$field}='{$val}' {$search_ID}";
		
		$count = $wpdb->get_var($wpdb->prepare($q));
		return $count;
	}
	function searchboth($field,$val,$field2,$val2){
		global $wpdb;
		
		$ID = trim($ID);
		$val = trim($val);
		$field = trim($field);
		$val2 = trim($val2);
		$field2 = trim($field2);
		
		$q = "SELECT ID FROM {$this->_table_name} WHERE {$field}='{$val}' AND {$field2}='{$val2}'";
		
		$count = $wpdb->get_var($wpdb->prepare($q));
		return $count;
	}
	function total($field,$val){
		global $wpdb;
		$val = trim($val);
		$field = trim($field);
		
		$q = "SELECT COUNT(ID) FROM {$this->_table_name} WHERE {$field}='{$val}'";
		
		$count = $wpdb->get_var($wpdb->prepare($q));
		return $count;
	}

}
